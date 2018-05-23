<template>
	<section id="activities" class="section-padding">
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

                    <div v-if="loading" class="text-center" style="margin-top: 2em;">
                        <h3>A carregar...</h3>
                    </div>

                    <div v-if="hasItems && canShowContent" class="text">
                 		<p class="text-justify">
                 			<span v-html="activities.description"></span>
                 		</p>
                 	</div>
                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>
               		
					<activitiesNav></activitiesNav>

                </div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {
                title: 'Atividades',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Atividades',
                    active: true
                }],
                activities: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return Object.keys(this.activities).length !== 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
         methods: {
            getActivities: function () {
                this.loading = true;
                this.errorLoading = false; 
                axios.get('/api/settings/activities')
                    .then(response=>{
                        this.activities = response.data;
                        this.loading = false;
                    }).catch((error) => {
                        this.loading = false;
                        this.errorLoading = true;
                });
            },
        },
        created: function () {
            this.getActivities();
        }
    }
</script>