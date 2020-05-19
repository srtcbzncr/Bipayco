<template>
    <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
        <div v-if="isLogin&&!course.inEntry" class="uk-transition-slide-right-small uk-position-top-right uk-padding-small uk-position-z-index">
            <a v-if="course.inFavorite" @click="removeFav" class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i class="fas fa-heart icon-medium" style="color: red"> </i>
            </a>
            <a v-else @click="addFav" class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i class="fas fa-heart icon-medium"> </i>
            </a>
            <a v-if="course.inBasket" @click="removeCart" class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i class="fas fa-shopping-cart icon-medium" style="color: limegreen"> </i>
            </a>
            <a v-else @click="addCart" class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i class="fas fa-shopping-cart icon-medium" > </i>
            </a>
        </div>
        <a :href="pageLink" class="uk-link-reset">
            <div class="course-img uk-background-center-center uk-background-cover uk-panel uk-flex uk-flex-center uk-flex-middle" :style="'background-image: url('+course.image+')'"></div>
            <div class="uk-card-body">
                <div v-if="moduleName=='generalEducation'">
                    <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 25px; max-height: 25px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-height-small">{{course.name}}</h4>
                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-height-small">{{subCategory.name}}</p>
                </div>
                <div v-if="moduleName=='prepareLessons'">
                    <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 25px; max-height: 25px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-height-small">{{course.name}}</h4>
                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-height-small">{{grade.name}}</p>
                </div>
                <div v-if="moduleName=='prepareExams'">
                    <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 25px; max-height: 25px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-height-small">{{course.name}}</h4>
                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-height-small">{{exam.name}}</p>
                </div>
                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small"> {{course.description}} </p>
                <div class="uk-width">
                    <stars-rating :rating="Number(course.point)" :style-full-star-color="styleFullStarColor" :style-empty-star-color="styleEmptyStarColor" > </stars-rating>
                </div>
                <hr class="uk-margin-remove-top">
                <div class="uk-flex justify-content-end uk-child-width-1-2">
<!--                    <div>-->
<!--                        <a class="uk-button uk-button-text uk-button-small" style="margin-right: 20px" href="#"> Satın Al</a>-->
<!--                        <a class="uk-button uk-button-text uk-button-small" :href=pageLink> İncele </a>-->
<!--                    </div>-->
                    <div v-if="course.price_with_discount!==course.price" class=" uk-margin-remove uk-padding-remove">
                        <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; font-weight: bold; font-size: 16px;">{{course.price_with_discount.toFixed(2)}} <i class="fas fa-lira-sign icon-tiny"></i></p>
                        <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; text-decoration: line-through; opacity: 0.75; font-size: 13px">{{course.price.toFixed(2)}} <i class="fas fa-lira-sign icon-tiny"></i></p>
                    </div>
                    <div v-else class=" uk-margin-remove uk-padding-remove">
                        <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; font-weight: bold; font-size: 16px;">{{course.price.toFixed(2)}} <i class="fas fa-lira-sign icon-tiny"></i></p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>
<script>
import StarsRating from "./stars-rating";
import {mapActions} from 'vuex'
import Axios from 'axios';
export default {
    name: "course-card",
    data(){
        return{
        }
    },
    components: {StarsRating},
    props:{
        course:{
            type:Object,
            required:true,
        },
        styleFullStarColor:String,
        styleEmptyStarColor:String,
        courseId:{
            type:Number,
            required:true,
        },
        moduleName:{
            type:String,
            required:true,
        },
        isLogin:{
            type:Boolean,
            default:false
        },
        userId:{
            type:String,
            default:"",
        },
        module:{
            type:String,
            required:true,
        },
    },
    computed:{
        image(){
            return {backgroundImage: "url("+this.imgPath+")"};
        },
        pageLink(){
            return '/'+this.module+'/course/'+this.course.id;
        },
        grade(){
            if(this.course.grade){
                return this.course.grade
            }else{
                return {name:''}
            }
        },
        subCategory(){
            if(this.course.subCategory){
                return this.course.subCategory
            }else{
                return {name:''}
            }
        },
        exam(){
            if(this.course.exam){
                return this.course.exam
            }else{
                return {name:''}
            }
        },
    },
    methods:{
        ...mapActions([
            'loadShoppingCart',
            'loadCourseCard',
            'loadIsInCart'
        ]),
        addCart:function () {
            Axios.post('/api/basket/add', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
            .then(response=>{
                this.$store.dispatch('loadShoppingCart',this.userId);
                this.$store.dispatch('loadCourseCard');
                this.$store.dispatch('loadIsInCart', [this.module, this.userId, this.courseId]);
            })
        },
        removeCart:function () {
            Axios.post('/api/basket/delete', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
            .then(response=>{
                this.$store.dispatch('loadShoppingCart',this.userId);
                this.$store.dispatch('loadCourseCard');
                this.$store.dispatch('loadIsInCart', [this.module, this.userId, this.courseId]);
            })
        },
        addFav:function () {
            Axios.post('/api/favorite/add', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
                .then(response=>{
                    this.$store.dispatch('loadCourseCard');
                })
        },
        removeFav:function () {
            Axios.post('/api/favorite/delete', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
                .then(response=>{
                    this.$store.dispatch('loadCourseCard');
                })
        }
    },
}
</script>

<style>
</style>
