<template>
	<section id="resources" class="section-padding">
		<div class="row">
			<div class="container">
				<div class="col-md-8 col-sm-12 marb-20">
                    <b-breadcrumb :items="items"/>
                    <div class="title-block left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>
                 	<div id="linksAndDocuments">
                        <ul class="linksAndDocumentsList">
                            <li><a href="#" title="Link 1" target="_blank">Link 1</a></li>
                            <li><a href="#" title="Link 2" target="_blank">Link 2</a></li>
                            <li><a href="#" title="Link 3" target="_blank">Link 3</a></li>
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
                title: 'Links Úteis',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Links Úteis',
                    active: true
                }]
            }
        },
    }
</script>