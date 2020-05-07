<template>
    <div class="uk-grid">
        <div class="uk-width-1-2@l">
            <select class='uk-select uk-margin-small-bottom' name="lesson" id="lesson" v-model="selected" @change="loadSubjectsList" required>
                <option v-if="hasSelectedOption" hidden selected :value="selectedLessonId">{{selectedLesson}} </option>
                <option v-if="!(hasSelectedOption)" disabled hidden selected value="">{{lessonDefaultText}}</option>
                <option v-for='lesson in crLessons' :value='lesson.id'>{{lesson.name}}</option>
            </select>
        </div>
        <div class="uk-width-1-2@l">
            <select class="uk-select" name="subject" id="subject" required>
                <option v-if="hasSelectedOption && hasChange" selected hidden :value="selectedSubCategoryId">{{selectedSubject}} </option>
                <option v-if="!(hasSelectedOption)|| !hasChange" disabled hidden selected value="">{{subjectDefaultText}}</option>
                <option v-for='subject in subjects' :value='subject.id'>{{subject.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex';
    import Axios from 'axios'
    export default {
        name:'categorySelect',
        data(){
          return{
              selected: this.selectedLessonId,
              changing:Boolean,
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
            selectedSubject:String,
            selectedLesson:String,
            selectedSubjectId:String,
            selectedLessonId:{
                type:String,
                default: "",
            },
        },
        computed:{
            hasChange:function () {
                return this.changing;
            },
            selectedId: function () {
                return this.selected;
            },
            ...mapState([
                'crLessons',
            ]),
        },
        methods:{
            ...mapActions([
                'loadCrLessons',
            ]),
            loadSubjectsList: function(){
                Axios.get('/api/instructor/subjects/lesson/'+this.selectedId)
                .then((res)=>{this.subjects=res.data.data});
                this.changing=document.getElementById('lesson').value===this.selectedLessonId;
            },
        },
        mounted () {
            this.$store.dispatch('loadCrLessons');
        },
    }
</script>

<style>
</style>

