<template>
    <div class="uk-card-default uk-card-hover  uk-card-small Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
        <div class="uk-transition-slide-right-small uk-position-top-right uk-padding-small uk-position-z-index">
            <a class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i v-if="fav" class="fas fa-heart icon-medium" style="color: red"> </i>
                <i v-if="!fav" class="fas fa-heart icon-medium"> </i>
            </a>
            <a class="uk-button uk-padding-remove-bottom uk-padding-remove-top course-badge">
                <i v-if="!inCart" class="fas fa-shopping-cart icon-medium"> </i>
                <i v-if="inCart" class="fas fa-shopping-cart icon-medium" style="color: limegreen"> </i>
            </a>
        </div>
        <a href="#" class="uk-link-reset">
            <img :src=imgPath class="course-img">
            <div class="uk-card-body">
                <h4>{{title}}</h4>
                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small"> {{description}} </p>
                <div>
                    <stars-rating :rating="Number(rate)"> </stars-rating>
                </div>
                <hr class="uk-margin-remove-top">
                <div>
                    <a class="uk-button uk-button-text uk-button-small" style="margin-right: 20px" href="#">Satın Al</a>
                    <a class="uk-button uk-button-text uk-button-small" :href=pageLink>İncele</a>
                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; font-weight: bold; font-size: 16px;">{{currentPrice}}$</p>
                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; text-decoration: line-through; opacity: 0.75; font-size: 13px" v-if="discount">{{prevPrice}}$</p>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
import StarsRating from "./stars-rating";
export default {
    name: "course-card",
    components: {StarsRating},
    props:{
        title: String,
        description: String,
        imgPath: String,
        rate: Number,
        prevPrice: Number,
        currentPrice: Number,
        discount: Boolean,
        pageLink: String,
        fav:{
            type:Boolean,
            default: false,
        },
        inCart:{
            type:Boolean,
            default: false,
        },
    }
}
</script>

<style>
</style>
