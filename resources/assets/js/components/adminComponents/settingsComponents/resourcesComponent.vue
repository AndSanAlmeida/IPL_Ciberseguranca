<template>
	<form class="m-2" autocomplete="off" v-on:submit.prevent="validateForm" >
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Atividades</label>
			<div class="col-sm-10">
                  <quill-editor v-model="resources.description"
                                ref="myQuillEditor"
                                :options="editorOption">
                  </quill-editor>
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
                resources: [],
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
                success: false,
                editorOption: {
                    theme: 'snow',
                    modules: {
                        toolbar: this.toolbarSettings()
                    }
                }
            }
        },
        computed: {
            missingResources: function () {
                return this.resources.description.trim() === '' && !this.hasServerError && this.attemptSubmit;
            },
            hasClientError: function () {
                return this.missingResources;
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
                        resources:  this.resources,
                    };
                    axios.post('/api/settings/resources/update', data)
                        .then((response) => {
                            this.success = true;
                            this.attemptSubmit = false;
                            this.serverError = true;
                            
                            swal("Recursos alterado com sucesso.", {
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
            getResources: function () {
                axios.get('/api/settings/resources')
                    .then(response=>{
                        this.resources = response.data;
                    });
            },
            cancel: function () {
                this.attemptSubmit = false;
                this.getResources();
            }
        },
        computed: {
            editor() {
                return this.$refs.myQuillEditor.quill
            }
        },
        created: function () {
            this.getResources();
        },
        mounted() {
            console.log('this is current quill instance object', this.editor)
        }
    }
</script>
<style type="text/css" media="screen">
    .ql-toolbar.ql-snow + .ql-container.ql-snow {
        min-height: 200px;
    }
</style>