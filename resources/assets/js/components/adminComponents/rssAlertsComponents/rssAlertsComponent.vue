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
		  	<p class="mb-0"><a href="javascript:;" class="alert-link" title="Adicionar RSS de Alertas" v-on:click="addRSSAlerts()">Criar {{title}}</a></p>
		</div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="loader mt-3"></div>
        
        <!-- ============ -->

		<rssAlertsList 
			v-show="hasItems && canShowContent"
			:rssAlerts="rssAlerts" 
			v-if="showList"
			@addRSSAlerts="addRSSAlerts"
			@editRssAlerts="editRssAlerts"
			@getRSSAlerts="getRSSAlerts"
			@deleteRSSAlerts="deleteRSSAlerts">
		</rssAlertsList>

		<rssAlertsCreate
			v-if="showCreate"
			@exit="exit">
		</rssAlertsCreate> 

		<rssAlertsEdit
			:rss="rss" 
			v-if="showEdit"
			@exit="exit">
		</rssAlertsEdit> 
	</div>
</template>

<script type="text/javascript">
    import RssAlertsList from './rssAlertsListComponent.vue';
    import RssAlertsCreate from './rssAlertsCreateComponent.vue';
    import RssAlertsEdit from './rssAlertsEditComponent.vue';
    
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	title: 'RSS de Alertas',
            	rss: '',
                rssAlerts: [],
                showList: true,
                showCreate: false,
                showEdit: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.rssAlerts.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
        	addRSSAlerts: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showEdit = false;
        	},
        	editRssAlerts: function(rss) {
        		this.rss = rss;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = true;
        	},
        	getRSSAlerts: function() {
        		this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/rssAlerts')
                    .then(response => {
                        this.rssAlerts = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    	this.loading = false;
                    	this.errorLoading = true;
                	});
        	},
        	exit: function(){
        		this.showList = true;
                this.showCreate = false;
                this.showEdit = false;
               	this.getRSSAlerts();
        	},
        	deleteRSSAlerts: function(rss) {
        		swal("Pertende realmente apagar este RSS?", {
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
		                axios.delete('/api/rssAlerts/'+rss.id+'/delete')
		                  .then((response) => {
		                    swal("RSS apagado com sucesso.", {
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
                                this.getRSSAlerts();
		                  })
		                  .catch((error) => {
                            this.loading = false;
                            this.errorLoading = true;
		                  });                  
		                  break;
		          }
		      });
        	}
        	
        },
        components: {
            'rssAlertsList': RssAlertsList,
            'rssAlertsCreate': RssAlertsCreate,
            'rssAlertsEdit': RssAlertsEdit,
        },
        created: function() {
        	this.getRSSAlerts();
        }
    }
</script>