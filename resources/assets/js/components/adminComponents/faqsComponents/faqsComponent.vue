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
            <p class="mb-0"><a href="javascript:;" class="alert-link" title="Criar FAQs" v-on:click="createFaq()">Criar {{title}}</a></p>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="loader mt-3"></div>
        
        <!-- ============ -->

        <faqsList 
            v-show="hasItems && canShowContent"
            :faqs="faqs" 
            v-if="showList"
            @seeMoreDetails="seeMoreDetails"
            @createFaq="createFaq"
            @editFaq="editFaq"
            @deleteFaq="deleteFaq">   
        </faqsList>

        <faqCreate
            v-if="showCreate"
            @exit="exit">
        </faqCreate> 

        <faqEdit
            :faq="faq"
            v-if="showEdit"
            @exit="exit">
        </faqEdit>

        <faqDetails
            :faq="faq"
            v-if="showDetails"
            @exit="exit">
        </faqDetails>

	</div>
</template>

<script type="text/javascript">
    import FaqsList from './faqsListComponent.vue';
    import FaqsCreate from './faqsCreateComponent.vue';
    import FaqsEdit from './faqsEditComponent.vue';  
    import FaqsDetails from './faqsDetailsComponent.vue';

    import swal from 'sweetalert';

    export default {
        data: function () {
            return {
                title: 'FAQs',
                faq: '',
                faqs: [],
                showList: true,
                showCreate: false,
                showEdit: false,
                showDetails: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.faqs.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            seeMoreDetails: function(faq) {
                this.faq = faq;
                this.showList = false;
                this.showCreate = false;
                this.showEdit = false;
                this.showDetails = true;
            },
            exit: function(){
                this.showList = true;
                this.showCreate = false;
                this.showEdit = false;
                this.showDetails = false;
                this.getFaqs();
            },
            createFaq: function() {
                this.showList = false;
                this.showCreate = true;
                this.showEdit = false;
                this.showDetails = false;
            },
            editFaq: function(faq) {
                this.faq = faq;
                this.showList = false;
                this.showCreate = false;
                this.showEdit = true;
                this.showDetails = false;
            },
            getFaqs: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/faqs')
                    .then(response => {
                        this.faqs = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                    });
            },
            deleteFaq : function(faq){
              swal("Pertende realmente apagar esta FAQ?", {
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
                        axios.delete('/api/faqs/'+faq.id+'/delete')
                          .then((response) => {
                            swal("FAQ apagada com sucesso.", {
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
                                this.getFaqs();
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
            'faqsList': FaqsList,
            'faqCreate': FaqsCreate,
            'faqEdit': FaqsEdit,
            'faqDetails': FaqsDetails,
        },
        mounted() {
            this.getFaqs();
        }
    }
</script>