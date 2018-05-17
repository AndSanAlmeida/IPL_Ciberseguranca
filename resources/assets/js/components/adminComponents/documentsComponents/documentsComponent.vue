<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Documentos</h2>
		  </div>
		</header>

		<documentsList 
			:documents="documents" 
			@createDocument="createDocument"
			@editDocument="editDocument"
			@deleteDocument="deleteDocument"
			v-if="showList">	
		</documentsList>

		<documentsCreate
			v-if="showCreate"
			@exit="exit">
		</documentsCreate> 

		<documentsEdit
			:document="document"
			v-if="showEdit"
			@exit="exit">
		</documentsEdit>

	</div>
</template>

<script type="text/javascript">
    import DocumentsList from './documentsListComponent.vue';
    import DocumentsCreate from './documentsCreateComponent.vue';
    import DocumentsEdit from './documentsEditComponent.vue';
    

    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	document: '',
                documents: [],
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
                this.getDocuments();
        	},
        	createDocument: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showEdit = false;
        	},
        	editDocument: function(document) {
        		this.document = document;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = true;
        	},
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
            deleteDocument : function(document){
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
		                axios.delete('/api/documents/'+document.id+'/delete')
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
            'documentsCreate': DocumentsCreate,
            'documentsEdit': DocumentsEdit,
        },
        mounted() {
            this.getDocuments();
        }
    }
</script>