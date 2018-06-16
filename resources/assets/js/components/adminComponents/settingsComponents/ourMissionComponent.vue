<template>
	<form class="m-2" autocomplete="off" v-on:submit.prevent="validateForm" >
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Nossa Missão</label>
			<div class="col-sm-10">
                  <quill-editor v-model="ourMission.description"
                    ref="myQuillEditor"
                    :options="editorOption">
                  </quill-editor>
                  <div class="clearfix mt-2">
                    <b-alert class="col-md-12" show variant="danger" v-cloak v-show="isFormInvalid && missingOurMission ">Preencher a nossa missão</b-alert>
                </div>
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
    import 'quill/dist/quill.snow.css';

    import { quillEditor } from 'vue-quill-editor';

	export default {
        data: function(){
            return {
                ourMission: [],
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
                editorOption: {
                    theme: 'snow',
                    modules: {
                        toolbar: this.toolbarSettings()
                    }
                }
            }
        },
        computed: {
            editor() {
                return this.$refs.myQuillEditor.quill
            },
            missingOurMission: function () {
                return this.ourMission.description === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return this.missingOurMission;
            },
            hasServerError: function () {
                return this.serverError;
            },
            isFormInvalid: function () {
                return (this.hasClientError || this.hasServerError) && this.attemptSubmit;
            },
        },
        components: {
            quillEditor
        },
        methods: {
            toolbarSettings: function() {
                return [
                          ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                          ['blockquote', 'code-block'],
                          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                          [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                          [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                          [{ 'direction': 'rtl' }],                         // text direction
                          [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                          ['clean']                                         // remove formatting button
                        ];
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
                        ourMission:  this.ourMission,
                    };
                    axios.post('/api/settings/ourMission/update', data)
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
            getOurMission: function () {
                axios.get('/api/settings/ourMission')
                    .then(response=>{
                        this.ourMission = response.data;
                    });
            },
            cancel: function () {
                this.attemptSubmit = false;
                this.getOurMission();
            }
        },
        
        created: function () {
            this.getOurMission();
        }
    }
</script>
<style type="text/css" media="screen">
    .ql-toolbar.ql-snow + .ql-container.ql-snow {
        min-height: 200px;
    }
</style>