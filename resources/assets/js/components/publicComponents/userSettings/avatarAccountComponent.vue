<template>
	<div class="row">
        <div class="col-md-8 col-xs-12">
            <div class="alert alert-success alert-dismissible" role="alert" v-cloak v-show="success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p><strong>Successo: </strong>Imagem de Perfil alterada com sucesso!</p>
            </div>
            <div class="alert alert-danger alert-dismissible" role="alert" v-cloak v-show="wrongFormat">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p><strong>Erro: </strong>Formato de ficheiro Inválido - JPEG | JPG | PNG</p>
            </div>
			<form class="form-horizontal">
				<div class="form-group">
					<div class="col-md-9 col-md-offset-3 col-xs-12 profile_left">
		                <!-- Current avatar -->
		                <img class="img-responsive img-rounded" v-if="avatar != ''" :src="avatar" alt="Imagem de Perfil" title="Imagem de Perfil" width="150px" height="150px">
		                <p class="help-block">Escolha uma Imagem de Perfil <br> Formatos - JPEG | JPG | PNG</p>
		            </div>
				</div>
				<div class="form-group">
					<div class="col-md-9 col-md-offset-3 col-xs-12">
		                <label class="btn btn-success btn-upload" for="inputImage" title="Enviar imagem de Perfil">
		                    <input type="file" v-on:change="onFileChange" class="sr-only" id="inputImage" name="file"
		                           accept="image/*"/>
		                    <span>Escolher Imagem</span>
		                </label>

		                <button type="button" @click="upload" class="btn btn-contrast">Guardar</button>
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
                avatar: '',
                success: false,
                avatarChanged: false,
                wrongFormat: false,
            }
        },
        computed: {

        },
        methods: {
            getAvatar: function () {
                axios.get('/api/user')
                    .then((response) => {
                        this.avatar = 'img/avatars/' + response.data.avatar;
                    });
            },
            onFileChange(e) {
                this.success = false;
                this.wrongFormat = false;
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);

            },
            createImage(file) {
                if (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png") {
                    this.avatar = '';
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.avatar = e.target.result;
                    };

                    reader.readAsDataURL(file);
                    this.avatarChanged = true;
                } else {
                    this.wrongFormat = true;
                }
            },
            upload(){
                if (this.avatarChanged) {
                    axios.post('/api/user/avatar/update', {avatar: this.avatar}).then(response => {
                        this.success = true;
                        this.avatarChanged = false;
                        this.getAvatar();
                    });
                }
            },
        },
        created: function () {
            this.getAvatar();
        }
    }
</script>