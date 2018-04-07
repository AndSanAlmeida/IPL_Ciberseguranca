<template>
    <div class="card card-container">
        <img class="profile-img-card" v-bind:src="'/img/logo_ipl_header.png'" alt="Logotipo IPL">
        <br>
        <form class="form-signin" method="post" v-on:submit.prevent="submitForm">

            <div class="alert alert-success" role="alert" v-cloak v-show="serverError">
                <p>{{serverErrorMessage}}</p>
            </div>

            <!-- USERNAME | EMAIL -->
            <input type="text" id="inputAuth" class="form-control" name="username" v-model="username" v-bind:class="{ 'is-invalid': missingUsername  }" placeholder="Username ou Email" required autofocus />

            <div class="clearfix">
                <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingUsername ">
                    <p v-if="missingUsername">Preencher Username / Email</p>
                </div>
            </div>

            <!-- PASSWORD -->
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" v-model="password" v-bind:class="{ 'is-invalid': missingPassword }" required />

            <div class="clearfix">
                <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingPassword">
                    <p v-if="missingPassword">Preencher Password</p>
                </div>
            </div>

            <!-- REMEMBER ME -->
            <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Lembrar-me
                </label>
            </div>
            
            <!-- LINKS --> 
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Iniciar Sessão</button>
            <p class="text-center">
                <router-link to="/password/reset">Recuperar Password</router-link>
            </p>
            <p class="text-center">
                <router-link to="/register" class="">Criar nova conta</router-link>
            </p>

        </form><!-- /form -->
        <p class="text-center">
            <a href="/" class="text-muted"><small>← Voltar a IPL-Cibersegurança</small></a>
        </p>
    </div><!-- /card-container -->
</template>

<script>
export default {
    data: function() {
        return {

            username: '',
            password: '',
            attemptSubmit: false,
            serverError: false,
            serverErrorMessage: '',
        }
    },
    computed: {
        missingUsername: function () {
            return this.username.trim() === '' && !this.hasServerError && this.attemptSubmit;
        },
        missingPassword: function () {
            return this.password.trim() === '' && !this.hasServerError && this.attemptSubmit;
        },
        hasClientError: function () {
            return (this.missingUsername || this.missingPassword);
        },
        hasServerError: function () {
            return this.serverError;
        },
        isFormInvalid: function () {
            return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
        },
    },
    methods: {
        submitForm: function (event) {
            this.serverError = false;
            this.attemptSubmit = true;

            if (!this.isFormInvalid) {
                const data = {
                    username: this.username,
                    password: this.password,
                };
                axios.post('/api/login', data)
                .then((response) => {
                    localStorage.setItem('access_token', 'Bearer ' + response.data.access_token);
                    axios.get('/api/user', { headers: {"Authorization" : 'Bearer ' + response.data.access_token}})
                    .then((response) => {
                        console.log(response.data);
                        if(response.data.type == 1){
                                        // ADIM
                                    } else if (response.data.type == 0) {
                                        window.location.href = '/'
                                    }
                                })
                    .catch((error) => {
                        this.serverError = true;
                        console.log(error);
                        this.serverErrorMessage = error.response.data.data;
                    });
                })
                .catch((error) => {
                    this.serverError = true;
                    console.log(error);
                    this.serverErrorMessage = error.response.data.data;
                });
            }
        },
    }

}
</script>
