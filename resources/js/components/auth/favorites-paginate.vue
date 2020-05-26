<template>
    <div class="uk-container">
        <div class="uk-clearfix boundary-align uk-margin-medium-top">
            <div class="uk-float-left section-heading none-border">
                <h2>{{favoritesText}}</h2>
                <p></p>
            </div>
        </div>
        <div v-if="courseCard.data&&courseCard.data.length>0">
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                <div v-for="course in courseCard.data">
                    <course-card
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        :module-name="moduleName"
                        :is-login="true"
                        :user-id="userId"
                        :module="module"
                    > </course-card>
                </div>
            </div>
            <ul class="uk-pagination uk-flex-center uk-margin-medium">
                <li>
                    <button v-show="courseCard.current_page>1" @click="loadNewPage(courseCard.prev_page_url)"> < </button>
                </li>
                <li v-for="page in pageNumber">
                    <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                    <button v-else-if="page==courseCard.current_page" class="uk-background-default uk-disabled" @click="loadNewPage(url+'?page='+page)">{{page}}</button>
                    <button v-else @click="loadNewPage(url+'?page='+page)">{{page}}</button>
                </li>
                <li>
                    <button v-show="courseCard.current_page<courseCard.last_page" @click="loadNewPage(courseCard.next_page_url)"> > </button>
                </li>
            </ul>
        </div>
        <div v-else class="uk-flex uk-flex-center align-items-center justify-content-center uk-margin-large-top">
            <h2>{{hasNoContent}}</h2>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";
    export default {
        name: "course-card-pagination",
        data(){
            return {
                url:'/api/'
            }
        },
        props:{
            userId:{
                type:String,
                required:true,
            },
            favoritesText:{
                type:String,
                default:"Favoriler"
            }
        },
        computed:{
            ...mapState([
                'courseCard'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.courseCard.last_page; i++){
                    if(i==2 && this.courseCard.current_page-2>3){
                        pages.push('...');
                        if(this.courseCard.current_page+3>this.courseCard.last_page){
                            index=this.courseCard.last_page-6;
                        }else{
                            index=this.courseCard.current_page-2;
                        }
                    }else if(i==8 && this.courseCard.current_page+2<this.courseCard.last_page-2){
                        pages.push('...');
                        index=this.courseCard.last_page;
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
            }
        },
        created() {
            if (this.courseCount>0) {
                this.$store.dispatch('loadUrlForCourseCard', this.url);
            }
        },
    }
</script>
<style scoped>
</style>
