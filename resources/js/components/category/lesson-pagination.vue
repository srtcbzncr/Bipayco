
<template>
    <div class="uk-container">
        <ul uk-switcher="connect: #lessons" class="uk-flex-center uk-margin-medium-top uk-subnav uk-subnav-pill uk-margin-remove-bottom">
            <li v-for="(grade,index) in grades" @click="changeGrade(grade)">
                <a v-if="grades.length< 7" href="#">{{grade.name}}</a>
                <a v-else-if="index<5" href="#">{{grade.name}}</a>
            </li>
            <li v-if="grades.length>7" >
                <a href="#">{{moreText}} <span class="fas fa-angle-down uk-margin-small-left icon-small"></span></a>
                <div uk-dropdown="mode: click">
                    <ul class="uk-nav uk-dropdown-nav" uk-switcher="connect: #lessons">
                        <li v-for="(grade,index) in grades" @click="changeGrade(grade)" v-if="index>=5"><a href="#">{{grade.name}}</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <div v-if="courseCount>0&&courseCard.data">
            <div class="uk-clearfix boundary-align uk-margin-medium-top">
                <div class="uk-float-left section-heading none-border">
                    <h2>{{gradeName}}</h2>
                </div>
                <div class="uk-float-right uk-margin-small-top">
                    <select class="uk-select uk-width uk-overflow-auto" v-model="sort" id="sortBy" @change="loadCourseList">
                        <option selected :value="'getBy'+name+'FilterByTrending'">{{byTrending}} </option>
                        <option :value="'getBy'+name+'FilterByPurchases'">{{byPurchases}} </option>
                        <option :value="'getBy'+name+'FilterByPoint'">{{byPoint}} </option>
                        <option :value="'getBy'+name+'FilterByPriceDESC'">{{byDesc}} </option>
                        <option :value="'getBy'+name+'FilterByPriceASC'">{{byInc}} </option>
                        <option :value="'getBy'+name+'FilterByNewest'">{{newest}} </option>
                        <option :value="'getBy'+name+'FilterByOldest'">{{oldest}} </option>
                    </select>
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
            <div v-if="courseCard.data.length<=0" class="uk-flex uk-flex-center align-items-center justify-content-center">
                <h2>{{hasNoContent}}</h2>
            </div>
            <ul class="uk-pagination uk-flex-center uk-margin-medium">
                <li>
                    <button v-show="courseCard.current_page>1" @click="loadNewPage(courseCard.prev_page_url)"> < </button>
                </li>
                <li v-for="page in pageNumber">
                    <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                    <button v-else-if="page==courseCard.current_page" class="uk-background-default uk-disabled" @click="loadNewPage(urlCreate(sortBy,id,userId,page))">{{page}}</button>
                    <button v-else @click="loadNewPage(urlCreate(sortBy,id,userId,page))">{{page}}</button>
                </li>
                <li>
                    <button v-show="courseCard.current_page<courseCard.last_page" @click="loadNewPage(courseCard.next_page_url)"> > </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "lesson-pagination",
        created() {
            if (this.courseCount>0) {
                var sort='getBy'+this.name+'FilterByTrending/'+this.grades[0].id;
                var url='/api/course/'+sort+'/'+this.id+'/'+this.userId;
                this.$store.dispatch('loadUrlForCourseCard', url);
                this.$store.dispatch('loadCategoryCourses',[sort, this.id, this.userId]);
            }
        },
        data(){
            return {
                currentPage:1,
                sort:'getByLessonsFilterByTrending',
                gradeId:this.grades[0].id,
                gradeName:this.grades[0].name,
            }
        },
        props:{
            name:{
                type:String,
                required:true,
            },
            grades:{
                type:Array,
                required:true,
            },
            newest:String,
            byDesc:String,
            byInc:String,
            byPoint:String,
            oldest:String,
            byPurchases:String,
            byTrending:String,
            sortText:String,
            categoryName:String,
            categoryDesc:String,
            hasNoContent:String,
            id:{
                type: String,
                required: true,
            },
            courseCount:{
                type: Number,
                required: true,
            },
            paginateCourse:{
                type: Number,
                require:true,
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
            moreText:{
                type:String,
                default:"Dahası"
            }
        },
        computed:{
            ...mapState([
                'categoryCourses',
                'courseCard'
            ]),
            sortBy(){
                return this.sort+'/'+this.gradeId;
            },
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
                'loadCategoryCourses',
                'loadUrlForCourseCard',
                'loadNewPageCourses'
            ]),
            urlCreate:function(sortBy,id,userId,page){
                if(userId!=''){
                    return '/api/course/'+sortBy+'/'+id+'/'+userId+'?page='+page;
                }else{
                    return '/api/course/'+sortBy+'/'+id+'?page='+page;
                }
            },
            loadCourseList: function(){
                this.$store.dispatch('loadCategoryCourses',[this.sortBy, this.id, this.userId]);
                if(this.userId!=''){
                    this.$store.dispatch('loadUrlForCourseCard', '/api/course/'+sort+'/'+this.id+'/'+this.userId);
                }else{
                    this.$store.dispatch('loadUrlForCourseCard', '/api/course/'+sort+'/'+this.id);
                }
            },
            loadNewPage: function(name,newPageNumber){
                this.$store.dispatch('loadNewPageCourses',name);
                this.$store.dispatch('loadUrlForCourseCard', name);
                this.currentPage=newPageNumber;
            },
            changeGrade:function (grade) {
                this.gradeId=grade.id;
                this.gradeName=grade.name;
                this.loadCourseList();
            }
        },
    }
</script>

<style scoped>

</style>
