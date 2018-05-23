<template>
	<div>
		<header class="page-header">
		  <div class="container-fluid">
		    <h2 class="no-margin-bottom">Questões dos Utilizadores</h2>
		  </div>
		</header>

        <userNotAnsweredQuestionsListComponent 
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
                question: [],
                notAnswered: [],
                showList: true,
                showDetails: false,
                showSuccess: false,
                successMessage: '',
                loading: true,
                errorLoading: false,
            }
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
        }
    }
</script>