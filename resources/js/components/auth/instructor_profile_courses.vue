<template>
    <div class="uk-width-3-4@m">
        <h3 class="uk-heading-line uk-text-center"><span>{{bioText}}</span></h3>
        <div class="uk-margin-medium-top uk-padding-small">
            <p class="uk-margin-remove-top uk-margin-small-bottom">{{bio}}</p>
        </div>
        <h3 class="uk-heading-line uk-text-center uk-margin-large-top"><span>{{generalEducationText}} </span></h3>
        <div v-if="courseCard.ge&&courseCard.ge.length<=0" class="uk-flex uk-flex-center">
            <h2>{{haveNoCourseText}}</h2>
        </div>
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">
                <li v-if="courseCard.ge" v-for="course in courseCard.ge">
                    <!-- course card -->
                    <course-card
                        v-if="authCheck"
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        module-name="generalEducation"
                        is-login
                        :user-id="userId"
                        module="ge"
                    ></course-card>
                    <course-card
                        v-else
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        module-name="generalEducation"
                        module="ge"
                    ></course-card>
                </li>
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                <li uk-slider-item="0" class="">
                    <a href="#"></a>
                </li>
            </ul>
        </div>
        <h3 class="uk-heading-line uk-text-center uk-margin-large-top"><span>{{prepareLessonsText}}</span></h3>
        <div v-if="courseCard.pl&&courseCard.pl.length<=0" class="uk-flex uk-flex-center">
            <h2>{{haveNoCourseText}}</h2>
        </div>
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">
                <li v-if="courseCard.pl" v-for="course in courseCard.pl">
                    <!-- course card -->
                    <course-card
                        v-if="authCheck"
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        module-name="prepareLessons"
                        is-login
                        :user-id="userId"
                        module="pl"
                    ></course-card>
                    <course-card
                        v-else
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        module-name="prepareLessons"
                        module="pl"
                    ></course-card>
                </li>
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                <li uk-slider-item="0" class="">
                    <a href="#"></a>
                </li>
            </ul>
        </div>
        <h3 class="uk-heading-line uk-text-center uk-margin-large-top"><span>{{prepareExamsText}}</span></h3>
        <div v-if="courseCard.pe&&courseCard.pe.length<=0" class="uk-flex uk-flex-center">
            <h2>{{haveNoCourseText}}</h2>
        </div>
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">
                <li v-if="courseCard.pe" v-for="course in courseCard.pe">
                    <!-- course card -->
                    <course-card
                        v-if="authCheck"
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        module-name="prepareExams"
                        is-login
                        :user-id="userId"
                        module="pe"
                    ></course-card>
                    <course-card
                        v-else
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        module-name="prepareExams"
                        module="pe"
                    ></course-card>
                </li>
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                <li uk-slider-item="0" class="">
                    <a href="#"></a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "instructor_profile_courses",
        props:{
            authCheck:{
                type:Boolean,
                default:false
            },
            bio:{
                type:String,
                required:true,
            },
            instructorId:{
                type:String,
                required:true,
            },
            userId:{
                type:String,
                default:"",
            },
            bioText:{
                type:String,
                default:"Biyografi"
            },
            prepareExamsText:{
                type:String,
                default:"Sınavlara Hazırlık"
            },
            prepareLessonsText:{
                type:String,
                default:"Derslere Hazırlık"
            },
            generalEducationText:{
                type:String,
                default:"Genel Eğitim"
            },
            haveNoCourseText:{
                type:String,
                default:"Hiç Kurs Bulunmuyor"
            }
        },
        computed: {
            ...mapState([
                'courseCard',
                'urlForCourseCard',
            ]),
        },
        methods: {
            ...mapActions([
                'loadCourseCard',
                'loadUrlForCourseCard'
            ]),
        },
        created() {
            this.$store.dispatch('loadUrlForCourseCard', '/api/profile/instructor/'+this.instructorId+'/'+this.userId);
        }
    }
</script>

<style scoped>

</style>
