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
                    <h3 v-if="hasItems && canShowContent"><b>IPL Cibersegurança links úteis:</b></h3>

                    <div v-if="!hasItems && canShowContent" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Não existe links disponíveis.</h4>
                    </div>

                    <div v-if="loading" class="loader"></div>

                 	<div v-if="hasItems && canShowContent" id="linksAndDocuments">
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
                loading: true,
                errorLoading: false,
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
        computed: {
            hasItems: function () {
                return this.usefulLinks.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        mounted() {
            this.getUsefulLinks();
        }
    }
</script>