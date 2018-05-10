<template>
	<section id="newsletter" class="section-padding">
        <div class="container">
            <div v-if="!logged" class="row">
                <div class="col-md-12">
                    <div class="newsletterContentNotLogged text-center">
                        <input type="email" placeholder="Subscrever Newsletter" class="newsletter-input" />
                        <input class="newsletter-send" type="submit" value="Enviar">
                    </div>
                </div>
            </div>
            <div v-if="logged" class="row">
                <div class="col-sm-12 col-md-6 col-md-offset-3">
                    <div class="newsletterContentLogged text-center">
                        <span>Subscreva-se à nossa newsletter e seja o primeiro a receber as nossas notificações.</span> 
                        <br>
                        <input type="submit" class="newsletter-sendLogged" value="Subscrever">              
                    </div>
                </div>
            </div>
        </div>
    </section>	
</template>
<script type="text/javascript">
    export default {
        data: function(){
            return {
                logged: false,
            }
        },
        created: function() {
            if(localStorage.getItem('access_token') != null) {
                this.logged = true;
            }
        }
    }
</script>

<style type="text/css">

</style>
