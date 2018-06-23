<template>
	<section v-if="!showNewsletter" id="newsletter" class="section-padding">
        <div class="container">
            <div v-if="!logged" class="row">
                <div class="col-xs-12">
                    <div class="newsletterContentNotLogged text-center">
                        <span>Subscreva-se à nossa newsletter e seja o primeiro a receber as nossas notificações.</span>
                        <br><br>
                        <form class="form-inline" role="form" autocomplete="off" v-on:submit.prevent="isShowedRecaptcha = true">
                            <div class="form-group">
                                <input type="text" placeholder="Nome" v-model="name" class="newsletter-input" required/>
                            </div>
                            <div class="form-group">
                                <input type="email" placeholder="Email" v-model="email" class="newsletter-input" required/>
                            </div>
                            <div class="form-group">
                                <input class="newsletter-send" type="submit" value="Subscrever">
                            </div>

                            <div class="form-group">
                                <br>
                                <vue-recaptcha v-if="isShowedRecaptcha"
                                    @verify="submitNewsletterWhenNotLogged"
                                    @expired="isShowedRecaptcha = false"
                                    align="center"
                                    sitekey="6LdxSGAUAAAAAArJ_prh93hEVYhyLQ13Xt2Ik4_b">
                                </vue-recaptcha>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="logged" class="row">
                <div class="col-sm-12 col-md-6 col-md-offset-3">
                    <div class="newsletterContentLogged text-center">
                        <span>Subscreva-se à nossa newsletter e seja o primeiro a receber as nossas notificações.</span> 
                        <br>
                        <button class="newsletter-sendLogged" v-on:click="isShowedRecaptchaLogged = true">Subscrever</button> 
            
                        <vue-recaptcha v-if="isShowedRecaptchaLogged"
                            @verify="submitNewsletterWhenLogged"
                            @expired="isShowedRecaptchaLogged = false"
                            align="center"
                            sitekey="6LdxSGAUAAAAAArJ_prh93hEVYhyLQ13Xt2Ik4_b">
                        </vue-recaptcha>

                    </div>
                </div>
            </div>
        </div>
    </section>	
</template>
<script type="text/javascript">
    import User from '../../classes/user.js';
    import swal from 'sweetalert';
    import VueRecaptcha from 'vue-recaptcha';

    export default {
        data: function(){
            return {
                logged: false,
                name: '',
                email: '',
                user: new User(),
                isShowedRecaptcha: false,
                isShowedRecaptchaLogged: false,
                showNewsletter: false,
            }
        },
        computed: {
            missingName: function () {
              return this.name.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            missiingEmail: function() {
              return this.email.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
              return (this.missingName || this.missingEmail);
            },
            hasServerError: function () {
              return this.serverError;
            },
            isFormInvalid: function () {
              return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },

        },
        methods: {
            onCaptchaVerified: function () {
                this.submitNewsletterWhenLogged();
            },
            submitNewsletterWhenLogged: function () {
                this.serverError = false;
                this.attemptSubmit = true;

                const data = {
                    name: this.user.name,
                    email: this.user.email,
                };
            
                axios.post('/api/newsletter/subscribe', data)
                    .then((response) => {
                        swal("Subscrição realizada com sucesso.", {
                            icon: 'success',
                            buttons: {
                                ok: "Ok"
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "ok":
                                this.showNewsletter = true;
                                break;
                            }
                            this.showHideRecaptchaLogged();
                        });
                    })
                    .catch((error) => {
                        this.serverError = true;
                        this.serverErrorMessage = error.response.data.data;
                    });
                    
                
            },
            onCaptchaVerified: function () {
                this.submitNewsletterWhenNotLogged();
            },
            submitNewsletterWhenNotLogged: function (event) {
                this.serverError = false;
                this.attemptSubmit = true;
                if (!this.isFormInvalid) {
                    const data = {
                        name: this.name,
                        email: this.email,
                    };
                    

                    axios.post('/api/newsletter/subscribe', data)
                        .then((response) => {
                            swal("Subscrição realizada com sucesso.", {
                                icon: 'success',
                                buttons: {
                                    ok: "Ok"
                                },
                            })
                            .then((value) => {
                                switch (value) {
                                    case "ok":
                                        this.name = '';
                                        this.email = '';
                                    break;
                                }
                                this.showHideRecaptcha();
                            });
                        })
                        .catch((error) => {
                            this.serverError = true;
                            console.log(error);
                            this.serverErrorMessage = error.response.data.data;
                        });
                    
                }
            },
            checkIfUserIsSubscribed: function(email) {
                const data = {
                        email: email,
                    };
                axios.post('/api/newsletter/subscribed', data)
                    .then((response) => {
                        this.showNewsletter = response.data.isSubscribed;
                    })
                    .catch((error) => {
                        
                    });
            } 
        },
        created: function() {
            if(localStorage.getItem('access_token') != null) {
                
                axios.get('/api/user')
                    .then((response) => {
                        this.logged = true;
                        this.checkIfUserIsSubscribed(response.data.email);
                        this.user.parse(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            }
        },
        components: { VueRecaptcha }
    }
</script>