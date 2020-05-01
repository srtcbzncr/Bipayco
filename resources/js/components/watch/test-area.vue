<template>
    <div class="uk-width uk-margin-remove-bottom uk-padding">
        <!--question area-->
        <div v-for="(question, questionIndex) in questions">
            <!--single choice-->
            <div v-show="currentQuestion==questionIndex" v-if="question.type=='singleChoice'">
                <!--image??-->
                <div v-if="question.imgUrl" class="uk-background-center-center uk-margin-bottom uk-background-cover uk-width-1-2@m uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+question.imgUrl+')'}"></div>
                <!--question-->
                <h5>{{questionText}} {{questionIndex+1}}: {{question.text}}</h5>
                <div class="uk-margin-top uk-child-width-1-2@m uk-grid uk-width align-items-center">
                    <!--answers*-->
                    <div v-for="(answer, answerIndex) in question.answers" class="uk-margin-top">
                        <div v-if="answer.type=='text'" class="uk-flex align-items-center">
                            <input class="uk-radio uk-margin-small-right" type="radio" v-model="data[questionIndex].answer" :value="answer.id">
                            <p>{{answer.content}}</p>
                        </div>
                        <div v-else class="uk-flex align-items-center">
                            <input class="uk-radio uk-margin-small-right" type="radio" v-model="data[questionIndex].answer" :value="answer.id">
                            <div class="uk-background-center-center uk-background-cover uk-width uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+answer.content+')'}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--multi choice-->
            <div v-else-if="question.type=='multiChoice'" v-show="currentQuestion==questionIndex">
                <!--image??-->
                <div v-if="question.imgUrl" class="uk-background-center-center uk-margin-bottom uk-background-cover uk-width-1-2@m uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+question.imgUrl+')'}"></div>
                <!--question-->
                <h5>{{questionText}} {{questionIndex+1}}: {{question.text}}</h5>
                <div class="uk-margin-top uk-child-width-1-2@m uk-grid align-items-center">
                    <!--answers*-->
                    <div v-for="(answer, answerIndex) in question.answers" class="uk-margin-top">
                        <div v-if="answer.type=='text'" class="uk-flex align-items-center">
                            <input class="uk-checkbox uk-margin-small-right" type="checkbox" v-model="data[questionIndex].answer" :value="answer.id">
                            <p>{{answer.content}}</p>
                        </div>
                        <div v-else class="uk-flex align-items-center">
                            <input class="uk-checkbox uk-margin-small-right" type="checkbox" v-model="data[questionIndex].answer" :value="answer.id">
                            <div class="uk-background-center-center uk-background-cover uk-width uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+answer.content+')'}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--fill in the blanks-->
            <div v-else-if="question.type=='fillBlank'" v-show="currentQuestion==questionIndex">
                <!--image??-->
                <div v-if="question.imgUrl" class="uk-background-center-center uk-margin-bottom uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+question.imgUrl+')'}"></div>
                <h5>{{questionText}} {{questionIndex+1}}: {{fillBlanksText}}</h5>
                <div v-for="(answer, index) in question.answers" class="uk-flex uk-flex-wrap align-items-center">
                    <!--beginning of sentence-->
                    <p v-if="index==0">{{question.text}}</p>
                    <!--blanks*
                        text*-->
                    <input class="uk-input uk-width-1-4@m uk-margin-small-left uk-margin-small-right"  v-model.trim="data[questionIndex].answer[index].content">
                    <p>{{answer.after}}</p>
                </div>
            </div>
            <!--true false-->
            <div v-else-if="question.type=='trueFalse'" v-show="questionIndex==currentQuestion">
                <!--image??-->
                <div v-if="question.imgUrl" class="uk-background-center-center uk-margin-bottom uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+question.imgUrl+')'}"></div>
                <!--question-->
                <h5>{{questionText}} {{questionIndex+1}}: {{question.text}}</h5>
                <!--select true or false-->
                <div class="uk-flex align-items-center justify-content-around uk-margin-top">
                    <div class="uk-flex align-items-center">
                        <input class="uk-radio uk-margin-remove" type="radio" v-model="data[questionIndex].answer" :value="1">
                        <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{trueText}}</p>
                    </div>
                    <div class="uk-flex align-items-center">
                        <input class="uk-radio uk-margin-remove" type="radio"  v-model="data[questionIndex].answer" :value="0">
                        <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{falseText}}</p>
                    </div>
                </div>
            </div>
            <!--order-->
            <div v-else-if="question.type=='order'" v-show="currentQuestion==questionIndex">
                <!--image??-->
                <div v-if="question.imgUrl" class="uk-background-center-center uk-margin-bottom uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+question.imgUrl+')'}"></div>
                <!--question-->
                <h5>{{questionText}} {{questionIndex+1}}: {{question.text}}</h5>
                <!--elements*-->
                <div class="tm-course-section-list">
                    <ul>
                        <li v-for="(answer, index) in question.answers" class="uk-card uk-card-default uk-padding-small uk-flex align-items-center justify-content-between">
                            <div class="uk-margin-remove uk-padding-remove">
                                <p class="uk-text-truncate uk-margin-small-right uk-margin-remove-left uk-margin-remove-top uk-margin-remove-bottom">{{answer.content}}</p>
                            </div>
                            <div class=" uk-padding-remove uk-flex uk-flex-column">
                                <button @click="itemUp(questionIndex,index)" class="uk-button uk-icon-button uk-padding-remove align-item-center" v-if="index>0"><i class="fas fa-sort-up"></i></button>
                                <button @click="itemDown(questionIndex,index)" class="uk-button uk-icon-button uk-padding-remove align-item-center" v-if="index<question.answers.length-1"><i class="fas fa-sort-down"></i></button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--match-->
            <div v-else-if="question.type=='match'" v-show="currentQuestion==questionIndex">
                <!--image??-->
                <div v-if="question.imgUrl" class="uk-background-center-center uk-margin-bottom uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+question.imgUrl+')'}"></div>
                <!--question-->
                <h5>{{questionText}} {{questionIndex+1}}: {{question.text}}</h5>
                <!--elements*-->
                <div v-for="(answer,index) in question.answers.answers" class="uk-flex align-items-center justify-content-between">
                    <!--first-->
                    <div v-if="answer.answer.type=='text'" class="uk-flex align-items-center uk-margin-bottom uk-margin-right">
                        <input class="uk-input number uk-margin-remove text-center" type="text" disabled :value="(index+1)">
                        <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{answer.answer.answer}}</p>
                    </div>
                    <!--second-->
                    <div v-if="answer.answer.type=='text'" class="uk-flex align-items-center uk-margin-bottom">
                        <p class="uk-margin-small-right uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-left">{{question.answers.contents[index].content.content}}</p>
                        <select v-model="data[questionIndex].answer[index].id" class="uk-select number">
                            <option v-for="(content,index) in question.answers.answers" :value="content.answer.id">{{index+1}}</option>
                        </select>
                    </div>
                    <div v-if="answer.answer.type=='image'" class="uk-flex align-items-center uk-margin-bottom uk-margin-right uk-width">
                        <input class="uk-input number uk-margin-remove text-center" type="text" disabled :value="(index+1)">
                        <div class="uk-background-center-center uk-margin-small-left uk-background-cover uk-width uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+answer.answer.answer+')'}"></div>
                    </div>
                    <!--second-->
                    <div v-if="answer.answer.type=='image'" class="uk-flex align-items-center uk-margin-bottom uk-width">
                        <div class="uk-background-center-center uk-margin-small-right uk-background-cover uk-width uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+question.answers.contents[index].content.content+')'}"></div>
                        <select v-model="data[questionIndex].answer[index].id" class="uk-select number">
                            <option v-for="(content,index) in question.answers.answers" :value="content.answer.id">{{index+1}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-margin-medium-top">
            <!--question paginate-->
            <ul class="uk-pagination uk-flex-center align-item-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
                <li>
                    <button v-show="currentQuestion>0" @click="currentQuestion--"> < </button>
                </li>
                <li>
                    <button class="uk-disabled" disabled>{{questionText}} {{currentQuestion+1}}</button>
                </li>
                <li>
                    <button v-show="currentQuestion<questions.length-1" @click="currentQuestion++"> > </button>
                </li>
            </ul>
            <button v-show="currentQuestion>=questions.length-1 && questions.length!=0" @click="postData" class="uk-button-success uk-button uk-float-right">{{endTestText}}</button>
        </div>
    </div>
</template>

<script>
    import {mapActions,mapState} from 'vuex'
    import Axios from 'axios'
    export default {
        name: "test-area",
        data(){
            return{
                currentQuestion:0,
                questions:[],
                data:[]
            }
        },
        props:{
            subjectId:{
                type:Number,
                required:true
            },
            lessonId:{
                type:Number,
                required:true
            },
            testType:{
                type:String,
                required:true
            },
            sectionId:{
                type:Number,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
            },
            userId:{
                type:String,
                required:true,
            },
            courseId:{
                type:String,
                required:true,
            },
            trueText:{
                type:String,
                default:"Doğru"
            },
            falseText:{
                type:String,
                default:"Yanlış"
            },
            questionText:{
                type:String,
                default:"Soru"
            },
            endTestText:{
                type:String,
                default:"Testi Sonlandır"
            },
            fillBlanksText:{
                type:String,
                default:"Boşlukları Doldur"
            },
            successMessage:{
                type:String,
                default:"Tebrikler sınavı başarıyla geçtin."
            },
            failedMessage:{
                type:String,
                default:"Maalesef Sınavı geçemedin. Tekrar denemelisin."
            }
        },
        methods:{
            loadData:function(data){
                this.questions=data;
                for(var i=0; i<data.length; i++){
                    switch(data[i].type){
                        case 'singleChoice':{
                            this.data.push({'questionId':data[i].id, 'answer':''});
                            break;
                        }
                        case 'multiChoice':{
                            this.data.push({'questionId':data[i].id, 'answer':[]});
                            break;
                        }
                        case 'trueFalse':{
                            this.data.push({'questionId':data[i].id, 'answer':''});
                            break;
                        }
                        case 'fillBlank':{
                            var answer=[];
                            for(var j=0; j<data[i].answers.length; j++){
                                answer.push({'id':data[i].answers[j].id, 'content':''})
                            }
                            this.data.push({'questionId':data[i].id, 'answer':answer});
                            break;
                        }
                        case 'match':{
                            var items=[];
                            for(var j=0; j<data[i].answers.contents.length; j++){
                                items.push({'content':data[i].answers.contents[j].content, 'id':''});
                            }
                            this.data.push({'questionId':data[i].id, 'answer':items});
                            break;
                        }
                        case 'order':{
                            var items=[];
                            for(var j=0; j<data[i].answers.length; j++){
                                items.push(data[i].answers[j].id);
                            }
                            this.data.push({'questionId':data[i].id, 'answer':items});
                            break;
                        }
                    }
                }
            },
            itemUp:function (questionIndex, answerIndex) {
                var changedArray=[], changedDataArray=[];
                for(var i=0; i<this.questions[questionIndex].answers.length;i++){
                    switch (i) {
                        case answerIndex-1:{
                            changedArray.push(this.questions[questionIndex].answers[i+1]);
                            changedDataArray.push(this.data[questionIndex].answer[i+1]);
                            break;
                        }
                        case answerIndex:{
                            changedArray.push(this.questions[questionIndex].answers[i-1]);
                            changedDataArray.push(this.data[questionIndex].answer[i-1]);
                            break;
                        }
                        default:{
                            changedArray.push(this.questions[questionIndex].answers[i]);
                            changedDataArray.push(this.data[questionIndex].answer[i]);
                        }
                    }
                }
                this.questions[questionIndex].answers=changedArray;
                this.data[questionIndex].answer=changedDataArray;
            },
            itemDown:function (questionIndex, answerIndex) {
                var changedArray=[], changedDataArray=[];
                for(var i=0; i<this.questions[questionIndex].answers.length;i++){
                    switch (i) {
                        case answerIndex+1:{
                            changedArray.push(this.questions[questionIndex].answers[i-1]);
                            changedDataArray.push(this.data[questionIndex].answer[i-1]);
                            break;
                        }
                        case answerIndex:{
                            changedArray.push(this.questions[questionIndex].answers[i+1]);
                            changedDataArray.push(this.data[questionIndex].answer[i+1]);
                            break;
                        }
                        default:{
                            changedArray.push(this.questions[questionIndex].answers[i]);
                            changedDataArray.push(this.data[questionIndex].answer[i]);
                        }
                    }
                }
                this.questions[questionIndex].answers=changedArray;
                this.data[questionIndex].answer=changedDataArray;
            },
            postData:function () {
                Axios.post('/api/learn/prepareLessons/createFirstLastTestStatus/create',{'userId':this.userId, 'sectionType':this.moduleName, 'sectionId':this.sectionId, 'testType':this.testType, 'courseId':this.courseId, 'answers':this.data})
                    .then(response=>{
                        if(!response.error){
                            if(response.data.data.result){
                                UIkit.notification({message:this.successMessage, status: 'success'});
                                setTimeout(()=>{window.location.replace('/learn/pl/course/'+this.courseId+'/lesson/'+response.data.data.nextLessonId);},3000);
                            }else{
                                UIkit.notification({message:this.failedMessage, status: 'danger'});
                                setTimeout(()=>{window.location.replace('/learn/pl/course/'+this.courseId+'/lesson/'+response.data.data.nextLessonId);},3000);
                            }
                        }
                    });
            }
        },
        created(){
            Axios.get('/api/learn/prepareLessons/getRandomQuestions/'+this.courseId+'/'+this.lessonId+'/'+this.subjectId)
                .then(response=>this.loadData(response.data.data.questions))
        },
    }
</script>

<style scoped>
    p{
        margin:0;
        margin-top:-5px;
    }
    .number{
        padding:5px !important;
        width: 50px;
    }
</style>
