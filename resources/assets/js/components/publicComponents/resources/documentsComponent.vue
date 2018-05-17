<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>

                    <h3 v-if="documents.length == 0" class="text-danger mt-2">Não existe documentos disponíveis</h3>

                 	<div v-if="documents.lenght != 0" id="linksAndDocuments">
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
                documents: []
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
        mounted() {
            this.getDocuments();
        }
    }
</script>