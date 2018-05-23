<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>
                 	
                    <div v-if="!hasItems && canShowContent" class="alert alert-danger" role="alert" style="margin-top: 2em;">
                        <h4><strong>Erro: </strong>Não existe FAQ's disponíveis.</h4>
                    </div>

                    <div v-if="loading" class="text-center" style="margin-top: 2em;">
                        <h3>A carregar...</h3>
                    </div>

                    <div v-if="hasItems && canShowContent" id="faq">
                        <div v-for="faq in faqs" class="faqContent">
                            <div class="faq-question">
                                <input v-bind:id="faq.id" type="checkbox" class="panel">
                                <div class="plus">+</div>
                                <label v-bind:for="faq.id" class="panel-title">{{faq.question}}</label>
                                <div class="panel-content">
                                    <span class="text-justify">{{faq.answer}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="!logged" id="faqAuth" class="row">
                        <div class="col-md-12">
                            <h2>Coloque-nos uma Questão</h2>
                            <a href="/auth/#/" class="faqRedirectBtn" title="Colocar Questão">Colocar Questão</a>
                        </div>
                    </div>

                    <div v-if="logged" id="faqSend" class="row">
                        <div class="col-md-12">
                            <h2>Envie-nos a sua Questão</h2>
                            <form class="form" role="form" method="post" autocomplete="off" v-on:submit.prevent="submitForm">
                            <b-form-textarea id="faq"
                                             v-model="faqTextarea"
                                             placeholder="Coloque aqui a sua Questão!"
                                             :rows="3"
                                             :max-rows="3"                                             
                                             :no-resize="true"
                                             required>
                            </b-form-textarea>
                            <input class="faqSendBtn" type="submit" value="Enviar">
                            </form>
                        </div>
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
                title: 'FAQ',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'FAQ',
                    active: true
                }],
                logged: false,
                faqTextarea: '',
                user_id: 0,
                faqs: [],
                loading: true,
                errorLoading: false,
            }
        },
        computed: {
            missingQuestion: function () {
                return this.faqTextarea.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return (this.missingQuestion);
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
            hasItems: function () {
                return this.faqs.length > 0;
            },
            canShowContent: function () {
                return !this.errorLoading && !this.loading;
            },
        },
        created: function() {
            this.isLogged();
                
        },
        methods: {
            getFaqs: function () {
                this.loading = true;
                this.errorLoading = false;                
                axios.get('/api/faqs')
                    .then(response => {
                        this.faqs = response.data.data;
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.errorLoading = true;
                });
            },
            reset: function() {
                this.faqTextarea = '';
            },
            submitForm: function() {
                this.serverError = false;
                this.attemptSubmit = true;
                if (!this.isFormInvalid) {
                    const data = {
                        question: this.faqTextarea,
                        user_id: this.user_id,
                    };
                    axios.post('/api/questions/create', data)
                        .then((response) => {
                            console.log(response);
                            swal("Questão enviada com sucesso.", {
                                icon: 'success',
                                buttons: {
                                ok: "Ok"
                                },
                            });
                            this.reset();
                        })
                        .catch((error) => {
                            this.serverError = true;
                            console.log(error);
                            this.serverErrorMessage = error.response.data.data;
                        });
                }
            },
            isLogged() {
                if(localStorage.getItem('access_token') != null) {
                    this.logged = true;
                }
            },
            getUser: function () {
                axios.get('/api/user')
                    .then((response) => {
                        console.log(response.data);
                        this.logged = true;
                        this.user_id = response.data.id;
                    })
                    .catch((error) => {
                        
                    });
            },
        }, 
        created: function () {
            this.getUser();
            this.getFaqs();
        }
    }
</script>