<template>
	<section id="resources" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>
                 	
                    <div id="faq">
                        <div class="faqContent">
                            <div class="faq-question">
                                <input id="q1" type="checkbox" class="panel">
                                <div class="plus">+</div>
                                <label for="q1" class="panel-title">Question One</label>
                                <div class="panel-content">
                                    <span class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                                </div>
                            </div>
                            <div class="faq-question">
                                <input id="q2" type="checkbox" class="panel">
                                <div class="plus">+</div>
                                <label for="q2" class="panel-title">Question Two</label>
                                <div class="panel-content">
                                    <span class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
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
                            <b-form-textarea id="faq"
                                             v-model="faqTextarea"
                                             placeholder="Coloque aqui a sua Questão!"
                                             :rows="3"
                                             :max-rows="3"                                             
                                             :no-resize="true"
                                             required>
                            </b-form-textarea>
                            <input type="submit" class="faqSendBtn" value="Enviar">
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
            }
        },
        created: function() {
            if(localStorage.getItem('access_token') != null) {
                this.logged = true;
            }
        }
    }
</script>