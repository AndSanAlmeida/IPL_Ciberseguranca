<template>
	<nav class="side-navbar">
	  <!-- Sidebar Header-->
	  <div class="sidebar-header d-flex align-items-center">
	    <div class="avatar"><img :src="`/img/avatars/${user.avatar}`" alt="Imagem de Perfil" class="img-fluid rounded-circle"></div>
	    <div class="title">
	      <h1 class="h4">{{ user.name }}</h1>
	      <p>{{ user.username }}</p>
	    </div>
	  </div>
	  <!-- Sidebar Navidation Menus-->
	  <span class="heading">Main</span>
	  <ul class="list-unstyled">
	    <li><router-link to="/home" title="Home"><i class="icon-home"></i>Home</router-link></li>
	    <li><router-link to="/users" title="Users"> <i class="icon-user"></i>Utilizadores</router-link></li>
	    <li><router-link to="/news"> <i class="icon-page"></i>Notícias </router-link></li>
	    <li><router-link to="#"> <i class="icon-website"></i>Alertas </router-link></li>
	    <li><router-link to="/events"> <i class="icon-paper-airplane"></i>Eventos </router-link></li>
	    <li><router-link to="/glossary"> <i class="icon-list"></i>Glossário </router-link></li>
	    <li><router-link to="#"> <i class="icon-bill"></i>Newsletter </router-link></li>
	    <li><router-link to="/documents"> <i class="icon-website"></i>Documentos</router-link></li>
	    <li><router-link to="/usefulLinks"> <i class="icon-page"></i>Links Úteis </router-link></li>
	    <li><router-link to="/userQuestions"> <i class="icon-ios-email-outline"></i>Questões dos Utilizadores </router-link></li>
	    <li><router-link to="/faqs"> <i class="icon-list-1"></i>FAQ </router-link></li>
	    <li><router-link to="/settings"> <i class="icon-interface-windows"></i>Definições </router-link></li>
	  </ul>
	</nav>
</template>

<script type="text/javascript">
    export default {
        data: function () {
            return {
            	user: []
            }
        },
        methods: {
            getUser: function () {
                axios.get('/api/user')
                    .then((response) => {
                        this.user = response.data
                    });
            }
        },
        created: function () {
            this.getUser();
        }
    }
</script>