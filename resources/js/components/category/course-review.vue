<template>
    <div>
        <div v-for="review in courseReviews.data">
            <div :class="'review'+review.user_id" class="uk-grid-small  uk-margin-medium-top" uk-grid>
                <div class="uk-width-1-5@m uk-first-column">
                    <img alt="Image" class="uk-visible@m uk-width-1-2 uk-margin-small-top uk-margin-small-bottom uk-border-circle uk-align-center  uk-box-shadow-large" :src="review.user.avatar">
                </div>
                <div class="uk-width-4-5@m uk-padding-remove-left">
                    <span v-if="review.user_id==userId" class="uk-float-right">
                        <button class="uk-button-default" type="button"><i class="fas fa-ellipsis-v"></i></button>
                        <div uk-dropdown="mode:click" class="uk-padding-small border-radius-6">
                            <ul class="uk-nav uk-dropdown-nav">
                                <li><a :uk-toggle="'target: .review'+userId">{{editText}}</a></li>
                                <li><a @click="deleteReview(review.id)" class="uk-text-danger">{{deleteText}}</a></li>
                            </ul>
                        </div>
                    </span>
                    <h4 class="uk-margin-remove-vertical uk-margin-small-right">{{review.user.first_name}} {{review.user.last_name}}</h4>
                    <div class="uk-width uk-flex uk-flex-wrap align-item-center justify-content-between uk-margin-small-top">
                        <p class="uk-margin-small-top uk-margin-small-bottom uk-text-justify uk-width-1-2@m">{{dateFormat(review.created_at)}}</p>
                        <stars-rating :rating="Number(review.point)" style-full-star-color="#F4C150" style-empty-star-color="#C1C1C1" :style-star-width="18" :style-star-height="18"> </stars-rating>
                    </div>
                    <hr class="uk-margin-small">
                    <p class="uk-margin-remove-top uk-margin-small-bottom">{{review.content}}</p>
                </div>
            </div>
            <div v-if="userId==review.user_id" :class="'review'+userId" hidden>
                <review
                    :review="review.content"
                    :rating="Number(review.point)"
                    :module-name="moduleName"
                    :course-id="courseId.toString()"
                    :user-id="userId.toString()"
                    :send-text="updateText"
                    :cancel-text="cancelText"
                    :comment-text="commentText"
                    :api-status="'update/'+review.id"
                    is-update
                > </review>
            </div>
            <hr>
        </div>
        <ul class="uk-pagination uk-flex-center uk-margin-medium">
            <li class="uk-float-left">
                <button v-show="courseReviews.current_page!==1" @click="loadNewPages(courseReviews.prev_page_url)"> < </button>
            </li>
            <li class="uk-float-right">
                <button v-show="courseReviews.current_page<courseReviews.last_page" @click="loadNewPages(courseReviews.next_page_url)"> > </button>
            </li>
        </ul>
    </div>
</template>
<script>
    import {mapActions, mapState} from "vuex";
    import Axios from 'axios';
    export default {
        name: "course-review",
        mounted() {
            this.$store.dispatch('loadCourseReviews',[this.module,this.courseId]);
        },
        data(){
            return {
                apiUrl:'/api/comment/'+this.module+'/'+this.courseId+'/comments',
            }
        },
        props:{
            courseId:{
                type:String,
                required:true,
            },
            userId:{
                type:String,
                default:""
            },
            moduleName:{
                type:String,
                required:true,
            },
            reviewCount:{
                type:Number,
                required:true,
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
            },
            editText:{
                type:String,
                default:"Düzenle",
            },
            deleteText:{
                type:String,
                default:"Sil",
            },
            cancelText:{
                type:String,
                default:"Vazgeç",
            },
            commentText:{
                type:String,
                default:"Yorum Yaz...",
            },
            updateText:{
                type:String,
                default:"Güncelle",
            },
        },
        computed:{
            ...mapState([
                'courseReviews',
            ]),
            module(){
                switch (this.moduleName) {
                    case 'prepareLessons': return 'pl';
                    case 'prepareExams': return 'pe';
                    default: return 'ge';
                }
            }
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
            loadNewPages: function(name){
                this.apiUrl=name;
                this.$store.dispatch('loadNewPageReviews',name);
            },
            deleteReview:function (id) {
                Axios.post('/api/comment/'+this.module+'/delete/'+id)
                    .then((response) => {
                        if(response.data.error){
                            UIkit.notification({message: response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: response.data.message, status: 'success'});
                        }
                        document.location.reload();
                    }).catch((error)=>{
                    if(error.response) {
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }});
            },
        },
    }
</script>
<style scoped>

</style>
