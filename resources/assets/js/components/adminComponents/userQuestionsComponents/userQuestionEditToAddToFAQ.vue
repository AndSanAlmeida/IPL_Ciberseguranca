<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

    
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Adicionar FAQ</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Questão</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="questionFromUser.question" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingQuestion ">
                            <p v-if="missingQuestion">Preencher pergunta</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Resposta</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="questionFromUser.answer" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingAnswer ">
                            <p v-if="missingAnswer">Preencher resposta</p>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"></label>
                        <div class="col-lg-9 text-right">
                            <input class="btn btn-secondary" value="Cancelar" type="button" v-on:click="cancel">
                            <input class="btn btn-primary" type="submit" value="Confirmar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import swal from 'sweetalert';

    export default {
        props: ['question'],
        data: function() {
            return {
                questionFromUser: this.question,
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
            }
        },
        components: {
        },
        computed: {
            missingQuestion: function () {
              return this.questionFromUser.question.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            missingAnswer: function () {
              return this.questionFromUser.answer.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
              return (this.missingQuestion || this.missingAnswer);
            },
            hasClientError: function () {
                return (this.missingQuestion || this.missingAnswer);
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
            submitForm: function (questionFromUser) {
                this.serverError = false;
                this.attemptSubmit = true;
                if (!this.isFormInvalid) {
                    const data = {
                        id: this.questionFromUser.id,
                        question: this.questionFromUser.question,
                        answer: this.questionFromUser.answer,
                    };

                    axios.post('/api/faqs/create', data)
                    .then((response) => {
                        swal("FAQ adicionada com sucesso.", {
                            icon: "success",
                                buttons: {
                                    ok: "Ok"
                                },
                            });
                            this.cancel();
                    })
                    .catch((error) => {

                    }); 
                }
            },
            cancel: function() {
                this.$emit('cancel');
            },
            
        },
        created: function () {
            
        }
    }
</script>