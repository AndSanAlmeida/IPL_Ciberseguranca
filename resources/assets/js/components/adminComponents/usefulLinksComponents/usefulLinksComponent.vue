<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Links Úteis</h2>
		  </div>
		</header>

		<usefulLinksList :usefulLinks="usefulLinks" @delete-click="deleteUsefulLinks"></usefulLinksList>

	</div>
</template>

<script type="text/javascript">
    import UsefulLinks from './usefulLinksListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                usefulLinks: [],
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
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
            deleteUsefulLinks : function(link){
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
        },
        mounted() {
            this.getUsefulLinks();
        }
    }
</script>