require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['Authorization'] = localStorage.getItem('access_token');

window.Vue = require('vue');

const home = Vue.component('home', require('./components/adminComponents/homeComponent.vue'));
const users = Vue.component('users', require('./components/adminComponents/usersComponent.vue'));
const eventos = Vue.component('events', require('./components/adminComponents/eventsComponent.vue'));
const eventsCreate = Vue.component('eventsCreate', require('./components/adminComponents/eventsCreateComponent.vue'));
const eventsEdit = Vue.component('eventsEdit', require('./components/adminComponents/eventsEditComponent.vue'));
const eventsDetails = Vue.component('eventsEdit', require('./components/adminComponents/eventsDetailsComponent.vue'));

/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/home' },
	{ path: '/home', component: home },
	{ path: '/users', component: users },
	{ path: '/events', component: eventos},
	{ path: '/events/create', component: eventsCreate},
	{ path: '/events/edit/:id', component: eventsEdit, name: 'eventsEdit', props: { default: true}},
	{ path: '/events/:id', component: eventsDetails, name: 'eventsDetails', props: { default: true}}
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#admin');