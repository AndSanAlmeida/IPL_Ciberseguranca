require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

window.Vue = require('vue');

const login = Vue.component('login', require('./components/loginComponents/loginComponent.vue'));
const register = Vue.component('register', require('./components/loginComponents/registerComponent.vue'));

/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/login' },
	{ path: '/login', component: login },
	{ path: '/register', component: register },
	{ path: '/password/reset', component: require('./components/loginComponents/recoverPasswordComponent.vue') },
	{ path: '/password/reset/:token', component: require('./components/loginComponents/newPasswordComponent.vue'), props: true }
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#auth');