<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

    
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Editar Entrada do Glossário</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Nome</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="name" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingName ">
                            <p v-if="missingName">Preencher nome</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeName ">
                            <p v-if="invalidSizeName">Tamanho do nome excedido (Max: 100)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Definição</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" v-model="definition" rows="7" required ></textarea>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingDefinition ">
                            <p v-if="missingDefinition">Preencher definição</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeDefinition ">
                            <p v-if="invalidSizeDefinition">Tamanho do definição excedido (Max: 100)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Fonte</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" v-model="source" rows="7" required ></textarea>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingSource ">
                            <p v-if="missingSource">Preencher fonte</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeSource ">
                            <p v-if="invalidSizeSource">Tamanho da fonte excedido (Max: 100)</p>
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

    import Datepicker from 'vuejs-datepicker';
    import swal from 'sweetalert';

    export default {
        data: function() {
            return {
                id: this.$route.params.id,
                name: '',
                definition: '',
                source: '',
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
            }
        },
        components: {
        },
        computed: {
            missingName: function () {
                return this.name.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeName: function() {
                return this.name.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            missingDefinition: function() {
                return this.definition.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeDefinition: function() {
                return this.definition.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            missingSource: function () {
                return this.source.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeSource: function() {
                return this.source.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
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
            getGlossaryItem: function(id) {
                axios.get('/api/glossary/'+this.id)
                .then((response) => {
                    this.name = response.data.name;
                    this.definition = response.data.definition;
                    this.source = response.data.source;
                })
                .catch((error) => {
                    this.serverError = true;
                    console.log(error);
                    this.serverErrorMessage = error.response.data.data;
                });
            },
            submitForm: function (glossaryItem) {
                this.serverError = false;
                this.attemptSubmit = true;
                if (!this.isFormInvalid) {
                    const data = {
                        name: this.name,
                        definition: this.definition,
                        source: this.source,
                    };

                    axios.post('/api/glossary/'+ this.id +'/update', data)
                    .then((response) => {
                        swal("Entrada do glossário alterada com sucesso.", {
                            icon: 'success',
                            buttons: {
                                ok: "Ok"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "ok":
                                window.location.href = '/admin/#/glossary'
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
                        window.location.href = '/admin/#/glossary'
                        break;
                    }
                });
            },
            
        },
        mounted: function () {
            this.getGlossaryItem();
        }
    }
</script>