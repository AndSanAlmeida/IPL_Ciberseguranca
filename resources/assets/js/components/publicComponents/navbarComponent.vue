<template>
    <div id="nav" class="navbar navbar-default navbar-fixed-top menu-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <router-link to="/" class="navbar-brand" style="font-weight: normal;">IPLeiria | Cibersegurança</router-link>
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

                                <!-- VISIBLE | HIDDEN -->
                                <li v-if="logged" class="visible-sm visible-xs">
                                    <router-link to="/userSettings" title="Ver Perfil">Ver Perfil</router-link>
                                </li>
                                <li v-if="logged && user.type == 1" class="visible-sm visible-xs">
                                    <a href="/admin/#/" title="Administração">Administração</a>
                                </li>
                                <li v-if="logged" class="visible-sm visible-xs">
                                    <a href="#" title="Logout" v-on:click="logout">
                                        <strong>Logout</strong> 
                                        <i class="fas fa-sign-out-alt"></i>
                                    </a>
                                </li>

                                <!-- DROPDOWN -->
                                <li v-if="logged" class="hidden-sm hidden-xs"> 
                                    <div class="dropdown">
                                        <span class="authDropdown dropdown-toggle" id="authDropdown" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                            <ul class="navbar-welcome">
                                                <li> {{user.name.split(/(\s).+\s/).join("")}}</li>
                                                <li>
                                                    <img class="img-responsive img-circle" :src="`/img/avatars/${user.avatar}`" alt="Imagem de Perfil" title="Imagem de Perfil" width="30px" height="30px">
                                                </li>
                                                <li><span class="caret"></span></li>
                                            </ul>                                         
                                        </span>                                        
                                        <ul class="dropdown-menu" aria-labelledby="authDropdown">
                                            <li><router-link to="/userSettings" title="Ver Perfil">Ver Perfil</router-link></li>
                                            <li role="separator" class="divider"></li>
                                            <li v-if="user.type == 1"><a href="/admin/#/" title="Administração">Administração</a></li>
                                            <li>
                                                <a href="#" title="Logout" v-on:click="logout">
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