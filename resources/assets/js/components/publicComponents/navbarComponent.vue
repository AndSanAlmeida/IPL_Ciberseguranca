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
                        <router-link to="/" class="navbar-brand">IPL-Cibersegurança</router-link>
                    </div>
                    <div class="navbar-collapse collapse">
                        <nav>
                            <ul class="nav navbar-nav navbar-right">
                                <li><router-link to="/home" class="page-scroll" title="Home">Home</router-link></li>
                                <li><router-link to="/resources" class="page-scroll" title="Recursos">Recursos</router-link></li>
                                <li><router-link to="/forum" class="page-scroll" title="Fórum">Fórum</router-link></li>
                                <li><router-link to="/activities" class="page-scroll" title="Actividades">Actividades</router-link></li>
                                <li><router-link to="/aboutUs" class="page-scroll" title="Sobre Nós">Sobre Nós</router-link></li>
                                <li><a href="/auth/" v-if="!logged" class="page-scroll">Login</a></li>
                                <li><a href="/auth/#/register" v-if="!logged" class="page-scroll">Registar</a></li>
                                <li><a href="/" v-if="logged" class="page-scroll">{{user.username}}</a></li>
                                <li><a v-on:click="logout" v-if="logged" class="page-scroll">Logout</a></li>
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