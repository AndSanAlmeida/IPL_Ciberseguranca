<template>
	<header class="header">
	  <nav class="navbar">
	    <div class="container-fluid">
	      <div class="navbar-holder d-flex align-items-center justify-content-between">
	        <!-- Navbar Header-->
	        <div class="navbar-header">
	          <!-- Navbar Brand --><a href="#" class="navbar-brand">
	            <div class="brand-text brand-big"><span>IPL-Cibersegurança</span></div>
	            <div class="brand-text brand-small"><strong>PA</strong></div></a>
	          <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
	        </div>
	        <!-- Navbar Menu -->
	        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item"> 
                    <a href="/" class="nav-link" title="Página Oficial"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Página Oficial</a>
                </li>
                <!-- Messages-->
	            <li class="nav-item"> 
                    <a href="#" class="nav-link" title="Mensagens">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-orange badge-corner">5</span>
                    </a>
	            </li>
	            <!-- Logout    -->
	            <li class="nav-item">
                    <a href="#" class="nav-link logout" v-on:click="logout" title="Sair">Logout <i class="fa fa-sign-out"></i></a>
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
            }
        },
        methods: {
            getUser: function () {
                axios.get('/api/user')
                    .then((response) => {
                        console.log('Admin Navbar: ' + response.data);
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
            }
        },
        created: function () {
            if(localStorage.getItem("access_token") != null) {
                this.getUser();
                this.logged = true;
            }
        }
    }
</script>