<template>
    <div class="uk-container">
        <div v-if="courseCount>0">
            <div class="uk-clearfix boundary-align uk-margin-medium-top">
                <div class="uk-float-left section-heading none-border">
                    <h2>{{categoryName}}</h2>
                    <p>{{categoryDesc}}</p>
                </div>
                <div class="uk-float-right uk-margin-small-top">
                    <select v-if='!subCategory' class="uk-select uk-width uk-overflow-auto" id="sortBy" @change="loadCourseList">
                        <option selected disabled value="getByCategoryFilterByTrending">{{sort}} </option>
                        <option value="getByCategoryFilterByTrending">{{byTrending}} </option>
                        <option value="getByCategoryFilterByPurchases">{{byPurchases}} </option>
                        <option value="getByCategoryFilterByPoint">{{byPoint}} </option>
                        <option value="getByCategoryFilterByPriceDESC">{{byDesc}} </option>
                        <option value="getByCategoryFilterByPriceASC">{{byInc}} </option>
                        <option value="getByCategoryFilterByNewest">{{newest}} </option>
                        <option value="getByCategoryFilterByOldest">{{oldest}} </option>
                    </select>
                    <select v-if='subCategory' class="uk-select uk-width uk-overflow-auto" id="sortBy" @change="loadCourseList">
                        <option selected disabled value="getBySubCategoryFilterByTrending">{{sort}} </option>
                        <option value="getBySubCategoryFilterByTrending">{{byTrending}} </option>
                        <option value="getBySubCategoryFilterByPurchases">{{byPurchases}} </option>
                        <option value="getBySubCategoryFilterByPoint">{{byPoint}} </option>
                        <option value="getBySubCategoryFilterByPriceASC">{{byInc}} </option>
                        <option value="getBySubCategoryFilterByPriceDESC">{{byDesc}} </option>
                        <option value="getBySubCategoryFilterByNewest">{{newest}} </option>
                        <option value="getBySubCategoryFilterByOldest">{{oldest}} </option>
                    </select>
                </div>
            </div>
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                <div v-for="course in categoryCourses.data">
                    <course-card
                        v-if="course.price!=course.price_with_discount"
                        :title="course.name"
                        :description="course.description"
                        :img-path="course.image"
                        discount
                        :current-price="course.price_with_discount"
                        :prev-price="course.price"
                        :rate="course.point"
                        :page-link="'/ge/course/'+course.id"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                    > </course-card>
                    <course-card
                        v-else
                        :title="course.name"
                        :description="course.description"
                        :img-path="course.image"
                        :current-price="course.price"
                        :rate="course.point"
                        :page-link="'/ge/course/'+course.id"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                    > </course-card>
                </div>
            </div>
            <ul class="uk-pagination uk-flex-center uk-margin-medium">
                <li>
                    <button v-show="currentPage>1" @click="loadNewPage(categoryCourses.links.prev,--currentPage)"> < </button>
                </li>
                <li v-for="page in pageNumber">
                    <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                    <button v-else @click="loadNewPage('/api/course/'+selectedSortOption+'/'+categoryId+'?page='+page,page)">{{page}}</button>
                </li>
                <li>
                    <button v-show="currentPage<(this.courseCount/this.paginateCourse)" @click="loadNewPage(categoryCourses.links.next,++currentPage)"> > </button>
                </li>
            </ul>
        </div>
        <div v-if="courseCount<=0" class="uk-flex uk-flex-center align-items-center justify-content-center uk-margin-large-top">
            <h2>{{hasNoContent}}</h2>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "course-card-pagination",
        mounted() {
            if (this.courseCount>0) {
                this.$store.dispatch('loadCategoryCourses', this.categoryId);
            }
        },
        data(){
            return {
                currentPage:1,
            }
        },
        props:{
            newest:String,
            byDesc:String,
            byInc:String,
            byPoint:String,
            oldest:String,
            byPurchases:String,
            byTrending:String,
            sort:String,
            categoryName:String,
            categoryDesc:String,
            hasNoContent:String,
            categoryId:{
                type: String,
                required: true,
            },
            subCategory:Boolean,
            courseCount:{
              type: Number,
              required: true,
            },
            paginateCourse:{
                type: Number,
                require:true,
            },
        },
        computed:{
            ...mapState([
                'categoryCourses',
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.lastPage; i++){
                    if(i==2 && this.currentPage-2>3){
                        pages.push('...');
                        if(this.currentPage+3>this.lastPage){
                            index=this.lastPage-6;
                        }else{
                            index=this.currentPage-2;
                        }
                    }else if(i==8 && this.currentPage+2<this.lastPage-2){
                        pages.push('...');
                        index=this.lastPage;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
            lastPage(){
                if(this.categoryCourses.meta!=null) {
                    return this.categoryCourses.meta.last_page;
                }else{
                    return 20;
                }
            },
            selectedSortOption(){
                return document.getElementById("sortBy").value;
            }
        },
        methods:{
            ...mapActions([
                'loadCategoryCourses',
            ]),
            loadCourseList: function(){
                this.$store.dispatch('loadCategoryCourses',this.categoryId);
            },
            loadNewPage: function(name,newPageNumber){
                this.$store.dispatch('loadNewPageCourses',name);
                this.currentPage=newPageNumber;
            }
        },
    }
</script>

<style scoped>

</style>
