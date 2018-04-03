<template>


<nav class="navbar">
        <!-- Search Box-->
        <div class="container-fluid">
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
                                <router-link to="/" class="navbar-brand">Oficina Cibersegurança</router-link>
                            </div>
                            <div class="navbar-collapse collapse">
                                <nav>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><router-link to="/" class="page-scroll">Home</router-link></li>
                                        <li><router-link to="/" class="page-scroll">Posts</router-link></li>
                                        <li><router-link to="/" class="page-scroll">Eventos</router-link></li>
                                        <li><router-link to="/" class="page-scroll">Forum</router-link></li>
                                        <li><router-link to="/login" class="page-scroll">Login</router-link></li>
                                        <li><router-link to="/register" class="page-scroll">Registo</router-link></li>
                                    </ul>
                                </nav>
                            </div>
                        </div><!--- END COL -->
                    </div><!--- END COL -->
                </div><!--- END CONTAINER -->
            </div>
        </div>
    </nav>
</template>
<script type="text/javascript">
export default {

}
</script>
<style type="text/css">

</style>