<template>
  <div>
    <header class="page-header">
      <div class="container-fluid">
        <h2 class="no-margin-bottom">Dashboard</h2>
      </div>
    </header>
    <div v-if="loading" class="loader mt-3"></div>
    <div v-if="canShowContent">
      <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
          <div class="row bg-white has-shadow" v-if="hasResultsUsers && canShowContent" >
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
              <div class="item d-flex align-items-center">
                <div class="icon bg-violet"><i class="icon-user"></i></div>
                <div class="title"><span>Número de<br>Utilizadores</span>
                </div>
                <div class="number"><strong>{{numUsers}}</strong></div>
              </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
              <div class="item d-flex align-items-center">
                <div class="icon bg-red"><i class="icon-user"></i></div>
                <div class="title"><span>Utilizadores<br>Bloqueados</span>
                </div>
                <div class="number"><strong>{{blockedUsers}}</strong></div>
              </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
              <div class="item d-flex align-items-center">
                <div class="icon bg-violet"><i class="icon-bill"></i></div>
                <div class="title"><span>Newsletters<br>Publicadas</span>
                </div>
                <div class="number"><strong>{{numberOfPublishedNewsletters}}</strong></div>
              </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
              <div class="item d-flex align-items-center">
                <div class="icon bg-green"><i class="icon-bill"></i></div>
                <div class="title"><span>Número inscritos<br>na Newsletter</span>
                </div>
                <div class="number"><strong>{{numberOfsubscriptions}}</strong></div>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid row">
          <div class="col-md-12" v-if="hasResultsEvents && canShowContent" >
            <div class="card">
              <div class="card-header d-flex align-items-center">
                <h3 class="h4">Número de Notícias Por Mês</h3>
              </div>
              <div class="card-body">
                <chartjs-bar :beginzero="true" :fill="true" :linetension="0" :bind="true" :datalabel="'Número de Notícias'" :option="myoption" :labels="newsPerMonth.labelChart" :data="dataNews"></chartjs-bar>
              </div>
            </div>
          </div>
          <div class="col-md-6" v-if="hasResultsEvents && canShowContent" >
            <div class="card">
              <div class="card-header d-flex align-items-center">
                <h3 class="h4">Número de Inscritos por Evento</h3>
              </div>
              <div class="card-body">
                <chartjs-bar :beginzero="true" :fill="true" :linetension="0" :bind="true" :datalabel="'Número de Inscritos por Evento'" :option="myoption" :labels="numberPerEvent.labelChart" :data="numberPerEvent.dataChart"></chartjs-bar>
              </div>
            </div>
          </div>
          <div class="col-md-6" v-if="hasResultsEvents && canShowContent" >
            <div class="card">
              <div class="card-header d-flex align-items-center">
                <h3 class="h4">Estados dos Eventos</h3>
              </div>
              <div class="card-body">
                <chartjs-pie :beginzero="true" :fill="true" :linetension="0" :bind="true" :datalabel="'Número de Eventos por Estado'" :option="myoption" :labels="statusPerEvent.labelChart" :data="statusPerEvent.dataChart"></chartjs-pie>
              </div>
            </div>
          </div>
          <div class="col-md-12" v-if="hasResultsEvents && canShowContent" >
            <div class="card">
              <div class="card-header d-flex align-items-center">
                <h3 class="h4">Número de Alertas Por Mês</h3>
              </div>
              <div class="card-body">
                <chartjs-bar :beginzero="true" :fill="true" :linetension="0" :bind="true" :datalabel="'Número de Alertas'" :option="myoption" :labels="alertsPerMonth.labelChart" :data="dataAlerts"></chartjs-bar>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

