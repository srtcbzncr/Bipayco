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
                                <a @click="selectCourse(course.id, 'ge')" class="uk-link-reset">
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
                        <li v-for="course in studentCourses.pl">
                            <div class="uk-grid-margin">
                                <a @click="selectCourse(course.id, 'pl')" class="uk-link-reset">
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
                        <li v-for="course in studentCourses.pe">
                            <div class="uk-grid-margin">
                                <a @click="selectCourse(course.id, 'pe')" class="uk-link-reset">
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
        <div id="courseDetailModal" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <div class="uk-modal-title">
                    <div class="uk-flex align-item-center justify-content-center flex-row flex-wrap">
                        <img :src="selectedCourse.image" class="uk-height-small uk-width-small ">
                        <div class="uk-margin-left uk-width-3-4@m">
                            <h2 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 40px; max-height: 40px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{selectedCourse.name}}</h2>
                            <h6 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 20px; max-height: 42px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-margin-small">{{selectedCourse.description}}</h6>
                        </div>
                    </div>
                </div>
                <div class="uk-modal-body" uk-overflow-auto>
                    <ul uk-tab class="uk-flex-center uk-tab" :class="{'uk-hidden': !hasTest}" >
                        <li class="uk-active"><a>{{lessonsText}}</a></li>
                        <li><a>{{testsText}}</a></li>
                    </ul>
                    <ul class="uk-switcher uk-margin uk-margin-medium-top">
                        <li>
                            <ul uk-accordion="" class="uk-accordion">
                                <li v-if="selectedCourse.sections.length>0" v-for="section in selectedCourse.sections" class="tm-course-lesson-section uk-background-default">
                                    <a class="uk-accordion-title uk-padding-small" href="#"><h6> {{sectionText}}  {{section.no}}</h6> <h4 class="uk-margin-remove"> {{section.name}}</h4> </a>
                                    <div class="uk-accordion-content uk-margin-remove-top">
                                        <div class="tm-course-section-list">
                                            <ul>
                                                <li v-if="section.lessons.length>0" v-for="lesson in section.lessons">
                                                    <span>
                                                        <i v-if="lesson.isCompleted" style="color:#2ED24A" class="fas fa-check-circle icon-medium"></i>
                                                        <i v-else-if="lesson.is_video" style="color:#666666" class="fas fa-play-circle icon-medium"></i>
                                                        <i v-else style="color:#666666" class="fas fa-file-alt icon-medium"></i>
                                                    </span>
                                                    <!-- Course title  -->
                                                    <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{lesson.name}}</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                            <h4 v-if="!selectedCourse.sections" class="uk-text-center">{{noContentText}}</h4>
                        </li>
                        <li v-if="hasTest">
                            <ul uk-accordion="" class="uk-accordion">
                                <li v-if="selectedTest.sections.length>0" v-for="section in selectedTest.sections" class="tm-course-lesson-section uk-background-default">
                                    <a class="uk-accordion-title uk-padding-small" href="#"><h6> {{sectionText}}  {{section.no}}</h6> <h4 class="uk-margin-remove"> {{section.name}}</h4> </a>
                                    <div class="uk-accordion-content uk-margin-remove-top">
                                        <div class="tm-course-section-list">
                                            <ul>
                                                <li v-if="section.firstTest">
                                                    <span>
                                                        <i v-if="section.firstTest.result" style="color:#2ED24A" class="fas fa-check-circle icon-medium"></i>
                                                        <i v-else style="color:#666666" class="fas fa-cross-circle icon-medium"></i>
                                                    </span>
                                                    <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{testType(section.firstTest.testType)}}</div>
                                                    <span style="color:#666666" class="uk-visible@m uk-position-center-right time uk-margin-right"> <i class="fas fa-star icon-small"></i>  {{section.firstTest.score}}</span>

                                                </li>
                                                <li v-if="section.lastTest">
                                                    <span>
                                                        <i v-if="section.lastTest.result" style="color:#2ED24A" class="fas fa-check-circle icon-medium"></i>
                                                        <i v-else style="color: red" class="fas fa-minus-circle icon-medium"></i>
                                                    </span>
                                                    <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{testType(section.lastTest.testType)}}</div>
                                                    <span style="color:#666666" class="uk-visible@m uk-position-center-right time uk-margin-right"> <i class="fas fa-star icon-small"></i>  {{section.lastTest.score}}</span>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <h4 v-if="!selectedCourse.sections" class="uk-text-center">{{noContentText}}</h4>
                        </li>
                    </ul>
                </div>
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
                selectedTest:{},
                hasTest:false,
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
            lessonsText:{
                type:String,
                default:"Dersler"
            },
            testsText:{
                type:String,
                default:"Testler"
            },
            sectionText:{
                type:String,
                default:"Bölüm"
            },
            sectionNameText:{
                type:String,
                default:"Bölüm Adı"
            },
            testTypeText:{
                type:String,
                default:"Test Tipi"
            },
            pointText:{
                type:String,
                default:"Puan"
            },
            firstTestText:{
                type:String,
                default:"Ön Test"
            },
            lastTestText:{
                type:String,
                default:"Son Test"
            }

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
                    case 'ge':{
                        moduleNumber=1;
                        this.hasTest=false;
                        break;
                    }
                    case 'pl':{
                        moduleNumber=2;
                        this.hasTest=true;
                        break;
                    }
                    case 'pe':{
                        moduleNumber=3;
                        this.hasTest=true;
                        break;
                    }
                }
                Axios.get('/api/guardian/courseInfo/'+this.userId+'/'+this.selectedStudent.id+'/'+id+'/'+moduleNumber)
                    .then((res)=>{this.selectedCourse=res.data.data;});
                if(this.hasTest){
                    Axios.get('/api/guardian/firstLastTestInfo/'+this.userId+'/'+this.selectedStudent.id+'/'+id+'/'+moduleNumber)
                        .then((res)=>{this.selectedTest=res.data.data; console.log(res.data.data)});
                }
                UIkit.modal('#courseDetailModal').show();
            },
            testType:function (test) {
                if(test){
                    return this.firstTestText;
                }else{
                    return this.lastTestText;
                }
            }
        },
        created() {
            this.$store.dispatch('loadGuardianStudentList', this.userId)
        }
    }
</script>

<style scoped>

</style>
