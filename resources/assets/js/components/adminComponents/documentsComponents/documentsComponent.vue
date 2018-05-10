<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Documentos</h2>
		  </div>
		</header>

		<documentsList :documents="documents" @delete-click="deleteDocuments"></documentsList>

	</div>
</template>

<script type="text/javascript">
    import DocumentsList from './documentsListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                documents: [],
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
            getDocuments: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/documents')
                    .then(response => {
                        this.documents = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            deleteDocuments : function(link){
		      swal("Pertende realmente apagar este documento?", {
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
		                axios.delete('/api/documents/'+link.id+'/delete')
		                  .then((response) => {
		                    swal("Documento apagado com sucesso.", {
		                    	icon: "success",
		                            buttons: {
		                                ok: "Ok"
		                            },
		                        })
		                        .then((value) => {
		                            switch (value) {
		                                case "ok":
		                                	this.getDocuments();
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
            'documentsList': DocumentsList,
        },
        mounted() {
            this.getDocuments();
        }
    }
</script>