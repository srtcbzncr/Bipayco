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
            <img :src="imgPath" class="course-img uk-background-center-center uk-background-cover uk-height" :style="image">
            <div class="uk-card-body">
                <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{title}}</h4>
                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small"> {{description}} </p>
                <div class="uk-width">
                    <stars-rating :rating="Number(rate)" :style-full-star-color="styleFullStarColor" :style-empty-star-color="styleEmptyStarColor" > </stars-rating>
                </div>
                <hr class="uk-margin-remove-top">
                <div>
                    <a class="uk-button uk-button-text uk-button-small" style="margin-right: 20px" href="#"> Satın Al</a>
                    <a class="uk-button uk-button-text uk-button-small" :href=pageLink> İncele </a>
                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; font-weight: bold; font-size: 16px;">{{currentPrice.toFixed(2)}}$</p>
                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; text-decoration: line-through; opacity: 0.75; font-size: 13px" v-if="discount">{{prevPrice.toFixed(2)}}$</p>
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
          fav:this.isFav,
          cart:this.inCart,
      }
    },
    components: {StarsRating},
    props:{
        title: String,
        description: String,
        imgPath: String,
        rate:{
            type: Number,
            default:0,
        },
        prevPrice:{
            type: Number,
            default:0,
        },
        currentPrice:{
            type: Number,
            default:0,
        },
        discount: Boolean,
        pageLink: String,
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
        isFav:{
            type:Boolean,
            default:false,
        },
        inCart:{
            type:Boolean,
            default:false,
        }
    },
    computed:{
        cPrice:function(){
            return this.currentPrice.toFixed(2);
        },
        pPrice:function () {
            return this.prevPrice.toFixed(2);
        },
        image(){
            return {backgroundImage: "url("+this.imgPath+")"};
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
    }
}
</script>

<style>
</style>
