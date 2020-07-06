<template>
    <div v-if="myCourses.courses">
        <h3 class="uk-heading-line uk-text-center"><span> {{liveStreamsText}} </span></h3>
        <div v-if="myCourses.courses.live && myCourses.courses.live.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.live">
                    <div class="uk-grid-margin">
                        <a :href="'/live/course/'+myCourse.course.id" class="uk-link-reset">
                            <div class="uk-card-default uk-padding-small border-radius-6 scale-up">
                                <img class="uk-background-center-center uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :src="myCourse.course.image">
                                <p class="uk-margin-small-top uk-height-small uk-margin-remove-bottom uk-text-bold" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;"> {{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}} </p>
                                <p class="uk-text-small uk-height-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{expectedDateText}}: {{myCourse.course.datetime}} </p>
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
        <h3 class="uk-heading-line uk-text-center"><span> {{generalEducationText}} </span></h3>
        <div v-if="myCourses.courses.ge && myCourses.courses.ge.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
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
        <div v-else class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
            <h4 class="uk-text-center text-secondary">{{noContent}}</h4>
        </div>
        <h3 class="uk-heading-line uk-text-center"><span> {{prepareLessonsText}} </span></h3>
        <div v-if="myCourses.courses.pl && myCourses.courses.pl.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.pl">
                    <div class="uk-grid-margin">
                        <a :href="'/pl/course/'+myCourse.course.id" class="uk-link-reset">
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
        <h3 class="uk-heading-line uk-text-center"><span> {{prepareExamsText}} </span></h3>
        <div v-if="myCourses.courses.pe && myCourses.courses.pe.length>0" class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                <li v-for="myCourse in myCourses.courses.pe">
                    <div class="uk-grid-margin">
                        <a :href="'/pe/course/'+myCourse.course.id" class="uk-link-reset">
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
            generalEducationText:{
                type:String,
                default:"Genel Eğitim",
            },
            prepareLessonsText:{
                type:String,
                default:"Derslere Hazırlık",
            },
            prepareExamsText:{
                type:String,
                default:"Sınavlara Hazırlık",
            },
            userId:{
                type:String,
                required:true,
            },
            noContent:{
                type:String,
                default:'Hiç Kursa Sahip Değilsin'
            },
            liveStreamsText:{
                type:String,
                default:"Canlı Yayınlar"
            },
            expectedDateText:{
                type:String,
                default:"Planlanan Tarih"
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
