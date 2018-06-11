<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

    
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Editar Evento</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitForm">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Nome do Evento</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="name" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingName ">
                            <p v-if="missingName">Preencher nome do evento</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeName ">
                            <p v-if="invalidSizeName">Tamanho do nome excedido (Max: 100)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Organizador</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="organizer" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingOrganizer ">
                            <p v-if="missingOrganizer">Preencher organizador</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeOrganizer ">
                            <p v-if="invalidSizeOrganizer">Tamanho do organizador excedido (Max: 100)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Localização</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" v-model="localization" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingLocalization ">
                            <p v-if="missingLocalization">Preencher localização</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeLocalization ">
                            <p v-if="invalidSizeLocalization">Tamanho da localização excedido (Max: 100)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Data</label>
                        <div class="col-lg-9">
                            <datepicker v-model="date" input-class="form-control" required typeable></datepicker>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Lotação</label>
                        <div class="col-lg-3">
                            <input class="form-control" type="number" v-model="max_inscritos" required>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingLocalization ">
                            <p v-if="missingLocalization">Preencher Lotação</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" v-model="description" rows="7" required ></textarea>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingDescription ">
                            <p v-if="missingDescription">Preencher descrição</p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && invalidSizeDescription ">
                            <p v-if="invalidSizeDescription">Tamanho da descrição excedido(Max: 250)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fileInput" class="col-lg-3 col-form-label form-control-label">Documento</label>
                        <div class="col-lg-9" v-if="path == null">
                            <input id="fileInput" type="file" accept=".pdf" class="form-control-file" v-on:change="onFileChange" required>
                        </div>
                        <div class="col-lg-9" v-if="path != null">
                            <a class="btn btn-success" :href="path" :download=description>Ver documento</a>
                            <button class="btn btn-danger" type="button" v-on:click="deleteDocument">Remover</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imageInput" class="col-lg-3 form-control-label">Imagem</label>
                        <div class="col-lg-9" v-if="!imagePath || imagePath == null">
                            <input id="imageInput" type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control-file" v-on:change="onImageChange" required>
                        </div>
                        <div class="col-lg-9" v-if="imagePath">
                            <img :src="imagePath" class="img-fluid" alt="Imagem do evento"/>
                            <button class="btn btn-md btn-danger mt-3 float-right" @click="removeImage"  type="button">Remover Imagem</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Descrição</label>
                        <div class="col-lg-9">
                            <select class="custom-select" v-model="status">
                                <option value="0">Por Realizar</option>
                                <option value="1">A Decorrer</option>
                                <option value="2">Concluido</option>
                            </select>
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
                organizer: '',
                localization: '',
                description: '',
                date: '',
                max_inscritos: 0,
                path: '',
                status: '',
                image:'',
                imagePath: '',
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
            }
        },
        components: {
            Datepicker
        },
        computed: {
            missingName: function () {
                return this.name.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeName: function() {
                return this.name.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            missingOrganizer: function() {
                return this.organizer.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeOrganizer: function() {
                return this.organizer.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            missingLocalization: function () {
                return this.localization.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeLocalization: function() {
                return this.localization.trim().length > 100 && !this.hasServerError && this.attemptSubmit;
            },
            missingDescription: function () {
                return this.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidSizeDescription: function () {
                return this.localization.trim().length > 250 && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return (this.missingName || this.missingLocalization || this.missingDescription || this.invalidSizeName || this.invalidSizeOrganizer || this.invalidSizeLocalization);
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
            getEvento: function(id) {
                axios.get('/api/events/'+this.item.id)
                .then((response) => {
                    this.name = response.data.name;
                    this.organizer = response.data.organizer;
                    this.localization = response.data.localization;
                    this.description = response.data.description;
                    this.date = new Date(response.data.date);
                    this.max_inscritos = response.data.max_inscritos;
                    this.path = response.data.path;
                    this.status = response.data.status;
                    if (response.data.image_path == null) {
                        this.imagePath = response.data.image_path;
                    } else {
                        this.imagePath = '/' + response.data.image_path;
                    }                    
                })
                .catch((error) => {
                    this.serverError = true;
                    console.log(error);
                    this.serverErrorMessage = error.response.data.data;
                });
            },
            submitForm: function (event) {
                this.serverError = false;
                this.attemptSubmit = true;
                if (!this.isFormInvalid) {
                    var newDate = this.getDate();
                    const data = {
                        name: this.name,
                        organizer: this.organizer,
                        localization: this.localization,
                        description: this.description,
                        date: newDate,
                        max_inscritos: this.max_inscritos,
                        status: this.status,
                        path: this.path,
                        image: this.image,
                    };
                    axios.post('/api/events/'+ this.item.id +'/update', data)
                    .then((response) => {
                        swal("Evento alterado com sucesso.", {
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
            getDate:function() {
                        var month = this.date.getUTCMonth() + 1; //months from 1-12
                        var day = this.date.getUTCDate();
                var year = this.date.getUTCFullYear();

                var newdate = new Date(year,month,day);
                newdate = newdate.toISOString().slice(0, 19).replace('T', ' ');

                newdate = this.formatDate(newdate);

                console.log(newdate);
                return newdate;
            },
            formatDate: function(date) {
                var d = new Date(date),
                month = '' + d.getMonth(),
                day = '' + (d.getDate()+1),
                year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            },
            exit: function() {
                this.$emit('exit');
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
            onImageChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
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
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                    vm.imagePath = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.image = '';
                this.imagePath ='';
            },
            deleteDocument: function() {
                this.path = null;
            },
        },
        mounted: function () {
            this.getEvento();
        }
    }
</script>