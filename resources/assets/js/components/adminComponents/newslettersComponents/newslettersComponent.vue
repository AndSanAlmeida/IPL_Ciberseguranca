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
		  	<p class="mb-0"><a href="javascript:;" class="alert-link" title="Criar Newsletters" v-on:click="createNewsletter()">Criar {{title}}</a></p>
		</div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="loader mt-3"></div>
        
        <!-- ============ -->

		<newslettersList 
			v-show="hasItems && canShowContent"
			:newsletters="newsletters" 
			@showNewsletter="showNewsletter"
			@createNewsletter="createNewsletter"
			@deleteNewsletter="deleteNewsletter"
			@publishNewsletter="publishNewsletter"
			v-if="showList">	
		</newslettersList>

		<newslettersCreate
			v-if="showCreate"
			@exit="exit">
		</newslettersCreate> 

		<newslettersDetails
			:newsletter="newsletter"
			v-if="showDetails"
			@exit="exit">
		</newslettersDetails> 

	</div>
</template>

<script type="text/javascript">
    import NewslettersList from './newslettersListComponent.vue';
    import NewslettersCreate from './newslettersCreateComponent.vue';
    import NewslettersDetails from './newslettersDetailsComponent.vue';

    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	title: 'Newsletters',
            	newsletter: '',
                newsletters: [],
                showList: false,
                showDetails: false,
                showCreate: false,
                showEdit: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.newsletters.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
        	showNewsletter: function(newsletter) {
        		this.newsletter = newsletter;
        		this.showList = false;
                this.showCreate = false;
                this.showDetails = true;
        	},
        	publishNewsletter: function(newsletter) {
        		swal("Pretende realmente publicar esta newsletter?","A newsletter será enviada para todos os utilizadores subscritos à newsletter.", {
		          icon: "info",
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
		                axios.post('/api/newsletters/'+newsletter.id+'/publish')
		                  .then((response) => {
		                    swal("Newsletter publicada com sucesso.", {
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
		                        this.getNewsletters();
		                  })
		                  .catch((error) => {
		                  	this.loading = false;
	                    	this.errorLoading = true;
		                  });                  
		                  break;
		          }
		      });
        	},
        	exit: function(){
        		this.showList = true;
                this.showCreate = false;
                this.showDetails = false;
                this.getNewsletters();
        	},
        	createNewsletter: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showDetails = false;
        	},
            getNewsletters: function () {
                this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/newsletters')
                    .then(response => {
                        this.newsletters = response.data.data;
                        this.newsletters.sort(function(a,b){
		                  var c = new Date(a.date);
		                  var d = new Date(b.date);
		                  return d-c;
		                });
                        if (response.data.data.length > 0) {
                        	this.showList = true;
                        }
                        this.loading = false;
						this.errorLoading = false;
                    }).catch((error) => {
	                    this.loading = false;
	                    this.errorLoading = true;
	                });
            },
            deleteNewsletter : function(newsletter){
		      swal("Pretende realmente apagar esta newsletter?", {
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
		                axios.delete('/api/newsletters/'+newsletter.id+'/delete')
		                  .then((response) => {
		                    swal("Newsletter apagada com sucesso.", {
		                    	icon: "success",
		                            buttons: {
		                                ok: "Ok"
		                            },
		                        })
		                        .then((value) => {
		                            switch (value) {
		                                case "ok":
		                                	this.getNewsletters();
		                                	break;
		                            }
		                        });
		                  })
		                  .catch((error) => {

		                  });                  
		                  break;
		          }
		      });
		    }
        },
        components: {
            'newslettersList': NewslettersList,
            'newslettersCreate': NewslettersCreate,
            'newslettersDetails': NewslettersDetails,
        },
        mounted() {
            this.getNewsletters();
            if (this.newsletters.length > 0)
            	this.showList = true;
        }
    }
</script>