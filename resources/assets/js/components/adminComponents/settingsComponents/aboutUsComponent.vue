<template>
	<form class="m-2" autocomplete="off" v-on:submit.prevent="validateForm" >
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Sobre Nós</label>
			<div class="col-sm-10">
				<textarea class="form-control" id="exampleFormControlTextarea1" v-model="aboutUs" rows="10"></textarea>
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
                aboutUs: '',
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
                success: false,
            }
        },
        computed: {
            missingAboutUs: function () {
                return this.aboutUs.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return this.missingAboutUs;
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        methods: {
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
                        aboutUs:  this.aboutUs,
                    };
                    axios.post('/api/settings/aboutUs/update', data)
                        .then((response) => {
                            this.success = true;
                            this.attemptSubmit = false;
                            this.serverError = true;
                            
                            swal("Sobre Nós alterado com sucesso.", {
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
            getAboutUs: function () {
                axios.get('/api/settings/aboutUs')
                    .then(response=>{
                        this.aboutUs = response.data;
                    });
            },
            cancel: function () {
                this.attemptSubmit = false;
                this.getAboutUs();
            }
        },
        created: function () {
            this.getAboutUs();
        }
    }
</script>