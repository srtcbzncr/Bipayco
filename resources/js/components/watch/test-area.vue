<template>
    <div class="uk-width uk-margin-remove-bottom uk-padding">
        <!--question area-->
        <!--single choice-->
        <div v-if="questions[currentQuestion].type=='singleChoice'">
            <!--image??-->
            <div v-if="questions[currentQuestion].imgUrl" class="uk-background-center-center uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+questions[currentQuestion].imgUrl+')'}"></div>
            <!--question-->
            <p>{{questions[currentQuestion].text}}</p>
            <div v-for="(answer, index) in questions[currentQuestion].answers" class="uk-margin-top uk-child-width-1-2@m uk-grid align-items-center">
                <!--answers*-->
                <div v-if="answer.type=='text'" class="uk-flex align-items-center">
                    <input class="uk-radio uk-margin-small-right" type="radio" :name="'singleAnswer'+questions[currentQuestion].id">
                    <p>{{answer.content}}</p>
                </div>
                <div v-else class="uk-flex align-items-center">
                    <input class="uk-radio uk-margin-small-right" type="radio" :name="'singleAnswer'+questions[currentQuestion].id">
                    <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+answer.content+')'}"></div>
                </div>
            </div>
        </div>
        <!--multi choice-->
        <div v-else-if="questions[currentQuestion].type=='multiChoice'">
            <!--image??-->
            <div v-if="questions[currentQuestion].imgUrl" class="uk-background-center-center uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+questions[currentQuestion].imgUrl+')'}"></div>
            <!--question-->
            <p>{{questions[currentQuestion].text}}</p>
            <div class="uk-margin-top uk-child-width-1-2@m uk-grid align-items-center">
                <!--answers*-->
                <div v-for="(answer, index) in questions[currentQuestion].answers" class="uk-flex align-items-center">
                    <input class="uk-checkbox uk-margin-small-right" type="checkbox" :name="'multiAnswer'+questions[currentQuestion].id">
                    <p>{{answer.content}}</p>
                </div>
            </div>
        </div>
        <!--fill in the blanks-->
        <div v-else-if="questions[currentQuestion].type=='fillBlanks'">
            <!--image??-->
            <div v-if="questions[currentQuestion].imgUrl" class="uk-background-center-center uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+questions[currentQuestion].imgUrl+')'}"></div>
            <div class="uk-flex uk-flex-wrap align-items-center">
                <!--beginning of sentence-->
                <p>{{questions[currentQuestion].text}}</p>
                <!--blanks*
                    text*-->
                <div v-for="(answer, index) in questions[currentQuestion].answers">
                    <input class="uk-input uk-width-1-2@m uk-margin-small-left uk-margin-small-right">
                    <p>{{answer.after}}</p>
                </div>
            </div>
        </div>
        <!--true false-->
        <div v-else-if="questions[currentQuestion].type=='trueFalse'">
            <!--image??-->
            <div v-if="questions[currentQuestion].imgUrl" class="uk-background-center-center uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+questions[currentQuestion].imgUrl+')'}"></div>
            <!--question-->
            <p>{{questions[currentQuestion].text}}</p>
            <!--select true or false-->
            <div class="uk-flex align-items-center justify-content-around uk-margin-top">
                <div class="uk-flex align-items-center">
                    <input class="uk-radio uk-margin-remove" type="radio" name="isCorrect" value="1">
                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{trueText}}</p>
                </div>
                <div class="uk-flex align-items-center">
                    <input class="uk-radio uk-margin-remove" type="radio" name="isCorrect" value="0">
                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{falseText}}</p>
                </div>
            </div>
        </div>
        <!--order-->
        <div v-else-if="questions[currentQuestion].type=='order'">
            <!--image??-->
            <div v-if="questions[currentQuestion].imgUrl" class="uk-background-center-center uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+questions[currentQuestion].imgUrl+')'}"></div>
            <!--question-->
            <p>{{questions[currentQuestion].text}}</p>
            <!--elements*-->
            <div class="tm-course-section-list">
                <ul>
                    <li v-for="(answer, index) in questions[currentQuestion].answers" class="uk-card uk-card-default uk-padding-small uk-flex align-items-center justify-content-between">
                        <div class="uk-grid uk-margin-remove uk-padding-remove">
                            <p class="uk-text-truncate uk-margin-small-right uk-margin-remove-left uk-margin-remove-top uk-margin-remove-bottom">{{answer.content}}</p>
                        </div>
                        <div class="uk-margin-small-left uk-padding-remove uk-flex uk-flex-column uk-width-1-4">
                            <a @click="" v-if="index>1"><i class="fas fa-sort-up"></i></a>
                            <a @click="" v-if="index<questions[currentQuestion].length"><i class="fas fa-sort-down"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!--match-->
        <div v-else-if="questions[currentQuestion].type=='match'">
            <!--image??-->
            <div v-if="questions[currentQuestion].imgUrl" class="uk-background-center-center uk-background-cover uk-width-1-2 uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+questions[currentQuestion].imgUrl+')'}"></div>
            <!--question-->
            <p>{{questions[currentQuestion].text}}</p>
            <!--elements*-->
            <div v-for="(answer,index) in questions[currentQuestion].answers" class="uk-grid uk-child-width-1-2@m align-items-center">
                <!--first-->
                <div v-if="answer.type=='text'" class="uk-flex align-items-center">
                    <input class="uk-input uk-margin-remove" type="text" name="isCorrect" disabled :value="index+1">
                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{answer.content}}</p>
                </div>
                <!--second-->
                <div v-if="answer.type=='text'" class="uk-flex align-items-center">
                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{falseText}}</p>
                    <input class="uk-input uk-margin-remove" type="text" name="isCorrect" >
                </div>
            </div>
        </div>
        <div>
            <!--question paginate-->
            <ul class="uk-pagination uk-flex-center align-item-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
                <li>
                    <button v-show="currentQuestion>0" @click="currentQuestion--"> < </button>
                </li>
                <li>
                    <button class="uk-disabled" disabled>soru {{currentQuestion+1}}</button>
                </li>
                <li>
                    <button v-show="currentQuestion<questions.length-1" @click="currentQuestion++"> > </button>
                </li>
            </ul>
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
                questions:[{
                    type:"",
                    answers:{
                        type:"",
                        content:""
                    },
                },{
                    type:"",
                    answers:{
                        type:"",
                        content:""
                    },
                }],
            }
        },
        props:{
            trueText:{
                type:String,
                default:"Doğru"
            },
            falseText:{
                type:String,
                default:"Yanlış"
            }
        },
        computed:{
            ...mapState([

            ]),
        },
        methods:{
            ...mapActions([

            ]),
            loadData:function(data){
                console.log(data);
                this.questions=data;
            }
        },
        created(){
            /* Axios.post('/api/learn/prepareLessons/createFirstLastTestStatus/create', {'courseId':this.courseId, 'sectionId':this.selectedSection.id, 'userId':this.userId})
                .then(response=>this.loadData(response.data)) */
        },
    }
</script>

<style scoped>
    p{
        margin:0;
        margin-top:-5px;
    }

</style>
