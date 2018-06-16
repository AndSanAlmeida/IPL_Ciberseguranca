<template>
	<section id="aboutUs" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>

                 	<div v-if="!hasItems && canShowContent" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Não existe conteúdo disponível.</h4>
                    </div>

                    <div v-if="loading" class="loader"></div>

                    <div v-if="hasItems && canShowContent" class="text">
                 		<p class="text-justify">
                 			<span v-html="aboutUs.description"></span>
                 		</p>
                 	</div>
                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>
                    
                    <aboutUsNav></aboutUsNav>

                </div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {
                title: 'Sobre Nós',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Sobre Nós',
                    active: true
                }],
                aboutUs: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return Object.keys(this.aboutUs).length !== 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            getAboutUs: function () {
                this.loading = true;
                this.errorLoading = false; 
                axios.get('/api/settings/aboutUs')
                    .then(response=>{
                        this.aboutUs = response.data;
                        this.loading = false;
                    }).catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                });
            },
        },
        created: function () {
            this.getAboutUs();
        }
    }
</script>