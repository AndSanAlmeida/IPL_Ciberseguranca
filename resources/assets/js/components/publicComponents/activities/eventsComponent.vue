<template>
	<section id="activities" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                        <h1>{{ title }}</h1>
                    </div>

                    <div v-if="!hasItems && canShowContent" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Não existe Eventos disponíveis.</h4>
                    </div>

                    <div v-if="loading" class="loader"></div>

                    <div v-if="hasItems && canShowContent" id="events">

                        <b-table  id="eventTable" responsive 
                                  stacked="md"
                                  :items="eventos" 
                                  :fields="fields"
                                  :current-page="currentPage"
                                  :per-page="perPage"> 
                        
                            <template slot="actions" slot-scope="row">
                                <i v-if="!row.detailsShowing" class="fas fa-arrow-circle-down fa-2x" id="hide" @click.stop="row.toggleDetails"></i>
                                <i v-if="row.detailsShowing" class="fas fa-arrow-circle-up fa-2x" id="show" @click.stop="row.toggleDetails"></i>
                            </template> 

                            <template slot="row-details" slot-scope="row">
                                <b-card>
                                    <h2>{{row.item.name}} <small>Por: {{row.item.organizer}}</small></h2>
                                    <div v-if="row.item.image_path" class="imgEvent text-center">
                                        <img class="img-responsive" :src="`${row.item.image_path}`" alt="Imagem do Evento">
                                    </div>
                                    <div class="infoEvent">
                                        <p><strong>Localização: </strong>{{row.item.localization}}</p>
                                        <p class="text-justify"><strong>Descrição: </strong><p v-html="row.item.description"></p></p>
                                        <p v-if="row.item.path"><strong>Documento: </strong><a :href="row.item.path" :download ="row.item.name" role="button">Ver documento</a></p>
                                        
                                        <div class="text-center">
                                            <div v-if="logged && row.item.status != 2">
                                                <div v-if="!subscribed(row.item.id)">
                                                    <div v-if="!isMaxCapacity(row.item)">
                                                        <p class="text-center">Se pertende inscrever no evento pressione o botao seguinte</p>
                                                    <button type="button" class="btn btn-contrast" v-on:click="subscribeToEvent(row.item)">Inscrever</button>
                                                    </div>
                                                    <div v-if="isMaxCapacity(row.item)">
                                                        <p class="text-center">Evento encontra-se com lotação esgotada</p>
                                                    </div>
                                                </div>
                                                <div v-if="subscribed(row.item.id)">
                                                    <p class="text-center">Já se encontra inscrito a este evento.</p>
                                                    <button type="button" class="btn btn-contrast" v-on:click="unsubscribeToEvent(row.item)">Anular Inscrição</button>
                                                </div>
                                            </div>
                                            <a v-if="!logged" href="/auth/#/" class="btn btn-red">Inscrever</a>
                                        </div>                                        
                                    </div>
                                </b-card>
                            </template>                          
                            
                        </b-table>
                        
                        <div class="text-center">
                            <b-pagination :total-rows="totalRows" 
                                          :per-page="perPage" 
                                          v-model="currentPage"/> 
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>

                    <activitiesNav></activitiesNav>
                    
                </div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">

    export default {
        data: function(){
            return {
                title: 'Eventos',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Atividades',
                    href: '/#/activities'
                }, {
                    text: 'Eventos',
                    active: true
                }],
                eventos: [],
                fields: [
                  { key: 'date', label: 'Data'},
                  { key: 'name', label: 'Título'},                  
                  { key: 'actions', label: ''}
                ],
                currentPage: 1,
                perPage: 5,
                totalRows: '',
                logged: false,
                loading: true,
                errorLoading: false,
                userId: 0,
                arrayOfIds: [],
            }
        },
        computed: {
            hasItems: function () {
                return this.eventos.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            subscribed: function(id) {
                return this.arrayOfIds.includes(id);
            },
            isMaxCapacity: function(evento) {
                return !(evento.max_inscritos-evento.total_interested > 0);
            },
            getUserId() {
                axios.get('/api/user')
                    .then((response) => {
                        this.userId = response.data.id;
                        this.getSubscribedEventsOfUser(response.data.id);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getSubscribedEventsOfUser: function(id) {
                const data = {
                    user_id: id
                }
                axios.post('/api/events/isSubscribed', data)
                    .then((response) => {
                        this.arrayOfIds = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            },
            getEvents() {
                this.loading = true;
                this.errorLoading = false; 
                axios.get('/api/events')
                    .then(response => {
                        this.eventos = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                });
            },
            isLogged() {
                if(localStorage.getItem('access_token') != null) {
                    this.logged = true;
                }
            },
            subscribeToEvent: function(evento) {
                swal("Pertende realmente inscrever-se a este evento?", {
                    icon: "info",
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
                            const data = {
                                user_id: this.userId,
                                events_id: evento.id
                            }
                            axios.post('/api/events/subscribe', data) 
                                .then(response => {
                                    swal(response.data.msg, {
                                        icon: 'success',
                                        buttons: {
                                            ok: "Ok"
                                        },
                                    })
                                    .then((value) => {
                                        switch (value) {
                                            case "ok":
                                            this.getSubscribedEventsOfUser(this.userId);
                                            break;
                                        }
                                    });
                                }).catch((error) => {
                                    
                                });         
                            break;
                    }
                });
            },
            unsubscribeToEvent: function(evento) {
                swal("Pertende realmente anular a inscrição do evento?", {
                    icon: "info",
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
                            const data = {
                                user_id: this.userId,
                                events_id: evento.id
                            }
                            axios.post('/api/events/unsubscribe', data) 
                                .then(response => {
                                    swal(response.data.msg, {
                                        icon: 'success',
                                        buttons: {
                                            ok: "Ok"
                                        },
                                    })
                                    .then((value) => {
                                        switch (value) {
                                            case "ok":
                                            this.getSubscribedEventsOfUser(this.userId);
                                            break;
                                        }
                                    });
                                }).catch((error) => {
                                    
                                });         
                            break;
                    }
                });
            },
        },
        created() {
            this.getEvents();
            this.totalRows = this.eventos.length;
            this.isLogged();
            this.getUserId();
        }

    }
</script>

<style type="text/css" media="screen">
    #hide {
        cursor: pointer;
    }

    #show {
        cursor: pointer;
    }
</style>