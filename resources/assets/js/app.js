
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import { 
    Form,
    HasError,
    AlertError,
    AlertErrors, 
    AlertSuccess
  } from 'vform';

// Components
import Dashboard from './components/Dashboard.vue';
import Roles from './components/UserManagement/Role.vue';
import Users from './components/UserManagement/Users.vue';
import Expenses from './components/ExpenseManagement/Expenses.vue';
import Categories from './components/ExpenseManagement/Categories.vue';
import Header from './components/Header.vue';
import VueApexCharts from 'vue-apexcharts'
import ChangePassword from './components/ChangePassword.vue';

import moment from 'moment';
window.Form = Form;



Vue.use(VueRouter);
Vue.use(VueApexCharts)

let routes = [
    { 
        path : '/home', component: Dashboard, 
    },
    { 
        path : '/roles', component: Roles, 
    },
    { 
        path : '/users', component: Users, 
    },
    { 
        path : '/expenses', component: Expenses, 
    },
    { 
        path : '/categories', component: Categories, 
    },
    { 
        path : '/changepassword', component: ChangePassword, 
    },

];

const router = new VueRouter({
    mode: 'history',
    routes
});
Vue.component('new-header', Header);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)
Vue.component('apexchart', VueApexCharts)


Vue.filter('formatDate', function(value) {
    if (value) {
      return moment(String(value)).format('YYYY-MM-DD')
    }
  });
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    router
});
