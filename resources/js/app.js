/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
/*require('./bootstrap');*/

window.Vue = require('vue');
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
Vue.component('top-bar', require('./components/top-bar/top-bar.vue').default);
Vue.component('side-bar', require('./components/side-bar/side-bar.vue').default);
Vue.component('provinces', {
    data:
        function () {
        return {
            items: [],
            selected:'',
        }
    },
    computed:{
      placeHolder: function () {
        return this.selected;
      },
    },
    template:"<select class='uk-select' v-model='selected' required><option v-for='item in items' :value='item.value'>{{item.label}} </option> </select>",
});
Vue.component('districts', {
    data:function () {
            return {
                items: [{
                    label: 'naber',
                    value: 1
                }, {
                    label: 'nasılsın',
                    value: 2
                }],
                selected:'',
            }
        },
    methods:{

    },
    template:"<select class='uk-select' name='district_id' v-model='selected' required><option v-for='item in items' :value='item.value'>{{item.label}} </option> </select>",
});
/*<option value='' disabled selected hidden>@lang('front/auth.district')</option>*/
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app1',
});
