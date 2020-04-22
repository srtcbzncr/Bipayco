<template>
    <div class="uk-margin-medium-top">
        <div class="uk-background-default border-radius-6 uk-height" >
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>{{questionText}}</th>
                    <th>{{lessonText}}</th>
                    <th>{{subjectText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr v-for="question in questionSource[currentPage-1]">
                    <td class="uk-width-2-5"><p> {{question.text}}</p></td>
                    <td class="uk-width-1-5"><p>{{question.lesson.name}}</p></td>
                    <td class="uk-width-1-5"><p>{{question.subject.name}}</p></td>
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
        <ul class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="currentPage>1" @click="currentPage--"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==currentPage" class="uk-background-default uk-disabled" >{{page}}</button>
                <button v-else @click="currentPage=page">{{page}}</button>
            </li>
            <li>
                <button v-show="currentPage<questionSource.length" @click="currentPage++"> > </button>
            </li>
        </ul>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex'
    import Axios from 'axios'
    export default {
        name: "question-source-list",
        data(){
            return{
                currentPage:1
            }
        },
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
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.questionSource.length; i++){
                    if(i==2 && this.currentPage-2>3){
                        pages.push('...');
                        if(this.currentPage+3>this.questionSource.length){
                            index=this.questionSource.length-6;
                        }else{
                            index=this.currentPage-2;
                        }
                    }else if(i==8 && this.currentPage+2<this.questionSource.length-2){
                        pages.push('...');
                        index=this.questionSource.length;
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
                'loadQuestionSource'
            ]),
            deleteQuestion:function(questionId){
                Axios.post('/api/questionSource/delete/'+questionId)
                    .then(this.$store.dispatch('loadQuestionSource', this.userId));
            },
            editPageRoute:function (questionId) {
                window.location.replace('/questionSource/update/'+questionId)
            }
        },
        created() {
            this.$store.dispatch('loadQuestionSource', this.userId)
        }
    }
</script>

<style scoped>

</style>
