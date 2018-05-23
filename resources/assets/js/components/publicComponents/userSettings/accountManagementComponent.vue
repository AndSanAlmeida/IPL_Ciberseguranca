<template>
	<div class="row">
 		<div class="col-md-8 col-xs-12">
            <form method="post" v-on:submit="validateForm" class="form-horizontal form-label-left">
                <div class="alert alert-success alert-dismissible" role="alert" v-cloak v-show="success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><strong>Successo: </strong>Informação de conta alterada com sucesso!</p>
                </div>
                <div class="alert alert-danger alert-dismissible" role="alert" v-cloak v-show="isFormInvalid">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p v-if="missingName"><strong>Erro: </strong>Introduza o nome</p>
                    <p v-if="missingEmail"><strong>Erro: </strong>Introduza o email</p>
                    <p v-if="invalidEmail"><strong>Erro: </strong>Email inválido</p>
                    <p v-if="missingUsername"><strong>Erro: </strong>Introduza o nome de utilizador</p>
                    <p v-if="hasServerError"><strong>Erro: </strong>{{ serverErrorMessage }}</p>
                </div>


                <div class="form-group" v-bind:class="{ 'has-error': missingName  }">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span
                            class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="name" id="name" v-model="name"
                               class="form-control" placeholder="Nome"/>
                    </div>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': missingUsername || usernameAlreadyUsed  }">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Nome de utilizador <span
                            class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="username" id="username" v-model="username"
                               class="form-control" placeholder="Nome de utilizador"/>
                    </div>
                </div>

                <div class="form-group"
                     v-bind:class="{ 'has-error': missingEmail || invalidEmail || emailAlreadyUsed  }">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span
                            class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="email" id="email" v-model="email"
                               class="form-control"
                               placeholder="Email"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9 col-xs-12">
                        <button type="button" @click="getData" class="btn btn-red">Cancelar</button>
                        <button type="submit" class="btn btn-contrast">Guardar</button>
                    </div>
                </div>
            </form>
            <hr>
		</div>
 	</div>
</template>

<script type="text/javascript">
	export default {
        data: function () {
            return {
                name: '',
                username: '',
                email: '',
                attemptSubmit: false,
                serverErrorCode: 0,
                serverErrorMessage: '',
                success: false,
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
            validateEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
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
                if (!this.isFormInvalid) {
                    const data = {
                        name: this.name,
                        username: this.username,
                        email: this.email,
                    };
                    axios.post('/api/user/update', data)
                        .then((response) => {
                            this.success = true;
                        })
                        .catch((error) => {
                            this.serverErrorCode = error.response.data.errorCode;
                            this.serverErrorMessage = error.response.data.msg;
                        });
                }
            },
            getData: function () {
                this.success = false;
                this.serverError = 0;
                this.attemptSubmit = false;
                axios.get('/api/user')
                    .then((response) => {
                        this.avatar = 'img/avatars/' + response.data.avatar;
                        this.name = response.data.name;
                        this.username = response.data.username;
                        this.email = response.data.email;
                    });
            },
        },
        created: function () {
            this.getData();
        }
    }
</script>