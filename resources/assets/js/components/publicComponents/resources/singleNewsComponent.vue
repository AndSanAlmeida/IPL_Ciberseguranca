<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div v-if="loading" class="loader"></div>
                    <div  v-if="!loading && hasItems">
                        <div class="left-highlight">
                            <h1 v-html="singleNews.title[0]"></h1>
                        </div>
                        <br>
                        <p class="text-muted text-right">{{prepareDate(singleNews.pubDate[0])}}</p>
                        <br>
                        <p class="text-justify" v-if="singleNews.description != null" v-html="singleNews.description[0]"></p>
                        <p><b>Fonte: </b>{{singleNews.link[0]}}</p>
                    </div>
                    <div  v-if="!loading && !hasItems" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Notícia não existe.</h4>
                    </div>

                    </div>
                   
                </div>
                
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {                
                title: '',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Notícias',
                    href: '/#/resources/news'
                }, {
                    text: '',
                    active: true
                }],
                singleNews: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.singleNews.length != 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            getRSSNews: function() {
                this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/rssNews')
                    .then(response => {
                        var rsss = response.data.data;
                        for (var i = 0; i < rsss.length; i++) { 

                            this.getRSSByFeed(rsss[i].url);
                        }
                        this.getDBNews();
                    }).catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                    });
            },
            getDBNews: function() {
                axios.get('/api/news')
                    .then((response) => {
                        if (response.data.data.length != 0) {
                            for (var j = 0; j < response.data.data.length; j++) {
                                if(decodeURIComponent(this.title) === response.data.data[j].title) {
                                    var newsObject = {title: {}, description: {}, pubDate: {}, link: {}}
                                    newsObject.title[0] = response.data.data[j].title;
                                    newsObject.description[0] = response.data.data[j].description;
                                    newsObject.pubDate[0] = response.data.data[j].pub_date;
                                    newsObject.link[0] = response.data.data[j].source;
                                    this.singleNews = Object.assign(newsObject);
                                }
                            }
                        }
                        this.loading = false;
                        this.errorLoading = false;
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                    });
            },
            getRSSByFeed: function(feed) {
                this.xhr = this.createCORSRequest('GET', feed);
                if (!this.xhr) {
                  throw new Error('CORS not supported');
                } else {
                    var vm = this;
                    $.getJSON('http://anyorigin.com/go?url='+feed+'&callback=?', function(data){
                        var parseString = require('xml2js').parseString;
                        parseString(data.contents, function (err, result) {
                                for (var i = 0; i < Object.assign(result.rss.channel[0].item).length; i++) { 
                                    Object.assign(result.rss.channel[0].item)[i].title[0] = Object.assign(result.rss.channel[0].item)[i].title[0].replace("?","");
                                    if (Object.assign(result.rss.channel[0].item)[i].title[0] == vm.title || 
                                        Object.assign(result.rss.channel[0].item)[i].title == vm.title ) {
                                        vm.singleNews = Object.assign(result.rss.channel[0].item)[i];
                                    }
                                }
                                
                            });
                    });
                    /*
                    axios.get("https://cors-anywhere.herokuapp.com/"+feed)
                        .then((response) => {
                            var vm = this;
                            var parseString = require('xml2js').parseString;
                            parseString(response.data, function (err, result) {
                                for (var i = 0; i < Object.assign(result.rss.channel[0].item).length; i++) { 
                                    Object.assign(result.rss.channel[0].item)[i].title[0] = Object.assign(result.rss.channel[0].item)[i].title[0].replace("?","");
                                    if (Object.assign(result.rss.channel[0].item)[i].title[0] == vm.title || 
                                        Object.assign(result.rss.channel[0].item)[i].title == vm.title ) {
                                        vm.singleNews = Object.assign(result.rss.channel[0].item)[i];
                                    }
                                }
                                
                            });

                        })
                        .catch((error) => {
                            this.loading = false;
                            this.errorLoading = true;
                        });
                        */
                }
            },
            createCORSRequest(method, url) {
                var xhr = new XMLHttpRequest();
                if ("withCredentials" in xhr) {
                    // Check if the XMLHttpRequest object has a "withCredentials" property.
                    // "withCredentials" only exists on XMLHTTPRequest2 objects.
                    xhr.open(method, url, true);

                } else if (typeof XDomainRequest != "undefined") {
                    // Otherwise, check if XDomainRequest.
                    // XDomainRequest only exists in IE, and is IE's way of making CORS requests.
                    xhr = new XDomainRequest();
                    xhr.open(method, url);
                } else {
                    // Otherwise, CORS is not supported by the browser.
                    xhr = null;
                    this.errorLoading = true;
                }
                return xhr;
            },
            prepareDate: function(item) {
                var today = new Date(item);
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                var month = ''; 

                switch (mm) {
                    case 1: month = ' de janeiro de ';
                        break;
                    case 2: month = ' de fevereiro de ';
                        break;
                    case 3: month = ' de março de ';
                        break;
                    case 4: month = ' de abril de ';
                        break;
                    case 5: month = ' de maio de ';
                        break;
                    case 6: month = ' de junho de ';
                        break;
                    case 7: month = ' de julho de ';
                        break;
                    case 8: month = ' de agosto de ';
                        break;
                    case 9: month = ' de setembro de ';
                        break;
                    case 10: month = ' de outubro de ';
                        break;
                    case 11: month = ' de novembro de ';
                        break;
                    case 12: month = ' de dezembro de ';
                        break;
                }
                return dd+month+yyyy;
            },
            get_ents: function(str){
                var temp=document.createElement("pre");
                temp.innerHTML=str;
                return decodeURIComponent(temp.firstChild.nodeValue);
            }
        },
        created: function() {
            this.title = decodeURIComponent(window.location.href.substr(window.location.href.lastIndexOf('/') + 1).replace(/%20/g, " "));
            this.items[3].text = this.get_ents(this.title);
            this.getRSSNews();
        }
    }
</script>

<style type="text/css" media="screen">
    #resources h1 {
        text-transform: none;
    }
</style>