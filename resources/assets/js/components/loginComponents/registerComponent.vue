<template>

    <div class="card card-container">
        <img class="profile-img-card" v-bind:src="'/img/logo_ipl_header.png'" alt="Logotipo IPL">
        <br>
        <div v-if="loading" class="loader"></div>
        <form class="form-signin" method="post" v-on:submit.prevent="validateForm">

            <div class="alert alert-success" role="alert" v-cloak v-show="success">
                <p>Utilizador criado, verifique o seu email para ativar a conta.</p>
            </div>
            
            <div class="alert alert-danger" role="alert" v-cloak v-show="serverErrorCode != 0">
                <p>{{serverErrorMessage}}</p>
            </div>

            <!-- NAME -->
            <input type="text" name="name" v-model="name" v-bind:class="{ 'is-invalid': missingName  }"
            class="form-control" placeholder="Name"/>
            <div class="alert-danger" role="alert" v-cloak v-show="isFormInvalid" ><p v-if="missingName">Preencher o Nome</p></div>
            
            <!-- USERNAME -->
            <input type="text" name="username" v-model="username" v-bind:class="{ 'is-invalid': missingUsername || usernameAlreadyUsed  }" class="form-control" placeholder="Username"/>
            <div class="alert-danger" role="alert" v-cloak v-show="isFormInvalid"><p v-if="missingUsername">Preencher o Username</p></div>

            <!-- EMAIL -->
            <input type="text" name="email" v-model="email"
            v-bind:class="{ 'is-invalid': missingEmail || invalidEmail || emailAlreadyUsed  }" class="form-control" placeholder="Email"/>
            <div class="alert-danger" role="alert" v-cloak v-show="isFormInvalid"><p v-if="missingEmail">Preencher o Email</p></div>
            <div class="alert-danger" role="alert" v-cloak v-show="isFormInvalid"><p v-if="invalidEmail">Invalido Email</p></div>

            <!-- PASSWORD -->
            <input type="password" name="password" autocomplete="new-password" v-model="password"
            v-bind:class="{ 'is-invalid': missingPassword || invalidPassword }" class="form-control"
            placeholder="Password"/>
            <div class="alert-danger" role="alert" v-cloak v-show="isFormInvalid"><p v-if="missingPassword">Preencher a Password</p></div>
            <div class="alert-danger" role="alert" v-cloak v-show="isFormInvalid"><p v-if="invalidPassword">Password deve ter 6 digitos</p></div>

            <!-- CONFIRM PASSWORD -->
            <input type="password" name="passwordConfirmation" v-model="passwordConfirmation"
            v-bind:class="{ 'is-invalid': missingPasswordConfirmation || wrongPasswordConfirmation }"
            class="form-control" placeholder="Confirm Password"/>
            <div class=" alert-danger" role="alert" v-cloak v-show="isFormInvalid"><p v-if="missingPasswordConfirmation">Confirma a Password</p></div>
            <div class=" alert-danger" role="alert" v-cloak v-show="isFormInvalid"> <p v-if="wrongPasswordConfirmation">Password não são iguais</p></div>
            
            <vue-recaptcha
                align="center"
                @verify="onCaptchaVerified"
                sitekey="6LdxSGAUAAAAAArJ_prh93hEVYhyLQ13Xt2Ik4_b">
            </vue-recaptcha>
            <br>
            <!-- LINKS -->
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Registar</button>
            <p class="text-center">
                <router-link to="/login" class="">Voltar a Iniciar Sessão</router-link>
            </p>

        </form><!-- /form -->
        <p class="text-center">
            <a href="/" class="text-muted"><small>← Voltar a IPL-Cibersegurança</small></a>
        </p>
    </div><!-- /card-container -->

</template>


<script type="text/javascript">
    import VueRecaptcha from 'vue-recaptcha';
    export default {
        data: function () {
            return {
                name: '',
                username: '',
                email: '',
                password: '',
                loading: false,
                isVerifiedWithRecaptcha: false,
                passwordConfirmation: '',
                attemptSubmit: false,
                serverErrorCode: 0,
                serverErrorMessage: '',
                success: false
            }
        },
        computed: {
            missingName: function () {
                return this.name.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            missingEmail: function () {
                return this.email.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidEmail: function () {
                return !this.missingEmail && !this.validateEmail(this.email.trim()) && !this.hasServerError && this.attemptSubmit;
            },
            emailAlreadyUsed: function () {
                return this.serverErrorCode == 1;
            },
            missingUsername: function () {
                return this.username.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            usernameAlreadyUsed: function () {
                return this.serverErrorCode == 2;
            },
            missingPassword: function () {
                return this.password.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidPassword: function () {
                return !this.missingPassword && !this.validatePasswordStructure(this.password.trim()) && !this.hasServerError && this.attemptSubmit;
            },
            missingPasswordConfirmation: function () {
                return !this.missingPassword && !this.invalidPassword && this.passwordConfirmation.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            wrongPasswordConfirmation: function () {
                return !this.missingPassword && !this.invalidPassword && !this.missingPasswordConfirmation && (this.passwordConfirmation.trim() != this.password.trim()) && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return (this.missingName || this.missingEmail || this.missingUsername || this.missingPassword || this.invalidPassword || this.wrongPasswordConfirmation || this.missingPasswordConfirmation || this.invalidEmail);
            },
            hasServerError: function () {
                return this.serverErrorCode == -1 || this.emailAlreadyUsed || this.usernameAlreadyUsed;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
            onCaptchaVerified: function() {
                this.isVerifiedWithRecaptcha = true;
            },
            validateEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            validatePasswordStructure: function (password) {
                var re = /^[a-zA-Z0-9]{6,}$/;
                return re.test(password);
            },
            clear: function () {
                this.name = '';
                this.username = '';
                this.email = '';
                this.password = '';
                this.passwordConfirmation = '';
                this.attemptSubmit = false;
                this.serverErrorCode = 0;
            },
            validateForm: function () { 
                //CLEARS SERVER ERROR'S
                this.serverErrorCode = 0;
                this.success = false;

                //PREVENT FORM
                event.preventDefault();

                //FORM SUBMITED
                this.attemptSubmit = true;

                //IF FORM IS VALID MAKE API REQUEST FOR LOGIN
                if (!this.isFormInvalid && this.isVerifiedWithRecaptcha == true) {
                    this.loading = true;
                    const data = {
                        name: this.name,
                        username: this.username,
                        email: this.email,
                        password: this.password
                    };
                    axios.post('/api/register', data)
                    .then((response) => {
                        this.success = true;
                        this.clear();
                        this.loading = false;
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.serverErrorCode = error.response.data.errorCode;
                        this.serverErrorMessage = error.response.data.msg;
                    });
                }
            },
        },
        components: { 
            VueRecaptcha 
        },
    }
</script>