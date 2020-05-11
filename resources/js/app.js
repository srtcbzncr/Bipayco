/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import store from './store/index.js';

window.Vue = require('vue');

/*require('./bootstrap');*/



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('course-card', require('./components/course-card.vue').default);
Vue.component('cart-page', require('./components/auth/cart-page.vue').default);
Vue.component('guardian-add-student', require('./components/auth/guardian-add-student.vue').default);
Vue.component('homepage-content', require('./components/homepage-content.vue').default);
Vue.component('stars-rating', require('./components/stars-rating.vue').default);
Vue.component('category-select', require('./components/instructor/category-select.vue').default);
Vue.component('cr-lesson-select', require('./components/instructor/cr-lesson-select.vue').default);
Vue.component('lesson-type-select', require('./components/instructor/lesson-type-select.vue').default);
Vue.component('instructor-area', require('./components/instructor/instructors-area.vue').default);
Vue.component('add-list', require('./components/instructor/add-list.vue').default);
Vue.component('add-section', require('./components/instructor/add-section.vue').default);
Vue.component('add-lesson', require('./components/instructor/add-lesson.vue').default);
Vue.component('add-question', require('./components/instructor/add-question.vue').default);
Vue.component('question-source-list', require('./components/instructor/question-source-list.vue').default);
Vue.component('section-settings', require('./components/instructor/section-settings.vue').default);
Vue.component('lesson-settings', require('./components/instructor/lesson-settings.vue').default);
Vue.component('instructor-courses-card', require('./components/instructor/instructor-courses-card.vue').default);
Vue.component('provinces', require('./components/auth/province.vue').default);
Vue.component('course-progress-card', require('./components/auth/course-progress-card.vue').default);
Vue.component('notification-card', require('./components/top-bar/notification-card.vue').default);
Vue.component('your-courses', require('./components/top-bar/your-courses.vue').default);
Vue.component('search', require('./components/top-bar/search.vue').default);
Vue.component('messages-small-card', require('./components/top-bar/messages-small-card.vue').default);
Vue.component('user-profile-dropdown-nav', require('./components/top-bar/user-profile-dropdown-nav.vue').default);
Vue.component('side-bar', require('./components/side-bar/side-bar.vue').default);
Vue.component('registered-profile', require('./components/admin/registered-profile.vue').default);
Vue.component('comment', require('./components/admin/comment.vue').default);
Vue.component('categories-page', require('./components/admin/categories-page.vue').default);
Vue.component('exams-page', require('./components/admin/exams-page.vue').default);
Vue.component('sub-categories-page', require('./components/admin/sub-categories-page.vue').default);
Vue.component('cities-page', require('./components/admin/cities-page.vue').default);
Vue.component('districts-page', require('./components/admin/districts-page.vue').default);
Vue.component('lesson-page', require('./components/admin/lessons-page.vue').default);
Vue.component('grade-page', require('./components/admin/grades-page.vue').default);
Vue.component('subject-page', require('./components/admin/subjects-page.vue').default);
Vue.component('course-card-pagination', require('./components/category/course-card-pagination.vue').default);
Vue.component('lesson-pagination', require('./components/category/lesson-pagination.vue').default);
Vue.component('course-review', require('./components/category/course-review.vue').default);
Vue.component('course-previews', require('./components/category/course-previews.vue').default);
Vue.component('review', require('./components/category/review.vue').default);
Vue.component('add-cart-button', require('./components/category/add-cart-button.vue').default);
Vue.component('similar-course-card', require('./components/category/similar-course-card.vue').default);
Vue.component('category-card', require('./components/category/category-card.vue').default);
Vue.component('watch', require('./components/watch/watch-main.vue').default);
Vue.component('question-answer-area', require('./components/watch/question-answer-area.vue').default);

/*<option value='' disabled selected hidden>@lang('front/auth.district')</option>*/
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app1',
    store,
});
