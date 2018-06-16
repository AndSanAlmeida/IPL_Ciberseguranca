<template>
    <div class="card card-container">
        <img class="profile-img-card" v-bind:src="'/img/logo_ipl_header.png'" alt="Logotipo IPL">
        <br>
       <div v-if="loading" class="loader"></div>
        
        <form class="form-signin" method="post" v-on:submit.prevent="submitForm">

            <div class="alert alert-danger" role="alert" v-cloak v-show="serverError">
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
            <a href="/" class="text-muted"><small>← Voltar a IPLeiria | Cibersegurança</small></a>
        </p>
    </div><!-- /card-container -->
</template>

<script>
export default {
    data: function() {
        return {

            username: '',
            password: '',
            loading: false,
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
            this.loading = true;
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
                        if(response.data.type == 1){
                            window.location.href = '/admin/#/home'
                            this.loading = false;
                        } else if (response.data.type == 0) {
                            window.location.href = '/'
                            this.loading = false;
                        }
                    })
                    .catch((error) => {
                        this.serverError = true;
                        this.serverErrorMessage = error.response.data.data;
                        this.loading = false;
                    });
                })
                .catch((error) => {
                    this.serverError = true;
                    console.log(error);
                    this.serverErrorMessage = error.response.data.data;
                    this.loading = false;
                });
            }
        },
    }
}
</script>