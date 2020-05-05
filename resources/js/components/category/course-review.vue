<template>
    <div>
        <div v-for="review in courseReviews.data">
            <div class="uk-grid-small  uk-margin-medium-top" uk-grid>
                <div class="uk-width-1-5@m uk-first-column">
                    <img alt="Image" class="uk-visible@m uk-width-1-2 uk-margin-small-top uk-margin-small-bottom uk-border-circle uk-align-center  uk-box-shadow-large" :src="review.user.avatar">
                </div>
                <div class="uk-width-4-5@m uk-padding-remove-left">
                    <div class="uk-flex justify-content-between">
                        <div class="uk-width-3-4">
                            <h4 class="uk-margin-remove">{{review.user.first_name}} {{review.user.last_name}}</h4>
                            <span class="uk-text-small">{{dateFormat(review.created_at)}}</span>
                        </div>
                        <stars-rating :rating="Number(review.point)" style-full-star-color="#F4C150" style-empty-star-color="#C1C1C1" :style-star-width="14" :style-star-height="14"> </stars-rating>

                    </div>
                    <hr class="uk-margin-small">
                    <p class="uk-margin-remove-top uk-margin-small-bottom">{{review.content}}</p>
                </div>
            </div>
            <hr>
        </div>
        <ul class="uk-pagination uk-flex-center uk-margin-medium">
            <li class="uk-float-left">
                <button v-show="currentPage!==1" @click="loadNewPages(courseReviews.links.prev,--currentPage)"> < </button>
            </li>
            <li class="uk-float-right">
                <button v-show="currentPage<lastPage" @click="loadNewPages(courseReviews.links.next,++currentPage)"> > </button>
            </li>
        </ul>
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
                isLoaded:false,
            }
        },
        props:{
            courseId:{
                type:String,
                requirement:true,
            },
            reviewCount:{
                type:Number,
                requirement:true,
            },
            minuteBeforeText:{
                type:String,
                default:"dakika önce"
            },
            hourBeforeText:{
                type:String,
                default:"saat önce"
            },
            dayBeforeText:{
                type:String,
                default:"gün önce"
            },
            monthBeforeText:{
                type:String,
                default:"ay önce"
            },
            yearBeforeText:{
                type:String,
                default:"yıl önce"
            }
        },
        computed:{
            ...mapState([
                'courseReviews',
            ]),
            lastPage(){
                if(this.courseReviews.meta!=null) {
                    return this.courseReviews.meta.last_page;
                }else{
                    return 20;
                }
            },
        },
        methods:{
            ...mapActions([
                'loadCourseReviews',
                'loadNewPageReviews'
            ]),
            dateFormat:function (date) {
                let created=new Date(date);
                let today=new Date();
                if(today.getFullYear()-created.getFullYear()>1){
                    return (today.getFullYear()-created.getFullYear())+" "+this.yearBeforeText;
                }else if(today.getMonth()-created.getMonth()>1){
                    return (today.getMonth()-created.getMonth())+" "+this.monthBeforeText;
                }else if(today.getDate()-created.getDate()>1) {
                    return (today.getDate() - created.getDate()) + " " + this.dayBeforeText;
                }else if(today.getHours()-created.getHours()>1) {
                    return (today.getHours() - created.getHours()) + " " + this.hourBeforeText;
                }else{
                    return (today.getMinutes() - created.getMinutes()) + " " + this.minuteBeforeText;
                }
            },
            loadNewPages: function(name,newPageNumber){
                this.$store.dispatch('loadNewPageReviews',name);
                this.currentPage=newPageNumber;
            }
        },
    }
</script>
<style scoped>

</style>
