
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




// Vue data table
Vue.component('pagination', require('laravel-vue-pagination'));


// Vue.component('v-select', vSelect)
import VueSingleSelect from "vue-single-select";
Vue.component('vue-single-select', VueSingleSelect);




// Import moment js for date time
import moment from 'moment';





import DatePick from 'vue-date-pick';
import 'vue-date-pick/dist/vueDatePick.css';
Vue.component('date-pick',DatePick);





//vue content preload
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);





// Ck-editor
import Vue from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );




//toggle button
import { ToggleButton } from 'vue-js-toggle-button';
Vue.component('ToggleButton', ToggleButton);





// Import vue form
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)




// VueTags
import { VueTags } from 'vue-tags-component';
Vue.component('vue-tags', VueTags);

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
// Vue Fire
window.Fire =  new Vue();




//
//window.User = window.Laravel.user;
Vue.component('formindex',require('./components/order-form/FormIndex.vue').default);
Vue.component('formbuilder', require('./components/order-form/FormBuilder.vue').default);
Vue.component('edit-formbuilder', require('./components/order-form/FormBuilderEdit.vue').default);
Vue.component('custom-order', require('./components/order-form/Order.vue').default);
Vue.component('payment', require('./components/order-form/Payment.vue').default);
//order page 
Vue.component('orders', require('./components/orders/Orders.vue').default);
Vue.component('Add', require('./components/orders/AddOrder.vue').default);
Vue.component('Servicedata', require('./components/orders/ServiceData.vue').default);
Vue.component('AllOrder', require('./components/orders/AllOrder.vue').default);
//Invoice page 
Vue.component('invoice', require('./components/invoice/Index.vue').default);
Vue.component('invoiceData', require('./components/invoice/Invocies.vue').default);
//message page
Vue.component('message', require('./components/message/Index.vue').default);
//discount page
Vue.component('discount', require('./components/discount/Index.vue').default);
//client invoice
Vue.component('client-invoice', require('./components/dashboard/invoice/Index.vue').default);
//client 
Vue.component('clients', require('./components/client/Main.vue').default);
Vue.component('clients-show', require('./components/client/Show.vue').default);
Vue.component('client-edit', require('./components/client/Edit.vue').default);
//Service 
Vue.component('services', require('./components/service/Main.vue').default);

const routes = [

  { path: '*', component: require('./components/NotFound.vue').default },
  //order route
  { path: '/orders', component: require('./components/orders/AllOrder.vue').default },
  { path: '/orders/all', component: require('./components/orders/AllOrder.vue').default },
  { path: '/orders/Pending', component: require('./components/orders/Pending.vue').default },
  { path: '/orders/Submitted', component: require('./components/orders/Submitted.vue').default },
  { path: '/orders/Working', component: require('./components/orders/Working.vue').default },
  { path: '/orders/Complete', component: require('./components/orders/Complete.vue').default },
  { path: '/orders/Canceled', component: require('./components/orders/Canceled.vue').default },
  { path: '/orders/order/:order_number', component: require('./components/orders/View.vue').default },
  { path: '/orders/edit/:order_number', component: require('./components/orders/Edit.vue').default },
  //order route
  { path: '/invoices', component: require('./components/invoice/Invocies.vue').default },
  { path: '/invoices/all', component: require('./components/invoice/Invocies.vue').default },
  { path: '/invoices/create', component: require('./components/invoice/Create.vue').default },
  { path: '/invoices/view/:invoice_number', component: require('./components/invoice/View.vue').default },
  { path: '/invoices/paid', component: require('./components/invoice/Paid.vue').default },
  { path: '/invoices/unpaid', component: require('./components/invoice/Unpaid.vue').default },
  { path: '/invoices/refund', component: require('./components/invoice/Refund.vue').default },
  { path: '/invoices/edit/:invoice_number', component: require('./components/invoice/Edit.vue').default },
  //discount route
  { path: '/discount', component: require('./components/discount/Discount.vue').default },
  { path: '/discount/create', component: require('./components/discount/Create.vue').default },
  
  //clients
  { path: '/clients', component: require('./components/client/Index.vue').default },
  { path: '/clients/create', component: require('./components/client/Create.vue').default },
  { path: '/clients/:email', component: require('./components/client/Show.vue').default },
  { path: '/clients/:email/edit', component: require('./components/client/Edit.vue').default },
  //service
  { path: '/services', component: require('./components/service/Index.vue').default },
  { path: '/services/create', component: require('./components/service/Create.vue').default },
  { path: '/services/edit/:slug', component: require('./components/service/Edit.vue').default },
  { path: '/services/variants/:slug', component: require('./components/service/Variants.vue').default },
  { path: '/services/data/:slug', component: require('./components/service/Data.vue').default },
 
  /*
  * Dashboard route
  */
  { path: '/dashboard/invoices/', component: require('./components/dashboard/invoice/Invoice.vue').default },
  { path: '/dashboard/invoices/:invoice_number', component: require('./components/dashboard/invoice/InvoiceView.vue').default },
  
  // { path: '/orders/submitted', component: require('./components/orders/Submitted.vue').default },
  // { path: '/orders/working', component: require('./components/orders/Working.vue').default },
  // { path: '/orders/complete', component: require('./components/orders/Complete.vue').default },
]


const router = new VueRouter({
	mode: "history",
  routes // short for `routes: routes`
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


//load current user and role & permission
import Auth from './auth';
Vue.prototype.$auth = new Auth(window.user);

Vue.filter('dateFormat', function (creted) {
  return moment(creted).format('MMMM Do YYYY');
})

Vue.filter('dateFormat1', function (creted) {
  return moment(creted).format('MMM Do YYYY');
})
Vue.filter('timeFormat', function (creted) {
  return moment(creted).format('hh:mm:A');
})

Vue.filter('dateFormat2', function (creted) {
  return moment(creted).format('M D YYYY');
})

Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})


Vue.filter('month', function () {
  return moment.month();
})


//stripe html tag
Vue.filter('striphtml', function (value) {
  var div = document.createElement("div");
  div.innerHTML = value;
  var text = div.textContent || div.innerText || "";
  return text;
});

// Vue Fire
window.Fire =  new Vue();


const app = new Vue({
    el: '#app',
    router
});
