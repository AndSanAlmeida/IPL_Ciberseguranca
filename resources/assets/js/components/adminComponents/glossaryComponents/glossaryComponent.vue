<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Glossário</h2>
		  </div>
		</header>

		<glossaryList :glossary="glossary" @delete-click="deleteGlossary"></glossaryList>

	</div>
</template>

<script type="text/javascript">
    import GlossaryList from './glossaryListComponent.vue';
    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                glossary: [],
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
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
        },
        mounted() {
            this.getGlossary();
        }
    }
</script>