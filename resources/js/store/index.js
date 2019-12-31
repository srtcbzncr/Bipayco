import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'

Vue.use(Vuex, Axios);

const state={
    /*province.vue*/
    cities:{},
    districts:{},
    categories:{},
    categoryCourses:{},
    courseReviews:{},
};
const getters={};
const mutations={
    /*province.vue*/
   setCities(state, index){
        state.cities=index.data;
    },
    setDistricts(state, index){
       state.districts=index.data;
    },
    setCategories(state,index){
      state.categories=index.data;
    },
    setCategoryCourses(state,index){
       state.categoryCourses=index.data;
    },
    setCourseReviews(state,index){
       state.courseReviews=index.data;
    }
};
const actions={
    /*province.vue*/
    loadCities({commit}){
       Axios.get('/api/city/index')
           .then(response =>commit('setCities',response.data))
    },
    loadDistricts({commit}){
        var id=document.getElementById("city").value;
        Axios.get('/api/city/'+id+'/districts')
            .then(response =>commit('setDistricts', response.data))
    },
    loadCategories({commit}){
        Axios.get('/api/category/index')
            .then(response =>commit('setCategories',response.data))
    },
    loadCategoryCourses({commit}, id){
        var sort = document.getElementById("sortBy").value;
        Axios.get('/api/course/'+sort+'/'+id)
            .then(response =>commit('setCategoryCourses',response))
    },
    loadNewPage({commit}, id){
        Axios.get(id)
            .then(response =>commit('setCategoryCourses',response.data))
    },
    loadCourseReviews({commit},id){
        Axios.get('/api/course/'+id+"/comments")
            .then(response =>commit('setCourseReviews',response.data));
    },
    loadNewPageReviews({commit}, id){
        Axios.get(id)
            .then(response =>commit('setCourseReviews',response.data));
    },
};

const store=new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});
export default store;
