<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}  
                            <small>
                                <a href="/feedNews.xml" title="RSS Notícias" target="_blank" class="rss_color">
                                    <i class="fas fa-rss"></i>
                                </a>
                            </small>
                        </h1>
                 	</div>
                    
                    <div id="news">
                        <div v-if="loading" class="loader"></div>
                        <div class="table-responsive">                       
                            <div class="card" v-if="hasItems">
                              <b-table v-if="showTable"
                                responsive
                                id = "tableNews" 
                                stacked="xs"
                                :items="orderedNews" 
                                :fields="fields"
                                :current-page="currentPage"
                                :per-page="perPage"> 
                                    <template slot="news" slot-scope="row">
                                        <a v-on:click="sendToNews(row.item)" title="">
                                            <article class="newsContent">
                                                <div class="row">
                                                    <div class="">
                                                        <div class="col-md-3">
                                                            <p class="text-right">{{prepareDate(row.item.pubDate[0])}}</p>
                                                        </div>
                                                        <div class="col-md-9 newsBorderB">
                                                            <h3><span v-html="row.item.title[0]"/></h3>
                                                            <p class="text-justify"><span v-html="prepareDesc(row.item.description[0])"/></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </a>
                                    </template>
                                </b-table>
                                <hr>
                                <div class="text-center">
                                    <b-pagination v-if="showTable"
                                        :total-rows="news.length" 
                                        :per-page="perPage" 
                                        v-model="currentPage"
                                        align="center"/> 
                                </div>
                            </div>
                            <div v-if="!hasItems && canShowContent" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                                <h4><strong>Erro: </strong>Não existe notícias disponíveis.</h4>
                            </div>
                          </div>
                    </div>
                   
                    
                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>

                    <resourcesNav></resourcesNav>
                    
                </div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {
                title: 'Notícias',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Notícias',
                    active: true
                }],
                fields: [
                    { key: 'news'},
                ],
                news:[],
                currentPage: 1,
                perPage: 10,
                sortBy: 'pubDate',
                sortDesc: true,
                showTable: false,
                loading: true,
            }
        },
        computed: {
            hasItems: function () {
                return this.news.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
            orderedNews: function () {
                return (this.news.sort(function(a,b){
                    var c = new Date(a.pubDate[0]);
                    var d = new Date(b.pubDate[0]);
                    return d-c;
                }));
            }
        },
        methods: {
            sendToNews: function(news) {
                window.location.href = '/#/resources/news/'+news.title[0];

            },
            prepareDesc: function(desc) {
                if (desc.length > 120) {
                    var cutString = desc.substring(0, 150);
                    var lastSpace = cutString.lastIndexOf(" ");
                    return desc.substring(0, lastSpace)+" ...";
                } else {
                    return desc;
                }
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
                    });
            },
            getDBNews: function() {
                axios.get('/api/news')
                    .then((response) => {

                        for (var j = 0; j < response.data.data.length; j++) {
                            var singleNews = response.data.data[j];
                            var newsObject = {title: {}, description: {}, pubDate: {}, link: {}}
                            newsObject.title[0] = singleNews.title;
                            newsObject.description[0] = singleNews.description;
                            newsObject.pubDate[0] = singleNews.pub_date;
                            newsObject.link[0] = singleNews.source;
                            this.news.push(newsObject);
                        }
                        window.setTimeout(this.orderNews(), 5000);
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                    });
            },
            orderNews: function() {
                this.news.sort(function(a,b){
                    var c = new Date(a.pubDate[0]);
                    var d = new Date(b.pubDate[0]);
                    return d-c;
                });
                this.loading = false;
                this.showTable = true;
            },
            getRSSByFeed: function(feed) {
                this.xhr = this.createCORSRequest('GET', feed);
                if (!this.xhr) {
                  throw new Error('CORS not supported');
                } else {
                    axios.get("https://cors.now.sh/"+feed)
                        .then((response) => {
                            var vm = this;
                            var parseString = require('xml2js').parseString;
                            parseString(response.data, function (err, result) {
                                vm.news = vm.news.concat(Object.assign(result.rss.channel[0].item));
                            });

                        })
                        .catch((error) => {
                            this.errorLoading = true;
                            this.loading = false;
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
        },
        created: function() {
            this.getRSSNews();
        }
    }
</script>

<style type="text/css" media="screen">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        border: 0;
    }   
    #tableNews>thead{
        display: none;
    }
    .card a {
        cursor: pointer;
    } 
    .table-responsive {
        border: 0;
    }
</style>