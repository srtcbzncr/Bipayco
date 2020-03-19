<template>
    <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown border-radius-6  uk-dropdown-top-right tm-dropdown-large uk-padding-remove">
        <div class="uk-clearfix">
            <div class="uk-float-left">
                <h5  class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left">  {{myCoursesText}} </h5>
            </div>
        </div>
        <hr class=" uk-margin-remove">
        <div class="uk-padding-small uk-text-left uk-height-medium">
            <div v-if="myCourses.courses != null && myCourses.courses.ge.length>0" class="demo1" data-simplebar style="overflow-y:auto">
                <div class="uk-child-width-1-2@s  uk-grid-small uk-padding-small"  uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100 ;repeat: true" uk-grid>
                    <div  v-for="myCourse in myCourses.courses.ge">
                        <a :href="'/ge/course/'+myCourse.course.id" class="uk-link-reset">
                            <div class="uk-padding-small uk-card-default">
                                <progress id="js-progressbar" class="uk-progress progress-green uk-margin-small-bottom" :value="myCourse.progress" max="100" style="height: 7px;"></progress>
                                <img :src="myCourse.course.image" class="uk-align-left  uk-margin-small-right uk-margin-small-bottom  uk-width-1-3  uk-visible@s" alt="">
                                <p class="uk-text-bold uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{myCourse.course.name}} </p>
                                <p class="uk-text-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}}</p>
                                <div class="uk-margin-small">
                                    <a class="Course-tags uk-margin-small-right   border-radius-6" href=""> <i class="fas fa-play"></i> Devam Et</a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div v-else class="uk-flex align-items-center justify-content-center uk-wrap uk-width uk-height">
                <h4> {{noContentText}}</h4>
            </div>
        </div>
        <hr class=" uk-margin-remove">
        <h5 class="uk-padding-small uk-margin-remove uk-text-bold uk-text-center"><a class="uk-link-heading" :href="profileRoute"> {{seeAllText}} </a> </h5>
    </div>
</template>

<script>

import {mapActions, mapState} from "vuex";
export default {
    name: "top-bar",
    props:{
        userId:{
            type:String,
            required:true,
        },
        noContentText:{
            type:String,
            default:'Hiç Kursa Sahip Değilsin'
        },
        seeAllText:{
            type:String,
            default:"Tümünü Gör"
        },
        profileRoute:{
            type:String,
            required:true,
        },
        myCoursesText:{
            type:String,
            default:"Kurslarım"
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
    created () {
        if(this.userId != null){
            this.$store.dispatch('loadMyCourses',this.userId);
        }
    },
    components: {
    }
}
</script>

<style>

</style>
