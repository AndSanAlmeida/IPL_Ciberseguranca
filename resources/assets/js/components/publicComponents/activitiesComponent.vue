<template>
	<section id="activities" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>
                 	<div class="text">
                 		<p class="text-justify">
                 			<span v-html="resources.description"></span>
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
                resources: []
            }
        },
         methods: {
            getActivities: function () {
                axios.get('/api/settings/activities')
                    .then(response=>{
                        this.resources = response.data;
                    });
            },
        },
        created: function () {
            this.getActivities();
        }
    }
</script>