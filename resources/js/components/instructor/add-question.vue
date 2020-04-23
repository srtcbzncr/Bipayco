<template>
    <div>
        <div class="uk-grid uk-child-width-1-3@m">
            <div>
                <div class="uk-form-label"> {{lessonText}} </div>
                <select class='uk-select uk-margin-right' v-model="selectedLessonId" @change="loadSubjects" required>
                    <option disabled hidden value="">{{chooseLessonText}}</option>
                    <option v-for='lesson in plLessonType.lesson' :value='lesson.id'>{{lesson.name}}</option>
                </select>
            </div>
            <div>
                <div class="uk-form-label"> {{subjectText}} </div>
                <select class="uk-select" v-model="selectedSubjectId" required>
                    <option disabled hidden value="">{{chooseSubjectText}}</option>
                    <option v-for='subject in courseSubjects' :value='subject.id'>{{subject.name}}</option>
                </select>
            </div>
            <div>
                <div class="uk-form-label"> {{levelText}} </div>
                <select class="uk-select" v-model="questionLevel" required>
                    <option disabled hidden value="">{{chooseLevelText}}</option>
                    <option value="1">{{easyText}}</option>
                    <option value="2">{{mediumText}}</option>
                    <option value="3">{{hardText}}</option>
                </select>
            </div>
        </div>
        <div class="uk-form-label"> {{questionTypeText}}</div>
        <select class="uk-width uk-select" v-model="questionType">
            <option selected disabled hidden value="">{{chooseQuestionTypeText}}</option>
            <option value="singleChoice">{{singleChoiceText}}</option>
            <option value="multiChoice">{{multiChoiceText}}</option>
            <option value="fillBlank">{{fillBlankText}}</option>
            <option value="trueFalse">{{trueFalseText}}</option>
            <option value="match">{{matchingText}}</option>
            <option value="order">{{rankingText}}</option>
        </select>
        <div v-if="questionType=='singleChoice'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" id="singleQuestionImgPreview" :style="{'background-image': 'url('+ previewUrl+')'}"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="singleQuestionImg" @change="previewImage('singleQuestionImg', 'singleQuestionImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-form-label"> {{questionText}} </div>
            <textarea class="uk-height-small uk-textarea uk-overflow-auto" id="singleQuestion" v-model="text" required></textarea>
            <div >
                <div class="uk-form-label"> {{answerTypeText}} </div>
                <select v-model="singleAnswerType"  class="uk-width uk-select">
                    <option value="" hidden disabled selected>{{chooseAnswerTypeText}}</option>
                    <option value="withImage">{{withImage}}</option>
                    <option value="withText">{{withText}}</option>
                </select>
                <div v-if="singleAnswerType=='withImage'" class="uk-margin-top">
                    <div class="uk-margin">
                        <div class="uk-form-label"> {{correctAnswerText}} </div>
                        <div>
                            <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" id="singleCorrectAnswerImgPreview" :style="{'background-image': 'url('+ correctAnswerImage+')'}"></div>
                        </div>
                        <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                            <input name="image" type="file" accept="image/*" id="singleCorrectAnswerImg" @change="previewImage('singleCorrectAnswerImg', 'singleCorrectAnswerImgPreview')" >
                            <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                        </div>
                        <div v-if="singleAnswersImg.length>0" class="uk-form-label"> {{wrongAnswerImageText}} </div>
                        <div v-for="(singleAnswer, singleIndex) in singleAnswersImg" class="uk-flex align-items-center uk-margin">
                            <div class="uk-margin-right uk-margin-left">
                                <i class="fas fa-trash-alt text-danger" @click="singleAnswersImg.splice(singleIndex,1)"></i>
                            </div>
                            <div class="uk-width">
                                <div>
                                    <input type="text" value=""  hidden disabled>
                                    <div v-if="singleAnswer.content!=''" class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'singleAnswerImgPreview'+singleIndex" :style="{'background-image': 'url('+ singleAnswer.content+')'}"></div>
                                    <div v-else class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'singleAnswerImgPreview'+singleIndex" :style="{'background-image': 'url('+ defaultImagePath+')'}"></div>
                                </div>
                                <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                    <input name="image" type="file" accept="image/*" :id="'singleAnswerImg'+singleIndex" @change="pushImage('singleQuestion', singleIndex,'singleAnswerImg'+singleIndex,'singleAnswerImgPreview'+singleIndex)">
                                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button" @click="singleAnswersImg.push({content:'', type:'image', isCorrect:'false'})"> <i class="fas fa-plus"></i> {{addWrongAnswerText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addSingleChoiceImgQuestion"> {{saveText}} </button>
                </div>
                <div v-if="singleAnswerType=='withText'" class="uk-margin-top">
                    <div class="uk-margin">
                        <div class="uk-form-label"> {{correctAnswerText}} </div>
                        <input type="text" class="uk-input uk-width" id="singleCorrectAnswer" v-model="correctAnswer">
                    </div>
                    <div v-if="singleAnswers.length>0" class="uk-form-label"> {{wrongAnswersText}} </div>
                    <div v-for="(singleAnswer,singleIndex) in singleAnswers" class="uk-flex align-items-center uk-margin">
                        <div class="uk-margin-right uk-margin-left">
                            <i class="fas fa-trash-alt text-danger" @click="singleAnswers.splice(singleIndex,1)"></i>
                        </div>
                        <div class=" uk-width">
                            <input class="uk-input uk-width" v-model="singleAnswer.content" type="text" required>
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button" @click="singleAnswers.push({content:'', type:'text', isCorrect:'false'})"> <i class="fas fa-plus"></i> {{addWrongAnswerText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addSingleChoiceTextQuestion"> {{saveText}} </button>
                </div>
            </div>
        </div>
        <div v-if="questionType=='multiChoice'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" id="multiQuestionImgPreview" :style="{'background-image': 'url('+ previewUrl+')'}"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="multiQuestionImg" @change="previewImage('multiQuestionImg', 'multiQuestionImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-form-label"> {{questionText}} </div>
            <textarea class="uk-height-small uk-textarea uk-overflow-auto" id="multiQuestion" v-model="text" required></textarea>
            <div>
                <div class="uk-form-label"> {{answerTypeText}} </div>
                <select v-model="multiAnswerType"  class="uk-width uk-select">
                    <option value="" hidden disabled>{{chooseAnswerTypeText}}</option>
                    <option value="withImage">{{withImage}}</option>
                    <option value="withText">{{withText}}</option>
                </select>
                <div v-if="multiAnswerType=='withImage'" class="uk-margin-top">
                    <div class="uk-margin">
                        <div v-if="multiAnswersImg.legth>0" class="uk-form-label"> {{answerImageText}} </div>
                        <div v-for="(multiAnswer, multiIndex) in multiAnswersImg" class="uk-flex align-items-center uk-margin">
                            <div class="uk-margin-right uk-margin-left">
                                <i class="fas fa-trash-alt text-danger" @click="multiAnswersImg.splice(multiIndex,1)"></i>
                            </div>
                            <div class="uk-width">
                                <div>
                                    <div v-if="multiAnswer.content!=''" class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'multiAnswerImgPreview'+multiIndex" :style="{'background-image': 'url('+ multiAnswer.content+')'}"></div>
                                    <div v-else class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'multiAnswerImgPreview'+multiIndex" :style="{'background-image': 'url('+ defaultImagePath+')'}"></div>
                                </div>
                                <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                    <input name="image" type="file" accept="image/*" :id="'multiAnswerImg'+multiIndex" @change="pushImage('multiQuestion', multiIndex,'multiAnswerImg'+multiIndex,'multiAnswerImgPreview'+multiIndex)">
                                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                </div>
                            </div>
                            <div class="uk-margin-right uk-margin-left">
                                <input type="checkbox" class="uk-checkbox" v-model="multiAnswer.isCorrect">
                            </div>
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button" @click="multiAnswersImg.push({content:'', isCorrect:false, type:'image'})"> <i class="fas fa-plus"></i> {{addAnswerText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addMultiChoiceImgQuestion"> {{saveText}} </button>
                </div>
                <div v-if="multiAnswerType=='withText'" class="uk-margin-top">
                    <div v-if="multiAnswers.length>0" class="uk-form-label"> {{answersText}} </div>
                    <div v-for="(multiAnswer, multiIndex) in multiAnswers" class="uk-flex align-items-center uk-margin">
                        <div class="uk-margin-right uk-margin-left">
                            <i class="fas fa-trash-alt text-danger" @click="multiAnswers.splice(multiIndex,1)"></i>
                        </div>
                        <div class=" uk-width">
                            <input class="uk-input uk-width" v-model="multiAnswer.content" type="text" required>
                        </div>
                        <div class="uk-margin-right uk-margin-left">
                            <input type="checkbox" class="uk-checkbox" v-model="multiAnswer.isCorrect">
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button" @click="multiAnswers.push({content:'', isCorrect:false, type:'text'})"> <i class="fas fa-plus"></i> {{addAnswerText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addMultiChoiceTextQuestion"> {{saveText}} </button>
                </div>
            </div>
        </div>
        <div v-if="questionType=='fillBlank'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <input type="text" value="" hidden disabled>
                <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" id="blankImgPreview" :style="{'background-image': 'url('+ previewUrl+')'}"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="blankImg" @change="previewImage('blankImg', 'blankImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-margin-bottom">
                <div class="uk-form-label"> {{questionText}} </div>
                <textarea class="uk-height-small uk-textarea uk-overflow-auto" id="blankQuestion" v-model="text" required></textarea>
            </div>
            <div>
                <div v-for="(blank,blankIndex) in blanks" class="uk-flex align-items-center uk-margin">
                    <div class="uk-margin-right uk-margin-left">
                        <i class="fas fa-trash-alt text-danger" @click="blanks.splice(blankIndex,1)"></i>
                    </div>
                    <div class="uk-width">
                        <div class="uk-form-label"> {{answerText}} </div>
                        <input class="uk-input uk-width uk-margin-bottom" v-model.trim="blank.answer" type="text" required>
                        <div class="uk-form-label"> {{afterBlankText}} </div>
                        <textarea class="uk-height-small uk-textarea uk-overflow-auto" v-model="blank.after" required></textarea>
                    </div>
                </div>
                <button class="uk-width uk-button-success uk-button" @click="blanks.push({answer:'', after:''})"> <i class="fas fa-plus"></i> {{addBlankAreaText}}</button>
                <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addFillBlankQuestion"> {{saveText}} </button>
            </div>
        </div>
        <div v-if="questionType=='trueFalse'" class="uk-margin-top">
            <div class="uk-margin-top">
                <div class="uk-form-label"> {{questionImageText}} </div>
                <div>
                    <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" id="trueFalseImgPreview" :style="{'background-image': 'url('+ previewUrl+')'}"></div>
                </div>
                <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                    <input name="image" type="file" accept="image/*" id="trueFalseImg" @change="previewImage('trueFalseImg', 'trueFalseImgPreview')" >
                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                </div>
                <div class="uk-margin-bottom">
                    <div class="uk-form-label"> {{phraseText}} </div>
                    <textarea class="uk-height uk-textarea uk-overflow-auto" id="trueFalseQuestion" v-model="text" required></textarea>
                </div>
                <div class="uk-margin-bottom">
                    <div class="uk-flex align-items-center justify-content-around">
                        <div class="uk-flex align-items-center">
                            <input class="uk-radio uk-margin-remove" type="radio" name="isCorrect" value="1" checked @click="isCorrect=1">
                            <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{trueText}}</p>
                        </div>
                        <div class="uk-flex align-items-center">
                            <input class="uk-radio uk-margin-remove" type="radio" name="isCorrect" value="0" @click="isCorrect=0">
                            <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{falseText}}</p>
                        </div>
                    </div>
                </div>
                <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addTrueFalseQuestion"> {{saveText}} </button>
            </div>
        </div>
        <div v-if="questionType=='order'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" id="rankingQuestionImgPreview" :style="{'background-image': 'url('+ previewUrl+')'}"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="rankingQuestionImg" @change="previewImage('rankingQuestionImg', 'rankingQuestionImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-form-label"> {{questionText}} </div>
            <textarea class="uk-height-small uk-textarea uk-overflow-auto" id="rankingQuestion" v-model="text" required></textarea>
            <div class="uk-margin-top">
                <div v-if="rankingAnswers.length>0" class="uk-form-label"> {{phrasesText}} </div>
                <div v-for="(rankingAnswer, rankingIndex) in rankingAnswers" class="uk-flex align-items-center uk-margin">
                        <div class="uk-margin-right uk-margin-left">
                            <i class="fas fa-trash-alt text-danger" @click="rankingAnswers.splice(rankingIndex,1)"></i>
                        </div>
                        <div class="uk-margin-right">
                            <p class="uk-margin-remove uk-padding-remove">{{rankingIndex+1}}.{{rankText}}</p>
                        </div>
                        <div class="uk-width">
                            <input class="uk-input uk-width" v-model="rankingAnswer.content" type="text" required>
                        </div>
                </div>
                <button class="uk-width uk-button-success uk-button" @click="rankingAnswers.push({content:''})"> <i class="fas fa-plus"></i> {{addPhraseText}}</button>
                <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addRankingQuestion"> {{saveText}} </button>
            </div>
        </div>
        <div v-if="questionType=='match'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <div class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" id="matchingQuestionImgPreview" :style="{'background-image': 'url('+ previewUrl+')'}"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="matchingQuestionImg" @change="previewImage('matchingQuestionImg', 'matchingQuestionImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-form-label"> {{questionText}} </div>
            <textarea class="uk-height-small uk-textarea uk-overflow-auto" id="matchingQuestion" v-model="text" required></textarea>
            <div>
                <div class="uk-form-label"> {{answerTypeText}} </div>
                <select v-model="matchingAnswerType"  class="uk-width uk-select">
                    <option value="" hidden disabled selected>{{chooseAnswerTypeText}}</option>
                    <option value="withImage">{{withImage}}</option>
                    <option value="withText">{{withText}}</option>
                </select>
                <div v-if="matchingAnswerType=='withImage'" class="uk-margin-top">
                    <div class="uk-margin">
                        <div v-if="matchingAnswersImg.legth>0" class="uk-form-label"> {{answerImageText}} </div>
                        <div v-for="(matchingAnswer, matchingIndex) in matchingAnswersImg" class="uk-flex align-items-center uk-margin">
                            <div class="uk-grid uk-width uk-child-width-1-2@m">
                                <div class="">
                                    <div class="uk-form-label">{{firstPhraseText}}</div>
                                    <div>
                                        <div v-if="matchingAnswer.first!=''" class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'matchingAnswerFirstImgPreview'+matchingIndex" :style="{'background-image': 'url('+ matchingAnswer.first+')'}"></div>
                                        <div v-else class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'matchingAnswerFirstImgPreview'+matchingIndex" :style="{'background-image': 'url('+defaultImagePath+')'}"></div>
                                    </div>
                                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                        <input name="image" type="file" accept="image/*" :id="'matchingAnswerFirstImg'+matchingIndex" @change="pushImage('matchingQuestionFirst', matchingIndex,'matchingAnswerFirstImg'+matchingIndex,'matchingAnswerFirstImgPreview'+matchingIndex)">
                                        <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="uk-form-label">{{secondPhraseText}}</div>
                                    <div>
                                        <div v-if="matchingAnswer.second!=''" class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'matchingAnswerSecondImgPreview'+matchingIndex" :style="{'background-image': 'url('+ matchingAnswer.second+')'}"></div>
                                        <div v-else class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :id="'matchingAnswerFirstImgPreview'+matchingIndex" :style="{'background-image': 'url('+defaultImagePath+')'}"></div>
                                    </div>
                                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                        <input name="image" type="file" accept="image/*" :id="'matchingAnswerSecondImg'+matchingIndex" @change="pushImage('matchingQuestionSecond', matchingIndex,'matchingAnswerSecondImg'+matchingIndex,'matchingAnswerSecondImgPreview'+matchingIndex)">
                                        <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small-left uk-margin-medium-top">
                                <i class="fas fa-trash-alt text-danger" @click="matchingAnswersImg.splice(matchingIndex,1)"></i>
                            </div>
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button" @click="matchingAnswersImg.push({first:'', second:'', type:'image'})"> <i class="fas fa-plus"></i> {{addAnswerText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addMatchingImgQuestion"> {{saveText}} </button>
                </div>
                <div v-if="matchingAnswerType=='withText'" class="uk-margin-top">
                    <div v-if="matchingAnswers.length>0" class="uk-form-label"> {{phrasesText}} </div>
                    <div v-for="(matching, matchingIndex) in matchingAnswers" class="uk-flex align-items-center uk-margin-bottom">
                        <div class="uk-grid uk-width uk-child-width-1-2@m">
                            <div class="">
                                <div class="uk-form-label">{{firstPhraseText}}</div>
                                <input class="uk-input uk-width" v-model="matching.first" type="text" required>
                            </div>
                            <div class="">
                                <div class="uk-form-label">{{secondPhraseText}}</div>
                                <input class="uk-input uk-width" v-model="matching.second" type="text" required>
                            </div>
                        </div>
                        <div class="uk-margin-small-left uk-margin-medium-top">
                            <i class="fas fa-trash-alt text-danger" @click="matchingAnswers.splice(matchingIndex,1)"></i>
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button" @click="matchingAnswers.push({first:'', second:'', type:'text'})"> <i class="fas fa-plus"></i> {{addPhraseText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addMatchingTextQuestion"> {{saveText}} </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Axios from 'axios'
    import {mapActions, mapState} from "vuex";
    export default {
        name: "add-question",
        data(){
            return{
                text:"",
                selectedLessonId:"",
                selectedSubjectId:"",
                questionLevel:"",
                questionType:"",
                singleAnswerType:"",
                multiAnswerType:"",
                singleAnswers:[],
                singleAnswersImg:[],
                multiAnswers:[],
                multiAnswersImg:[],
                blanks:[],
                isCorrect:1,
                rankingAnswers:[],
                matchingAnswers:[],
                matchingAnswersImg:[],
                matchingAnswerType:"",
                imgUrl:"",
                correctAnswerImage:"",
                correctAnswer:"",
            }
        },
        props:{
            defaultImagePath:{
                type:String,
                required:true,
            },
            questionText:{
                type:String,
                default:"Soru"
            },
            questionTypeText:{
                type:String,
                default:"Soru Tipi"
            },
            chooseQuestionTypeText:{
                type:String,
                default:"Soru Tipi Seçiniz"
            },
            singleChoiceText:{
                type:String,
                default:"Çoktan Seçmeli"
            },
            multiChoiceText:{
                type:String,
                default:"Çoklu Seçmeli"
            },
            fillBlankText:{
                type:String,
                default:"Boşluk Doldurma"
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            selectFileText:{
                type:String,
                default:"Dosya Seç"
            },
            questionImageText:{
                type:String,
                default:"Soru Resmi"
            },
            answerTypeText:{
                type:String,
                default:"Cevap Tipi"
            },
            chooseAnswerTypeText:{
                type:String,
                default:"Cevap Tipi Seçiniz"
            },
            withImage:{
                type:String,
                default:"Resimli"
            },
            withText:{
                type:String,
                default:"Yazılı"
            },
            correctAnswerText:{
                type:String,
                default:"Doğru Cevap"
            },
            addWrongAnswerText:{
                type:String,
                default:"Yanlış Cevap Ekle"
            },
            wrongAnswersText:{
                type:String,
                default:"Yanlış Cevaplar"
            },
            answerText:{
                type:String,
                default:"Cevap"
            },
            answersText:{
                type:String,
                default:"Cevaplar"
            },
            afterBlankText:{
                type:String,
                default:"Boşluk Sonrası Cümle"
            },
            addAnswerText:{
                type:String,
                default:"Cevap Ekle"
            },
            addBlankAreaText:{
                type:String,
                default:"Boşluk Ekle"
            },
            instructorId:{
                type:String,
                required:true,
            },
            levelText:{
                type:String,
                default:"Zorluk Seviyesi"
            },
            chooseLevelText:{
                type:String,
                default:"Zorluk Seviyesi Seçiniz"
            },
            lessonText:{
                type:String,
                default:"Ders"
            },
            chooseLessonText:{
                type:String,
                default:"Ders Seçiniz"
            },
            subjectText:{
                type:String,
                default:"Konu"
            },
            chooseSubjectText:{
                type:String,
                default:"Konu Seçiniz"
            },
            hardText:{
                type:String,
                default:"Zor"
            },
            mediumText:{
                type:String,
                default:"Orta"
            },
            easyText:{
                type:String,
                default:"Kolay"
            },
            answerImageText:{
                type:String,
                default:"Cevap Resmi"
            },
            correctAnswerImageText:{
                type:String,
                default:"Doğru Cevap Resmi"
            },
            wrongAnswerImageText:{
                type:String,
                default:"Yanlış Cevap Resmi"
            },
            trueText:{
                type:String,
                default:"Doğru"
            },
            falseText:{
                type:String,
                default:"Yanlış"
            },
            trueFalseText:{
                type:String,
                default:"Doğru Yanlış"
            },
            phraseText:{
                type:String,
                default:"İfade",
            },
            addPhraseText:{
                type:String,
                default:"İfade Ekle",
            },
            phrasesText:{
                type:String,
                default:"İfadeler",
            },
            matchingText:{
                type:String,
                default:"Eşleştirme"
            },
            rankingText:{
                type:String,
                default:"Sıralama"
            },
            firstPhraseText:{
                type:String,
                default:"İlk İfade"
            },
            secondPhraseText:{
                type:String,
                default:"İkinci İfade"
            },
            rankText:{
                type:String,
                default:"Sıra"
            },
            questionId:{
                type:String,
                required:true,
            }
        },
        computed:{
            ...mapState([
                'courseSubjects',
                'plLessonType'
            ]),
            url(){
                if(this.questionId==''){
                    return '/api/questionSource/create'
                }else{
                    return '/api/questionSource/update/'+this.questionId
                }
            },
            previewUrl(){
                if(this.imgUrl!=""&&this.imgUrl!=null&&this.imgUrl!=undefined){
                    return this.imgUrl;
                }else{
                    return this.defaultImagePath;
                }
            },
            correctAnswerImageUrl(){
                if(this.correctAnswerImage!="" && this.correctAnswerImage!=null && this.correctAnswerImage!=undefined){
                    return this.correctAnswerImage;
                }else{
                    return this.defaultImagePath;
                }
            }
        },
        methods:{
            ...mapActions([
                'loadLessonSubjects',
                'loadPlLessonType'
            ]),
            previewImage: function(inputId, previewId){
                var input = document.getElementById(inputId);
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        document.querySelector('#'+previewId).setAttribute('style', 'background-image:url('+e.target.result+')');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            },
            addSingleChoiceTextQuestion:function () {
                var i;
                var formData=new FormData();
                var image=document.querySelector('#singleQuestionImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('singleQuestion').value);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                for(i=0; i<this.singleAnswers.length; i++){
                    formData.append('answers['+i+']', JSON.stringify(this.singleAnswers[i]));
                }
                formData.append('answers['+i+']', JSON.stringify({'content':document.getElementById('singleCorrectAnswer').value, 'type':'text', 'isCorrect':'true'}));
                formData.append('type', 'singleChoice');
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });

            },
            addSingleChoiceImgQuestion:function () {
                var i;
                var formData=new FormData();
                var image=document.querySelector('#singleQuestionImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('singleQuestion').value);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                for(i=0; i<this.singleAnswersImg.length; i++){
                    formData.append('answersContent['+i+']', this.singleAnswersImg[i].content);
                    formData.append('answers['+i+']', JSON.stringify(this.singleAnswersImg[i]));
                }
                if(document.querySelector('#singleCorrectAnswerImg').files&&document.querySelector('#singleCorrectAnswerImg').files[0]){
                    formData.append('answersContent['+i+']', document.querySelector('#singleCorrectAnswerImg').files[0]);
                    formData.append('answers['+i+']', JSON.stringify({content:document.querySelector('#singleCorrectAnswerImg').files[0], type:'image', isCorrect:'true'}));
                }else{
                    formData.append('answersContent['+i+']', this.correctAnswerImage);
                    formData.append('answers['+i+']', JSON.stringify({content:this.correctAnswerImage, type:'image', isCorrect:'true'}));
                }
                formData.append('type', 'singleChoice');
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            addMultiChoiceTextQuestion:function () {
                var formData=new FormData();
                var image=document.querySelector('#multiQuestionImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('multiQuestion').value);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                for(var i=0; i<this.multiAnswers.length; i++){
                    formData.append('answers['+i+']', JSON.stringify(this.multiAnswers[i]));
                }
                formData.append('type', 'multiChoice');
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            addMultiChoiceImgQuestion:function () {
                var formData=new FormData();
                var image=document.querySelector('#multiQuestionImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('multiQuestion').value);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                for(var i=0; i<this.multiAnswersImg.length; i++) {
                    formData.append('answersContent['+i+']', this.multiAnswersImg[i].content);
                    formData.append('answers['+i+']', JSON.stringify(this.multiAnswersImg[i]));
                }
                formData.append('type', 'multiChoice');
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            addFillBlankQuestion:function () {
                var image=document.querySelector('#blankImg');
                var formData=new FormData();
                formData.append('level', this.questionLevel);
                formData.append('beginningOfSentence', document.getElementById('blankQuestion').value);
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                for(var i=0; i<this.blanks.length; i++) {
                    formData.append('answers['+i+']', JSON.stringify(this.blanks[i]));
                }
                formData.append('type', 'fillBlank');
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            addTrueFalseQuestion:function(){
                var formData=new FormData();
                var image=document.querySelector('#trueFalseImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('level', this.questionLevel);
                formData.append('content', document.getElementById('trueFalseQuestion').value);
                formData.append('isCorrect',this.isCorrect);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                formData.append('type', 'trueFalse');
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            addMatchingTextQuestion:function(){
                var formData=new FormData();
                formData.append('level', this.questionLevel);
                var image=document.querySelector('#matchingQuestionImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('text', document.getElementById('matchingQuestion').value);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                formData.append('type', 'match');
                for(var i=0; i<this.matchingAnswers.length; i++) {
                    formData.append('answers['+i+']', JSON.stringify(this.matchingAnswers[i]));
                }
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            addMatchingImgQuestion:function(){
                var formData=new FormData();
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('matchingQuestion').value);
                var image=document.querySelector('#matchingQuestionImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                formData.append('type', 'match');
                for(var i=0; i<this.matchingAnswersImg.length; i++) {
                    formData.append('answersContent['+i+']', this.matchingAnswersImg[i].first);
                    formData.append('answersAnswer['+i+']', this.matchingAnswersImg[i].second);
                    formData.append('answers['+i+']', JSON.stringify(this.matchingAnswersImg[i]));
                }
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            addRankingQuestion:function(){
                var formData=new FormData();
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('rankingQuestion').value);
                var image=document.querySelector('#rankingQuestionImg');
                if(image.files && image.files[0]){
                    formData.append('imgUrl', image.files[0]);
                }else if(this.imgUrl!=null && this.imgUrl!="" && this.imgUrl!=undefined){
                    formData.append('imgUrl', this.imgUrl);
                }
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                formData.append('type', 'order');
                for(var i=0; i<this.rankingAnswers.length; i++) {
                    formData.append('content['+i+']', this.rankingAnswers[i].content);
                }
                Axios.post(this.url, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.replace('/questionSource');},1000)
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    });
            },
            loadSubjects:function () {
                this.$store.dispatch('loadLessonSubjects', this.selectedLessonId);
            },
            pushImage:function (answerType, index, inputId, previewId) {
                var image=document.querySelector('#'+inputId);
                switch (answerType) {
                    case 'multiQuestion':{
                        this.multiAnswersImg[index].content=image.files[0];
                        break;
                    }
                    case 'singleQuestion':{
                        this.singleAnswersImg[index].content=image.files[0];
                        break;
                    }
                    case 'matchingQuestionFirst':{
                        this.matchingAnswersImg[index].first=image.files[0];
                        break;
                    }
                    case 'matchingQuestionSecond':{
                        this.matchingAnswersImg[index].second=image.files[0];
                        break;
                    }
                }
                this.previewImage(inputId,previewId);
            },
            loadData:function(data){
                this.text=data.text;
                this.selectedLessonId=data.crLessonId;
                this.$store.dispatch('loadLessonSubjects', data.crLessonId);
                this.selectedSubjectId=data.crSubjectId;
                this.questionLevel=data.level;
                this.questionType=data.type;
                this.imgUrl=data.imgUrl;
                switch (data.type) {
                    case 'singleChoice':{
                        if(data.answers[0].type==='text'){
                            this.singleAnswerType='withText';
                            for(var i=0; i<data.answers.length; i++){
                                if(data.answers[i].isTrue){
                                    this.correctAnswer=data.answers[i].content;
                                }else{
                                    this.singleAnswers.push({content:data.answers[i].content, type:data.answers[i].type, isCorrect:data.answers[i].isTrue});
                                }
                            }
                        }else{
                            this.singleAnswerType='withImage';
                            for(var i=0; i<data.answers.length; i++){
                                if(data.answers[i].isTrue){
                                    this.correctAnswerImage=data.answers[i].content;
                                }else{
                                    this.singleAnswersImg.push({content:data.answers[i].content, type:data.answers[i].type, isCorrect:data.answers[i].isTrue});
                                }
                            }
                        }
                        break;
                    }
                    case 'multiChoice':{
                        if(data.answers[0].type=='text'){
                            this.multiAnswerType='withText';
                            for(var i=0; i<data.answers.length; i++){
                                this.multiAnswers.push({content: data.answers[i].content, isCorrect:data.answers[i].isTrue, type:data.answers[i].type});
                            }
                        }else{
                            this.multiAnswerType='withImage';
                            for(var i=0; i<data.answers.length; i++){
                                this.multiAnswersImg.push({content: data.answers[i].content, isCorrect:data.answers[i].isTrue, type:data.answers[i].type});
                            }
                        }
                        break;
                    }
                    case 'fillBlank':{
                        for(var i=0; i<data.answers.length; i++){
                            this.blanks.push({answer:data.answers[i].content, after:data.answers[i].after, type:data.answers[i].type});
                        }
                        break;
                    }
                    case 'trueFalse':{
                        this.isCorrect= data.answers[0].content;
                        document.getElementsByName("isCorrect").value=data.answers[0].content;
                        this.isCorrect=0;
                        break;
                    }
                    case 'match':{
                        if(data.answers[0].type=='text'){
                            this.matchingAnswerType='withText';
                            for(var i=0; i<data.answers.length; i++){
                                this.matchingAnswers.push({first:data.answers[i].content, second:data.answers[i].answer, type:data.answers[i].type});
                            }
                        }else{
                            this.matchingAnswerType='withImage';
                            for(var i=0; i<data.answers.length; i++){
                                this.matchingAnswersImg.push({first:data.answers[i].content, second:data.answers[i].answer, type:data.answers[i].type});
                            }
                        }
                        break;
                    }
                    case 'order':{
                        for(var i=0; i<data.answers.length; i++){
                            this.rankingAnswers=data.answers;
                        }
                        break;
                    }
                }
            },
            previewImageForUpdate:function (questionType) {
                switch (questionType) {
                    case 'singleChoice':{
                        document.querySelector('#singleQuestionImgPreview').setAttribute('style', 'background-image:url('+this.imgUrl+')');
                        break;
                    }
                }
            }
        },
        created() {
            this.$store.dispatch('loadPlLessonType');
            if(this.questionId!=''){
                Axios.get('/api/questionSource/getQuestion/'+this.questionId)
                    .then(response=>this.loadData(response.data.data))
            }
        }
    }
</script>

<style scoped>
    textarea{
        resize:none;
    }
</style>
