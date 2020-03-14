<template>
    <div>
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
                <input type="text" value="" id="courseCreateId" hidden disabled>
                <div id="imagePreview" class="uk-background-center-center uk-background-cover uk-height"></div>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="image" type="file" accept="image/*" id="questionImage" @change="previewImage" >
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
            </div>
            <div class="uk-form-label"> {{questionText}} </div>
            <textarea class="uk-height-small uk-textarea uk-overflow-auto" required></textarea>
            <div>
                <div class="uk-form-label"> {{answerTypeText}} </div>
                <select v-model="answerType"  class="uk-width uk-select">
                    <option value="" hidden disabled selected>{{chooseAnswerTypeText}}</option>
                    <option value="withImage">{{withImage}}</option>
                    <option value="withText">{{withText}}</option>
                </select>
                <div v-if="answerType=='withImage'">
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
                    <button class="uk-width uk-button-success uk-button"> <i class="fas fa-plus"></i> {{addWrongAnswer}}</button>
                </div>
                <div v-if="answerType=='withText'">
                    <div class="uk-margin">
                        <div class="uk-form-label"> {{correctAnswerText}} </div>
                        <input type="text" class="uk-input uk-width">
                    </div>
                    <div>
                        <div class="uk-form-label"> {{wrongAnswersText}} </div>
                        <single-choice-answer></single-choice-answer>
                        <single-choice-answer></single-choice-answer>
                        <single-choice-answer></single-choice-answer>
                        <button class="uk-width uk-button-success uk-button"> <i class="fas fa-plus"></i> {{addWrongAnswer}}</button>
                    </div>
                </div>
            </div>
            <button class="uk-button uk-button-grey uk-margin-top"> {{saveText}} </button>
        </div>
        <div v-if="questionType=='multiChoice'" class="uk-margin-top">
            <multi-choice-answer></multi-choice-answer>
            <multi-choice-answer></multi-choice-answer>
            <multi-choice-answer></multi-choice-answer>
            <button class="uk-button uk-button-grey uk-margin-top"> {{saveText}} </button>
        </div>
        <div v-if="questionType=='fillInTheBlank'" class="uk-margin-top">
            <fill-blank></fill-blank>
            <fill-blank></fill-blank>
            <fill-blank></fill-blank>
            <button class="uk-button uk-button-grey uk-margin-top"> {{saveText}} </button>
        </div>
    </div>
</template>
<script>
    import SingleChoiceAnswer from "./single-choice-answer";
    import MultiChoiceAnswer from "./multi-choice-answer";
    import FillBlank from "./fill-blank";
    export default {
        name: "add-question",
        components: {FillBlank, MultiChoiceAnswer, SingleChoiceAnswer},
        data(){
            return{
                questionType:"",
                answerType:"",
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
            addWrongAnswer:{
                type:String,
                default:"Yanlış Cevap Ekle"
            },
            wrongAnswersText:{
                type:String,
                default:"Yanlış Cevaplar"
            }
        },
        methods:{
            previewImage: function(){
                var input = document.getElementById('questionImage');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        document.querySelector('#imagePreview').setAttribute('style', 'background-image:url('+e.target.result+')');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
    }
</script>

<style scoped>
    textarea{
        resize:none;
    }
</style>
