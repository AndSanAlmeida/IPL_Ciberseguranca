require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

window.Vue = require('vue');

Vue.component('navbar', require('./components/templateComponents/navbarComponent.vue'));
const login = Vue.component('login', require('./components/loginComponents/loginComponent.vue'));
const home = Vue.component('home', require('./components/templateComponents/homeComponent.vue'));
const recoverPassword = Vue.component('recoverPassword', require('./components/loginComponents/recoverPassword.vue'));

/*ROUTES*/
const routes = [
{
	path:'/',
	component:require('./components/templateComponents/homeComponent')
},
{
	path:'/login',
	component:require('./components/loginComponents/loginComponent')
},
{
	path:'/register',
	component:require('./components/loginComponents/registerComponent')
}
];

const router = new VueRouter({
    routes:routes
});

new Vue({
    router
}).$mount('#appVue');

