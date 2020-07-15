<template>
    <div class="uk-margin-medium-top">
        <ul uk-tab class="uk-margin-top uk-flex-center">
            <li><a @click="changeArea('waitingAnswer')">{{waitingAnswerText}}</a></li>
            <li><a @click="changeArea('answered')">{{answeredText}}</a></li>
        </ul>
        <div class="uk-background-default uk-padding-remove uk-margin-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="questionAnswerData.length>0">
                    <tr>
                        <th>{{questionTitleText}}</th>
                        <th>{{courseNameText}}</th>
                        <th>{{studentNameText}}</th>
                    </tr>
                </thead>
                <tbody v-if="questionAnswerData.length>0">
                    <tr v-for="(item,index) in questionAnswerData[selectedPage-1]" @click="openInfo(index)" class="clickable">
                        <td class="uk-width-1-2"><p>{{item.title}}</p></td>
                        <td class="uk-width-1-4"><p>{{item.course.name}}</p></td>
                        <td class="uk-width-1-4"><p>{{item.user.first_name}} {{item.user.last_name}}</p></td>
                    </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{haveNoQuestionText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="questionAnswerData.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="(selectedPage-1)>1" @click="loadNewPage(Number(selectedPage)-1)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==selectedPage" class="uk-background-default uk-disabled" @click="loadNewPage(selectedPage)">{{page}}</button>
                <button v-else @click="loadNewPage(page)">{{page}}</button>
            </li>
            <li>
                <button v-show="(selectedPage-1)<questionAnswerData.length-1" @click="loadNewPage(Number(selectedPage)+1)"> > </button>
            </li>
        </ul>
        <div id="answerArea" class="uk-height-viewport uk-modal-container uk-modal">
            <div v-if="selectedQuestion" class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">{{questionDetailText}}</h3>
                </div>

                <div class="uk-modal-body uk-height-max-large uk-overflow-auto">
                    <!-- question area -->
                    <div>
                        <p>{{selectedQuestion.course.name}} > {{selectedQuestion.section.name}} > {{selectedQuestion.lesson.name}}</p>
                    </div>
                    <hr>
                    <div class="uk-card uk-card-default-uk-padding-small">
                        <div>
                            <h4 class="uk-margin-remove">{{selectedQuestion.title}}</h4>
                            <p>{{selectedQuestion.content}}</p>
                        </div>
                        <hr class="uk-margin-remove-vertical">
                        <div class="uk-flex justify-content-between uk-card-footer align-item-center uk-flex-wrap">
                            <div class="uk-flex align-item-center">
                                <img :src="selectedQuestion.user.avatar" alt="" class="uk-border-circle user-profile-tiny">
                                <p class="uk-margin-remove-vertical uk-margin-small-left">{{selectedQuestion.user.first_name}} {{selectedQuestion.user.last_name}}</p>
                            </div>
                            <p class="uk-margin-remove-vertical">{{new Date(selectedQuestion.created_at).toLocaleDateString()}}</p>
                        </div>
                    </div>
                    <!-- answer area -->
                    <div id="answerTextArea" class="uk-margin-top" :class="{'isAnswered': selectedQuestion.answer}">
                        <div class="uk-margin-bottom">
                            <div class="uk-form-label">{{answerText}}</div>
                            <textarea v-model="answer" class="uk-width uk-height-small uk-textarea" :placeholder="letsAnswerText"></textarea>
                        </div>
                        <button v-if="selectedQuestion.answer" class="uk-button uk-button-default uk-float-right uk-margin-small-left" @click="closeInfo" type="button">{{cancelText}}</button>
                        <button v-if="selectedQuestion.answer" class="uk-button uk-button-success uk-float-right" type="button" @click="updateItem">{{sendText}}</button>
                        <button v-else class="uk-button uk-button-success uk-float-right" type="button" @click="saveItem">{{sendText}}</button>
                    </div>
                    <!-- answered text area -->
                    <div id="answered" v-if="selectedQuestion.answer" class="answerToggle uk-card uk-margin-top uk-card-body uk-card-primary uk-padding-small">
                        <span v-if="selectedQuestion.answer.user.id==userId" class="uk-float-right uk-card-title">
                            <button class="uk-button-default" type="button"><i class="fas fa-ellipsis-v"></i></button>
                            <div uk-dropdown="mode:click; pos:bottom-right" class="uk-padding-small border-radius-6">
                                <ul class="uk-nav uk-dropdown-nav">
                                    <li><a @click="editAnswer" class="uk-text-black">{{editText}}</a></li>
                                    <li><a @click="deleteAnswer" class="uk-text-danger uk-modal-close">{{deleteText}}</a></li>
                                </ul>
                            </div>
                        </span>
                        <div class="uk-card-body uk-padding-small">
                            <p>{{selectedQuestion.answer.content}}</p>
                        </div>
                        <hr class="uk-margin-remove-vertical">
                        <div class="uk-flex uk-card-footer align-item-center justify-content-between uk-flex-wrap">
                            <div class="uk-flex align-item-center">
                                <img :src="selectedQuestion.answer.user.avatar" alt="" class="uk-border-circle user-profile-tiny">
                                <p class="uk-margin-remove-vertical uk-margin-small-left">{{selectedQuestion.answer.user.first_name}} {{selectedQuestion.answer.user.last_name}}</p>
                            </div>
                            <p class="uk-margin-remove-vertical">{{new Date(selectedQuestion.answer.created_at).toLocaleDateString()}}</p>
                        </div>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" @click="closeInfo" type="button">{{closeText}}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "questions-page",
        data(){
            return{
                selectedQuestionIndex:"",
                selectedUrl:'/api/instructor/getNotAnsweredQuestions',
                selectedAreaName:"waitingAnswer",
                selectedPage:1,
                answer:"",
            }
        },
        props:{
            userId:{
                type:String,
                required:true,
            },
            questionDetailText:{
                type:String,
                default:"Soru Detayı"
            },
            questionTitleText:{
                type:String,
                default:"Soru Başlığı"
            },
            studentNameText:{
                type:String,
                default:"Öğrenci Adı"
            },
            courseNameText:{
                type:String,
                default:"Kurs Adı"
            },
            haveNoQuestionText:{
                type:String,
                default:"Soru Bulunmuyor"
            },
            waitingAnswerText:{
                type:String,
                default:"Cevap Bakleyenler"
            },
            answeredText:{
                type:String,
                default:"Cevaplananlar"
            },
            deleteText:{
                type:String,
                default:"Sil"
            },
            editText:{
                type:String,
                default:"Düzenle"
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            sendText:{
                type:String,
                default:"Gönder"
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            },
            answerText:{
                type:String,
                default:"Cevap"
            },
            letsAnswerText:{
                type:String,
                default:"Hadi Sorusunu Cevapla"
            },
            closeText:{
                type:String,
                default:"Kapat"
            }
        },
        watch:{
            selectedAreaName(){
                this.selectedPage=1;
                if(this.selectedAreaName=='waitingAnswer'){
                    this.selectedUrl='/api/instructor/getNotAnsweredQuestions';
                }else{
                    this.selectedUrl='/api/instructor/getAnsweredQuestions';
                }
                this.fetchData();
                if(this.selectedQuestion!=null&&this.selectedQuestion.answer){
                    this.answer=this.selectedQuestion.answer.content;
                }else{
                    this.answer="";
                }
            },
        },
        computed:{
            ...mapState([
                'questionAnswerData'
            ]),
            selectedQuestion(){
                if(this.questionAnswerData.length>0){
                    return this.questionAnswerData[this.selectedPage-1][this.selectedQuestionIndex];
                }else{
                    return null;
                }
            },
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.questionAnswerData.length; i++){
                    if(i==2 && this.selectedPage-2>3){
                        pages.push('...');
                        if(this.selectedPage+3>this.questionAnswerData.length){
                            index=this.questionAnswerData.length-6;
                        }else{
                            index=this.selectedPage-2;
                        }
                    }else if(i==8 && this.selectedPage+2<this.questionAnswerData.length-2){
                        pages.push('...');
                        index=this.questionAnswerData.length;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
        },
        methods:{
            ...mapActions([
                'loadQuestionAnswerData',
            ]),
            fetchData:function(){
                this.$store.dispatch('loadQuestionAnswerData', this.selectedUrl+'/'+this.userId);
            },
            changeArea:function(name){
                this.selectedAreaName=name;
            },
            deleteAnswer:function () {
                Axios.post('/api/instructor/deleteAnswer/'+this.selectedQuestion.answer.id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.fetchData();
                        }
                    }).catch((error)=>{
                    if(error.response) {
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }});
            },
            editAnswer:function () {
                this.answer=this.selectedQuestion.answer.content;
                document.getElementById('answerTextArea').style.display = "block";
                document.getElementById('answered').style.display = "none";
            },
            updateItem:function(){
                Axios.post('/api/instructor/updateAnswer/'+this.selectedQuestion.answer.id, {content:this.answer, userId:this.userId})
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.fetchData();
                        }
                    }).catch((error)=>{
                    if(error.response) {
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }});
                document.getElementById('answerTextArea').style.display = "none";
                document.getElementById('answered').style.display = "block";

            },
            openInfo:function (index) {
                this.selectedQuestionIndex=index;
                UIkit.modal('#answerArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            closeInfo:function(){
                if(this.selectedQuestion.answer){
                    document.getElementById('answerTextArea').style.display = "none";
                    document.getElementById('answered').style.display = "block";
                }
                this.clearForm();
            },
            clearForm:function(){
                if(this.selectedQuestion.answer){
                    this.answer=this.selectedQuestion.answer.content;
                }else{
                    this.answer="";
                }
            },
            saveItem:function () {
                Axios.post('/api/learn/'+this.selectedQuestion.course.type+'/'+this.selectedQuestion.course.id+'/lesson/'+this.selectedQuestion.lesson.id+'/discussion/answer/'+this.selectedQuestion.id, {
                    content: this.answer,
                    userId:this.userId
                }).then(response=>{
                    if(response.data.error){
                        UIkit.notification({message:response.data.message, status: 'danger'});
                    }else{
                        UIkit.notification({message:response.data.message, status: 'success'});
                        this.fetchData();
                    }
                }).catch((error)=>{
                    if(error.response) {
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }});
                this.clearForm();
                UIkit.modal('#answerArea').hide();
            },
            loadNewPage: function(pageNo){
                this.selectedPage=pageNo;
            }
        },
        mounted() {
            this.$store.dispatch('loadQuestionAnswerData', '/api/instructor/getNotAnsweredQuestions/'+this.userId);
        }
    }
</script>

<style scoped>
    h6{
        margin:0
    }

    .clickable{
        cursor: pointer;
    }

    textarea{
        resize:none;
    }

    .isAnswered{
        display:none;
    }
</style>
