require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

window.Vue = require('vue');

Vue.component('navbar', require('./components/publicComponents/navbarComponent.vue'));
const home = Vue.component('home', require('./components/publicComponents/homeComponent.vue'));

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
}).$mount('#app');

