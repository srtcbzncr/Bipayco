<template>
    <div class="uk-margin-medium-top">
        <ul uk-tab class="uk-margin-top uk-flex-center">
            <li><a @click="changeArea('waitingAnswer')">{{waitingAnswerText}}</a></li>
            <li><a @click="changeArea('answered')">{{answeredText}}</a></li>
        </ul>
        <div class="uk-background-default uk-padding-remove uk-margin-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="selectedArea.data&&selectedArea.data.length>0">
                    <tr>
                        <th>{{questionTitleText}}</th>
                        <th>{{courseNameText}}</th>
                        <th>{{studentNameText}}</th>
                    </tr>
                </thead>
                <tbody v-if="selectedArea.data&&selectedArea.data.length>0">
                    <tr v-for="(item,index) in selectedArea.data" @click="openInfo(index)" class="clickable">
                        <td class="uk-width-1-2"><p>{{item.title}}</p></td>
                        <td class="uk-width-1-4"><p>{{item.course.name}}</p></td>
                        <td class="uk-width-1-4"><p>{{item.student.first_name}} {{item.student.last_name}}</p></td>
                    </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{haveNoQuestionText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="selectedArea.data&&selectedArea.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="selectedArea.current_page>1" @click="loadNewPage(Number(selectedArea.current_page)-1)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==selectedArea.current_page" class="uk-background-default uk-disabled" @click="loadNewPage(page)">{{page}}</button>
                <button v-else @click="loadNewPage(page)">{{page}}</button>
            </li>
            <li>
                <button v-show="selectedArea.current_page<selectedArea.last_page" @click="loadNewPage(Number(selectedArea.current_page)+1)"> > </button>
            </li>
        </ul>
        <div id="answerArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{selectedQuestion.title}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <!-- question area -->

                    <!-- answer area -->
                    <div>
                        <div class="uk-margin-bottom">
                            <div class="uk-form-label">{{answerText}}</div>
                            <textarea v-model="answer" class="uk-width uk-textarea" :placeholder="letsAnswerText"></textarea>
                        </div>
                        <button class="uk-button uk-button-default uk-modal-close" @click="clearForm" type="button">{{cancelText}}</button>
                        <button class="uk-button uk-button-success" type="button" @click="saveItem">{{sendText}}</button>
                    </div>
                    <!-- answered text area -->
                    <div>

                    </div>
                </div>

                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">{{closeText}}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    export default {
        name: "questions-page",
        data(){
            return{
                selectedArea:[],
                selectedQuestionIndex:"",
                selectedQuestion:{},
                selectedUrl:'/api/instructor/getNotAnsweredQuestions',
                selectedAreaName:"waitingAnswer",
                selectedPage:'0',
                answer:"",
            }
        },
        props:{
            userId:{
                type:String,
                required:true,
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
                this.selectedPage="0";
                if(this.selectedAreaName=='waitingAnswer'){
                    this.selectedUrl='/api/instructor/getNotAnsweredQuestions';
                }else{
                    this.selectedUrl='/api/instructor/getAnsweredQuestions';
                }
            },
            selectedUrl(){
                this.fetchData();
            },
            selectedQuestionIndex(){
                this.selectedQuestion=this.selectedArea.data[this.selectedQuestionIndex];
            }
        },
        computed:{
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.selectedArea.last_page; i++){
                    if(i==2 && this.selectedArea.current_page-2>3){
                        pages.push('...');
                        if(this.selectedArea.current_page+3>this.selectedArea.last_page){
                            index=this.selectedArea.last_page-6;
                        }else{
                            index=this.selectedArea.current_page-2;
                        }
                    }else if(i==8 && this.selectedArea.current_page+2<this.selectedArea.last_page-2){
                        pages.push('...');
                        index=this.selectedArea.last_page;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
        },
        methods:{
            fetchData:function(){
                Axios.get(this.selectedUrl+'/'+this.userId+'?page='+this.selectedPage)
                    .then((res)=>{this.selectedArea=res.data.data});
            },
            changeArea:function(name){
                this.selectedAreaName=name;
            },
            // deleteItem:function (id) {
            //     Axios.post('/api/guardian/deleteStudent/'+this.userId+'/'+id)
            //         .then(response=>{
            //             if(response.data.error){
            //                 UIkit.notification({message:response.data.message, status: 'danger'});
            //             }else{
            //                 UIkit.notification({message:response.data.message, status: 'success'});
            //                 this.$store.dispatch('loadGuardianNewPage', this.selectedPage)
            //             }
            //         });
            // },
            openInfo:function (index) {
                this.selectedQuestionIndex=index;
                UIkit.modal('#answerArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function(){
                this.answer="";
            },
            // /api/learn/generalEducation/{course_id}/lesson/{lesson_id}/discussion/answer/{question_id}
            saveItem:function () {
                Axios.post('/api/learn/'+this.selectedQuestion.course.course_type+'/'+this.selectedQuestion.course.id+'/lesson/'+this.selectedQuestion.lesson.id+'/discussion/answer/'+this.selectedQuestion.id, {
                    answer: this.answer,
                    instructorUserId:this.userId,
                }).then(response=>{
                    if(response.data.error){
                        UIkit.notification({message:response.data.message, status: 'danger'});
                    }else{
                        UIkit.notification({message:response.data.message, status: 'success'});
                        this.fetchData();
                    }
                });
                this.clearForm();
                UIkit.modal('#answerArea').hide();
            },
            loadNewPage: function(pageNo){
                this.selectedPage=pageNo;
                this.fetchData();
            }
        },
        created() {
            this.fetchData();
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
</style>
