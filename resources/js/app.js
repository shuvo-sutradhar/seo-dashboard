
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Import vue Router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
window.routes = VueRouter;

// Vue progress bar
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(21, 87, 153)',
  failedColor: 'red',
  height: '4px'
})

// Import vue form
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// Vue sweet alert
import Swal from 'sweetalert2';
window.Swal = Swal;
const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast = toast;

Vue.component('formindex',require('./components/FormIndex.vue').default);
Vue.component('formbuilder', require('./components/FormBuilder.vue').default);
Vue.component('edit-formbuilder', require('./components/FormBuilderEdit.vue').default);
Vue.component('custom-order', require('./components/Order.vue').default);
Vue.component('payment', require('./components/Payment.vue').default);

// const routes = [
//   { path: '/formindex', component: require('./components/FormIndex.vue').default },
//   { path: '/formbuilder', component: require('./components/FormBuilder.vue').default },
// ]


// const router = new VueRouter({
// 	mode: "history",
//   	routes // short for `routes: routes`
// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue Fire
window.Fire =  new Vue();


const app = new Vue({
    el: '#app',
    //router
});
