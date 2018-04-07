<template>
        <div class="card card-container">
        <img class="profile-img-card" v-bind:src="'/img/logo_ipl_header.png'" alt="Logotipo IPL">
        <br>
        <form class="form-signin" method="post" v-on:submit.prevent="submitForm">

            <div class="alert alert-success" role="alert" v-cloak v-show="serverError">
                <p>{{serverErrorMessage}}</p>
            </div>

            <div class="alert alert-success" role="alert" v-cloak v-show="success">
                <p class="text-center">Email com a informação para recuperar a password foi enviado. Verifique o seu email.</p>
            </div>
            
            <!-- USERNAME | EMAIL -->
            <input type="email" id="inputAuth" class="form-control" name="email" v-model="email" v-bind:class="{ 'is-invalid': missingEmail  }" placeholder="Email" required autofocus />

            <div class="clearfix">
                <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingEmail ">
                    <p v-if="missingEmail">Preencher Email</p>
                </div>
            </div>

            <!-- LINKS --> 
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Recuperar Password</button>
            <p class="text-center">
                <router-link to="/login" class="">Voltar a Iniciar Sessão</router-link>
            </p>

        </form><!-- /form -->
        <p class="text-center">
            <a href="/" class="text-muted"><small>← Voltar a IPL-Cibersegurança</small></a>
        </p>
    </div><!-- /card-container -->
</template>

<script>
    export default {
        data: function(){
            return {
                email: '',
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
                success: false
            }
        },
        computed: {
            missingEmail: function () {
                return this.email.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidEmail: function () {
                return !this.missingEmail && !this.validateEmail(this.email.trim()) && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return (this.missingEmail || this.invalidEmail);
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
            validateEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            submitForm: function (event) {
                //CLEARS SERVER ERROR'S
                this.serverError = false;
                this.success = false;

                //PREVENT FORM

                event.preventDefault();

                //FORM SUBMITED
                this.attemptSubmit = true;

                //IF FORM IS VALID MAKE API REQUEST FOR LOGIN
                if (!this.isFormInvalid) {
                    const data = {
                        email: this.email
                    };
                    axios.post('/api/password/email', data)
                        .then((response) => {
                            this.success = true;
                            this.attemptSubmit = false;
                            setTimeout( () => this.$router.push({ path: '/login'}), 5000);
                        })
                        .catch((error) => {
                            this.serverError = true;
                            this.serverErrorMessage = error.response.data.msg ;
                        });
                }
            },
        }
    }
</script>
