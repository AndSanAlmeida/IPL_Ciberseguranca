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
        </div>

        <div class="alert alert-danger" role="alert" v-if="errorLoading">
            <p>Erro ao pesquisar os dados tente novamente.</p>
        </div>

        <!-- LOADING -->
        <div v-if="loading" class="align-loader mt-4">
            <div class="loader"></div>
        </div>
        
        <!-- ============ -->

        <userAllQuestionsListComponent 
            v-show="hasItems && canShowContent"
            v-if="showList"
            :questions="questions" 
            @deleteQuestion="deleteQuestion" 
            @answerQuestion="useInFAQ"
            @seeMoreDetails="seeMoreDetails">
        </userAllQuestionsListComponent>

        <userQuestionDetailsComponent
            :question="question"
            @cancel="cancel"
            v-if="showDetails">
        </userQuestionDetailsComponent>

        <editToAddToFAQComponent
            :question="question"
            @cancel="cancel"
            v-if="showEdit">
        </editToAddToFAQComponent>

	</div>
</template>

<script type="text/javascript">
    import swal from 'sweetalert';
    import UserAllQuestionsListComponent from './userAllQuestionsListComponent.vue';
    import UserQuestionDetailsComponent from './userQuestionDetailsComponent.vue';
    import EditToAddToFAQComponent from './userQuestionEditToAddToFAQ.vue';

    export default {
        data: function () {
            return {
                title: 'Questões dos Utilizadores',
                question: [],
                questions: [],
                showList: true,
                showDetails: false,
                showEdit: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.questions.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            cancel: function() {
                this.question = '';
                this.showEdit = false;
                this.showDetails = false;
                this.showList = true;
            },
            seeMoreDetails: function(question) {
                this.question = question;
                this.showDetails = true;
                this.showList = false;
                this.showEdit = false;
            },
            editToAddFAQ: function(question) {
                this.question = question;
                this.showDetails = false;
                this.showList = false;
                this.showEdit = true;
            },
            getQuestions: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/questions/answered')
                    .then(response => {
                        this.questions = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            useInFAQ: function(question) {
                swal("Pretende editar a pergunta/resposta antes de adicionar às FAQs?", {
                    buttons: {
                        cancel: "Cancelar",
                        no: {
                            text: "Não",
                            value: "no",
                        },
                        yes: {
                            text: "Sim",
                            value: "yes",
                        },
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "yes":
                            this.editToAddFAQ(question);
                            break;
                 
                        case "no":
                            this.addQuestionToFAQs(question);
                            break;
                
                        default:
                      
                    }
                });
            },
            addQuestionToFAQs: function(question) {
                const data = {
                    id: question.id,
                    question: question.question,
                    answer: question.answer,
                }
                axios.post('/api/faqs/create', data)
                    .then((response) => {
                        swal("FAQ adicionada com sucesso.", {
                            icon: "success",
                                buttons: {
                                    ok: "Ok"
                                },
                            });
                            this.getQuestions();
                    })
                    .catch((error) => {

                    });    
            },
            deleteQuestion: function(question) {
                swal("Pertende realmente apagar esta pergunta?", {
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
                            axios.delete('/api/questions/'+question.id+'/delete')
                                .then((response) => {
                                    swal("Pergunta apagada com sucesso.", {
                                        icon: "success",
                                            buttons: {
                                                ok: "Ok"
                                            },
                                        })
                                        .then((value) => {
                                            switch (value) {
                                                case "ok":
                                                    this.getQuestions();
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
            'userAllQuestionsListComponent': UserAllQuestionsListComponent,
            'userQuestionDetailsComponent': UserQuestionDetailsComponent,
            'editToAddToFAQComponent': EditToAddToFAQComponent,
        },
        mounted() {
            this.getQuestions();
        }
    }
</script>