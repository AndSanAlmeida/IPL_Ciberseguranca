<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div v-if="loading" class="loader"></div>
                    <div  v-if="!loading && hasItems">
                        <div class="left-highlight">
                            <h1 v-html="newsletter.title"></h1>
                        </div>
                        <br>
                        <p class="text-muted text-right">{{prepareDate(newsletter.date)}}</p>
                        <br>
                        <p class="text-justify" v-html="newsletter.description"></p>
                    </div>
                    <div  v-if="!loading && !hasItems" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Newsletter não existe.</h4>
                    </div>
                </div>
                
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {                
                title: '',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Newsletters',
                    href: '/#/resources/newsletters'
                }, {
                    text: '',
                    active: true
                }],
                newsletter: [],
                showNews: false,
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            hasItems: function () {
                return this.newsletter.length != 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        methods: {
            getNewsletters: function () {
                this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/newsletter/getPublishedNewsletters')
                    .then(response => {
                
                        for (var j = 0; j < response.data.data.length; j++) {
                            if(decodeURIComponent(this.title) === response.data.data[j].title) {
                                var newsletterObject = {title: '', description: '', date: ''}
                                newsletterObject.title = response.data.data[j].title;
                                newsletterObject.description = response.data.data[j].description;
                                newsletterObject.date = response.data.data[j].date;
                                this.newsletter = Object.assign(newsletterObject);
                            }
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
            get_ents: function(str){
                var temp=document.createElement("pre");
                temp.innerHTML=str;
                return decodeURIComponent(temp.firstChild.nodeValue);
            }
        },
        created: function() {
            this.title = decodeURIComponent(window.location.href.substr(window.location.href.lastIndexOf('/') + 1).replace(/%20/g, " "));
            this.items[3].text = this.get_ents(this.title);
            this.getNewsletters();
        }
    }
</script>

<style type="text/css" media="screen">
    #resources h1 {
        text-transform: none;
    }
</style>