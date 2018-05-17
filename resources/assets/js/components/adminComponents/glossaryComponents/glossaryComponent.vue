<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Glossário</h2>
		  </div>
		</header>

		<glossaryList 
			:glossary="glossary" 
			v-if="showList"
			@createGlossary="createGlossary"
			@viewGlossary="viewGlossary"
			@editGlossary="editGlossary"
			@deleteGlossary="deleteGlossary">
		</glossaryList>

		<glossaryCreate
			v-if="showCreate"
			@exit="exit">
		</glossaryCreate> 

		<glossaryEdit
			:item="item"
			v-if="showEdit"
			@exit="exit">
		</glossaryEdit>

		<glossaryView
			:item="item"
			v-if="showView"
			@exit="exit">
		</glossaryView>

	</div>
</template>

<script type="text/javascript">
    import GlossaryList from './glossaryListComponent.vue';
    import GlossaryCreate from './glossaryCreateComponent.vue';
    import GlossaryEdit from './glossaryEditComponent.vue';
    import GlossaryView from './glossaryDetailsComponent.vue';
    
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
            	item: '',
                glossary: [],
                showList: true,
                showCreate: false,
                showView:false,
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
                this.showView = false;
                this.getGlossary();
        	},
        	createGlossary: function() {
        		this.showList = false;
                this.showCreate = true;
                this.showEdit = false;
                this.showView = false;
        	},
        	viewGlossary: function(item) {
        		this.item = item;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = false;
                this.showView = true;
        	},
        	editGlossary: function(item) {
        		this.item = item;
        		this.showList = false;
                this.showCreate = false;
                this.showEdit = true;
                this.showView = false;
        	},
            getGlossary: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/glossary')
                    .then(response => {
                        this.glossary = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            deleteGlossary : function(glossary){
		      swal("Pertende realmente apagar esta entrada do glossário?", {
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
		                axios.delete('/api/glossary/'+glossary.id+'/delete')
		                  .then((response) => {
		                    swal("Entrada do glossário apagado com sucesso.", {
		                    	icon: "success",
		                            buttons: {
		                                ok: "Ok"
		                            },
		                        })
		                        .then((value) => {
		                            switch (value) {
		                                case "ok":
		                                	this.getGlossary();
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
            'glossaryList': GlossaryList,
            'glossaryCreate': GlossaryCreate,
            'glossaryEdit': GlossaryEdit, 
            'glossaryView': GlossaryView,
        },
        mounted() {
            this.getGlossary();
        }
    }
</script>