<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

    
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Editar Documento</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="description" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingDescription ">
                            <p v-if="missingDescription">Preencher descrição</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeDescription ">
                            <p v-if="invalidSizeDescription">Tamanho da descrição excedido (Max: 100)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Ficheiro</label>
                        <div class="col-lg-9" v-if="path == null">
                            <input id="fileInput" type="file" accept=".pdf" class="form-control-file" v-on:change="onFileChange" required>
                        </div>
                        <div class="col-lg-9" v-if="path != null">
                            <a class="btn btn-success" :href="path" :download=description>Ver documento</a>
                            <button class="btn btn-danger" type="button" v-on:click="deleteDocument">Remover</button>
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
                description: '',
                path: '',
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
            invalidSizeDescription: function() {
                return this.description.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return (this.missingDescription || this.invalidSizeDescription);
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
            getDocument: function(id) {
                axios.get('/api/documents/'+this.id)
                .then((response) => {
                    this.description = response.data.description;
                    this.path = response.data.path;
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
                        path: this.path,
                    };

                    axios.post('/api/documents/'+ this.id +'/update', data)
                    .then((response) => {
                        swal("Documento alterado com sucesso.", {
                            icon: 'success',
                            buttons: {
                                ok: "Ok"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "ok":
                                window.location.href = '/admin/#/documents'
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
                        window.location.href = '/admin/#/documents'
                        break;
                    }
                });
            },
            deleteDocument: function() {
                this.path=null;
            },
            onFileChange(e) {
                var file1 = e.target.files[0];
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.path = e.target.result;
                };
                reader.readAsDataURL(file1);
                console.log(this.path);
        
            },
            
        },
        mounted: function () {
            this.getDocument();
        }
    }
</script>