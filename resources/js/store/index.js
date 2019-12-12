import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'

Vue.use(Vuex, Axios);

const state={
    cities:{},
    districts:{},
};
const getters={};
const mutations={
   setCities(state, index){
        state.cities=index.data;
    },
    setDistricts(state, index){
       state.districts=index.data;
    }
};
const actions={
    loadCities({commit}){
       Axios.get('api/city/index')
           .then(response =>commit('setCities',response.data))
    },
    loadDistricts({commit},id){
        id=document.getElementById("city").value;
        Axios.get('api/city/'+id+'/districts')
            .then(response =>commit('setDistricts', response.data))
    }
};

const store=new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});
export default store;
