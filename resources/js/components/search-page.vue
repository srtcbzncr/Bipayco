<template>
    <div class="uk-container">
        <div v-if="courseCard.length>0">
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                <div v-for="course of courseCard[Number(currentPage)-1]">
                    <course-card
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        :module-name="course.type"
                        :is-login="userId!=''"
                        :user-id="userId"
                        :module="convertModule(course.type)"
                    > </course-card>
                </div>
            </div>
            <ul class="uk-pagination uk-flex-center uk-margin-medium">
                <li>
                    <button v-show="currentPage>1" @click="loadNewPage(Number(currentPage)-1)"> < </button>
                </li>
                <li v-for="page in pageNumber">
                    <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                    <button v-else-if="page==currentPage" class="uk-background-default uk-disabled" @click="loadNewPage(page)">{{page}}</button>
                    <button v-else @click="loadNewPage(page)">{{page}}</button>
                </li>
                <li>
                    <button v-show="currentPage<courseCard.length" @click="loadNewPage(Number(currentPage)+1)"> > </button>
                </li>
            </ul>
        </div>
        <div v-else class="uk-flex uk-flex-center align-items-center justify-content-center uk-height-medium uk-margin-large-top">
            <h2>{{hasNoContent}}</h2>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "search-page",
        data(){
            return {
                currentPage:1,
            }
        },
        props:{
            userId:{
                type:String,
                default:""
            },
            tag:{
                type:String,
                required:true,
            },
            hasNoContent:{
                type:String,
                default:"Aradığınız sonuç bulunamadı"
            }
        },
        computed:{
            ...mapState([
                'courseCard'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.courseCard.length; i++){
                    if(i==2 && this.currentPage-2>3){
                        pages.push('...');
                        if(this.currentPage+3>this.courseCard.length){
                            index=this.courseCard.length-6;
                        }else{
                            index=this.currentPage-2;
                        }
                    }else if(i==8 && this.currentPage+2<this.courseCard.length-2){
                        pages.push('...');
                        index=this.courseCard.length;
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
                'loadUrlForCourseCard',
            ]),
            loadNewPage: function(name){
                this.$store.dispatch('loadUrlForCourseCard', name);
            },
            convertModule:function(moduleName){
                switch(moduleName){
                    case 'generalEducation': return 'ge';
                    case 'prepareLessons': return 'pl';
                    case 'prepareExams': return 'pe';
                    default: return'';
                }
            }
        },
        created() {
            this.$store.dispatch('loadUrlForCourseCard', '/api/search/'+this.tag+'/'+this.userId);
        },
    }
</script>

<style scoped>

</style>
