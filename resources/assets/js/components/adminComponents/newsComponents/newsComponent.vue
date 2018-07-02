<template>
	<div>
		<header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">{{title}}</h2>
          </div>
        </header>
        
        <!-- ERRORS -->
        <div class="alert alert-warning" role="alert" v-if="!hasItems && canShowContent && !showCreate">
            <h2 class="alert-heading">Opss!</h2>
            <p>Não foram encontrados {{title}}.</p>
            <hr>
            <p class="mb-0"><a href="javascript:;" class="alert-link" title="Criar Notícias" v-on:click="createNews()">Criar {{title}}</a></p>
            <hr>
            <p class="mb-0"><a href="/admin/#/rssNews" class="alert-link" title="Adicionar RSS">Adicionar RSS</a></p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="loader mt-3"></div>
        <!-- ============ -->

		<newsList
            v-show="hasItems && canShowContent" 
			:news="orderedNews" 
			v-if="showList"
            @updateXML="updateXML"
			@createNews="createNews"
			@getRSS="getRSSNews"
			@viewNews="viewNews"
            @editNews="editNews"
            @deleteNews="deleteNews">
		</newsList>

		<newsCreate
			v-if="showCreate"
			@exit="exit">
		</newsCreate> 

		<newsView
			:item="item"
			v-if="showView"
			@exit="exit">
		</newsView>

        <newsEdit
            :item="item"
            v-if="showEdit"
            @exit="exit">
        </newsEdit>

	</div>
</template>

<script type="text/javascript">
    import NewsList from './newsListComponent.vue';
    import NewsCreate from './newsCreateComponent.vue';
    import NewsView from './newsDetailsComponent.vue';
    import NewsEdit from './newsEditComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                title: 'Notícias',
                newsToShow: [],
                news: [],
                newsFromIPLeiria: [],
                rssNews: [],
                showList: false,
                showCreate: false,
                showView:false,
                showEdit: false,
                xhr:'',
                xml:'',
                loading: true,
                errorLoading: false,
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
            editNews: function(item) {
                this.item = item;
                this.showList = false;
                this.showCreate = false;
                this.showView = false;
                this.showEdit = true;
            },
            deleteNews: function(news) {
                swal("Pretende realmente apagar a notícia?", {
                    icon: "warning",
                    buttons: {
                        no: {
                            text: "Não",
                            className: "btn-light",
                        },
                        yes: {
                            text: "Sim",
                            className: "btn-info",
                        },
                    },
                })
                .then((value) => {
                  switch (value) {
                      case "no":
                        break;
                   
                      case "yes":
                        axios.delete('/api/news/'+news.id+'/delete')
                          .then((response) => {
                            swal("Notícia apagada com sucesso.", {
                                icon: "success",
                                    buttons: {
                                        ok: "Ok"
                                    },
                                })
                                .then((value) => {
                                    switch (value) {
                                        case "ok":
                                            break;
                                    }
                                });
                                this.getRSSNews();
                          })
                          .catch((error) => {
                            this.loading = false;
                            this.errorLoading = true;
                          });                  
                          break;
                    }
                });
            },
            updateXML: function() {
                this.loading = true;
                this.errorLoading = false; 
                const data = {
                    news: this.newsFromIPLeiria
                }
                axios.post('/api/news/rss', data)
                    .then(response => {
                        swal("RSS Feed de notícias atualizado com sucesso.", {
                        icon: "success",
                            buttons: {
                                ok: "Ok"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "ok":
                                    break;
                            }
                        });
                        this.loading = false;
                        this.errorLoading = false;  
                    }).catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                    });
                
            },
        	createNews: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showView = false;
                this.showEdit = false;
        	},
        	getRSSNews: function() {
        		this.loading = true;
                this.errorLoading = false;   
                this.news = [];
                this.newsFromIPLeiria = [];             
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
                this.newsFromIPLeiria = [];
                axios.get('/api/news')
                    .then((response) => {
                        for (var j = 0; j < response.data.data.length; j++) {
                            var singleNews = response.data.data[j];
                            var newsObject = {title: {}, description: {}, pubDate: {}, link: {}, isFromIPLeiria: true, id: 0}
                            newsObject.title[0] = singleNews.title;
                            newsObject.description[0] = singleNews.description;
                            newsObject.pubDate[0] = singleNews.pub_date;
                            newsObject.link[0] = singleNews.source;
                            newsObject.id = singleNews.id;
                            this.news = this.news.concat(newsObject);
                            this.newsFromIPLeiria = this.newsFromIPLeiria.concat(newsObject);
                        }
                        window.setTimeout(this.orderNews(), 3000);
                        
                    })
                    .catch((error) => {
                        this.errorLoading = true;
                        this.loading = false;
                    });
            },
            orderNews: function() {
                this.newsFromIPLeiria.sort(function(a,b){
                    var c = new Date(a.pubDate[0]);
                    var d = new Date(b.pubDate[0]);
                    return d-c;
                });
                this.loading = false;
                this.showList = true;
            },
        	getRSSByFeed: function(feed) {
        		this.xhr = this.createCORSRequest('GET', feed);
				if (!this.xhr) {
				  throw new Error('CORS not supported');
				} else {/*
					axios.get("https://cors-anywhere.herokuapp.com/"+feed)
				        .then((response) => {
				      		var vm = this;
				            var parseString = require('xml2js').parseString;
							parseString(response.data, function (err, result) {
                                result.rss.channel[0].item.isFromIPLeiria = false;
							    vm.news = vm.news.concat(Object.assign(result.rss.channel[0].item));
							});

				        })
				        .catch((error) => {
				            this.errorLoading = true;
				        });*/
                    var vm = this;
                    $.getJSON('http://anyorigin.com/go?url='+feed+'&callback=?', function(data){
                        var parseString = require('xml2js').parseString;
                        parseString(data.contents, function (err, result) {
                            vm.news = vm.news.concat(Object.assign(result.rss.channel[0].item));
                        });
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
        	exit: function(){
        		this.showList = true;
                this.showCreate = false;
                this.showView = false;
                this.showEdit = false;
                this.news = [];
                this.getRSSNews();
        	},
        	viewNews: function(item) {
        		this.item = item;
        		this.showList = false;
                this.showCreate = false;
                this.showView = true;
                this.showEdit = false;
        	},
        },
        components: {
            'newsList': NewsList,
            'newsCreate': NewsCreate,
            'newsView': NewsView,
            'newsEdit': NewsEdit,
        },
        mounted: function() {
            this.news = [];
            this.newsFromIPLeiria = [];
        	this.getRSSNews();
        }
    }
</script>