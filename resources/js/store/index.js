import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'

Vue.use(Vuex, Axios);

const state={
    /*province.vue*/
    cities:{},
    districts:{},
    categories:{},
    subCategories:{},
    categoryCourses:{},
    courseReviews:{},
    myCourses:{},
    canComment:{},
    sections:{},
    selectedLessonInfo:{},
    selectedSectionInfo:{},
};
const getters={
    selectedLessonSources:state=>{
        if(state.selectedLessonInfo != undefined){
            return state.selectedLessonInfo.sources;
        }
    }
};
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
    /*course*/
    setCategoryCourses(state,index){
        state.categoryCourses=index.data;
    },
    setCourseReviews(state,index){
        state.courseReviews=index.data;
    },
    /*course-progress-card.vue*/
    setMyCourses(state, index){
        state.myCourses=index.data;
    },
    setCanComment(state, index){
        state.canComment=index.data;
    },
    setSubCategory(state,index){
        state.subCategories=index.data.sub_categories;
    },
    setSections(state,index){
        state.sections=index.data.sections;
        console.log(index.data.sections)
    },
    setSelectedLessonInfo(state,lessonIndex){
        state.selectedLessonInfo=state.selectedSectionInfo.lessons[lessonIndex];
    },
    setSelectedSectionInfo(state,sectionIndex){
        state.selectedSectionInfo=state.sections[sectionIndex];
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
        Axios.get(id)
            .then(response =>commit('setCategoryCourses',response))
    },
    loadCourseReviews({commit},id){
        Axios.get('/api/course/'+id+"/comments")
            .then(response =>commit('setCourseReviews',response));
    },
    loadNewPageReviews({commit}, id){
        Axios.get(id)
            .then(response =>commit('setCourseReviews',response));
    },
    loadMyCourses({commit},userId){
        Axios.get('/api/myCourses/'+userId)
            .then(response =>commit('setMyCourses',response));
    },
    loadCanComment({commit},userId,courseId){
        Axios.get('/api/course/'+courseId+'/canComment/'+userId)
            .then(response =>commit('setCanComment',response));
    },
    loadSubCategories({commit},id){
        Axios.get('/api/category/'+id)
            .then(response =>commit('setSubCategory', response.data))
    },
    loadSections({commit},courseId){
        Axios.get('/api/instructor/course/'+courseId+'/sections/get')
            .then(response=>commit('setSections',response.data));
    },
    loadLessons({commit},{courseId,sectionId}){
        Axios.get('/api/instructor/course/'+courseId+'/sections/'+sectionId+'/lesson')
            .then(response=>commit('setSections',response.data));
    },
    loadSelectedLessonInfo({commit},lessonIndex){
        commit('setSelectedLessonInfo',lessonIndex);
    },
    loadSelectedSectionInfo({commit}, sectionIndex){
        commit('setSelectedSectionInfo',sectionIndex);
    },
};

const store=new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});
export default store;
