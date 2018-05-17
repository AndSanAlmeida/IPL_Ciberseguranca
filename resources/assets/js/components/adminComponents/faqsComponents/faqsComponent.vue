<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">FAQs</h2>
		  </div>
		</header>

        <faqsList 
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
                faq: '',
                faqs: [],
                showList: true,
                showCreate: false,
                showEdit: false,
                showDetails: false,
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
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
                                            this.getFaqs();
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