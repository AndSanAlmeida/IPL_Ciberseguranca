<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>
                 	<div id="linksAndDocuments">
                 		<ul class="linksAndDocumentsList">
                            <li><a href="#" title="Artigo 1" target="_blank">Artigo 1</a></li>
                            <li><a href="#" title="Artigo 2" target="_blank">Artigo 2</a></li>
                            <li><a href="#" title="Artigo 3" target="_blank">Artigo 3</a></li>
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
                title: 'Documentos',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Documentos',
                    active: true
                }]
            }
        },
    }
</script>