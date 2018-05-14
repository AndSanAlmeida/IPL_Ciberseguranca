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
                            <li v-for="link in usefulLinks" :key="link.id" ><a :href="link.link" target="_blank">{{link.description}}</a></li>
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
                }],
                usefulLinks: [],
            }
        },
        methods: {
            getUsefulLinks: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/usefulLinks')
                    .then(response => {
                        this.usefulLinks = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
        },
        mounted() {
            this.getUsefulLinks();
        }
    }
</script>