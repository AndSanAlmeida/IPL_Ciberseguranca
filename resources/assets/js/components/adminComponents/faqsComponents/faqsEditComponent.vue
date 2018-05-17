<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

    
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Editar FAQ</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Questão</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="faqEdited.question" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingQuestion ">
                            <p v-if="missingQuestion">Preencher questão</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Resposta</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="faqEdited.answer" required>
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
        props: ['faq'],
        data: function() {
            return {
                faqEdited: this.faq,
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
            }
        },
        components: {
        },
        computed: {
            missingQuestion: function () {
              return this.faqEdited.question.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            missingAnswer: function () {
              return this.faqEdited.answer.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
              return (this.missingQuestion || this.missingAnswer);
            },
            hasClientError: function () {
                return (this.missingName || this.missingDefinition || this.missingSource || this.invalidSizeName || this.invalidSizeDefinition || this.invalidSizeSource);
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
            submitForm: function () {
                this.serverError = false;
                this.attemptSubmit = true;
                if (!this.isFormInvalid) {
                    const data = {
                        question: this.faqEdited.question,
                        answer: this.faqEdited.answer,
                    };

                    axios.post('/api/faqs/'+ this.faq.id +'/update', data)
                    .then((response) => {
                        swal("FAQ alterada com sucesso.", {
                            icon: 'success',
                            buttons: {
                                ok: "Ok"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "ok":
                                this.exit();
                                break;
                            }
                        });
                    })
                    .catch((error) => {
                        this.serverError = true;
                        this.serverErrorMessage = error.response.data.data;
                    });
                }
            },
            cancel: function() {
                swal("Deseja realmente sair?", {
                    icon: "warning",
                    buttons: {
                        no: "Não",
                        yes: "Sim",
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "no":
                        break;

                        case "yes":
                        this.exit();
                        break;
                    }
                });
            },
            exit: function() {
                this.$emit('exit');
            }
        },
        mounted: function () {
        }
    }
</script>