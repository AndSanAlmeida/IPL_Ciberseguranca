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
                                    <div class="">
                                        <div class="col-md-3">
                                            <p class="text-right">27 de Abril de 2018</p>
                                        </div>
                                        <div class="col-md-9 newsBorderB">
                                            <h3>O próximo dia 26 de abril é dia de “Girls in ICT”</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        </div>
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
    </div>
</template>
<script type="text/javascript">
    export default {
        data: function(){
            return {
                stats: []
            }
        },
        methods: {

        },
        mounted(){
        }
    }
</script>
<style>

</style>