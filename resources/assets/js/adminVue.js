require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';

Vue.use(VueRouter);
Vue.use(BootstrapVue);

// CSS
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['Authorization'] = localStorage.getItem('access_token');

//FIXED
const platformEmail = Vue.component('platformEmail', require('./components/adminComponents/settingsComponents/platformEmailComponent.vue'));
const resources = Vue.component('resources', require('./components/adminComponents/settingsComponents/resourcesComponent.vue'));
const activities = Vue.component('activities', require('./components/adminComponents/settingsComponents/activitiesComponent.vue'));
const aboutUs = Vue.component('aboutUs', require('./components/adminComponents/settingsComponents/aboutUsComponent.vue'));
const ourMission = Vue.component('ourMission', require('./components/adminComponents/settingsComponents/ourMissionComponent.vue'));
const imageHome = Vue.component('imageHome', require('./components/adminComponents/settingsComponents/imageHomeComponent.vue'));

Vue.component('admin-layout', require('./components/adminComponents/layoutComponent.vue'));
const home = Vue.component('home', require('./components/adminComponents/homeComponent.vue'));
const users = Vue.component('users', require('./components/adminComponents/usersComponents/usersComponent.vue'));
const eventos = Vue.component('events', require('./components/adminComponents/eventsComponents/eventsComponent.vue'));
const eventsCreate = Vue.component('eventsCreate', require('./components/adminComponents/eventsComponents/eventsCreateComponent.vue'));
const eventsEdit = Vue.component('eventsEdit', require('./components/adminComponents/eventsComponents/eventsEditComponent.vue'));
const eventsDetails = Vue.component('eventsEdit', require('./components/adminComponents/eventsComponents/eventsDetailsComponent.vue'));
const glossary = Vue.component('events', require('./components/adminComponents/glossaryComponents/glossaryComponent.vue'));
const settings = Vue.component('settings', require('./components/adminComponents/settingsComponents/settingsComponent.vue'));
const usefulLinks = Vue.component('settings', require('./components/adminComponents/usefulLinksComponents/usefulLinksComponent.vue'));
const documents = Vue.component('settings', require('./components/adminComponents/documentsComponents/documentsComponent.vue'));
const faqs = Vue.component('faqs', require('./components/adminComponents/faqsComponents/faqsComponent.vue'));
const userQuestions = Vue.component('userQuestions', require('./components/adminComponents/userQuestionsComponents/userQuestionsComponent.vue'));
const userAllQuestionsComponent = Vue.component('userAllQuestionsComponent', require('./components/adminComponents/userQuestionsComponents/userAllQuestionsComponent.vue'));
const newsComponent = Vue.component('newsComponent', require('./components/adminComponents/newsComponents/newsComponent.vue'));
const rssNews = Vue.component('rssNews', require('./components/adminComponents/rssNewsComponents/rssNewsComponent.vue'));
const newslettersComponent = Vue.component('newslettersComponent', require('./components/adminComponents/newslettersComponents/newslettersComponent.vue'));
const alertsComponent = Vue.component('alertsComponent', require('./components/adminComponents/alertsComponents/alertComponent.vue'));
const rssAlerts = Vue.component('rssAlerts', require('./components/adminComponents/rssAlertsComponents/rssAlertsComponent.vue'));

/*ROUTES*/
const routes = [
	
	//{ path: '/',  },
	{
	    path: '/',
	    redirect: '/home',
	    component: {
          template: '<router-view></router-view>',
      	},
      	beforeEnter: (to, from, next) => {
      		if (localStorage.getItem('access_token')) {
      			axios.get('/api/user')
			    .then(response => {
			    	if (response.status != 401 ) 
			    		next();
			    	else 
			    		window.location = '/';
			    })
			    .catch(error => {
				    window.location = '/';
				});
      		} else {
      			window.location = '/';
      		}
			
		}, 
	    children: [
	    	{ path: 'home', component: home },
			{ path: 'users', component: users },
			{ path: 'events', component: eventos },
			{ path: 'events/create', component: eventsCreate },
			{ path: 'events/edit/:id', component: eventsEdit, name: 'eventsEdit', props: { default: true} },
			{ path: 'events/:id', component: eventsDetails, name: 'eventsDetails', props: { default: true} },
			{ path: 'glossary', component: glossary },
			{ path: 'settings', component: settings },
			{ path: 'usefulLinks', component: usefulLinks },
			{ path: 'documents', component: documents },
			{ path: 'faqs', component: faqs },
			{ path: 'userQuestions', component: userQuestions },
			{ path: 'userQuestions/all', component: userAllQuestionsComponent },
			{ path: 'news', component: newsComponent },
			{ path: 'newsletters', component: newslettersComponent },
			{ path: 'rssNews', component: rssNews },
			{ path: 'alerts', component: alertsComponent },
			{ path: 'rssAlerts', component: rssAlerts },
	    ],
	},
];

const router = new VueRouter({
    routes: routes
});

new Vue({
    router,
    data: function () {
        return {
        	numberOfQuestions: 0,
        }
    },
    methods: {
    	
    },
    created: function() {

    },
    
}).$mount('#admin');

