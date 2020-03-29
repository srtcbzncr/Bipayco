<template>
    <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
        <div v-if="isLogin" class="uk-transition-slide-right-small uk-position-top-right uk-padding-small uk-position-z-index">
            <a class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i v-if="fav" @click="removeFav" class="fas fa-heart icon-medium" style="color: red"> </i>
                <i v-else  @click="addFav" class="fas fa-heart icon-medium"> </i>
            </a>
            <a class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i v-if="cart" class="fas fa-shopping-cart icon-medium" @click="removeCart" style="color: limegreen"> </i>
                <i v-else class="fas fa-shopping-cart icon-medium" @click="addCart"> </i>
            </a>
        </div>
        <a :href="pageLink" class="uk-link-reset">
            <img :src="course.image" class="course-img uk-background-center-center uk-background-cover uk-height" :style="image">
            <div class="uk-card-body">
                <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{course.name}}</h4>
                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small"> {{course.description}} </p>
                <div class="uk-width">
                    <stars-rating :rating="Number(course.point)" :style-full-star-color="styleFullStarColor" :style-empty-star-color="styleEmptyStarColor" > </stars-rating>
                </div>
                <hr class="uk-margin-remove-top">
                <div class="uk-grid uk-child-width-1-2">
                    <div>
                        <a class="uk-button uk-button-text uk-button-small" style="margin-right: 20px" href="#"> Satın Al</a>
                        <a class="uk-button uk-button-text uk-button-small" :href=pageLink> İncele </a>
                    </div>
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
            fav:this.course.inFavorite,
            cart:this.course.inBasket,
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
        }
    },
    computed:{
        image(){
            return {backgroundImage: "url("+this.imgPath+")"};
        },
        pageLink(){
            return '/'+this.module+'/course/'+this.course.id;
        }
    },
    methods:{
        ...mapActions([
           'loadShoppingCart'
        ]),
        addCart:function () {
            Axios.post('/api/basket/add', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
            .then(response=>{
                if(!response.data.error) {
                    this.cart = true;
                }
                this.$store.dispatch('loadShoppingCart',this.userId);
                console.log(response)
            })
        },
        removeCart:function () {
            Axios.post('/api/basket/delete', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
            .then(response=>{
                if(!response.data.error) {
                    this.cart = false;
                }
                this.$store.dispatch('loadShoppingCart',this.userId);
                console.log(response)
            })
        },
        addFav:function () {
            Axios.post('/api/favorite/add', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
                .then(response=>{
                    if(!response.data.error){
                        this.fav=true;
                    }
                    console.log(response)
                })
        },
        removeFav:function () {
            Axios.post('/api/favorite/delete', {
                course_id:this.courseId,
                module_name:this.moduleName,
                user_id:this.userId,
            })
                .then(response=>{
                    if(!response.data.error){
                        this.fav=false;
                    }
                    console.log(response)
                })
        }
    },
}
</script>

<style>
</style>
