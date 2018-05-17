<template>
    <div class="col-md-8 offset-md-2">
        <span class="anchor" id="formUserEdit"></span>

        <div class="card card-outline-secondary mt-2">
            <div class="card-header">
                <h1 class="mb-0 text-center">Detalhes da Questão</h1>
            </div>
            <div class="card-body">
                
                <p><b>Questão: </b>{{question.question}}</p>

                <p v-if="question.answer"><b>Resposta: </b>{{question.answer}}</p>
 				<hr>
 				<p><b>Utilizador que realizou a questou:</b></p>
 				<p><b>Nome: </b>{{this.user.name}}</p>
 				<p><b>Email: </b>{{this.user.email}}</p>
                <a class="btn btn-primary" :href="`mailto:${this.user.email}`"">Enviar Email</a>
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
    	props: ['question'],
        data: function() {
            return {
            	user: '',
                
            }
        },
        methods: {
            cancel: function() {
                this.$emit('cancel');
            },
            getUser: function() {
            	axios.get('/api/user/'+this.question.id)
                    .then((response) => {
                       	this.user = response.data;
                    })
                    .catch((error) => {

                    });    
            },
            
        },
        mounted() {
            this.getUser();
        }
    }
</script>