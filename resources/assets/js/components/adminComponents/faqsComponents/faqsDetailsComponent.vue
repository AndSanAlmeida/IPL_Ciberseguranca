<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

        <div class="card card-outline-secondary mt-2">
            <div class="card-header">
                <h1 class="mb-0 text-center">Detalhes da FAQ</h1>
            </div>
            <div class="card-body">
                
                <p><b>Questão: </b>{{faq.question}}</p>

                <p><b>Resposta: </b>{{faq.answer}}</p>
 				 <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"></label>
                    <div class="col-lg-9">
                        <input class="btn btn-secondary float-right" value="Voltar" type="button" v-on:click="exit">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
    	props: ['faq'],
        data: function() {
            return {
            	
            }
        },
        methods: {
            exit: function() {
                this.$emit('exit');
            },
        },
        mounted() {
        }
    }
</script>