<template>
    <div class="uk-container">
        <div v-if="courseCount>0">
            <div class="uk-clearfix boundary-align uk-margin-medium-top">
                <div class="uk-float-left section-heading none-border">
                    <h2>Browse Web development courses</h2>
                    <p>Adipisici elit, sed eiusmod tempor incidunt ut labore et</p>
                </div>
                <div class="uk-float-right">
                    <span class="uk-text-small uk-text-uppercase uk-width-1-2"> Sort by :</span>
                    <select class="uk-select uk-margin-remove uk-width-1-2 uk-overflow-auto" id="sortBy" @change="loadCourseList">
                        <option value="getByCategoryFilterByPurchases">satın alıma</option>
                        <option value="getByCategoryFilterByNewest">Newest Courses</option>
                        <option value="getByCategoryFilterByPoint">Puana göre </option>
                        <option value="getByCategoryFilterByOldest">Oldest Courses</option>
                        <option value="getByCategoryFilterByPriceASC"> Artan </option>
                        <option value="getByCategoryFilterByPriceDESC">Azalan</option>
                        <option selected value="getByCategoryFilterByTrending">Trending Courses</option>
                    </select>
                </div>
            </div>
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                <div v-for="course in categoryCourses.data">
                    <course-card
                        v-if="course.discount"
                        :title="course.name"
                        :description="course.description"
                        :img-path="course.image"
                        discount
                        :current-price="course.discount.price_with_discount"
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
                    <button @click="loadNewPage(categoryCourses.links.prev)"> < </button>
                </li>
                <li v-for="page in pageNumber">
                    <button @click="loadNewPage('http://127.0.0.1:8000/api/course/'+selectedSortOption+'/'+categoryId+'?page='+page)">{{page}}</button>
                </li>
                <li>
                    <button @click="loadNewPage(categoryCourses.links.next)"> > </button>
                </li>
            </ul>
        </div>
        <div v-if="courseCount<=0" class="uk-flex uk-flex-center align-items-center justify-content-center uk-margin-large-top">
            <h2>Burada Kurs Yok</h2>
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
                pages:[],
            }
        },
        props:{
            categoryId:{
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
            }
        },
        computed:{
            ...mapState([
                'categoryCourses'
            ]),
            pageNumber(){
                for (var i=1;i<(this.courseCount/this.paginateCourse)+1;i++){
                    this.pages.push(i);
                }
                return this.pages;
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
            loadNewPage: function(name){
                this.$store.dispatch('loadNewPageCourses',name);
            }
        },


    }
</script>

<style scoped>

</style>
