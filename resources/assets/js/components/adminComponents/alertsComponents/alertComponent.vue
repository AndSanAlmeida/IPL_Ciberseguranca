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
            <p class="mb-0"><a href="#" class="alert-link" title="Criar Alerta" v-on:click="createAlerts()">Criar {{title}}</a></p>
            <hr>
            <p class="mb-0"><a href="/admin/#/rssAlerts" class="alert-link" title="Adicionar RSS">Adicionar RSS</a></p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="align-loader mt-4">
            <div class="loader"></div>
        </div>
        
        <!-- ============ -->

		<alertsList
            v-show="hasItems && canShowContent" 
			:alerts="alerts" 
			v-if="showList"
			@createAlerts="createAlerts"
			@getRSS="getRSSAlerts"
			@viewAlerts="viewAlerts">
		</alertsList>

		<alertsCreate
			v-if="showCreate"
			@exit="exit">
		</alertsCreate> 

		<alertsView
			:item="item"
			v-if="showView"
			@exit="exit">
		</alertsView>

	</div>
</template>

<script type="text/javascript">
    import AlertsList from './alertListComponent.vue';
    import AlertsCreate from './alertCreateComponent.vue';
    import AlertsView from './alertDetailsComponent.vue';
    
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                title: 'Alertas',
                alerts: [],
                rssAlerts: [],
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
                return this.alerts.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
        	createAlerts: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showView = false;
        	},
        	getRSSAlerts: function() {
        		this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/rssAlerts')
                    .then(response => {
                    	this.rssAlerts = response.data.data;
                    	for (var i = 0; i < this.rssAlerts.length; i++) { 
						    this.getRSSByFeed(this.rssAlerts[i].url);
						}
                        this.getDBAlerts();
                        this.loading = false;
                    }).catch((error) => {
                    	this.loading = false;
                    	this.errorLoading = true;
                	});
        	},
            getDBAlerts: function() {
                axios.get('/api/alerts')
                    .then((response) => {
                        for (var j = 0; j < response.data.data.length; j++) {
                            var alert = response.data.data[j];
                            var newsObject = {title: {}, description: {}, pubDate: {}, link: {}, category: {}}
                            newsObject.title[0] = alert.title;
                            newsObject.description[0] = alert.description;
                            newsObject.pubDate[0] = alert.pub_date;
                            newsObject.category[0] = alert.category;
                            newsObject.link[0] = alert.source;
                            this.alerts = this.alerts.concat(newsObject);
                        }
                        this.showList = true;
                        window.setTimeout(this.orderAlerts(), 3000);
                        console.log(response.data);
                    })
                    .catch((error) => {
                        this.errorLoading = true;
                    });
            },
            orderAlerts: function() {
                this.alerts.sort(function(a,b){
                    var c = new Date(a.pubDate[0]);
                    var d = new Date(b.pubDate[0]);
                    return d-c;
                });
                this.showList = true;
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
							    vm.alerts = vm.alerts.concat(Object.assign(result.rss.channel[0].item));
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
                this.getRSSAlerts();
        	},
        	viewAlerts: function(item) {
        		this.item = item;
        		this.showList = false;
                this.showCreate = false;
                this.showView = true;
        	},
        },
        components: {
            'alertsList': AlertsList,
            'alertsCreate': AlertsCreate,
            'alertsView': AlertsView,
        },
        created: function() {
        	this.getRSSAlerts();
        }
    }
</script>