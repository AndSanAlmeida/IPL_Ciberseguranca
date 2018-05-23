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
                    <h3><b>IPL Cibersegurança documentos:</b></h3>

                    <div v-if="!hasItems && canShowContent" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Não existe documentos disponíveis.</h4>
                    </div>

                    <div v-if="loading" class="text-center" style="margin-top: 2em;">
                        <h3>A carregar...</h3>
                    </div>

                 	<div v-if="hasItems && canShowContent" id="linksAndDocuments">
                 		<ul class="linksAndDocumentsList">
                            <li v-for="document in documents" :key="document.id" ><a :href="document.path" :download="document.description">{{document.description}}</a></li>
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
                }],
                documents: [],
                loading: true,
                errorLoading: false,
            }
        },
        methods: {
            getDocuments: function () {
                this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/documents')
                    .then(response => {
                        this.documents = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
        },
        computed: {
            hasItems: function () {
                return this.documents.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        mounted() {
            this.getDocuments();
        }
    }
</script>