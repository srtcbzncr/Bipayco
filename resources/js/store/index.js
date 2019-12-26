import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'

Vue.use(Vuex, Axios);

const state={
    /*province.vue*/
    cities:{},
    districts:{},
    categories:{},
    categoryCourses:{}
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
    loadNewPageCourses({commit}, id){
        var sort = document.getElementById("sortBy").value;
        Axios.get(id)
            .then(response =>commit('setCategoryCourses',response))
    },
};

const store=new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});
export default store;
