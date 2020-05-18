<template>
    <div>
        <div class="uk-margin-medium-top">
            <select v-model="selectedStudentIndex" class="uk-select uk-width-1-2@m uk-width-1-3@l">
                <option value="" hidden disabled>{{selectStudentText}}</option>
                <option v-for="(student, index) in guardianStudentList" :value="index">{{student.user.first_name}} {{student.user.last_name}}</option>
            </select>
            <div v-if="selectedStudent!=''">
                <div class=" uk-margin-top uk-flex uk-flex-wrap align-items-center justify-content-start">
                    <img :src="selectedStudent.avatar" class="uk-height-small uk-width-small uk-border-circle">
                    <h3 class="uk-margin-medium-left">{{selectedStudent.first_name}} {{selectedStudent.last_name}}</h3>
                </div>
                <h3 class="uk-heading-line uk-text-center"><span> {{generalEducationText}} </span></h3>
                <div v-if="studentCourses.ge.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                    <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                        <li v-for="course in studentCourses.ge">
                            <div class="uk-grid-margin">
                                <a href="#" class="uk-link-reset">
                                    <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                        <!--                                    <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="course.progress" max="100" style=" height: 7px;"> </progress>-->
                                        <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="course.image">
                                        <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{course.name}} </p>
                                        <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{course.description}} </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
                <div v-else class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
                    <h4 class="uk-text-center text-secondary">{{noContentText}}</h4>
                </div>
                <h3 class="uk-heading-line uk-text-center"><span> {{prepareLessonsText}} </span></h3>
                <div v-if="studentCourses.pl.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                    <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                        <li v-for="course in studentCourses.ge">
                            <div class="uk-grid-margin">
                                <a href="#" class="uk-link-reset">
                                    <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                        <!--                                    <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="course.progress" max="100" style=" height: 7px;"> </progress>-->
                                        <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="course.image">
                                        <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{course.name}} </p>
                                        <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{course.description}} </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
                <div v-else class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
                    <h4 class="uk-text-center text-secondary">{{noContentText}}</h4>
                </div>
                <h3 class="uk-heading-line uk-text-center"><span> {{prepareExamsText}} </span></h3>
                <div v-if="studentCourses.pe.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                    <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                        <li v-for="course in studentCourses.ge">
                            <div class="uk-grid-margin">
                                <a href="#" class="uk-link-reset">
                                    <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                        <!--                                    <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="course.progress" max="100" style=" height: 7px;"> </progress>-->
                                        <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="course.image">
                                        <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{course.name}} </p>
                                        <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{course.description}} </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
                <div v-else class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
                    <h4 class="uk-text-center text-secondary">{{noContentText}}</h4>
                </div>
            </div>
        </div>
        <div id="modal-container" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h2 class="uk-modal-title">{{selectedCourse.title}}</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import Axios from 'axios';
    export default {
        name: "student-profile-page",
        data(){
            return{
                selectedStudentIndex:"",
                selectedStudent:"",
                studentCourses:{pe:[], ge:[], pl:[]},
                selectedCourse:{},
            }
        },
        props:{
            userId:{
                type:String,
                required:true,
            },
            selectStudentText:{
                type:String,
                default:"Öğrenci Seçiniz",
            },
            generalEducationText:{
                type:String,
                default:"Genel Eğitim"
            },
            prepareLessonsText:{
                type:String,
                default:"Derslere Hazırlık"
            },
            prepareExamsText:{
                type:String,
                default:"Sınavlara Hazırlık"
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmuyor"
            },
        },
        watch:{
            selectedStudentIndex(){
                this.selectedStudent=this.guardianStudentList[this.selectedStudentIndex].user;
                Axios.get('/api/guardian/courseInfo/'+this.userId+'/'+this.selectedStudent.id)
                    .then((res)=>{
                        this.studentCourses=res.data.data.allCourses;
                        console.log(this.studentCourses)
                    });
            },
        },
        computed:{
            ...mapState([
                'guardianStudentList'
            ]),
        },
        methods:{
            ...mapActions([
                'loadGuardianStudentList'
            ]),
            selectCourse:function (id, module) {
                let moduleNumber;
                switch (module) {
                    case 'ge':moduleNumber=1;break;
                    case 'pl':moduleNumber=2;break;
                    case 'pe':moduleNumber=3;break;
                }
                Axios.get('/api/guardian/courseInfo/'+this.userId+'/'+this.selectedStudent.id+'/'+id+'/'+moduleNumber)
                    .then(()=>{})
            }
        },
        created() {
            this.$store.dispatch('loadGuardianStudentList', this.userId)
        }
    }
</script>

<style scoped>

</style>
