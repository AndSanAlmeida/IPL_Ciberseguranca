<template>
    <div class="card card-container">
        <img class="profile-img-card" v-bind:src="'/img/logo_ipl_header.png'" alt="Logotipo IPL">
        <br>
        <form class="form-signin" method="post" v-on:submit.prevent="validateForm">

            <div class="alert alert-danger" role="alert" v-cloak v-show="serverError">
                <p>{{serverErrorMessage}}</p>
            </div>

            <div class="alert alert-success" role="alert" v-cloak v-show="success">
                <p>Password Alterada</p>
            </div>

            <div v-if="loading" class="loader"></div>

            <!-- EMAIL -->
            <input type="text" name="email" v-model="email"
            v-bind:class="{ 'is-invalid': missingEmail || invalidEmail }" class="form-control" placeholder="Email"/>

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

            <!-- LINKS --> 
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Alterar Password</button>

        </form><!-- /form -->
        <p class="text-center">
            <a href="/" class="text-muted"><small>← Voltar a IPL-Cibersegurança</small></a>
        </p>
    </div><!-- /card-container -->
</template>

<script type="text/javascript">
export default {
    props: ['token', 'user'],
    data: function () {
        return {
            email:'',
            password: '',
            passwordConfirmation: '',
            attemptSubmit: false,
            serverError: false,
            serverErrorMessage: '',
            success: false,
            loading: false,
        }
    },
    computed: {
        missingEmail: function () {
            return this.email.trim() === '' && !this.hasServerError && this.attemptSubmit;
        },
        invalidEmail: function () {
            return !this.missingEmail && !this.validateEmail(this.email.trim()) && !this.hasServerError && this.attemptSubmit;
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
            return (this.missingEmail || this.invalidEmail || this.missingPassword || this.invalidPassword || this.wrongPasswordConfirmation || this.missingPasswordConfirmation);
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
        validatePasswordStructure: function (password) {
            var re = /^[a-zA-Z0-9]{6,}$/;
            return re.test(password);
        },
        validateForm: function () {
                //CLEARS SERVER ERROR'S
                this.serverError = false;
                this.success = false;

                //PREVENT FORM
                event.preventDefault();

                //FORM SUBMITED
                this.attemptSubmit = true;

                //IF FORM IS VALID MAKE API REQUEST FOR LOGIN
                if (!this.isFormInvalid) {
                    this.loading = true;
                    const data = {
                        email: this.email,
                        token: this.token,
                        password: this.password
                    };
                    axios.post('/api/password/reset', data)
                    .then((response) => {

                        this.success = true;
                        this.attemptSubmit = false;
                        this.loading = false;
                        this.email = '';
                        this.password = '';
                        this.passwordConfirmation = '';
                        setTimeout( () => this.$router.push({ path: '/login'}), 5000);
                    })
                    .catch((error) => {
                        this.serverError = true;
                        this.serverErrorMessage = "server" + error.response.data.msg;
                        setTimeout(this.serverError = false, 5000);
                    });
                    

                }
            },
        }
    }
    </script>