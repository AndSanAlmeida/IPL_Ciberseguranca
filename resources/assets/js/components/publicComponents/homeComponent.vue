<template>
    <div>
        <section id="home">
            <div class="bg-color">
                <div class="container">
                    <div class="row banner-content">
                        <div class="col-xs-12 col-md-10 col-lg-8">
                            <div class="banner-inner text-center">
                                <h1 class="banner-heading">Instituto Politécnico de Leiria</h1>
                                <h3>Portal de Cibersegurança</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="news" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="borderB">
                            <h1>Notícias <small><a href="#" title="RSS Notícias" target="_blank" class="rss_color"><i class="fas fa-rss"></i></a></small></h1>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-8 col-md-offset-2">

                        <a href="#" title="">
                            <article class="newsContent">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="text-right">27 de Abril de 2018</p>
                                    </div>
                                    <div class="col-md-9 newsBorderB">
                                        <h3>O próximo dia 26 de abril é dia de “Girls in ICT”</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                            </article>
                        </a>

                        <a href="#" title="">
                            <article class="newsContent">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="text-right">27 de Abril de 2018</p>
                                    </div>
                                    <div class="col-md-9 newsBorderB">
                                        <h3>Ransomware está a crescer: o alerta foi dado pelo NCCIC </h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                            </article> 
                        </a>  

                        <div class="text-right">
                            <router-link to="/resources/news" class="showMore">Ver todas <i class="fas fa-list-ul"></i></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="mission">
            <div class="bg-color ">
                <div class="container">
                    <div class="row missionContent">
                        <div class="col-md-12 text-center">
                            <h1>Nossa missão</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>                         
                    </div>
                </div>           
            </div>
        </section>
        <section v-if="hasEvents" id="homeEvents" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="borderB">
                            <h1>Eventos</h1>
                        </div>
                    </div>
                </div>
                <div class="homeEventsContainer">                    
                    <div class="thumbnail" v-for="evento in eventos" :key="evento.id">                      
                        <img class="img-responsive" :src="evento.image_path" alt="evento.name">
                        <div class="caption">
                            <h3>{{ evento.name }}</h3>
                            <p>{{ evento.date }}</p>
                            <br>
                            <p><router-link to="/activities/events" title="Saber Mais" class="btn btn-red" role="button">Saber Mais</router-link></p>
                        </div>
                    </div>
                </div>
            </div>            
        </section>
    </div>
</template>
<script type="text/javascript">
    export default {
        data: function(){
            return {
                eventos: [],
            }
        },
        computed: {
            hasEvents: function () {
                return this.eventos.length > 0;
            },
        },
        methods: {
            getEvents() {
                axios.get('/api/events')
                    .then(response => {
                        this.eventos = response.data.data;
                });
            },
        },
        mounted(){
            this.getEvents();
        }
    }
</script>