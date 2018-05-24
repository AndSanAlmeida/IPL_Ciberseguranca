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

                    <div v-if="loading" class="text-center" style="margin-top: 2em;">
                        <h3>A carregar...</h3>
                    </div>

                    <div v-if="hasItems && canShowContent" id="events">

                        <b-table  id="eventTable" responsive 
                                  stacked="md"
                                  :items="eventos" 
                                  :fields="fields"
                                  :current-page="currentPage"
                                  :per-page="perPage"> 
                        
                            <template slot="actions" slot-scope="row">
                                <button type="button" class="btn btn-red" @click.stop="row.toggleDetails">
                                  {{ row.detailsShowing ? 'Esconder' : 'Mostrar' }} Detalhes
                                </button>
                            </template> 

                            <template slot="row-details" slot-scope="row">
                                <b-card>
                                    <h2>{{row.item.name}} <small>Por: {{row.item.organizer}}</small></h2>
                                    <div v-if="row.item.image_path" class="imgEvent text-center">
                                        <img class="img-responsive" :src="`${row.item.image_path}`" alt="Imagem do Evento">
                                    </div>
                                    <div class="infoEvent">
                                        <p><strong>Localização: </strong>{{row.item.localization}}</p>
                                        <p class="text-justify"><strong>Descrição: </strong>{{row.item.description}}</p>
                                        <p v-if="row.item.path"><strong>Documento: </strong><a href="#" target="_blank">{{row.item.name}}</a></p>
                                        <div class="text-center">
                                            <button v-if="logged" type="button" class="btn btn-contrast" v-on:click="inscreverEvento(row.item)">Inscrever</button>
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
                  { key: 'localization', label: 'Localização'},
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
            getUserId() {
                axios.get('/api/user')
                    .then((response) => {
                        this.userId = response.data.id;
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
            inscreverEvento(evento) {
                this.getUserId();
                const data = {
                    userId: this.userId,
                    eventId: evento.id
                }
                axios.post('/api/events/subscribe', data) 
                    .then(response => {

                    }).catch((error) => {
                        
                });
            },
        },
        created() {
            this.getEvents();
            this.totalRows = this.eventos.length;
            this.isLogged();
        }

    }
</script>