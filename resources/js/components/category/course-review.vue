<template>
    <div>
        <div v-for="review in courseReviews">
            <div class="uk-grid-small  uk-margin-medium-top" uk-grid>
                <div class="uk-width-1-5 uk-first-column">
                    <img alt="Image" class="uk-width-1-2 uk-margin-small-top uk-margin-small-bottom uk-border-circle uk-align-center  uk-box-shadow-large" :src="review.user.avatar">
                </div>
                <div class="uk-width-4-5 uk-padding-remove-left">
                    <div class="uk-float-right">
                        <stars-rating :rating="review.point"> </stars-rating>
                    </div>
                    <h4 class="uk-margin-remove">{{review.user.first_name}} {{review.user.last_name}}</h4>
                    <span class="uk-text-small">{{review.created_at}} </span>
                    <hr class="uk-margin-small">
                    <p class="uk-margin-remove-top uk-margin-small-bottom">{{review.content}}</p>
                </div>
            </div>
            <hr>
        </div>
    </div>
</template>
<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "course-review",
        mounted() {
            this.$store.dispatch('loadCourseReviews',this.courseId);
        },
        data(){
            return {
                currentPage:1,
            }
        },
        props:{
            courseId:{
                type:String,
                requirement:true,
            },
        },
        computed:{
            ...mapState([
                'courseReviews',
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
                'loadCourseReviews',
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
