<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1 v-html="title" v-if="canShowContent && hasItems"></h1>
                 	</div>
                    <p></p>
                    <div v-if="loading" class="align-loader">
                        <div class="loader"></div>
                    </div>
                    <br><br>
                    <p class="text-justify" v-html="singleNews.description[0]"></p>
                    
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
                news: [],
                singleNews: [],
                showNews: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.singleNews != null;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            getNewsByTitle: function() {
                this.getRSSNews();

                this.loading = false;
                this.showNews = true;
            },
            getRSSNews: function() {
                this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/rssNews')
                    .then(response => {
                        this.rssNews = response.data.data;
                        for (var i = 0; i < this.rssNews.length; i++) { 
                            this.getRSSByFeed(this.rssNews[i].url);
                        }
                        this.getDBNews();
                    }).catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                        console.log("3"+error);
                    });
            },
            getDBNews: function() {
                axios.get('/api/news')
                    .then((response) => {
                        for (var j = 0; j < response.data.data.length; j++) {
                            if(this.title == response.data.data[j].title) {
                                this.singleNews = response.data.data[j];
                            }
                            
                        }
                    })
                    .catch((error) => {
                        this.errorLoading = true;
                        console.log("2"+error);
                    });
            },
            getRSSByFeed: function(feed) {
                this.xhr = this.createCORSRequest('GET', feed);
                if (!this.xhr) {
                  throw new Error('CORS not supported');
                } else {
                    axios.get("https://cors.now.sh/"+feed)
                        .then((response) => {
                            //console.log(response.data);
                            var vm = this;
                            var parseString = require('xml2js').parseString;
                            parseString(response.data, function (err, result) {
                                for (var i = 0; i < Object.assign(result.rss.channel[0].item).length; i++) { 
                                    if (Object.assign(result.rss.channel[0].item)[i].title[0] == vm.title) {
                                        vm.singleNews = Object.assign(result.rss.channel[0].item)[i];
                                    }
                                }
                                
                            });

                        })
                        .catch((error) => {
                            this.errorLoading = true;
                            console.log("1"+error);
                        });
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
                return temp.firstChild.nodeValue;
            }
        },
        created: function() {
            this.title = window.location.href.substr(window.location.href.lastIndexOf('/') + 1).replace(/%20/g, " ");
            this.items[3].text = this.get_ents(this.title);
            this.getNewsByTitle();
        }
    }
</script>

<style type="text/css" media="screen">
    #resources h1 {
        text-transform: none;
    }
</style>