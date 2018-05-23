<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>

                    <br>
                    <h3><b>IPL Cibersegurança newsletter:</b></h3>

                    <div class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Não existe newsletters disponíveis.</h4>
                    </div>

                    <div v-if="loading" class="text-center" style="margin-top: 2em;">
                        <h3>A carregar...</h3>
                    </div>

                 	<div id="linksAndDocuments">
                 		<ul class="linksAndDocumentsList">
                            <li>
                                <a href="#" title="Newsletter 1" target="_blank">Newsletter 1</a>
                                <small>| 14 Maio 2018</small>
                            </li>
                            <li>
                                <a href="#" title="Newsletter 2" target="_blank">Newsletter 2</a>
                                <small>| 14 Maio 2018</small>
                            </li>
                            <li>
                                <a href="#" title="Newsletter 3" target="_blank">Newsletter 3</a>
                                <small>| 14 Maio 2018</small>
                            </li>
                        </ul>
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
                title: 'Newsletters',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Newsletters',
                    active: true
                }],
                loading: true,
                errorLoading: false,
            }
        },
        /*computed: {
            hasItems: function () {
                return this.newsletter.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },*/
    }
</script>