<template>
    <div class="uk-container">
        <div v-if="courseCount>0">
            <div class="uk-clearfix boundary-align uk-margin-medium-top">
                <div class="uk-float-left section-heading none-border">
                    <h2>{{categoryName}}</h2>
                    <p>{{categoryDesc}}</p>
                </div>
                <div class="uk-float-right">
                    <span class="uk-text-small uk-text-uppercase uk-width-1-2"> {{sort}} :</span>
                    <select v-if='!subCategory' class="uk-select uk-margin-remove uk-width-1-2 uk-overflow-auto" id="sortBy" @change="loadCourseList">
                        <option selected value="getByCategoryFilterByTrending">{{byTrending}} </option>
                        <option value="getByCategoryFilterByPurchases">{{byPurchases}} </option>
                        <option value="getByCategoryFilterByPoint">{{byPoint}} </option>
                        <option value="getByCategoryFilterByPriceDESC">{{byDesc}} </option>
                        <option value="getByCategoryFilterByPriceASC">{{byInc}} </option>
                        <option value="getByCategoryFilterByNewest">{{newest}} </option>
                        <option value="getByCategoryFilterByOldest">{{oldest}} </option>
                    </select>
                    <select v-if='subCategory' class="uk-select uk-margin-remove uk-width-1-2 uk-overflow-auto" id="sortBy" @change="loadCourseList">
                        <option selected value="getBySubCategoryFilterByTrending">{{byTrending}} </option>
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
                        page-link="#"
                        > </course-card>
                    <course-card
                        v-else
                        :title="course.name"
                        :description="course.description"
                        :img-path="course.image"
                        :current-price="course.price"
                        :rate="course.point"
                        page-link="#"
                    > </course-card>
                </div>
            </div>

            <ul class="uk-pagination uk-flex-center uk-margin-medium">
                <li>
                    <button v-show="currentPage>1" @click="loadNewPage(categoryCourses.links.prev)"> < </button>
                </li>
                <li v-for="page in pageNumber">
                    <button @click="loadNewPage('/api/course/'+selectedSortOption+'/'+categoryId+'?page='+page,page)">{{page}}</button>
                </li>
                <li>
                    <button v-show="currentPage<(this.courseCount/this.paginateCourse)" @click="loadNewPage(categoryCourses.links.next)"> > </button>
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
            if (this.courseCount>0){
                this.$store.dispatch('loadCategoryCourses',this.categoryId);
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
            }
        },
        computed:{
            ...mapState([
                'categoryCourses',
            ]),
            pageNumber(){
                var pages=['1'];
                if(this.currentPage > 4){
                    pages.push('...');
                    for(var i=currentPage-2;i<currentPage+3;i++){
                        pages.push(i);
                    }
                }else{
                    for (var i=2;i<(this.courseCount/this.paginateCourse)+1;i++){

                        pages.push(i);
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
            ]),
            loadCourseList: function(){
                this.$store.dispatch('loadCategoryCourses',this.categoryId);
            },
            loadNewPage: function(name,newPageNumber){
                this.$store.dispatch('loadNewPageCourses',name);
                if(name==this.categoryCourses.links.next){
                    this.currentPage++;
                }
                else if (name==this.categoryCourses.links.prev){
                    this.currentPage--;
                }else{
                    this.currentPage=newPageNumber;
                }
            }
        },
    }
</script>

<style scoped>

</style>
