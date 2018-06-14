<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}  <small><a href="#" title="RSS Alertas de Segurança" target="_blank" class="rss_color"><i class="fas fa-rss"></i></a></small></h1>
                 	</div>
                 	<div id="alerts">
                        <div v-if="loading" class="align-loader">
                            <div class="loader"></div>
                        </div>
                        <div class="table-responsive">                       
                            <div class="card" v-if="hasItems && canShowContent && !loading" >
                              <b-table v-if="showTable"
                                responsive
                                id = "tableAlerts" 
                                stacked="sm"
                                :items="alerts" 
                                :fields="fields"
                                :current-page="currentPage"
                                :per-page="perPage"> 
                                    <template slot="alerts" slot-scope="row">
                                        <a href="#" title="">
                                            <article class="alertContent">
                                                <h3><span v-html="row.item.title[0]"/> <small>{{prepareDate(row.item.pubDate[0])}}</small></h3>
                                                <dl class="dl-horizontal">
                                                    <dt class="text-uppercase">Categoria</dt>
                                                    <dd><span v-html="row.item.category[0]"/></dd>
                                                </dl>
                                            </article>
                                        </a> 
                                    </template>
                                </b-table>
                                <hr>
                                <div class="text-center">
                                    <b-pagination v-if="showTable"
                                        :total-rows="alerts.length" 
                                        :per-page="perPage" 
                                        v-model="currentPage"
                                        align="center"/> 
                                </div>
                            </div>
                            <div v-if="(!hasItems || !canShowContent) && !loading" class="alert alert-danger" role="alert" style="margin-top: 2em;">
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
                title: 'Alertas',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Alertas',
                    active: true
                }],
                fields: [
                    { key: 'alerts'},
                ],
                loading: true,
                currentPage: 1,
                perPage: 10,
                alerts: [],
                showTable: false,
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
        components: {
    
        },
        created: function() {
            this.getRSSAlerts();
        }
    }
</script>

<style type="text/css" media="screen">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        border: 0;
    }   
    #tableAlerts>thead{
        display: none;
    }
    .table-responsive {
        border: 0;
    }
</style>