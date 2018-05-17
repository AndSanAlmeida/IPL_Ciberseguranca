require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['Authorization'] = localStorage.getItem('access_token');

window.Vue = require('vue');

const home = Vue.component('home', require('./components/adminComponents/homeComponent.vue'));
const users = Vue.component('users', require('./components/adminComponents/usersComponents/usersComponent.vue'));

const eventos = Vue.component('events', require('./components/adminComponents/eventsComponents/eventsComponent.vue'));
const eventsCreate = Vue.component('eventsCreate', require('./components/adminComponents/eventsComponents/eventsCreateComponent.vue'));
const eventsEdit = Vue.component('eventsEdit', require('./components/adminComponents/eventsComponents/eventsEditComponent.vue'));
const eventsDetails = Vue.component('eventsEdit', require('./components/adminComponents/eventsComponents/eventsDetailsComponent.vue'));

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

const faqs = Vue.component('faqs', require('./components/adminComponents/faqsComponents/faqsComponent.vue'));
const userQuestions = Vue.component('userQuestions', require('./components/adminComponents/userQuestionsComponents/userQuestionsComponent.vue'));
const userNotAnsweredQuestionsListComponent = Vue.component('userNotAnsweredQuestionsListComponent', require('./components/adminComponents/userQuestionsComponents/userNotAnsweredQuestionsListComponent.vue'));
const userAllQuestionsComponent = Vue.component('userAllQuestionsComponent', require('./components/adminComponents/userQuestionsComponents/userAllQuestionsComponent.vue'));
const userAllQuestionsListComponent = Vue.component('userAllQuestionsListComponent', require('./components/adminComponents/userQuestionsComponents/userAllQuestionsListComponent.vue'));
const userQuestionDetailsComponent = Vue.component('userAllQuestionsListComponent', require('./components/adminComponents/userQuestionsComponents/userQuestionDetailsComponent.vue'));

const newsComponent = Vue.component('newsComponent', require('./components/adminComponents/newsComponents/newsComponent.vue'));


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
	{ path: '/faqs', component: faqs},
	{ path: '/userQuestions', component: userQuestions},
	{ path: '/userQuestions/notAnswered', component: userNotAnsweredQuestionsListComponent},
	{ path: '/userQuestions/all', component: userAllQuestionsComponent},
	{ path: '/news', component: newsComponent},

];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router
}).$mount('#admin');