require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

window.Vue = require('vue');

const home = Vue.component('login', require('./components/adminComponents/home.vue'));

/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/home' },
	{ path: '/home', component: home },
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#admin');