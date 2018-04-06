require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

window.Vue = require('vue');

const login = Vue.component('login', require('./components/loginComponents/loginComponent.vue'));
const register = Vue.component('register', require('./components/loginComponents/registerComponent.vue'));
const recoverPassword = Vue.component('recoverPassword', require('./components/loginComponents/recoverPassword.vue'));

/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/login' },
	{ path: '/login', component: login },
	{ path: '/register', component: register },
	{ path: '/recoverPassword', component: recoverPassword },
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#auth');

