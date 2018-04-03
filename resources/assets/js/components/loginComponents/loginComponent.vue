<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="text-center text-light">Login</h2>
                    </div>
                    <div class="panel-body">
                        <form method="post" v-on:submit.prevent="submitForm">
                            <div class="form-group">
                                <input type="text" name="username" v-model="username" v-bind:class="{ 'is-invalid': missingUsername  }" class="form-control" placeholder="Username"  />
                            </div>
                            <div class="clearfix">
                                <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingUsername ">
                                    <p v-if="missingUsername">Preencher Username</p>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <input type="password" name="password" v-model="password" v-bind:class="{ 'is-invalid': missingPassword }" class="form-control margin-bottom0" placeholder="Password"  />
                            </div>
                            <div class="clearfix">
                                <div class="alert alert-danger" role="alert" v-cloak v-show="isFormInvalid && missingPassword">
                                    <p v-if="missingPassword">Preencher Password</p>
                                </div>
                            </div>
                            <p v-if="serverError" class="alert alert-danger">{{serverErrorMessage}}</p>

                            <router-link to="/password/reset" class="float-right text-muted mt-0 small font-italic" >Recuperar Password</router-link>

                            <button type="submit" class="btn btn-dark btn-block mt-4">Log in</button>
                            <p class="text-center mb-0 pb-0 mt-2">
                                <router-link to="/register" class="">Criar nova conta</router-link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
