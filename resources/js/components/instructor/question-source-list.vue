<template>
    <div class="uk-card uk-card-default uk-margin-medium-top border-radius-6 uk-height" >
        <div class="uk-card-body uk-padding-small">
            <div v-if="questionSource.length>0">
                <div class="uk-grid align-items-center justify-content-center">
                    <div class="uk-width-1-6"> </div>
                    <div class="uk-width-1-2">
                        <h4 class="uk-form-label"> {{questionText}} </h4>
                    </div>
                    <div class="uk-width-1-6">
                        <h4 class="uk-form-label"> {{lessonText}} </h4>
                    </div>
                    <div class="uk-width-1-6 text-center">
                        <h4 class="uk-form-label"> {{difficultyText}} </h4>
                    </div>
                </div>
                <hr class="uk-margin-small-top">
                <div v-for="question in questionSource" class="uk-margin-bottom">
                    <div class="uk-grid align-items-center">
                        <div class="uk-width-1-6 uk-flex uk-child-width-1-4@m text-center">
                            <i class="fas fa-trash-alt text-danger" @click="deleteQuestion(question.id)"></i>
                            <i class="fas fa-cog" @click="editPageRoute(question.id)"></i>
                        </div>
                        <div class="uk-width-1-2">
                            <h6> {{question.text}} </h6>
                        </div>
                        <div class="uk-width-1-6">
                            <h6> {{question.lesson.name}} </h6>
                        </div>
                        <div class="uk-width-1-6 text-center">
                            <h6> {{question.level}} </h6>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div v-if="questionSource.length<=0" class="uk-width uk-flex align-item-center justify-content-center uk-padding">
                <h4 class="uk-margin-remove">Soru Bulunmamaktadır</h4>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex'
    import Axios from 'axios'
    export default {
        name: "question-source-list",
        props:{
            userId:{
                type:String,
                required:true,
            },
            questionText:{
                type:String,
                default:"Soru"
            },
            lessonText:{
                type:String,
                default:"Ders"
            },
            difficultyText:{
                type:String,
                default:"Zorluk Seviyesi"
            }
        },
        computed:{
            ...mapState([
                'questionSource'
            ])
        },
        methods:{
            ...mapActions([
                'loadQuestionSource'
            ]),
            deleteQuestion:function(questionId){
                Axios.post('/api/questionSource/delete/'+questionId)
                    .then(this.$store.dispatch('loadQuestionSource', this.userId));
            },
            editPageRoute:function (questionId) {
                window.location.replace('/questionSource/'+questionId)
            }
        },
        created() {
            this.$store.dispatch('loadQuestionSource', this.userId)
        }
    }
</script>

<style scoped>

</style>
