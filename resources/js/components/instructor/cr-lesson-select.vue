<template>
    <div class="uk-grid">
        <div class="uk-width-1-2@l">
            <select class='uk-select uk-margin-small-bottom' id="crLessonId" v-model="selectedLesson" @change="loadSubjectsList" required>
                <option disabled hidden selected value="">{{lessonDefaultText}}</option>
                <option v-for='lesson in crLessons' :value='lesson.id'>{{lesson.name}}</option>
            </select>
        </div>
        <div class="uk-width-1-2@l">
            <select class="uk-select" id="crSubjectId" v-model="selectedSubject" @change="$store.commit('setSelectedSubjectId', selectedSubject)" required>
                <option disabled hidden selected value="">{{subjectDefaultText}}</option>
                <option v-for='subject in courseSubjects' :value='subject.id'>{{subject.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions, mapMutations} from 'vuex';
    import Axios from 'axios'
    export default {
        name:'categorySelect',
        data(){
          return{
              selectedSubject:"",
              selectedLesson:"",
              subjects:[],
          }
        },
        props:{
            lessonDefaultText:{
                type:String,
                default:"Ders Seçiniz"
            },
            subjectDefaultText:{
                type:String,
                default:"Konu Seçiniz"
            },
            hasSelectedOption:{
                type:Boolean,
                default:false,
            },
        },
        computed:{
            ...mapState([
                'crLessons',
                'selectedLessonId',
                'selectedSubjectId',
                'courseSubjects',
            ]),
        },
        watch:{
            selectedLessonId(){
                this.selectedLesson=this.selectedLessonId;
                if(this.selectedLessonId!=""){
                    this.$store.dispatch('loadLessonSubjects', this.selectedLessonId);
                }else{
                    this.$store.commit('setCourseSubjects',[]);
                }
            },
            selectedSubjectId(){
                this.selectedSubject=this.selectedSubjectId;
            },
        },
        methods:{
            ...mapActions([
                'loadCrLessons',
                'loadLessonSubjects'
            ]),
            ...mapMutations([
                'setSelectedLessonId',
                'setSelectedSubjectId',
                'setCourseSubjects'
            ]),

            loadSubjectsList: function(){
                this.$store.commit('setSelectedLessonId',this.selectedLesson);
                this.$store.commit('setSelectedSubjectId', "");
            },
        },
        created() {
            this.$store.dispatch('loadCrLessons');
        },
    }
</script>

<style>
</style>

