<template>
    <div>
        <div class="uk-container">
            <input id="questionTitle" type="text" class="uk-width uk-input uk-margin-small-bottom" :placeholder="questionTitleText">
            <textarea class="uk-textarea uk-width uk-height-small" style="resize:none;" :placeholder="askQuestionText" id="questionArea" > </textarea>
            <button  class="uk-button uk-button-primary uk-margin-small-top uk-float-right" @click="postQuestion"> {{sendText}} </button>
        </div>
        <div class="uk-container">
            <div v-if="lessonDiscussion.questions.length>0" v-for="discussion in lessonDiscussion.questions[page]" class="uk-margin-top">
                <div class="uk-card uk-padding-small uk-card-default">
                    <div class="uk-card-body uk-padding-small uk-flex">
                        <div class="uk-width-1-6@m uk-visible@m justify-content-center">
                            <img class="uk-border-circle " :src="discussion.user.avatar" style="width: 125px; height:125px;">
                        </div>
                        <div class="uk-grid-stack uk-width-5-6@m">
                            <div class="uk-margin-remove uk-flex justify-content-between uk-flex-wrap align-item-center">
                                <h4 class="uk-margin-remove">{{discussion.user.first_name}} {{discussion.user.last_name}}</h4>
                                <p class="uk-margin-remove">{{dateFormat(discussion.question.created_at)}}</p>
                            </div>
                            <hr class="uk-margin-small-bottom uk-margin-small-top">
                            <p class="uk-margin-remove">
                                {{discussion.question.content}}
                            </p>
                        </div>
                    </div>
                </div>
                <div v-if="discussion.answers&&discussion.answers.length>0" uk-grid>
                    <div class="uk-width-1-6"></div>
                    <div class="uk-card uk-card-primary uk-padding-small uk-width-5-6 uk-card-body uk-padding-small uk-flex">
                        <div class="uk-width-1-6@m uk-visible@m justify-content-center uk-margin-small-right">
                            <img class="uk-border-circle" :src="discussion.answers[0].user.avatar" style="width: 125px; height:125px;">
                        </div>
                        <div class="uk-grid-stack uk-width-5-6@m">
                            <div class="uk-margin-remove uk-flex justify-content-between align-item-center uk-flex-wrap">
                                <h4 class="uk-margin-remove">{{discussion.answers[0].user.first_name}} {{discussion.answers[0].user.last_name}}</h4>
                                <p class="uk-margin-remove">{{dateFormat(discussion.answers[0].created_at)}}</p>
                            </div>
                            <hr class="uk-margin-small-bottom uk-margin-small-top">
                            <p class="uk-margin-remove">
                                {{discussion.answers[0].content}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="uk-pagination uk-flex-center">
                <li v-if="page>0"><a href="#" @click="page--"><span uk-pagination-previous></span></a></li>
                <li v-else><a href="#" class="uk-disabled"><span uk-pagination-previous></span></a></li>
                <li v-if="page<lessonDiscussion.questions.length-1"><a href="#" @click="page++"><span uk-pagination-next></span></a></li>
                <li v-else><a href="#" class="uk-disabled"><span uk-pagination-next></span></a></li>
            </ul>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import {mapActions, mapState} from "vuex";
    export default {
        name: "question-answer-area",
        data(){
            return{
                page:0,
            }
        },
        props:{
            courseId:{
                type:String,
                required:true,
            },
            studentId:{
                type:String,
                required:true,
            },
            selectedLessonId:{
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
            questionTitleText:{
                type:String,
                default: "Başlık",
            },
            moduleName:{
                type:String,
                required:true,
            },
            minuteBeforeText:{
                type:String,
                default:"dakika önce"
            },
            hourBeforeText:{
                type:String,
                default:"saat önce"
            },
            dayBeforeText:{
                type:String,
                default:"gün önce"
            },
            monthBeforeText:{
                type:String,
                default:"ay önce"
            },
            yearBeforeText:{
                type:String,
                default:"yıl önce"
            }
        },
        computed:{
            ...mapState([
                'lessonDiscussion'
            ]),
        },
        methods:{
            ...mapActions([
                'loadLessonDiscussion'
            ]),
            postQuestion: function(){
                var formData=new FormData();
                formData.append('userId', this.studentId);
                formData.append('content', document.getElementById('questionArea').value);
                formData.append('title', document.getElementById('questionTitle').value);
                axios.post('/api/learn/'+this.moduleName+'/'+this.courseId+'/lesson/'+this.selectedLessonId+'/discussion/ask', formData)
                    .then(this.$store.dispatch('loadLessonDiscussion', [this.moduleName, this.courseId, this.selectedLessonId]))
                    .catch((error) => {
                        UIkit.notification({message:error.message, status: 'danger'});
                    });
                document.getElementById('questionArea').value="";
                document.getElementById('questionTitle').value="";
            },
            dateFormat:function (date) {
                let created=new Date(date);
                let today=new Date();
                if(today.getFullYear()-created.getFullYear()>1){
                    return (today.getFullYear()-created.getFullYear())+" "+this.yearBeforeText;
                }else if(today.getMonth()-created.getMonth()>1){
                    return (today.getMonth()-created.getMonth())+" "+this.monthBeforeText;
                }else if(today.getDate()-created.getDate()>1) {
                    return (today.getDate() - created.getDate()) + " " + this.dayBeforeText;
                }else if(today.getHours()-created.getHours()>1) {
                    return (today.getHours() - created.getHours()) + " " + this.hourBeforeText;
                }else{
                    return (today.getMinutes() - created.getMinutes()) + " " + this.minuteBeforeText;
                }
            },
        },
        created(){
            this.$store.dispatch('loadLessonDiscussion', [this.moduleName, this.courseId, this.selectedLessonId]);
        }
    }
</script>
<style scoped>
</style>
