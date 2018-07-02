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
                    <div v-if="!loading && !hasItems" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Não existe newsletters disponíveis.</h4>
                    </div>

                    <div v-if="!loading && hasItems">
                        <h3><b>IPLeiria Cibersegurança newsletter:</b></h3>

                        <div v-if="loading" class="loader"></div>

                        <div id="linksAndDocuments">
                            <ul class="linksAndDocumentsList">
                                <li v-for="newsletter in newsletters" >
                                    <a href="javascript:;" v-on:click="sendToNewsletter(newsletter)" :title="newsletter.tittle" class="text-justify">{{newsletter.title}}</a>
                                    <small>| {{prepareDate(newsletter.date)}}</small>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div v-if="loading" class="loader"></div>
                    
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
                newsletters: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.newsletters.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            sendToNewsletter: function(newsletter) {
                window.location.href = '/#/resources/newsletters/'+newsletter.title;
            },
            getNewsletters: function () {
                this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/newsletter/getPublishedNewsletters')
                    .then(response => {
                        this.newsletters = response.data.data;
                        this.newsletters.sort(function(a,b){
                          var c = new Date(a.date);
                          var d = new Date(b.date);
                          return d-c;
                        });
                        if (response.data.data.length > 0) {
                            this.showList = true;
                        }
                        this.loading = false;
                        this.errorLoading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            prepareDate: function(item) {
                var today = new Date(item);
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                var month = ''; 

                switch (mm) {
                    case 1: month = ' de janeiro de ';
                        break;
                    case 2: month = ' de fevereiro de ';
                        break;
                    case 3: month = ' de março de ';
                        break;
                    case 4: month = ' de abril de ';
                        break;
                    case 5: month = ' de maio de ';
                        break;
                    case 6: month = ' de junho de ';
                        break;
                    case 7: month = ' de julho de ';
                        break;
                    case 8: month = ' de agosto de ';
                        break;
                    case 9: month = ' de setembro de ';
                        break;
                    case 10: month = ' de outubro de ';
                        break;
                    case 11: month = ' de novembro de ';
                        break;
                    case 12: month = ' de dezembro de ';
                        break;
                }
                return dd+month+yyyy;
            },
        },
        mounted() {
            this.getNewsletters();
        }
    }
</script>