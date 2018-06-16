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
                            <input class="form-control" type="text" v-model="name">
                            <div class="clearfix mt-2">
                                  <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingName ">Preencher nome da entrada</b-alert>
                                  <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && invalidSizeName ">Nome demasiado longa (Max: 100)</b-alert>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Definição</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" v-model="definition" rows="7" ></textarea>
                            <div class="clearfix mt-2">
                                  <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missiingDefinition ">Preencher definição</b-alert>

                              </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Fonte</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" v-model="source" rows="7" ></textarea>
                            <div class="clearfix mt-2">
                              <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingName ">Preencher fonte</b-alert>
                              <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && invalidSizeName ">Fonte demasiado longa (Max: 100)</b-alert>
                            </div>
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
        props: ['item'],
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
            missiingDefinition: function() {
              return this.definition.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            missingSource: function () {
              return this.source.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeSource: function() {
              return this.source.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
              return (this.missingName || this.invalidSizeName || this.missiingDefinition || this.missingSource || this.invalidSizeSource);
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
                axios.get('/api/glossary/'+this.item.id)
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

                    axios.post('/api/glossary/'+ this.item.id +'/update', data)
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
            this.getGlossaryItem();
        }
    }
</script>