<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}  <small><a href="#" title="RSS Notícias" target="_blank" class="rss_color"><i class="fas fa-rss"></i></a></small></h1>
                 	</div>
                    
                    <div id="news">
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
                                <div class="row" style="margin-top: 15px;">
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
                                <div class="row" style="margin-top: 15px;">
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
                    </div>
                    
                    <div class="text-center">
                        <b-pagination size="md" :total-rows="100" v-model="currentPage" :per-page="5" ></b-pagination>
                    </div>
                    
                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>

                    <resourcesNav></resourcesNav>
                    
                </div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {
                title: 'Notícias',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Notícias',
                    active: true
                }],
                currentPage: 1,
            }
        },
    }
</script>