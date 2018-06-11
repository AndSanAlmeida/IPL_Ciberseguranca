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
		  	<p class="mb-0"><a href="#" class="alert-link" title="Criar Links Úteis" v-on:click="createLink()">Criar {{title}}</a></p>
		</div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="align-loader mt-4">
            <div class="loader"></div>
        </div>
        
        <!-- ============ -->

		<usefulLinksList 
			v-show="hasItems && canShowContent"
			:usefulLinks="usefulLinks" 
			v-if="showList"
			@createLink="createLink"
			@editLink="editLink"
			@deleteLink="deleteLink">	
		</usefulLinksList>

		<usefulLinksCreate
			v-if="showCreate"
			@exit="exit">
		</usefulLinksCreate> 

		<usefulLinksEdit
			:link="link"
			v-if="showEdit"
			@exit="exit">
		</usefulLinksEdit>
	</div>
</template>

<script type="text/javascript">
    import UsefulLinks from './usefulLinksListComponent.vue';
    import UsefulLinksCreate from './usefulLinksCreateComponent.vue';
    import UsefulLinksEdit from './usefulLinksEditComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	title: 'Links Úteis',
            	link: '',
                usefulLinks: [],
                showList: true,
                showCreate: false,
                showEdit: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.usefulLinks.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
        	exit: function(){
        		this.showList = true;
                this.showCreate = false;
                this.showEdit = false;
                this.getUsefulLinks();
        	},
        	createLink: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showEdit = false;
        	},
        	editLink: function(link) {
        		this.link = link;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = true;
        	},
            getUsefulLinks: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/usefulLinks')
                    .then(response => {
                        this.usefulLinks = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            deleteLink : function(link){
		      swal("Pertende realmente apagar este link útil?", {
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
		                axios.delete('/api/usefulLinks/'+link.id+'/delete')
		                  .then((response) => {
		                    swal("Link útil apagado com sucesso.", {
		                    	icon: "success",
		                            buttons: {
		                                ok: "Ok"
		                            },
		                        })
		                        .then((value) => {
		                            switch (value) {
		                                case "ok":
		                                	this.getUsefulLinks();
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
            'usefulLinksList': UsefulLinks,
            'usefulLinksCreate': UsefulLinksCreate,
            'usefulLinksEdit': UsefulLinksEdit,
        },
        mounted() {
            this.getUsefulLinks();
        }
    }
</script>