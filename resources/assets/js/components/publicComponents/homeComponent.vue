<template>
    <div>
        <section id="home">
            <div class="bg-color">
                <div class="container">
                    <div class="row banner-content">
                        <div class="col-xs-12 col-md-10 col-lg-8">
                            <div class="banner-inner text-center">
                                <h1 class="banner-heading">Instituto Politécnico de Leiria</h1>
                                <h3>Portal de Cibersegurança</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="news" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="borderB">
                            <h1>Notícias <small>
                            <a  v-if="hasNews && canShowContent" href="#" title="RSS Notícias" target="_blank" class="rss_color">
                                <i class="fas fa-rss"></i>
                            </a></small></h1>
                        </div>
                    </div>
                </div>
                


                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-8 col-md-offset-2">
                        <div v-if="!hasNews && canShowContent" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                            <h4><strong>Erro: </strong>Não existe notícias disponíveis.</h4>
                        </div>

                        <div v-if="loading" class="align-loader">
                            <div class="loader"></div>
                        </div>
                        <div v-if="hasNews && canShowContent && showNews">
                            <div v-for="item in mostRecentNews">
                                <a href="#" title="">
                                    <article class="newsContent">
                                        <div class="row">
                                            <div class="">
                                                <div class="col-md-3">
                                                    <p class="text-right">{{prepareDate(item.pubDate[0])}}</p>
                                                </div>
                                                <div class="col-md-9 newsBorderB">
                                                    <h3><span v-html="item.title[0]"/></h3>
                                                    <p class="text-justify"><span v-html="prepareDesc(item.description[0])"/></p>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </a>
                            </div>
                        </div>
                        
                        <div class="text-right" v-if="hasNews && canShowContent">
                            <router-link to="/resources/news" class="showMore">Ver todas <i class="fas fa-list-ul"></i></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section v-if="hasOurMission" id="mission">
            <div class="bg-color ">
                <div class="container">
                    <div class="row missionContent">
                        <div class="col-md-12 text-center">
                            <h1>Nossa missão</h1>
                            <p v-html="ourMission.description"></p>
                        </div>                         
                    </div>
                </div>           
            </div>
        </section>
        <section v-if="hasEvents" id="homeEvents" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="borderB">
                            <h1>Eventos</h1>
                        </div>
                    </div>
                </div>
                <div class="homeEventsContainer">                    
                    <div class="thumbnail" v-for="evento in eventos" :key="evento.id">                      
                        <img class="img-responsive" :src="evento.image_path" alt="evento.name">
                        <div class="caption">
                            <h3>{{ evento.name }}</h3>
                            <p>{{ evento.date }}</p>
                            <br>
                            <p><router-link to="/activities/events" title="Saber Mais" class="btn btn-red" role="button">Saber Mais</router-link></p>
                        </div>
                    </div>
                </div>
            </div>            
        </section>
    </div>
</template>
<script type="text/javascript">
    export default {
        data: function(){
            return {
                ourMission: [],
                eventos: [],
                showNews: false,
                news: [],
                mostRecentNews: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasOurMission: function () {
                return Object.keys(this.ourMission).length !== 0;
            },
            hasEvents: function () {
                return this.eventos.length > 0;
            },
            hasNews: function () {
                return this.news.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            getOurMission() {
                axios.get('/api/settings/ourMission')
                    .then(response=>{
                        this.ourMission = response.data;
                });
            },
            getEvents() {
                axios.get('/api/events')
                    .then(response => {
                        this.eventos = response.data.data;
                });
            },
            prepareDesc: function(desc) {
                var cutString = desc.substring(0, 150);
                var lastSpace = cutString.lastIndexOf(" ");
                return desc.substring(0, lastSpace)+" ...";
                
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
                            this.news = this.news.concat(newsObject);
                        }
                        window.setTimeout(this.orderNews(), 3000);
                    })
                    .catch((error) => {
                        this.errorLoading = true;
                    });
            },
            orderNews: function() {
                this.news.sort(function(a,b){
                    var c = new Date(a.pubDate[0]);
                    var d = new Date(b.pubDate[0]);
                    return d-c;
                });

                
                this.mostRecentNews.push(this.news[0]);
                this.mostRecentNews.push(this.news[1]);
                this.loading = false;
                this.showNews = true;
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
                                vm.news = vm.news.concat(Object.assign(result.rss.channel[0].item));
                            });

                        })
                        .catch((error) => {
                            this.errorLoading = true;
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
        mounted(){
            this.getOurMission();
            this.getEvents();
        },
        created: function() {
            this.getRSSNews();
        }
    }
</script>