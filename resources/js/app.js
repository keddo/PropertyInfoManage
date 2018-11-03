
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import {Form, HasError, AlertError} from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import swal from 'sweetalert2';


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.use(VueRouter);

let routes = [
    {path: '/dashboard', component: require( './components/Dashboard.vue')},
    {path: '/users', component: require( './components/User.vue')},
    {path: '/materials', component: require( './components/Material.vue')},
    {path: '/profile', component: require('./components/Profile.vue')},
    {path: '/developers', component: require('./components/Developer.vue')},
]

const router = new VueRouter({
    mode: 'history',
    routes
});

Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY');
})


Vue.use(VueProgressBar, {
     color: 'rgb(244, 115, 17)',
     failedColor: 'red',
     height: '2px'
 })

window.Fire = new Vue();

window.swal = swal;
const toast = swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 3000
 })

window.toast = toast;

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router
});
