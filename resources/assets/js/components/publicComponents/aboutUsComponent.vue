<template>
	<section id="aboutUs" class="section-padding">
		<div class="row">
			<div class="container">
				<div class="col-md-8 col-sm-12 marb-20">
                    <b-breadcrumb :items="items"/>
                    <div class="title-block left-highlight">
                     	<h1>{{ title }}</h1>
                 	</div>
                 	<div class="text">
                 		<p class="text-justify">
                 			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                 		</p>
                 	</div>
                </div>
                <div class="col-md-4 col-sm-12 container-nav">
                    <div class="container-nav-title">
                        <h3><strong>{{ title }}</strong></h3>
                    </div>
                    <div class="container-nav-list">
                        <ul>
                            <li><a title="Instituto Politécnico de Leiria"><router-link to="/ipl">Instituto Politécnico de Leiria</router-link></a></li>
                            <li><a title="Contactos"><router-link to="/contacts">Contactos</router-link></a></li>
                        </ul>
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
                title: 'Sobre Nós',
                items: [{
                    text: 'Início',
                    href: '/#/home'
                }, {
                    text: 'Sobre Nós',
                    active: true
                }]
            }
        },
    }
</script>