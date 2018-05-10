<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

        <div class="card card-outline-secondary">
            <div class="card-header">
                <h1 class="mb-0 text-center">{{name}}</h1>
            </div>
            <div class="card-body">

                <p><b>Definição: </b>{{definition}}</p>

                <p><b>Fonte: </b>{{source}}</p>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"></label>
                    <div class="col-lg-9">
                        <input class="btn btn-secondary float-right" value="Voltar" type="button" v-on:click="cancel">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        data: function() {
            return {
                id: this.$route.params.id,
                name: '',
                definition: '',
                source: '',
                serverError: false,
                serverErrorMessage: '',
            }
        },
        methods: {
            getGlossaryItem: function(id) {
                axios.get('/api/glossary/'+this.id)
                .then((response) => {
                    this.name = response.data.name;
                    this.definition = response.data.definition;
                    this.source = response.data.source;
                })
                .catch((error) => {
                    this.serverError = true;
                    console.log(error);
                    this.serverErrorMessage = error.response.data.data;
                });
            },
            cancel: function() {
                window.location.href = '/admin/#/glossary'
            },
        },
        mounted: function () {
            this.getGlossaryItem();
        }
    }
</script>