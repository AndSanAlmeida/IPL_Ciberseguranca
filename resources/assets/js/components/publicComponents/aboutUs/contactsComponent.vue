<template>
	<section id="aboutUs" class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12">
                    <b-breadcrumb :items="items"/>
                    <div class="left-highlight">
                        <h1>{{ title }}</h1>
                    </div>
                    <address>
                        <h4><strong>Instituto Politécnico de Leiria</strong></h4>
                        Rua General Norton de Matos, <br>
                        Apartado 4133, <br>
                        2411-901 Leiria – Portugal<br>
                        <abbr title="GPS">GPS:</abbr> 39°44’15.1″N 8°48’40.8″W <br>
                        <abbr title="Phone">P:</abbr> (+351) 244830010 <br>
                        <br>
                        <h4><strong>Email</strong></h4><a href="mailto:ipleiria@ipleiria.pt">ipleiria@ipleiria.pt</a>
                    </address>
                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>

                    <aboutUsNav></aboutUsNav>
                    
                </div>
			</div>
		</div>
	</section>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {
                title: 'Contactos',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Sobre Nós',
                    href: '/#/aboutUs'
                }, {
                    text: 'Contactos',
                    active: true
                }],
            }
        }
    }
</script>