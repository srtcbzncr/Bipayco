<template>
    <div>
        <div class="uk-grid uk-child-width-1-3@m">
            <div>
                <div class="uk-form-label"> {{lessonText}} </div>
                <select class='uk-select uk-margin-right uk-margin-small-bottom' v-model="selectedLessonId" @change="loadSubjects" required>
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
            <option value="fillInTheBlank">{{fillBlankText}}</option>
        </select>
        <div v-if="questionType=='singleChoice'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <div class="uk-background-center-center uk-background-cover uk-height" id="singleQuestionImgPreview"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="singleQuestionImg" @change="previewImage('singleQuestionImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-form-label"> {{questionText}} </div>
            <textarea class="uk-height-small uk-textarea uk-overflow-auto" id="singleQuestion" required></textarea>
            <div>
                <div class="uk-form-label"> {{answerTypeText}} </div>
                <select v-model="singleAnswerType"  class="uk-width uk-select">
                    <option value="" hidden disabled selected>{{chooseAnswerTypeText}}</option>
                    <option value="withImage">{{withImage}}</option>
                    <option value="withText">{{withText}}</option>
                </select>
                <div v-if="singleAnswerType=='withImage'">
                    <div class="uk-margin">
                        <div class="uk-form-label"> {{questionImageText}} </div>
                        <div>
                            <input type="text" value=""  hidden disabled>
                            <div class="uk-background-center-center uk-background-cover uk-height"></div>
                        </div>
                        <div uk-form-custom="target: true" class="uk-flex uk-flex-center">
                            <input name="image" type="file" accept="image/*" @change="previewImage" >
                            <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button"> <i class="fas fa-plus"></i> {{addWrongAnswerText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addSingleChoiceImgQuestion"> {{saveText}} </button>
                </div>
                <div v-if="singleAnswerType=='withText'">
                    <div class="uk-margin">
                        <div class="uk-form-label"> {{correctAnswerText}} </div>
                        <input type="text" class="uk-input uk-width">
                    </div>
                    <div v-if="singleAnswers.length>0" class="uk-form-label"> {{wrongAnswersText}} </div>
                    <div v-for="(singleAnswer,singleIndex) in singleAnswers" class="uk-flex align-items-center uk-margin">
                        <div class="uk-margin-right uk-margin-left">
                            <i class="fas fa-trash-alt text-danger" @click="singleAnswers.splice(singleIndex,1)"></i>
                        </div>
                        <div class=" uk-width">
                            <input class="uk-input uk-width" v-model="singleAnswer.answer" type="text" required>
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button" @click="singleAnswers.push({answer:'', answerType:'text', isCorrect:'false'})"> <i class="fas fa-plus"></i> {{addWrongAnswerText}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width" @click="addSingleChoiceTextQuestion"> {{saveText}} </button>
                </div>
            </div>
        </div>
        <div v-if="questionType=='multiChoice'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <div class="uk-background-center-center uk-background-cover uk-height" id="multiQuestionImgPreview"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="multiQuestionImg" @change="previewImage('multiQuestionImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-form-label"> {{questionText}} </div>
            <textarea class="uk-height-small uk-textarea uk-overflow-auto" required></textarea>
            <div>
                <div class="uk-form-label"> {{answerTypeText}} </div>
                <select v-model="multiAnswerType"  class="uk-width uk-select">
                    <option value="" hidden disabled selected>{{chooseAnswerTypeText}}</option>
                    <option value="withImage">{{withImage}}</option>
                    <option value="withText">{{withText}}</option>
                </select>
                <div v-if="multiAnswerType=='withImage'">
                    <div class="uk-margin">
                        <div class="uk-form-label"> {{answerImageText}} </div>
                        <div>
                            <input type="text" value=""  hidden disabled>
                            <div class="uk-background-center-center uk-background-cover uk-height"></div>
                        </div>
                        <div uk-form-custom="target: true" class="uk-flex uk-flex-center">
                            <input name="image" type="file" accept="image/*" @change="previewImage" >
                            <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                        </div>
                    </div>
                    <button class="uk-width uk-button-success uk-button"> <i class="fas fa-plus"></i> {{addAnswer}}</button>
                    <button class="uk-button uk-button-grey uk-margin-top uk-width"> {{saveText}} </button>
                </div>
                <div v-if="multiAnswerType=='withText'">
                    <div v-if="multiAnswers.length>0" class="uk-form-label"> {{answersText}} </div>
                    <div v-for="(multiAnswer, multiIndex) in multiAnswers" class="uk-flex align-items-center uk-margin">
                        <div class="uk-margin-right uk-margin-left">
                            <i class="fas fa-trash-alt text-danger" @click="multiAnswers.splice(multiIndex,1)"></i>
                        </div>
                        <div class=" uk-width">
                            <input class="uk-input uk-width" v-model="multiAnswer.answer" type="text" required>
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
        <div v-if="questionType=='fillInTheBlank'" class="uk-margin-top">
            <div class="uk-form-label"> {{questionImageText}} </div>
            <div>
                <input type="text" value="" hidden disabled>
                <div class="uk-background-center-center uk-background-cover uk-height" id="blankImgPreview"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="blankImg" @change="previewImage('blankImgPreview')" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-margin-bottom">
                <div class="uk-form-label"> {{questionText}} </div>
                <textarea class="uk-height-small uk-textarea uk-overflow-auto" required></textarea>
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
    </div>
</template>
<script>
    import Axios from 'axios'
    import {mapActions, mapState} from "vuex";
    export default {
        name: "add-question",
        data(){
            return{
                selectedLessonId:"",
                selectedSubjectId:"",
                questionLevel:"",
                questionType:"",
                singleAnswerType:"",
                multiAnswerType:"",
                singleAnswers:[],
                multiAnswers:[],
                blanks:[],
            }
        },
        props:{
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
            }
        },
        computed:{
            ...mapState([
                'courseSubjects',
                'plLessonType'
            ]),
        },
        methods:{
            ...mapActions([
                'loadLessonSubjects',
                'loadPlLessonType'
            ]),
            previewImage: function(previewId){
                var input = document.getElementById('questionImage');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        document.querySelector('#'+previewId).setAttribute('style', 'background-image:url('+e.target.result+')');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            },
            addSingleChoiceTextQuestion:function () {
                this.singleAnswerType.push({content:document.getElementById('singleCorrectAnswer').value, isCorrect:true, type:text});
                var formData=new FormData();
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('singleQuestion').value);
                formData.append('imgUrl', document.getElementById('singleQuestionImg').files[0]);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                formData.append('answers', this.singleAnswers);
                formData.append('type', 'singleChoice');
                Axios.post('/api/questionSource/create', formData)
                    .then(response=>console.log(response));
            },
            addSingleChoiceImgQuestion:function () {

            },
            addMultiChoiceTextQuestion:function () {
                var formData=new FormData();
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('multiQuestion').value);
                formData.append('imgUrl', document.getElementById('multiQuestionImg').files[0]);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                formData.append('answers', this.multiAnswers);
                formData.append('type', 'multiChoice');
                Axios.post('/api/questionSource/create', formData)
                    .then(response=>console.log(response));
            },
            addMultiChoiceImgQuestion:function () {

            },
            addFillBlankQuestion:function () {
                var formData=new FormData();
                formData.append('level', this.questionLevel);
                formData.append('text', document.getElementById('blankQuestion').value);
                formData.append('imgUrl', document.getElementById('blankQuestionImg').files[0]);
                formData.append('crLessonId', this.selectedLessonId);
                formData.append('crSubjectId', this.selectedSubjectId);
                formData.append('instructorId', this.instructorId);
                formData.append('beginningOfSentence', document.getElementById('beginningOfSentence').value);
                formData.append('answers', this.blanks);
                formData.append('type', 'fillBlank');
                Axios.post('/api/questionSource/create', formData)
                    .then(response=>console.log(response));
            },
            loadSubjects:function () {
                this.$store.dispatch('loadLessonSubjects', this.selectedLessonId);
            }
        },
        created() {
            this.$store.dispatch('loadPlLessonType');
        }
    }
</script>

<style scoped>
    textarea{
        resize:none;
    }
</style>
