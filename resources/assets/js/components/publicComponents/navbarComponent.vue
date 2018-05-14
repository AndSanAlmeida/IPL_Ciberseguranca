<template>
    <div id="nav" class="navbar navbar-default navbar-fixed-top menu-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <router-link to="/" class="navbar-brand" style="font-weight: normal;">IPL | Cibersegurança</router-link>
                    </div>
                    <div class="navbar-collapse collapse">
                        <nav>
                            <ul class="nav navbar-nav navbar-right">
                                <li><router-link to="/home" title="Home">Home</router-link></li>
                                <li><router-link to="/resources" title="Recursos">Recursos</router-link></li>
                                <li><router-link to="/activities" title="Actividades">Atividades</router-link></li>
                                <li><router-link to="/aboutUs" title="Sobre Nós">Sobre Nós</router-link></li>

                                <!-- LOGIN | SIGN UP -->
                                <li v-if="!logged"><a href="/auth/" class="login">Entrar</a></li>
                                <li v-if="!logged"><a href="/auth/#/register" class="signup">Registar</a></li>

                                <!-- DROPDOWN -->
                                <li v-if="logged"> 
                                    <div class="dropdown">
                                        <span class="authDropdown dropdown-toggle" id="authDropdown" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                            Bem-vindo, {{user.name}}
                                            <span class="caret"></span>
                                        </span>
                                        <ul class="dropdown-menu" aria-labelledby="authDropdown">
                                            <li><a href="#">Definições</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="#" v-on:click="logout">
                                                    <strong>Logout</strong> 
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div><!--- END COL -->
            </div><!--- END COL -->
        </div><!--- END CONTAINER -->
    </div>
</template>

<script type="text/javascript">
    import User from '../../classes/user.js';
    export default {
        data: function(){
            return {
                user: new User(),
                logged: false
            }
        },
        methods: {
            getUser: function () {
                let config = {
                    headers: {
                    'Authorization': localStorage.getItem("access_token")
                    }
                }
                axios.get('/api/user', config)
                    .then((response) => {
                        console.log(response.data);
                        this.logged = true;
                        this.user.parse(response.data);
                    })
                    .catch((error) => {
                        
                    });
            },
            isLogged: function() {
                return this.logged;
            },
            logout:function() {
                let config = {
                    headers: {
                    'Authorization': localStorage.getItem("access_token")
                    }
                }
                axios.post('/api/logout', null, config)
                    .then((response) => {
                        localStorage.removeItem("access_token");
                        this.logged = false;
                        location.reload(true);
                    })
                    .catch((error) => {
                        
                    });
            }
        },
        computed: {
            
        },
        components: {

        },
        created: function () {
            if(localStorage.getItem("access_token") != null) {
                this.getUser();
                this.logged = true;
            }
        }
    }
</script>

<style type="text/css">

</style>