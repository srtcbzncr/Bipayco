<template>
    <div class="uk-background-default uk-margin-medium-top border-radius-6 uk-height" >
        <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
            <thead v-if="true">
            <tr>
                <th>{{questionText}}</th>
                <th>{{lessonText}}</th>
                <th>{{difficultyText}}</th>
                <th></th>
            </tr>
            </thead>
            <tbody v-if="true">
            <tr v-for="question in questionSource">
                <td class="uk-width-2-5"><p> {{question.text}}</p></td>
                <td class="uk-width-1-5"><p>{{question.lesson.name}}</p></td>
                <td class="uk-width-1-5"><p>{{question.level}}</p></td>
                <td class="uk-flex flex-wrap align-items-center justify-content-around">
                    <a @click="editPageRoute(question.id)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                    <a @click="deleteQuestion(question.id)" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                </td>
            </tr>
            </tbody>
            <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                <h4> {{noContentText}} </h4>
            </div>
        </table>
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
            },
            editText:{
                type:String,
                default:"Düzenle"
            },
            deleteText:{
                type:String,
                default:"Sil"
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
