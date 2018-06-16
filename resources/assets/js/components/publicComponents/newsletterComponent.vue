<template>
	<section v-if="!showNewsletter" id="newsletter" class="section-padding">
        <div class="container">
            <div v-if="!logged" class="row">
                <div class="col-md-12">
                    <div class="newsletterContentNotLogged text-center">
                        <span>Subscreva-se à nossa newsletter e seja o primeiro a receber as nossas notificações.</span>
                        <br><br>
                        <form class="form" role="form" autocomplete="off" v-on:submit.prevent="submitNewsletterWhenNotLogged">
                            <input type="text" placeholder="Nome" v-model="name" class="newsletter-input" />
                            <input type="email" placeholder="Email" v-model="email" class="newsletter-input" />
                            <input class="newsletter-send" type="submit" value="Subscrever">
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="logged" class="row">
                <div class="col-sm-12 col-md-6 col-md-offset-3">
                    <div class="newsletterContentLogged text-center">
                        <span>Subscreva-se à nossa newsletter e seja o primeiro a receber as nossas notificações.</span> 
                        <br>
                        <button class="newsletter-sendLogged" v-on:click="submitNewsletterWhenLogged()">Subscrever</button>  
                    </div>
                </div>
            </div>
        </div>
    </section>	
</template>
<script type="text/javascript">
    import User from '../../classes/user.js';
    import swal from 'sweetalert';

    export default {
        data: function(){
            return {
                logged: false,
                name: '',
                email: '',
                user: new User(),
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
            submitNewsletterWhenLogged: function (event) {
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
                        });
                    })
                    .catch((error) => {
                        this.serverError = true;
                        this.serverErrorMessage = error.response.data.data;
                    });
                    
                
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
        }
    }
</script>