<template>
    <div v-if="myCourses.courses!=null">
        <div v-if="generalEducation && myCourses.courses.ge.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.ge">
                    <div class="uk-grid-margin">
                        <a :href="'/ge/course/'+myCourse.course.id" class="uk-link-reset">
                            <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="myCourse.progress" max="100" style=" height: 7px;"> </progress>
                                <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="myCourse.course.image">
                                <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}} </p>
                            </div>
                        </a>
                    </div>
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
        <div v-else-if="prepareForLessons && myCourses.courses.pl.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.pl">
                    <div class="uk-grid-margin">
                        <a href="#" class="uk-link-reset">
                            <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="myCourse.progress" max="100" style=" height: 7px;"> </progress>
                                <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="myCourse.course.image">
                                <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}} </p>
                            </div>
                        </a>
                    </div>
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
        <div v-else-if="prepareForExams && myCourses.courses.pe.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.pe">
                    <div class="uk-grid-margin">
                        <a href="#" class="uk-link-reset">
                            <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="myCourse.progress" max="100" style=" height: 7px;"> </progress>
                                <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="myCourse.course.image">
                                <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}} </p>
                            </div>
                        </a>
                    </div>
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
        <div v-else-if="books && myCourses.courses.books.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.books">
                    <div class="uk-grid-margin">
                        <a href="#" class="uk-link-reset">
                            <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="myCourse.progress" max="100" style=" height: 7px;"> </progress>
                                <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="myCourse.course.image">
                                <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}} </p>
                            </div>
                        </a>
                    </div>
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
        <div v-else-if="exams && myCourses.courses.exams.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.exams">
                    <div class="uk-grid-margin">
                        <a href="#" class="uk-link-reset">
                            <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="myCourse.progress" max="100" style=" height: 7px;"> </progress>
                                <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="myCourse.course.image">
                                <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}} </p>
                            </div>
                        </a>
                    </div>
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
        <div v-else-if="homeworks && myCourses.courses.homeworks.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.homeworks">
                    <div class="uk-grid-margin">
                        <a href="#" class="uk-link-reset">
                            <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                <progress id="js-progressbar" class="uk-progress uk-margin-small-bottom" :value="myCourse.progress" max="100" style=" height: 7px;"> </progress>
                                <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="myCourse.course.image">
                                <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}} </p>
                            </div>
                        </a>
                    </div>
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
        <div v-else class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
            <h4 class="uk-text-center text-secondary">{{noContent}}</h4>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "course-progress-card",
        props:{
            generalEducation:{
                type:Boolean,
                default:false,
            },
            prepareForLessons:{
                type:Boolean,
                default:false,
            },
            prepareForExams:{
                type:Boolean,
                default:false,
            },
            books:{
                type:Boolean,
                default:false,
            },
            exams:{
                type:Boolean,
                default:false,
            },
            homeworks:{
                type:Boolean,
                required: false,
            },
            userId:{
                type:String,
                required:true,
            },
            noContent:{
                type:String,
                default:'Hiç Kursa Sahip Değilsin'
            }
        },
        computed:{
            ...mapState([
                'myCourses',
            ]),
        },
        methods:{
            ...mapActions([
                'loadMyCourses'
            ]),
        },
        created() {
            this.$store.dispatch('loadMyCourses',this.userId);
        },
    }
</script>

<style scoped>

</style>
