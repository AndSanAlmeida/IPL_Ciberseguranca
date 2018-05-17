<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Links Úteis</h2>
		  </div>
		</header>

		<usefulLinksList 
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
            	link: '',
                usefulLinks: [],
                showList: true,
                showCreate: false,
                showEdit: false,
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
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