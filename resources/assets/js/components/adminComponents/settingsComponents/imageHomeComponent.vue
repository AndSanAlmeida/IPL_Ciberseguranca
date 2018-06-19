<template>
    <div>
        <div class="form-group row m-4">
            <h2 class="w-50">Homepage - Imagem </h2>
            <div class="w-50 text-right">
                <label class="btn btn-success" for="inputImageHome" title="Enviar imagem da Homepage">
                    <input type="file" v-on:change="onFileChangeHome" class="sr-only" id="inputImageHome" name="fileHome"
                           accept="image/*"/>
                    <span>Escolher Imagem</span>
                </label>

                <label  @click="uploadHome" class="btn btn-primary">Guardar</label>
            </div>
            <img class="mw-100 mt-3" :src="imageHome" alt="Imagem da Homepage" title="Imagem da Homepage" >
        </div>
        <hr>
        <div class="form-group row m-4">
            <h2 class="w-50">Nossa Missão - Imagem</h2>
            <div class="w-50 text-right">
                <label class="btn btn-success" for="inputImageMission" title="Enviar imagem da Nossa Missão">
                    <input type="file" v-on:change="onFileChangeMission" class="sr-only" id="inputImageMission" name="fileMission"
                           accept="image/*"/>
                    <span>Escolher Imagem</span>
                </label>

                <label @click="uploadMission" class="btn btn-primary">Guardar</label>
            </div>
            <img class="mw-100 img-responsive mt-3" :src="imageMission" alt="Imagem da Nossa Missão" title="Imagem da Nossa Missão" >
        </div>
        <hr>
    </div>
</template>

<script type="text/javascript">

	export default {
        data: function(){
            return {
                imageHome: '',
                homeChanged: false,
                imageMission: '',
                missionChanged: false,
                success: false,
                wrongFormat: false,
                attemptSubmit: false,
                serverError: false,
                serverErrorMessage: '',
            }
        },
        computed: {
            
        },
        components: {

        },
        methods: {
            uploadMission: function() {
                if (this.missionChanged) {
                    axios.post('/api/settings/mission/image', {img: this.imageMission}).then(response => {
                        this.success = true;
                        this.missionChanged = false;
                        swal("Imagem alterada com sucesso.", {
                            icon: "success",
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
                        this.getImages();        
                        
                    });
                }
            },
            uploadHome: function() {
                if (this.homeChanged) {
                    axios.post('/api/settings/home/image', {img: this.imageHome}).then(response => {
                        this.success = true;
                        this.homeChanged = false;
                        swal("Imagem alterada com sucesso.", {
                            icon: "success",
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
                        this.getImages();
                    });
                }
            },
            onFileChangeHome(e) {
                this.success = false;
                this.wrongFormat = false;
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImageHome(files[0]);

            },
            createImageHome(file) {
                if (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png") {
                    this.imageHome = '';
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.imageHome = e.target.result;
                    };

                    reader.readAsDataURL(file);
                    this.homeChanged = true;
                } else {
                    this.wrongFormat = true;
                }
            },
            onFileChangeMission(e) {
                this.success = false;
                this.wrongFormat = false;
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImageMission(files[0]);

            },
            createImageMission(file) {
                if (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png") {
                    this.imageMission = '';
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.imageMission = e.target.result;
                    };

                    reader.readAsDataURL(file);
                    this.missionChanged = true;
                } else {
                    this.wrongFormat = true;
                }
            },
            cancel: function () {
                this.attemptSubmit = false;
                this.getImages();
                
            },
            getImages: function () {
                var d = new Date();
                this.imageHome = '/img/cybersecuriy.png?ver=' + d.getTime();
                this.imageMission = '/img/mission.png?ver=' + d.getTime();
            }
        },
        
        created: function () {
            this.getImages();
        },
        mounted() {

        }
    }
</script>
<style type="text/css" media="screen">

</style>