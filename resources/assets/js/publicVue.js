require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
 
Vue.use(BootstrapVue);
axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['Authorization'] = localStorage.getItem('access_token');
Vue.use(VueRouter);

// CSS
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

// FIXED
Vue.component('navbar', require('./components/publicComponents/navbarComponent.vue'));
Vue.component('resourcesNav', require('./components/publicComponents/resources/resourcesNavComponent.vue'));
Vue.component('activitiesNav', require('./components/publicComponents/activities/activitiesNavComponent.vue'));
Vue.component('aboutUsNav', require('./components/publicComponents/aboutUs/aboutUsNavComponent.vue'));
Vue.component('newsletter', require('./components/publicComponents/contactComponent.vue'));
Vue.component('contact', require('./components/publicComponents/newsletterComponent.vue'));

// MAIN
const home = Vue.component('home', require('./components/publicComponents/homeComponent.vue'));
const aboutUs = Vue.component('aboutUs', require('./components/publicComponents/aboutUsComponent.vue'));
const resources = Vue.component('resources', require('./components/publicComponents/resourcesComponent.vue'));
const activities = Vue.component('activities', require('./components/publicComponents/activitiesComponent.vue'));

// RESOURCES
const alerts = Vue.component('alerts', require('./components/publicComponents/resources/alertsComponent.vue'));
const glossary = Vue.component('glossary', require('./components/publicComponents/resources/glossaryComponent.vue'));
const news = Vue.component('news', require('./components/publicComponents/resources/newsComponent.vue'));
const usefulLinks = Vue.component('usefulLinks', require('./components/publicComponents/resources/usefulLinksComponent.vue'));
const documents = Vue.component('documents', require('./components/publicComponents/resources/documentsComponent.vue'));
const faq = Vue.component('faq', require('./components/publicComponents/resources/faqComponent.vue'));

// ACTIVITIES

// ABOUT US


/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/home' },
	{ path: '/home', component: home },
	{ path: '/aboutUs', component: aboutUs },
	{ path: '/resources', component: resources },
	{ path: '/activities', component: activities },

	// RESOURCES
	{ path: '/resources/alerts', component: alerts },
	{ path: '/resources/glossary', component: glossary },
	{ path: '/resources/news', component: news },
	{ path: '/resources/usefulLinks', component: usefulLinks },
	{ path: '/resources/documents', component: documents },
	{ path: '/resources/faq', component: faq },
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#app');