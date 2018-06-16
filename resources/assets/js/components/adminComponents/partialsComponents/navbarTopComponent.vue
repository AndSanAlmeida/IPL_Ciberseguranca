<template>
	<header class="header">
	  <nav class="navbar">
	    <div class="container-fluid">
	      <div class="navbar-holder d-flex align-items-center justify-content-between">
	        <!-- Navbar Header-->
	        <div class="navbar-header">
	          <!-- Navbar Brand --><a href="#" class="navbar-brand">
	            <div class="brand-text brand-big"><span>IPLeiria - Cibersegurança</span></div>
	            <div class="brand-text brand-small"><strong>IPLeiria</strong></div></a>
	          <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
	        </div>
	        <!-- Navbar Menu -->
	        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item"> 
                    <a href="/" class="nav-link" title="Página Oficial"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Página Oficial</a>
                </li>
                <!-- Messages-->
	            <li class="nav-item" v-if="this.$root.numberOfQuestions>0" > 
                    <a href="/admin/#/userQuestions" class="nav-link" title="Perguntas dos utilizadores">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-orange badge-corner">{{this.$root.numberOfQuestions}}</span>
                    </a>
	            </li>
	            <!-- Logout    -->
	            <li class="nav-item">
                    <a href="javascript:;" class="nav-link logout" v-on:click="logout" title="Sair">Logout <i class="fa fa-sign-out"></i></a>
                </li>
	        </ul>
	      </div>
	    </div>
	  </nav>
	</header>
</template>
<script type="text/javascript">
    import User from '../../../classes/user.js';
    export default {
        data: function(){
            return {
                user: new User(),
                logged: false,
                numberOfQuestions: 0,
            }
        },
        methods: {
            getUser: function () {
                axios.get('/api/user')
                    .then((response) => {
                        this.logged = true;
                        this.user.parse(response.data);
                    });
            },
            logout:function() {
                axios.post('/api/logout', null)
                    .then((response) => {
                        localStorage.removeItem("access_token");
                        window.location.href = '/';
                        this.logged = false;
                    });
            },
            getNotAnsweredQuestions: function () {
                this.loading = true;
                this.errorLoading = false;
                
                axios.get('/api/questions/notAnswered')
                    .then(response => {
                        this.$root.numberOfQuestions = response.data.data.length;
                    }).catch((error) => {
                });
            },
        },
        created: function () {
            if(localStorage.getItem("access_token") != null) {
                this.getUser();
                this.logged = true;
            }
            this.getNotAnsweredQuestions();
        }
    }
</script>