<template>
    <div class="uk-width-1-3@m uk-visible@m">
        <h3 class="uk-text-bold">{{relatedCoursesText}}</h3>
        <div v-for="course in courseCard" class="uk-margin-medium-bottom">
            <course-card
                v-if="authCheck"
                :course="course"
                style-full-star-color="#F4C150"
                style-empty-star-color="#C1C1C1"
                :course-id="course.id"
                :module-name="moduleName"
                is-login
                :user-id="userId"
                :module="module"
            ></course-card>
            <course-card
                v-else
                :course="course"
                style-full-star-color="#F4C150"
                style-empty-star-color="#C1C1C1"
                :course-id="course.id"
                :module-name="moduleName"
                :module="module"
            ></course-card>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex'
    export default {
        name: "similar-course-card",
        props:{
            moduleName:{
                type:String,
                required:true,
            },
            module:{
                type:String,
                required:true
            },
            courseId:{
                type:String,
                required:true,
            },
            authCheck:{
                type:Boolean,
                default:false
            },
            userId:{
                type:String,
                default:""
            },
            relatedCoursesText:{
                type:String,
                default:"Benzer Kurslar"
            },
        },
        computed:{
            ...mapState([
                'courseCard'
            ]),
            url(){
                return '/api/'+this.module+'/similarCourses/'+this.courseId+'/'+this.userId;
            }
        },
        methods:{
            ...mapActions([
                'loadUrlForCourseCard'
            ]),
        },
        created() {
            this.$store.dispatch('loadUrlForCourseCard', this.url);
        }
    }
</script>

<style scoped>

</style>
