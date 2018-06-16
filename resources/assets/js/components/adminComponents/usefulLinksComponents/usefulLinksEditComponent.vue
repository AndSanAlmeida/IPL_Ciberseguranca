<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

    
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Editar Link Útil</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="description">
                            <div class="clearfix mt-2">
                                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingDescription ">Preencher descrição</b-alert>
                                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && invalidSizeDescription ">Descrição demasiado longa (Max: 100)</b-alert>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">URL</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="url" v-model="linkURL">
                            <div class="clearfix mt-2">
                                <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingLink ">Preencher url</b-alert>
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
    import swal from 'sweetalert';

    export default {
        props: ['link'],
        data: function() {
            return {
                description: '',
                linkURL: '',
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
            }
        },
        components: {
        },
        computed: {
            missingDescription: function () {
              return this.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeDescription: function () {
              return this.description.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            missingLink: function () {
              return this.linkURL.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
              return (this.missingDescription || this.missingLink);
            },
            hasServerError: function () {
              return this.serverError;
            },
            isFormInvalid: function () {
              return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
            getUsefulLink: function(id) {
                axios.get('/api/usefulLinks/'+this.link.id)
                .then((response) => {
                    this.description = response.data.description;
                    this.linkURL = response.data.link;
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
                        description: this.description,
                        link: this.linkURL,
                    };

                    axios.post('/api/usefulLinks/'+ this.link.id +'/update', data)
                    .then((response) => {
                        swal("Link útil alterado com sucesso.", {
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
            this.getUsefulLink();
        }
    }
</script>