<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

        <div class="card card-outline-secondary">
            <div class="card-header">
                <h1 class="mb-0 text-center">{{name}}</h1>
            </div>
            <div class="card-body">
                
                <div class="item">  
                    <div class="col-sm-12" v-if="image">
                        <img :src="image" class="mx-auto d-block img-fluid mb-2" alt="Imagem do evento"/>
                    </div>
                </div>

                <p><b>Organizador do Evento: </b>{{organizer}}</p>

                <p><b>Localização: </b>{{localization}}</p>

                <p><b>Data do Evento: </b>{{shortDate}}</p>

                <p><b>Descrição: </b><spam v-html="description"></spam></p>

                <p><b>Estado: </b>{{status == 0 ? 'Por Realizar' : status == 0 ? 'A Decorrer' : 'Concluido'}}</p>
                 
                <p v-if="document"><b>Documento: </b><a :href="document" :download ="name" role="button">Ver Documento</a></p>

                <hr>
                <p><b>Lotação: </b>{{max_inscritos}}</p>
    
                <p><b>Total de Inscritos: </b>{{total_interested}}</p>
                
                <div v-if="total_interested != 0">
                    <button class="btn btn-primary" v-on:click="showHideUsers()">{{buttonText}}</button>

                    <div v-if="showUsers">
                        <div class="table-responsive mt-4">                       
                            <div class="card">
                              <b-table responsive 
                                stacked="md"
                                :items="users" 
                                :fields="fields"
                                :current-page="currentPage"
                                :per-page="perPage"> 
                                <template slot="status" slot-scope="row">
                                  {{row.item.status == 0 ? 'Por Realizar' : row.item.status == 0 ? 'A Decorrer' : 'Concluido'}}
                                </template>
                                <template slot="actions" slot-scope="row">
                                  <button type="button" class="btn btn-primary" v-on:click="viewEvent(row.item)">Ver detalhes</button>
                                  <button type="button" class="btn btn-warning" v-on:click="editEvent(row.item)">Editar</button>
                                  <button type="button" class="btn btn-danger" v-on:click="deleteEvent(row.item)">Eliminar</button>
                                </template>
                              </b-table>
                              <hr>
                              <b-pagination :total-rows="users.length" 
                                  :per-page="perPage" 
                                  v-model="currentPage"
                                  align="center"/>
                            </div>
                          </div>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"></label>
                    <div class="col-lg-9">
                        <input class="btn btn-secondary float-right" value="Voltar" type="button" v-on:click="cancel">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        props: ['item'],
        data: function() {
            return {
                name: '',
                organizer: '',
                localization: '',
                description: '',
                date: new Date,
                shortDate: new Date,
                max_inscritos: 0,
                status: '',
                document: '',
                image:'',
                total_interested: '',
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
                buttonText: 'Ver utilizadores inscritos',
                showUsers: false,
                users: [],
                fields: [
                    { key: 'id', label:'#'},
                    { key: 'name', label:'Nome'},
                    { key: 'email', label:'Email'},
                    
                ],
                currentPage: 1,
                perPage: 10
            }
        },
        methods: {
            showHideUsers: function() {
                if (this.showUsers == true) {
                    this.showUsers =false; 
                    this.buttonText = 'Mostar utilizadores inscritos'
                } else {
                    this.buttonText = 'Ocultar utilizadores inscritos'
                    this.showUsers =true;

                    this.getSignedUsers();
                }
            },
            getSignedUsers: function() {
                if (this.users.length == 0) {
                    
                    axios.get('/api/events/'+this.item.id+'/users')
                        .then((response) => {
                            this.users = response.data.data;
                        })
                        .catch((error) => {
                            this.serverError = true;
                            console.log(error);
                            this.serverErrorMessage = error.response.data.data;
                        });
                }
            },
            getEvento: function() {
                axios.get('/api/events/'+this.item.id)
                .then((response) => {
                    this.name = response.data.name;
                    this.organizer = response.data.organizer;
                    this.localization = response.data.localization;
                    this.description = response.data.description;
                    this.date = new Date(response.data.date);
                    this.max_inscritos = response.data.max_inscritos;
                    this.status = response.data.status;
                    this.document = response.data.path;
                    this.image = '/' + response.data.image_path;
                    this.total_interested = response.data.total_interested;
                    this.formatDate();
                })
                .catch((error) => {
                    this.serverError = true;
                    console.log(error);
                    this.serverErrorMessage = error.response.data.data;
                });
            },
            cancel: function() {
                this.exit();
            },
            exit: function() {
                this.$emit('exit');
            },
            formatDate: function() {
                var dateObj = this.date;
                var month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                var date = ('0' + dateObj.getDate()).slice(-2);
                var year = dateObj.getFullYear();
                this.shortDate = year + '-' + month + '-' + date;
            },
        },
        mounted: function () {
            this.getEvento();
        }
    }
</script>