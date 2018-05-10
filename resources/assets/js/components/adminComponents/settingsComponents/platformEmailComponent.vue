<template>
	<form class="m-2" autocomplete="off" v-on:submit.prevent="validateForm" >
		<div class="form-group row">
			<label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" id="inputEmail" placeholder="Email" v-model="settings.email" autocomplete="off">
			</div>
		</div>
		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" id="inputPassword" v-model="settings.password" placeholder="Password">
			</div>
		</div>
		<hr>
		<div class="form-group row">
			<label for="inputDriver" class="col-sm-2 col-form-label">Driver</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="inputDriver" v-model="settings.driver" placeholder="Driver">
			</div>
		</div>
		<div class="form-group row">
			<label for="inputHost" class="col-sm-2 col-form-label">Host</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="inputHost" v-model="settings.host" placeholder="Host">
			</div>
		</div>
		<div class="form-group row">
			<label for="inputPort" class="col-sm-2 col-form-label">Port</label>
			<div class="col-sm-10">
				<input type="number" class="form-control" id="inputPort" v-model="settings.port" placeholder="Port">
			</div>
		</div>
		<div class="form-group row">
			<label for="inputEncryption" class="col-sm-2 col-form-label">Encryption</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="inputEncryption" v-model="settings.encryption" placeholder="Encryption">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-primary ml-2 float-right">Confirmar</button>
				<button type="reset" class="btn btn-secondary float-right" v-on:click="cancel">Cancelar</button>
			</div>
		</div>
	</form>
</template>

<script type="text/javascript">
	export default {
        data: function(){
            return {
                settings: {
                    email: '',
                    password: '',
                    host: '',
                    port: '',
                    encryption: '',
                    driver: '',
                },
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
                success: false,
            }
        },
        computed: {
            missingEmail: function () {
                return this.settings.email.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidEmail: function () {
                return !this.missingEmail && !this.validateEmail(this.settings.email.trim()) && !this.hasServerError && this.attemptSubmit;
            },
            missingPassword: function () {
                return this.settings.password.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            missingHost: function () {
                return this.settings.host.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            missingPort: function () {
                return this.settings.port === '' && !this.hasServerError && this.attemptSubmit;
            },
            invalidPort: function () {
                return !this.missingPort && !this.validateIntegerBiggerThan0(this.settings.port) && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return (this.missingEmail || this.invalidEmail || this.missingPassword || this.missingHost || this.missingPort || this.invalidPort);
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
            validateIntegerBiggerThan0: function (number) {
                var re = /^[1-9][0-9]*$/;
                return re.test(number);
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
                    const data = {
                        host:  this.settings.host,
                        port:  this.settings.port,
                        driver: this.settings.driver,
                        password:  this.settings.password,
                        encryption:  this.settings.encryption,
                        email: this.settings.email,
                    };
                    axios.post('/api/settings/update', data)
                        .then((response) => {
                            this.success = true;
                            this.attemptSubmit = false;
                            this.serverError = true;
                            
                            swal("Email da plataforma alterado com sucesso.", {
                            	icon: 'success',
					            buttons: {
					              ok: "Ok"
					            },
					          })
					          .then((value) => {
					            switch (value) {
					              case "ok":
					              break;
					            }
					          });

                        })
                        .catch((error) => {
                            this.serverError = true;
                            this.serverErrorMessage = error.response.data.msg;
                        });
                }
            },
            getPlatformData: function () {
                axios.get('/api/settings')
                    .then(response=>{
                        this.settings = response.data.data;
                    });
            },
            cancel: function () {
                this.attemptSubmit = false;
                this.getPlatformData();
            }
        },
        created: function () {
            this.getPlatformData();
        }
    }
</script>