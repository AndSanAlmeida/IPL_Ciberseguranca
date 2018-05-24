<template>
	<div>
		<header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">{{title}}</h2>
          </div>
        </header>
        
        <!-- ERRORS -->
        <div class="alert alert-warning" role="alert" v-if="!hasItems && canShowContent">
            <h2 class="alert-heading">Opss!</h2>
            <p>Não foram encontrados {{title}}.</p>
            <hr>
            <p class="mb-0"><a href="#" class="alert-link" title="Criar Notícias" v-on:click="createNews()">Criar {{title}}</a></p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div class="col-md-12">
            <h1 class="m-5 text-center" v-if="loading">A carregar...</h1>
        </div>
        
        <!-- ============ -->

		<newsList
            v-show="hasItems && canShowContent" 
			:news="news" 
			v-if="showList"
			@createNews="createNews"
			@getRSS="getRSSNews"
			@viewNews="viewNews">
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

	</div>
</template>

<script type="text/javascript">
    import NewsList from './newsListComponent.vue';
    import NewsCreate from './newsCreateComponent.vue';
    import NewsView from './newsDetailsComponent.vue';
    
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                title: 'Notícias',
                news: [],
                rssNews: [],
                showList: false,
                showCreate: false,
                showView:false,
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
        },
        methods: {
        	createNews: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showView = false;
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
                        this.loading = false;
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
                        this.showList = true;
                    })
                    .catch((error) => {
                        this.errorLoading = true;
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
        	exit: function(){
        		this.showList = true;
                this.showCreate = false;
                this.showView = false;
        	},
        	viewNews: function(item) {
        		this.item = item;
        		this.showList = false;
                this.showCreate = false;
                this.showView = true;
        	},
        	
        },
        components: {
            'newsList': NewsList,
            'newsCreate': NewsCreate,
            'newsView': NewsView,
        },
        created: function() {
        	this.getRSSNews();
        }
    }
</script>