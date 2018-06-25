<template>
	<section id="activities" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
					<b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                        <h1>{{ title }}</h1>
                    </div>
                    <br>
                    <b-alert show variant="danger" v-if="showError">{{msgError}}</b-alert>
					<div v-if="showButton">
					     <button type="button" v-on:click="pressedUnsubscribe" class="btn btn-primary">Anular Subscrição</button>
					     <button type="button" v-on:click="cancel" class="btn btn-danger">Cancelar</button>
				    </div>
				    <br><br>
                    <b-alert show variant="success" v-if="pressedNo">
					  <h4 class="alert-heading">IPLeiria | Cibersegurança - Newsletter </h4>
					  <p>
					    Obrigado por continuar subscrito à nossa newsletter.
					  </p>
					  <hr>
					  <p class="mb-0">
					    <a href="/" class="alert-link">Ir para Página Inicial <i class="fas fa-arrow-right"></i></a>
					  </p>
					</b-alert>
					<b-alert show variant="success" v-if="pressedYes">
					  <h4 class="alert-heading">IPLeiria | Cibersegurança - Newsletter </h4>
					  <p>
					    Lamentamos que tenho anulado a subscrição à nossa newsletter.
					    A qualquer momento pode subscrever-se, basta voltar a inscrever-se na nossa página.
					  </p>
					  <hr>
					  <p class="mb-0">
					    <a href="/" class="alert-link">Ir para Página Inicial <i class="fas fa-arrow-right"></i></a>
					  </p>
					</b-alert>
                </div>
            </div>
		</div>
	</section>
</template>
<script type="text/javascript">
	import swal from 'sweetalert';
	export default {
        data: function(){
            return {
                email: '',
                title: 'Anular Subscrição',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Recursos',
                    href: '/#/resources'
                }, {
                    text: 'Newsletters',
                    href: '/#/resources/newsletters'
                }, {
                    text: 'Anular Subscrição',
                    active: true
                }],
                pressedNo: false,
                pressedYes: false,
                showButton: true,
                showError: false,
                msgError: '',
                loading: false,
            }
        },
        computed: {
        	
        },
        methods: {
        	cancel: function() {
        		this.pressedYes = false;
              	this.pressedNo = true;
              	this.showButton = false;
        	},
            pressedUnsubscribe: function() {
            	this.loading=true;
                
				swal("Pertende realmente anular a subscrição da newsletter?", {
              		icon: "warning",
              		buttons: {
                  		no: {
                    		text: "Não",
                    		className: "btn-light",
                  		},
                  		yes: {
	                        text: "Sim",
	                        className: "btn-info",
                  		},
              		},
          		})
          		.then((value) => {
              		switch (value) {
                  		case "no":
                  			this.pressedYes = false;
                  			this.pressedNo = true;
                  			this.showButton = false;
                    		break;
                  		case "yes":
                  			axios.delete('/api/newsletter/unsubcribe/'+this.email)
			                    .then(response=>{
			                    	if (response.data.error == true) {
			                    		this.showError = true;
			                    		this.msgError = response.data.msg;
			                    	} else {
			                    		this.pressedYes = true;
				                      	this.pressedNo = false;
				                      	this.showButton = false;
				                    }
			                        this.loading = false;
			                    }).catch((error) => {
			                    	console.log(error);
			                        this.loading = false;
			                        this.errorLoading = true;
			                });

	                     	break;
	                }
          		});
           	},
        },
        created: function() {
        	this.email = this.$route.params.email;
        },
    }
</script>