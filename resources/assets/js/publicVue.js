require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex'
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';

Vue.use(Vuex)
Vue.use(VueRouter);
Vue.use(BootstrapVue);

// CSS
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

/*****************************************
 COMPONENT TO CHECK IF IS LOGGED OR NOT
 * **************************************/

axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['Authorization'] = localStorage.getItem('access_token');

// FIXED
Vue.component('navbar', require('./components/publicComponents/navbarComponent.vue'));
Vue.component('newsletter', require('./components/publicComponents/contactComponent.vue'));
Vue.component('contact', require('./components/publicComponents/newsletterComponent.vue'));

// MAIN
const home = Vue.component('home', require('./components/publicComponents/homeComponent.vue'));
const aboutUs = Vue.component('aboutUs', require('./components/publicComponents/aboutUsComponent.vue'));
const resources = Vue.component('resources', require('./components/publicComponents/resourcesComponent.vue'));
const activities = Vue.component('activities', require('./components/publicComponents/activitiesComponent.vue'));
const userSettings = Vue.component('userSettings', require('./components/publicComponents/userSettingsComponent.vue'));

// RESOURCES
const alerts = Vue.component('alerts', require('./components/publicComponents/resources/alertsComponent.vue'));
const glossary = Vue.component('glossary', require('./components/publicComponents/resources/glossaryComponent.vue'));
const news = Vue.component('news', require('./components/publicComponents/resources/newsComponent.vue'));
const usefulLinks = Vue.component('usefulLinks', require('./components/publicComponents/resources/usefulLinksComponent.vue'));
const documents = Vue.component('documents', require('./components/publicComponents/resources/documentsComponent.vue'));
const faq = Vue.component('faq', require('./components/publicComponents/resources/faqComponent.vue'));
const newsletters = Vue.component('newsletters', require('./components/publicComponents/resources/newsletterComponent.vue'));

// ACTIVITIES
const events = Vue.component('events', require('./components/publicComponents/activities/eventsComponent.vue'));

// ABOUT US
const contacts = Vue.component('contacts', require('./components/publicComponents/aboutUs/contactsComponent.vue'));

// VUEX
/*const store = new Vuex.Store({
  state: {
    count: 0
  },
  mutations: {
    increment (state) {
      state.count++
    }
  }
});

store.commit('increment')
console.log(store.state.count)*/


/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/home' },
	{ path: '/home', component: home },
	{ path: '/aboutUs', component: aboutUs },
	{ path: '/resources', component: resources },
	{ path: '/activities', component: activities },
	{ path: '/userSettings', component: userSettings },

	// RESOURCES
	{ path: '/resources/alerts', component: alerts },
	{ path: '/resources/glossary', component: glossary },
	{ path: '/resources/news', component: news },
	{ path: '/resources/usefulLinks', component: usefulLinks },
	{ path: '/resources/documents', component: documents },
	{ path: '/resources/faq', component: faq },
	{ path: '/resources/newsletters', component: newsletters },

	//ACTIVITIES
	{ path: '/activities/events', component: events },

	//ABOUT US
	{ path: '/aboutUs/contacts', component: contacts },
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#app');