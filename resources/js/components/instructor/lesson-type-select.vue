<template>
    <div>
        <div class="uk-grid">
            <div class="uk-width-1-2@l">
                <select class='uk-select uk-margin-small-bottom' id="gradeType" required>
                    <option v-if="hasSelectedOption" hidden selected :value="selectedGradeId">{{selectedGrade}} </option>
                    <option v-else disabled hidden selected value="">{{gradeDefaultText}}</option>
                    <option v-for='grade in plLessonType.grade' :value='grade.id'>{{grade.name}}</option>
                </select>
            </div>
            <div class="uk-width-1-2@l">
                <select class="uk-select" id="lessonType" required>
                    <option v-if="hasSelectedOption" hidden selected :value="selectedLessonId">{{selectedLesson}} </option>
                    <option v-else disabled hidden selected value="">{{lessonDefaultText}}</option>
                    <option v-for='lesson in plLessonType.lesson' :value='lesson.id'>{{lesson.name}}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from "vuex";

    export default {
        name: "lesson-type-select",
        props:{
            gradeDefaultText:{
                type:String,
                default:"grade"
            },
            lessonDefaultText:{
                type:String,
                default:"Ders"
            },
            selectedGradeId:{
                type:String,
                default:null,
            },
            selectedGrade:{
                type:String,
                default:null,
            },
            selectedLesson:{
                type:String,
                default:null,
            },
            selectedLessonId:{
                type:String,
                default:null,
            },
            hasSelectedOption:{
                type:Boolean,
                default:false,
            }
        },
        computed:{
            ...mapState([
                'plLessonType'
            ]),
        },
        methods:{
          ...mapActions([
              'loadPlLessonType'
          ])
        },
        created() {
            this.$store.dispatch('loadPlLessonType');
        }
    }
</script>

<style scoped>

</style>
