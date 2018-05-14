<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}  <small><a href="#" title="RSS Alertas de Segurança" target="_blank" class="rss_color"><i class="fas fa-rss"></i></a></small></h1>
                 	</div>
                 	<div id="alerts">
                        <a href="#" title="">
                            <article class="alertContent">
                                <h3>Alerta de Vulnerabilidade - Firefox 58 <small>5 de Janeiro de 2018</small></h3>
                                <dl class="dl-horizontal">
                                    <dt class="text-uppercase">Categoria</dt>
                                    <dd>Vulnerabilidades</dd>
                                    <dt class="text-uppercase">Sistemas Afetados</dt>
                                    <dd>vSphere Data Protection 5.x, 6.0.x, 6.1.x</dd>
                                </dl>
                            </article>
                        </a>
                        <a href="#" title="">
                            <article class="alertContent">
                                <h3>Alerta de Vulnerabilidade - Firefox 58 <small>5 de Janeiro de 2018</small></h3>
                                <dl class="dl-horizontal">
                                    <dt class="text-uppercase">Categoria</dt>
                                    <dd>Vulnerabilidades</dd>
                                    <dt class="text-uppercase">Sistemas Afetados</dt>
                                    <dd>vSphere Data Protection 5.x, 6.0.x, 6.1.x</dd>
                                </dl>
                            </article>
                        </a> 
                        <a href="#" title="">
                            <article class="alertContent">
                                <h3>Alerta de Vulnerabilidade - Firefox 58 <small>5 de Janeiro de 2018</small></h3>
                                <dl class="dl-horizontal">
                                    <dt class="text-uppercase">Categoria</dt>
                                    <dd>Vulnerabilidades</dd>
                                    <dt class="text-uppercase">Sistemas Afetados</dt>
                                    <dd>vSphere Data Protection 5.x, 6.0.x, 6.1.x</dd>
                                </dl>
                            </article>
                        </a> 
                        <a href="#" title="">
                            <article class="alertContent">
                                <h3>Alerta de Vulnerabilidade - Firefox 58 <small>5 de Janeiro de 2018</small></h3>
                                <dl class="dl-horizontal">
                                    <dt class="text-uppercase">Categoria</dt>
                                    <dd>Vulnerabilidades</dd>
                                    <dt class="text-uppercase">Sistemas Afetados</dt>
                                    <dd>vSphere Data Protection 5.x, 6.0.x, 6.1.x</dd>
                                </dl>
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
                title: 'Alertas',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Alertas',
                    active: true
                }],
                currentPage: 1,
            }
        },
    }
</script>