</template>
<script type="text/javascript">
  require('chart.js');
  require('hchs-vue-charts');
  Vue.use(VueCharts);
  export default {
    data: function () {
      return {
        users: [],
        news: [],
        alerts: [],
        events: [],
        numUsers: 0,
        blockedUsers: 0,
        newUsers: 0,
        numberOfsubscriptions: 0,
        numberOfPublishedNewsletters: 0,
        loading: true,
        errorLoading: false,
        numberPerEvent: {
          labelChart: [],
          dataChart: [],
        },
        statusPerEvent: {
          labelChart: [],
          dataChart: [],
        },
        newsPerMonth: {
          labelChart: [],
          dataChart: [],
        },
        alertsPerMonth: {
          labelChart: [],
          dataChart: [],
        },
        myoption: {
          responsive:true,
          maintainAspectRatio:true
        }
      }
    },
    methods: {
      getUsersForStatus: function () {
        axios.post('/api/usersForStatus')
        .then(response => {
          this.users = response.data.data;
          this.numUsers = this.users.length;
          this.getBlockedUsers();
          this.getNewUsers();
        })
        .catch(error => {
          console.log(error.response)
        });

      },
      getBlockedUsers: function () {
        let blocked = 0;
        this.users.forEach(function (user, key) {
          if (user.blocked === 1) {
            blocked++;
          }
        });

        this.blockedUsers = blocked;

      },
      getNewUsers: function () {
        let newp = 0;
        this.users.forEach(function (user, key) {
          if (user.activated === 0 && user.blocked === 0) {
            newp++;
          }
        });

        this.newUsers = newp;
      },
      getNewsletters: function () {              
        axios.get('/api/newsletter/getPublishedNewsletters')
            .then(response => {
                this.numberOfPublishedNewsletters = response.data.data.length;
            }).catch((error) => {
            this.loading = false;
            this.errorLoading = true;
        });
    },
      getNumberOfsubscriptions: function (){ 
        axios.post('/api/newsletters/getSubscribers')
        .then(response => {
          this.numberOfsubscriptions = response.data.data.length;
        }).catch((error) => {
          this.loading = false;
          this.errorLoading = true;
        });  
      },
      getEvents: function () {          
        axios.get('/api/events')
        .then(response => {
          this.events = response.data.data;
          if(this.hasResultsEvents){
            this.numberPerEvent.labelChart = [];
            this.numberPerEvent.dataChart = [];

            var index;
            var porRealizar = 0, aDecorrer = 0, concluido = 0;

            for (index = 0; index < this.events.length; ++index) {
              this.numberPerEvent.dataChart.push(this.events[index].total_interested);
              this.numberPerEvent.labelChart.push(this.events[index].name);

              switch (this.events[index].status) {
                case 0: 
                porRealizar++;
                break;
                case 1: 
                aDecorrer++;
                break;
                case 2:
                concluido++; 
                break;
              }
            }
            this.statusPerEvent.labelChart.push("Por Realizar");
            this.statusPerEvent.dataChart.push(porRealizar);
            this.statusPerEvent.labelChart.push("A Decorrer");
            this.statusPerEvent.dataChart.push(aDecorrer);
            this.statusPerEvent.labelChart.push("Concluido");
            this.statusPerEvent.dataChart.push(concluido);
          }
        }).catch((error) => {
          this.loading = false;
          this.errorLoading = true;
        });
      },
      getRSSNews: function() {
        this.loadingNews = true;
        this.news = [];         
        axios.get('/api/rssNews')
        .then(response => {
          this.rssNews = response.data.data;
          for (var i = 0; i < this.rssNews.length; i++) { 
            this.getRSSByFeed(this.rssNews[i].url);
          }
          this.getDBNews();
        })
        .catch((error) => {
          this.loading = false;
          this.errorLoading = true;
        });
      },
      getDBNews: function() {
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
          }
          this.prepareNewsChart();
        })
        .catch((error) => {
          this.loading = false;
          this.loadingNews = false;
        });
      },
      getRSSByFeed: function(feed) {
        this.xhr = this.createCORSRequest('GET', feed);
        if (!this.xhr) {
          throw new Error('CORS not supported');
        } else {
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
            this.loading = false;
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
          prepareNewsChart: function() {
            this.newsPerMonth.labelChart.push("janeiro");
            this.newsPerMonth.labelChart.push("fevereiro");
            this.newsPerMonth.labelChart.push("março");
            this.newsPerMonth.labelChart.push("abril");
            this.newsPerMonth.labelChart.push("maio");
            this.newsPerMonth.labelChart.push("junho");
            this.newsPerMonth.labelChart.push("julho");
            this.newsPerMonth.labelChart.push("agosto");
            this.newsPerMonth.labelChart.push("setembro");
            this.newsPerMonth.labelChart.push("outubro");
            this.newsPerMonth.labelChart.push("novembro");
            this.newsPerMonth.labelChart.push("dezembro");

          },
          getRSSAlerts: function() {
            this.loadingAlerts = true; 
            this.alerts = [];            
            axios.get('/api/rssAlerts')
            .then(response => {
              this.rssAlerts = response.data.data;
              for (var i = 0; i < this.rssAlerts.length; i++) { 
                this.getRSSAlertsByFeed(this.rssAlerts[i].url);
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
                var alertObject = {title: {}, description: {}, pubDate: {}, link: {}, category: {}, isFromIPLeiria: true, id: 0}
                alertObject.title[0] = alert.title;
                alertObject.description[0] = alert.description;
                alertObject.pubDate[0] = alert.pub_date;
                alertObject.category[0] = alert.category;
                alertObject.link[0] = alert.source;
                alertObject.id = alert.id;
                this.alerts = this.alerts.concat(alertObject);
              }
              this.prepareAlertsChart();
            })
            .catch((error) => {
              this.loading = false;
              this.errorLoading = true;
            });
          },
          getRSSAlertsByFeed: function(feed) {
            this.xhr = this.createCORSRequest('GET', feed);
            if (!this.xhr) {
              throw new Error('CORS not supported');
            } else {
              axios.get("https://cors-anywhere.herokuapp.com/"+feed)
              .then((response) => {
                var vm = this;
                var parseString = require('xml2js').parseString;
                parseString(response.data, function (err, result) {
                  vm.alerts = vm.alerts.concat(Object.assign(result.rss.channel[0].item));
                });
              })
              .catch((error) => {
                this.loading = false;
                this.errorLoading = true;
              });
            }
          },
          prepareAlertsChart: function() {
            this.alertsPerMonth.labelChart.push("janeiro");
            this.alertsPerMonth.labelChart.push("fevereiro");
            this.alertsPerMonth.labelChart.push("março");
            this.alertsPerMonth.labelChart.push("abril");
            this.alertsPerMonth.labelChart.push("maio");
            this.alertsPerMonth.labelChart.push("junho");
            this.alertsPerMonth.labelChart.push("julho");
            this.alertsPerMonth.labelChart.push("agosto");
            this.alertsPerMonth.labelChart.push("setembro");
            this.alertsPerMonth.labelChart.push("outubro");
            this.alertsPerMonth.labelChart.push("novembro");
            this.alertsPerMonth.labelChart.push("dezembro");



          },
        },
        mounted: function () {
          this.loading = true;
          this.getUsersForStatus();
          this.getNewsletters();
          this.getEvents();
          this.getNumberOfsubscriptions();
          this.getRSSNews();
          this.getRSSAlerts();
          window.setTimeout(this.loading = false, 3000);

        },
        computed: {
          hasResultsEvents: function () {
            return this.events.length > 0;
          },
          hasResultsUsers: function () {
            return this.users.length > 0;
          },
          hasResultsNews: function () {
            return this.dataNews.length > 0;
          },
          dataNews: function() {
            this.loading = true;
            var index, data=[];
            var janeiro = 0, fevereiro = 0, marco = 0, abril = 0, maio = 0, junho = 0, julho = 0, agosto = 0, setembro = 0, outubro = 0, novembro = 0, dezembro = 0;

            for (index = 0; index < this.news.length; ++index) {
              var today = new Date(this.news[index].pubDate[0]);
                var mm = today.getMonth()+1; //January is 0!
                switch (mm) {
                  case 1: janeiro++;
                  break;
                  case 2: fevereiro++;
                  break;
                  case 3: marco++;
                  break;
                  case 4: abril++;
                  break;
                  case 5: maio++;
                  break;
                  case 6: junho++;
                  break;
                  case 7: julho++;
                  break;
                  case 8: agosto++;
                  break;
                  case 9: setembro++;
                  break;
                  case 10: outubro++;
                  break;
                  case 11: novembro++;
                  break;
                  case 12: dezembro++;
                  break;
                }
              }

              data.push(janeiro);
              data.push(fevereiro);
              data.push(marco);
              data.push(abril);
              data.push(maio);
              data.push(junho);
              data.push(julho);
              data.push(agosto);
              data.push(setembro);
              data.push(outubro);
              data.push(novembro);
              data.push(dezembro);

              this.loading = false;

              return data;
            },
            dataAlerts: function() {
              var index, data=[];
              var janeiro = 0, fevereiro = 0, marco = 0, abril = 0, maio = 0, junho = 0, julho = 0, agosto = 0, setembro = 0, outubro = 0, novembro = 0, dezembro = 0;

              for (index = 0; index < this.alerts.length; ++index) {
                var today = new Date(this.alerts[index].pubDate[0]);
                var mm = today.getMonth()+1; //January is 0!
                switch (mm) {
                  case 1: janeiro++;
                  break;
                  case 2: fevereiro++;
                  break;
                  case 3: marco++;
                  break;
                  case 4: abril++;
                  break;
                  case 5: maio++;
                  break;
                  case 6: junho++;
                  break;
                  case 7: julho++;
                  break;
                  case 8: agosto++;
                  break;
                  case 9: setembro++;
                  break;
                  case 10: outubro++;
                  break;
                  case 11: novembro++;
                  break;
                  case 12: dezembro++;
                  break;
                }
              }

              data.push(janeiro);
              data.push(fevereiro);
              data.push(marco);
              data.push(abril);
              data.push(maio);
              data.push(junho);
              data.push(julho);
              data.push(agosto);
              data.push(setembro);
              data.push(outubro);
              data.push(novembro);
              data.push(dezembro);

              return data;
            },
            hasResultsAlerts: function () {
              return this.dataAlerts.length > 0;
            },
            canShowContent: function () {
              return !this.errorLoading && !this.loading;
            },
          },
        }
      </script>
      <style>

    </style>
