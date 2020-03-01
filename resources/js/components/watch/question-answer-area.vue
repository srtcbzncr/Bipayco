<template>
    <div>
        <div class="uk-container">
            <textarea class="uk-textarea uk-width uk-height-small" style="resize:none;" :placeholder="askQuestionText" id="questionArea" > </textarea>
            <button  class="uk-button uk-button-primary uk-margin-small-top uk-float-right" @click="postQuestion"> {{sendText}} </button>
        </div>
        <div v-for="question in lessonDiscussion" class="uk-container uk-margin-top">
            <div class="uk-card uk-padding-small uk-card-default">
                <div class="uk-card-body uk-padding-small uk-flex align-items-center">
                    <div class="uk-width-1-6@m uk-visible@m justify-content-center">
                        <img class="uk-border-circle " src="" style="width: 125px; height:125px;">
                    </div>
                    <div class="uk-grid-stack uk-width-5-6@m">
                        <h4 class="uk-margin-remove">{{question.user.first_name}} {{question.user.last_name}}</h4>
                        <hr class="uk-margin-small-bottom uk-margin-small-top">
                        <p class="uk-margin-remove">
                            {{question.message}}
                        </p>
                    </div>
                </div>
            </div>
            <div uk-grid>
                <div class="uk-width-1-6"></div>
                <div class="uk-card uk-card-primary uk-padding-small uk-width-5-6">
                    <div class="uk-card-body uk-padding-small uk-flex align-items-center">
                        <div class="uk-width-1-6@m uk-visible@m justify-content-center">
                            <img class="uk-border-circle " :src="question.answer.user.avatar" style="width: 125px; height:125px;">
                        </div>
                        <div class="uk-grid-stack uk-width-5-6@m">
                            <h4 class="uk-margin-remove">{{question.answer.user.first_name}} {{question.answer.user.last_name}}</h4>
                            <hr class="uk-margin-small-bottom uk-margin-small-top">
                            <p class="uk-margin-remove">
                                {{question.answer.message}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import {mapActions, mapState} from "vuex";
    export default {
        name: "question-answer-area",
        props:{
            courseId:{
                type:String,
                required:true,
            },
            studentId:{
                type:String,
                required:true,
            },
            askQuestionText:{
                type:String,
                default:"Bir Soru Sor..."
            },
            sendText:{
                type:String,
                default:"Gönder"
            },

        },
        computed:{
            ...mapState([
                'learnCourse',
                'selectedSectionIndex',
                'selectedLessonIndex',
                'lessonDiscussion'
            ]),
            lessonId(){
                return this.learnCourse.sections[this.selectedSectionIndex].lessons[this.selectedLessonIndex].id;
            },
        },
        methods:{
            ...mapActions([
                'loadLessonDiscussion'
            ]),
            postQuestion: function(){
                var formData=new FormData();
                formData.append('studentId', this.studentId);
                formData.append('question', document.getElementById('questionArea').value);
                axios.post('/api/learn/generalEducation/'+this.courseId+'/lesson/'+this.learnCourse.sections[this.selectedSectionIndex].lessons[this.selectedLessonIndex].id+'/discussion/ask', formData)
                    .then(response=>console.log(response))
                    .then(this.$store.dispatch('loadLessonDiscussion', [this.courseId, this.lessonId]))
                    .catch((error) => {
                        UIkit.notification({message:error.message, status: 'danger'});
                    });
            },
        },
    }
</script>

<style scoped>

</style>
