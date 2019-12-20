/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import store from './store/index.js'

window.Vue = require('vue');

/*require('./bootstrap');*/



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('course-card', require('./components/course-card.vue').default);
Vue.component('provinces', require('./components/auth/province.vue').default);
Vue.component('user-status', require('./components/auth/user-status.vue').default);
Vue.component('statu', require('./components/auth/statu.vue').default);
Vue.component('notification-card', require('./components/top-bar/notification-card.vue').default);
Vue.component('top-bar', require('./components/top-bar/top-bar.vue').default);
Vue.component('messages-small-card', require('./components/top-bar/messages-small-card.vue').default);
Vue.component('user-profile-dropdown', require('./components/top-bar/user-profile-dropdown-nav.vue').default);
Vue.component('your-course-card', require('./components/top-bar/your-course-card.vue').default);
Vue.component('accordion-menu-title', require('./components/side-bar/accordion-menu-title.vue').default);
Vue.component('side-bar', require('./components/side-bar/side-bar.vue').default);
Vue.component('app-footer', require('./components/footer/footer.vue').default);
Vue.component('registered-profile', require('./components/admin/registered-profile.vue').default);
Vue.component('comment', require('./components/admin/comment.vue').default);

/*<option value='' disabled selected hidden>@lang('front/auth.district')</option>*/
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app1',
    store
});
