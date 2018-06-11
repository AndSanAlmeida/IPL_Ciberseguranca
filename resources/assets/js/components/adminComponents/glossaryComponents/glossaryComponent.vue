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
            <p class="mb-0"><a href="#" class="alert-link" title="Criar Entrada" v-on:click="createGlossary()">Criar {{title}}</a></p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="align-loader mt-4">
            <div class="loader"></div>
        </div>
        
        <!-- ============ -->

		<glossaryList 
            v-show="hasItems && canShowContent"
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
                title: 'Glossário',
            	item: '',
                glossary: [],
                showList: true,
                showCreate: false,
                showView:false,
                showEdit: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.glossary.length > 0;
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