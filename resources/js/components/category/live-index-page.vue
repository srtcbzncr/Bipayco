<template>
    <div class="uk-container">
        <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
            <div class="loader"></div>
        </div>
        <div v-else-if="courseCard.data&&courseCard.data.length>0">
            <div class="uk-clearfix boundary-align uk-margin-medium-top">
                <div class="uk-float-left section-heading none-border">
                    <h2>{{liveStreamsText}}</h2>
                </div>
            </div>
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                <div v-for="course in courseCard.data">
                    <course-card
                        :course="course"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                        :course-id="course.id"
                        :module-name="moduleName"
                        :is-login="isLogin"
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
                    <button v-else-if="page==courseCard.current_page" class="uk-background-default uk-disabled">{{page}}</button>
                    <button v-else @click="loadNewPage(urlCreate(userId,page))">{{page}}</button>
                </li>
                <li>
                    <button v-show="courseCard.current_page<courseCard.last_page" @click="loadNewPage(courseCard.next_page_url)"> > </button>
                </li>
            </ul>
        </div>
        <div v-else class="uk-flex uk-flex-center align-items-center justify-content-center uk-margin-large-top">
            <h2>{{hasNoContentText}}</h2>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "live-index-page",
        created() {
            var url;
            if(this.userId!=''){
                url='/api/home/live/all_courses/'+this.userId;
            }else{
                url='/api/home/live/all_courses/';
            }
            this.$store.dispatch('loadUrlForCourseCard', url);
        },
        data(){
            return {
                currentPage:1,
            }
        },
        props:{
            hasNoContentText:{
                type:String,
                default: "İçerik Bulunmuyor"
            },
            moduleName:{
                type:String,
                required:true,
            },
            module:{
                type:String,
                required:true,
            },
            isLogin:{
                type:Boolean,
                default:false,
            },
            userId:{
                type:String,
                default:""
            },
            liveStreamsText:{
                type:String,
                default:"Canlı Yayınlar"
            }
        },
        computed:{
            ...mapState([
                'courseCard',
                'loadingStatus'
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
            selectedSortOption(){
                return document.getElementById("sortBy").value;
            }
        },
        methods:{
            ...mapActions([
                'loadUrlForCourseCard',
                'loadNewPageCourses'
            ]),
            urlCreate:function(userId,page){
                if(userId!=''){
                    return '/api/home/live/all_courses/'+userId+'?page='+page;
                }else{
                    return '/api/home/live/all_courses/'+id+'?page='+page;
                }
            },
            loadCourseList: function(){
                if(this.userId!=''){
                    this.$store.dispatch('loadUrlForCourseCard', '/api/home/live/all_courses/'+this.userId);
                }else{
                    this.$store.dispatch('loadUrlForCourseCard', '/api/home/live/all_courses/');
                }
            },
            loadNewPage: function(name,newPageNumber){
                this.$store.dispatch('loadNewPageCourses',name);
                this.$store.dispatch('loadUrlForCourseCard', name);
                this.currentPage=newPageNumber;
            }
        },
    }
</script>

<style scoped>

</style>
