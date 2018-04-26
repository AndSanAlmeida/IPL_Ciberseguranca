require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
 
Vue.use(BootstrapVue);
Vue.use(VueRouter);

// CSS
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

Vue.component('navbar', require('./components/publicComponents/navbarComponent.vue'));
const home = Vue.component('home', require('./components/publicComponents/homeComponent.vue'));
const aboutUs = Vue.component('aboutUs', require('./components/publicComponents/aboutUsComponent.vue'));
const resources = Vue.component('resources', require('./components/publicComponents/resourcesComponent.vue'));
const forum = Vue.component('forum', require('./components/publicComponents/forumComponent.vue'));
const activities = Vue.component('activities', require('./components/publicComponents/activitiesComponent.vue'));

/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/home' },
	{ path: '/home', component: home },
	{ path: '/aboutUs', component: aboutUs },
	{ path: '/resources', component: resources },
	{ path: '/forum', component: forum },
	{ path: '/activities', component: activities }
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#app');