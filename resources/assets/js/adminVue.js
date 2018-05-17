require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';

Vue.use(VueRouter);
Vue.use(BootstrapVue);
axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['Authorization'] = localStorage.getItem('access_token');

// CSS
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

const home = Vue.component('home', require('./components/adminComponents/homeComponent.vue'));
const users = Vue.component('users', require('./components/adminComponents/usersComponent.vue'));
const eventos = Vue.component('events', require('./components/adminComponents/eventsComponent.vue'));
const eventsCreate = Vue.component('eventsCreate', require('./components/adminComponents/eventsCreateComponent.vue'));
const eventsEdit = Vue.component('eventsEdit', require('./components/adminComponents/eventsEditComponent.vue'));
const eventsDetails = Vue.component('eventsEdit', require('./components/adminComponents/eventsDetailsComponent.vue'));

const glossary = Vue.component('events', require('./components/adminComponents/glossaryComponents/glossaryComponent.vue'));
const glossaryCreate = Vue.component('events', require('./components/adminComponents/glossaryComponents/glossaryCreateComponent.vue'));
const glossaryEdit = Vue.component('events', require('./components/adminComponents/glossaryComponents/glossaryEditComponent.vue'));
const glossaryDetails = Vue.component('events', require('./components/adminComponents/glossaryComponents/glossaryDetailsComponent.vue'));

const settings = Vue.component('settings', require('./components/adminComponents/settingsComponents/settingsComponent.vue'));
const platformEmail = Vue.component('platformEmail', require('./components/adminComponents/settingsComponents/platformEmailComponent.vue'));
const aboutUs = Vue.component('aboutUs', require('./components/adminComponents/settingsComponents/aboutUsComponent.vue'));
const activities = Vue.component('activities', require('./components/adminComponents/settingsComponents/activitiesComponent.vue'));
const resources = Vue.component('resources', require('./components/adminComponents/settingsComponents/resourcesComponent.vue'));

const usefulLinks = Vue.component('settings', require('./components/adminComponents/usefulLinksComponents/usefulLinksComponent.vue'));
const usefulLinksCreate = Vue.component('events', require('./components/adminComponents/usefulLinksComponents/usefulLinksCreateComponent.vue'));
const usefulLinksEdit = Vue.component('events', require('./components/adminComponents/usefulLinksComponents/usefulLinksEditComponent.vue'));

const documents = Vue.component('settings', require('./components/adminComponents/documentsComponents/documentsComponent.vue'));
const documentsCreate = Vue.component('events', require('./components/adminComponents/documentsComponents/documentsCreateComponent.vue'));
const documentsEdit = Vue.component('events', require('./components/adminComponents/documentsComponents/documentsEditComponent.vue'));

/*ROUTES*/
const routes = [
	{ path: '/', redirect: '/home' },
	{ path: '/home', component: home },
	{ path: '/users', component: users },
	{ path: '/events', component: eventos},
	{ path: '/events/create', component: eventsCreate},
	{ path: '/events/edit/:id', component: eventsEdit, name: 'eventsEdit', props: { default: true}},
	{ path: '/events/:id', component: eventsDetails, name: 'eventsDetails', props: { default: true}},
	{ path: '/glossary', component: glossary},
	{ path: '/glossary/create', component: glossaryCreate},
	{ path: '/glossary/edit/:id', component: glossaryEdit, name: 'glossaryEdit', props: { default: true}},
	{ path: '/glossary/:id', component: glossaryDetails, name: 'glossaryDetails', props: { default: true}},
	{ path: '/settings', component: settings},
	{ path: '/settings/platformEmail', component: platformEmail},
	{ path: '/settings/aboutUs', component: aboutUs},
	{ path: '/settings/resources', component: resources},
	{ path: '/settings/activities', component: activities},
	{ path: '/usefulLinks', component: usefulLinks},
	{ path: '/usefulLinks/create', component: usefulLinksCreate},
	{ path: '/usefulLinks/edit/:id', component: usefulLinksEdit, name: 'usefulLinksEdit', props: { default: true}},
	{ path: '/documents', component: documents},
	{ path: '/documents/create', component: documentsCreate},
	{ path: '/documents/edit/:id', component: documentsEdit, name: 'documentsEdit', props: { default: true}},
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#admin');