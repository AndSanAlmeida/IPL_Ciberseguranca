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

        <div class="text-center">
            <router-link v-if="hasQuestions" to="/userQuestions/all" class="mt-5 btn btn-primary btn-lg">Ver histórico de questões</router-link>
        </div>

        <userNotAnsweredQuestionsListComponent 
            v-show="hasItems && canShowContent"
            v-if="showList"
            :notAnswered="notAnswered" 
            @seeMoreDetails="seeMoreDetails"
            @answerQuestion="answerQuestion" 
            @deleteNotAnswered="deleteNotAnswered">        
        </userNotAnsweredQuestionsListComponent>

        <userQuestionDetailsComponent
            :question="question"
            @cancel="cancel"
            v-if="showDetails">
        </userQuestionDetailsComponent>

	</div>
</template>

<script type="text/javascript">
    import swal from 'sweetalert';
    import UserNotAnsweredQuestionsListComponent from './userNotAnsweredQuestionsListComponent.vue';
    import UserQuestionDetailsComponent from './userQuestionDetailsComponent.vue';

    export default {
        data: function () {
            return {
                title: 'Questões dos Utilizadores',
                question: [],
                notAnswered: [],
                allQuestions: [],
                showList: true,
                showDetails: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.notAnswered.length > 0;
            },
            hasQuestions: function () {
                return this.allQuestions.length > 0;
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
            },
            getAllQuestions: function () {                
                axios.get('/api/questions/answered')
                    .then(response => {
                        this.allQuestions=  response.data.data;
                });
            },
            getNotAnsweredQuestions: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/questions/notAnswered')
                    .then(response => {
                        this.notAnswered = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            answerQuestion: function(question) {
                swal("Pergunta: " +question.question, {
                    content: "input",
                  })
                  .then((value) => {
                    if (value != '') {
                        const data = {
                            id: question.id,
                            answer: value,
                        }
                        axios.post('/api/questions/answer', data)
                            .then((response) => {
                                swal("Pergunta respondida com sucesso.", {
                                    icon: "success",
                                        buttons: {
                                            ok: "Ok"
                                        },
                                    })
                                    .then((value) => {
                                        switch (value) {
                                            case "ok":
                                                this.getNotAnsweredQuestions();
                                                this.getAllQuestions();
                                                break;
                                        }
                                    });
                            })
                            .catch((error) => {

                            });    
                    } else {
                        swal("Preencher resposta.", {
                                    icon: "warning",
                                        buttons: {
                                            ok: "Ok"
                                        },
                                    })
                                    .then((value) => {
                                        switch (value) {
                                            case "ok":
                                                this.getNotAnsweredQuestions();
                                                break;
                                        }
                                    });
                    }   
                });
            },
            deleteNotAnswered: function(question) {
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
                                                    this.getNotAnsweredQuestions();
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
            'userNotAnsweredQuestionsListComponent': UserNotAnsweredQuestionsListComponent,
            'userQuestionDetailsComponent': UserQuestionDetailsComponent,
        },
        mounted() {
            this.getNotAnsweredQuestions();
            this.getAllQuestions();
        }
    }
</script>