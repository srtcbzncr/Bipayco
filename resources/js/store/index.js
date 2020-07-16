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
    sections:[{
        lessons:[{
            name:"",
            sources:[]
        }],
        name:"",
    }],
    selectedLessonIndex:0,
    selectedSectionIndex:0,
    learnCourse:{
        sections:[{
            name:"",
            lessons:[{
                name:"",
                file_path:"",
                preview:0,
                sources:[{
                    name:""
                }],
            }]
        }]
    },
    courseSources:[{
        name:"",
    }],
    lessonDiscussion:{
        questions:[[{
            question:{
                title: "",
                content: "",
                created_at:"" ,
            },
            user: {
                first_name:"",
                last_name:"",
                avatar:"",
                username:"",
            },
            answers: [],
        }]]
    },
    plLessonType:{},
    previewLessons:{
        prepareLessons:{}
    },
    courseSubjects:[],
    questionSource:{},
    shoppingCart:{},
    courseCard:{},
    urlForCourseCard:"",
    isInCart:"",
    adminCity:{},
    adminDistrict:{},
    adminLesson:{},
    adminSubject:{},
    adminGrade:{},
    adminExam:{},
    adminAdmins:{},
    adminInstructor:{},
    adminGuardian:{},
    adminUsers:{},
    adminSales:{},
    adminPromotionPayments:{},
    adminPromotionPurchaseDetail:{},
    adminCategory:{},
    adminSubCategory:{},
    crLessons:{},
    crExams:{},
    selectedSubjectId:"",
    selectedLessonId:"",
    guardianStudents:{},
    guardianStudentList:{},
    questionAnswerData:[],
    loadingStatus:false,
    purchaseHistory:{},
    adminCourses:{},
    adminCourseDetail:{},
    adminCourseStudent:{},
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
    /*course*/
    setCategoryCourses(state,index){
        state.categoryCourses=index.data.data;
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
    },
    setSelectedLessonIndex(state,lessonIndex){
        state.selectedLessonIndex=lessonIndex;
    },
    setSelectedSectionIndex(state,sectionIndex){
        state.selectedSectionIndex=sectionIndex;
    },
    setLearnCourse(state,course){
        state.learnCourse=course.data;
    },
    setCourseSources(state,sources){
        state.courseSources=sources.data;
    },
    setLessonDiscussion(state, messages){
        state.lessonDiscussion=messages.data;
    },
    setPlLessonType(state,response){
        state.plLessonType=response.data;
    },
    setPreviewLessons(state,response){
        state.previewLessons=response.previewLessons;
    },
    setCourseSubjects(state,subject){
        state.courseSubjects=subject.data;
    },
    setQuestionSource(state,question){
        state.questionSource=question.data;
    },
    setShoppingCart(state,item){
        state.shoppingCart=item.data;
        state.loadingStatus=true;

    },
    setCourseCard(state,course){
        state.courseCard=course.data;
        state.loadingStatus=true;
    },
    setUrlForCourseCard(state, url){
        state.urlForCourseCard=url;
    },
    setIsInCart(state, bool){
        state.isInCart=bool.inBasket;
    },
    setAdminCity(state, city){
        state.adminCity=city.data;
        state.loadingStatus=true;
    },
    setAdminDistrict(state, district){
        state.adminDistrict=district.data;
        state.loadingStatus=true;
    },
    setAdminLesson(state, lesson){
        state.adminLesson=lesson.data;
        state.loadingStatus=true;
    },
    setAdminSubject(state, subject){
        state.adminSubject=subject.data;
        state.loadingStatus=true;
    },
    setAdminGrade(state, grade){
        state.adminGrade=grade.data;
        state.loadingStatus=true;
    },
    setAdminAdmins(state, admins){
        state.adminAdmins=admins.data;
        state.loadingStatus=true;
    },
    setAdminInstructor(state, instructors){
        state.adminInstructor=instructors.data;
        state.loadingStatus=true;
    },
    setAdminUsers(state, users){
        state.adminUsers=users.data;
        state.loadingStatus=true;
    },
    setAdminSales(state, sales){
        state.adminSales=sales.data;
        state.loadingStatus=true;
    },
    setAdminCourses(state, course){
        state.adminCourses=course.data;
        state.loadingStatus=true;
    },
    setAdminCourseStudent(state, student){
        state.adminCourseStudent=student.data;
        state.loadingStatus=true;
    },
    setAdminPromotionPayments(state, payment){
        state.adminPromotionPayments=payment.data;
        state.loadingStatus=true;
    },
    setAdminPromotionPurchaseDetail(state, payment){
        state.adminPromotionPurchaseDetail=payment.data;
        state.loadingStatus=true;
    },
    setAdminGuardian(state, guardians){
        state.adminGuardian=guardians.data;
        state.loadingStatus=true;
    },
    setAdminExam(state, exam){
        state.adminExam=exam.data;
        state.loadingStatus=true;
    },
    setAdminCategory(state, category){
        state.adminCategory=category.data;
        state.loadingStatus=true;
    },
    setAdminSubCategory(state, subCategory){
        state.adminSubCategory=subCategory.data;
        state.loadingStatus=true;
    },
    setCrLessons(state, lessons){
        state.crLessons=lessons.data;
    },
    setCrExams(state, exams){
        state.crExams=exams.data;
    },
    setSelectedLessonId(state, lesson){
        state.selectedLessonId=lesson;
    },
    setSelectedSubjectId(state, subject){
        state.selectedSubjectId=subject;
    },
    setGuardianStudents(state, students){
        state.guardianStudents=students.data;
    },
    setGuardianStudentList(state, students){
        state.guardianStudentList=students.data;
    },
    setPurchaseHistory(state, purchases){
        state.purchaseHistory=purchases.data;
        state.loadingStatus=true;
    },
    setQuestionAnswerData(state, data){
        state.questionAnswerData=data.data;
    },
    setLoadingStatus(state, data){
        state.loadingStatus=data;
    },
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
    loadCategoryCourses({commit}, [sort, categoryId, userId]){
        if(userId!=''){
            Axios.get('/api/course/'+sort+'/'+categoryId+'/'+userId)
                .then(response =>commit('setCategoryCourses',response))
        }else{
            Axios.get('/api/course/'+sort+'/'+categoryId)
                .then(response =>commit('setCategoryCourses',response))
        }
    },
    loadNewPageCourses({commit}, id){
        Axios.get(id)
            .then(response =>commit('setCategoryCourses',response))
    },
    loadCourseReviews({commit},[module, id]){
        Axios.get('/api/comment/'+module+'/'+id+"/comments")
            .then(response =>commit('setCourseReviews',response.data));
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
    loadSections({commit},[moduleName, courseId]){
        Axios.get('/api/instructor/'+moduleName+'/course/'+courseId+'/sections/get')
            .then(response=>commit('setSections',response.data));
    },
    loadSelectedLessonIndex({commit},lessonIndex){
        commit('setSelectedLessonIndex',lessonIndex);
    },
    loadSelectedSectionIndex({commit}, sectionIndex){
        commit('setSelectedSectionIndex',sectionIndex);
    },
    loadLearnCourse({commit}, [moduleName, courseId, userId]){
        Axios.get('/api/learn/'+moduleName+'/'+courseId+'/user/'+userId)
            .then(response=>commit('setLearnCourse',response.data));
    },
    loadCourseSources({commit}, [moduleName, courseId, lessonId]){
        Axios.get('/api/learn/'+moduleName+'/'+courseId+'/lesson/'+lessonId+'/sources')
            .then(response=>commit('setCourseSources',response.data))
    },
    loadLessonDiscussion({commit}, [moduleName, courseId, lessonId]){
        Axios.get('/api/learn/'+moduleName+'/'+courseId+'/lesson/'+lessonId+'/discussion')
            .then(response=>commit('setLessonDiscussion',response.data))

    },
    loadPlLessonType({commit}){
        Axios.get('/api/curriculum/index')
            .then(response=>commit('setPlLessonType',response.data))
    },
    loadPreviewLessons({commit}, [moduleName, courseId]){
        Axios.get('/api/course/'+courseId+'/'+moduleName+'/previewLessons')
            .then(response=>commit('setPreviewLessons',response.data))
    },
    loadCourseSubjects({commit}, [moduleName, courseId]){
        Axios.get('/api/instructor/'+moduleName+'/course/'+courseId+'/subjects')
            .then(response=>commit('setCourseSubjects',response.data))
    },
    loadLessonSubjects({commit}, lessonId){
        Axios.get('/api/instructor/subjects/lesson/'+lessonId)
            .then(response=>commit('setCourseSubjects',response.data))
    },
    loadQuestionSource({commit},userId){
        Axios.get('/api/questionSource/getQuestions/'+userId)
            .then(response=>commit('setQuestionSource', response.data))
    },
    loadShoppingCart({commit},userId){
        Axios.get('/api/basket/show/'+userId)
            .then(response=>commit('setShoppingCart', response.data))
    },
    loadCourseCard({commit}){
        commit('setLoadingStatus',false);
        Axios.get(state.urlForCourseCard)
            .then(response=>commit('setCourseCard', response.data));
    },
    loadUrlForCourseCard({commit, dispatch}, url){
        commit('setUrlForCourseCard', url);
        dispatch('loadCourseCard');
    },
    loadIsInCart({commit}, [module, userId, courseId]){
        Axios.get('/api/'+module+'/inBasket/'+userId+'/'+courseId)
            .then(response=>commit('setIsInCart', response.data));
    },
    loadAdminLesson({commit}){
        Axios.get('/api/admin/cr/lesson/show')
            .then(response=>commit('setAdminLesson', response.data));
    },
    loadAdminSubject({commit}, lessonId){
        Axios.get('/api/admin/cr/lesson/'+lessonId+'/subjects')
            .then(response=>commit('setAdminSubject', response.data));
    },
    loadAdminGrade({commit}){
        Axios.get('/api/admin/cr/grade/show')
            .then(response=>commit('setAdminGrade', response.data));
    },
    loadAdminCategory({commit}){
        Axios.get('/api/admin/ge/category/show')
            .then(response=>commit('setAdminCategory', response.data));
    },
    loadAdminSubCategory({commit}, categoryId){
        Axios.get('/api/admin/ge/category/'+categoryId+'/subCategories')
            .then(response=>commit('setAdminSubCategory', response.data));
    },
    loadAdminCity({commit}){
        Axios.get('/api/admin/bs/city/show')
            .then(response=>commit('setAdminCity', response.data));
    },
    loadAdminExam({commit}){
        Axios.get('/api/admin/cr/exam/show')
            .then(response=>commit('setAdminExam', response.data));
    },
    loadAdminAdmins({commit}){
        Axios.get('/api/admin/auth/admin/show')
            .then(response=>commit('setAdminAdmins', response.data));
    },
    loadAdminInstructor({commit}){
        Axios.get('/api/admin/auth/instructor/show')
            .then(response=>commit('setAdminInstructor', response.data));
    },
    loadAdminGuardian({commit}){
        Axios.get('/api/admin/auth/guardian/show')
            .then(response=>commit('setAdminGuardian', response.data));
    },
    loadAdminUsers({commit}){
        Axios.get('/api/admin/auth/student/show')
            .then(response=>commit('setAdminUsers', response.data));
    },
    loadAdminCourses({commit}, [module, userId]){
        Axios.get('/api/admin/course/all_'+module+'_courses/'+userId)
            .then(response=>commit('setAdminCourses', response.data));
    },
    loadAdminCourseStudent({commit}, [module, userId, courseId]){
        Axios.get('/api/admin/course/students_'+module+'/'+userId+'/'+courseId)
            .then(response=>commit('setAdminCourseStudent', response.data));
    },
    loadAdminSales({commit}, userId){
        Axios.get('/api/admin/purchase/getPurchases/'+userId)
            .then(response=>commit('setAdminSales', response.data));
    },
    loadAdminPromotionPayments({commit}, userId){
        Axios.get('/api/admin/purchase/getInstructorsEarnByReferenceCode/'+userId)
            .then(response=>commit('setAdminPromotionPayments', response.data));
    },
    loadAdminPromotionPurchaseDetail({commit}, [userId, instructorId]){
        Axios.get('/api/admin/purchase/getInstructorEarnByReferenceCode/'+userId+'/'+instructorId)
            .then(response=>commit('setAdminPromotionPurchaseDetail', response.data));
    },
    loadAdminDistrict({commit}, cityId){
        Axios.get('/api/admin/bs/city/'+cityId+'/districts')
            .then(response=>commit('setAdminDistrict', response.data));
    },
    loadAdminNewPage({commit}, [url, mutationName]){
        Axios.get(url).then(response=>commit(mutationName, response.data));
    },
    loadCrLessons({commit}){
        Axios.get('/api/pl/lessons')
            .then(response=>commit('setCrLessons',response.data))
    },
    loadCrExams({commit}){
        Axios.get('/api/pe/exams')
            .then(response=>commit('setCrExams',response.data))
    },
    loadGuardianStudents({commit}, userId){
        Axios.get('/api/guardian/getStudents/'+userId)
            .then(response=>commit('setGuardianStudents', response.data));
    },
    loadGuardianStudentList({commit}, userId){
        Axios.get('/api/guardian/getStudentsList/'+userId)
            .then(response=>commit('setGuardianStudentList', response.data));
    },
    loadGuardianNewPage({commit}, apiUrl){
        Axios.get(apiUrl)
            .then(response=>commit('setGuardianStudents', response.data));
    },
    loadPurchaseHistory({commit}, userId){
        Axios.get('/api/purchases/'+userId)
            .then(response=>commit('setPurchaseHistory', response.data));
    },
    loadPurchaseHistoryNewPage({commit}, apiUrl){
        Axios.get(apiUrl)
            .then(response=>commit('setPurchaseHistory', response.data));
    },
    loadQuestionAnswerData({commit},url){
        Axios.get(url)
            .then(response=>commit('setQuestionAnswerData',response.data));
    },
    loadLoadingStatus({commit}, isLoaded){
        commit('setLoadingStatus', isLoaded);
    }
};

const store=new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});
export default store;
