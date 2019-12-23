<template>
    <div>
        <div class="uk-card-default uk-card-hover  uk-card-small Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
            <div class="uk-transition-slide-right-small uk-position-top-right uk-padding-small uk-position-z-index">
                <a class="uk-button course-badge"> <i class="fas fa-shopping-cart icon-medium"></i> </a>
            </div>
            <a href="#" class="uk-link-reset">
                <img :src=imgPath class="course-img">
                <div class="uk-card-body">
                    <h4>{{title}}</h4>
                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small"> {{description}} </p>
                    <div>
                        <!--<span class="uk-margin-small-top uk-margin-small-bottom" uk-icon="star"></span>
                        <span class="uk-margin-small-top uk-margin-small-bottom" uk-icon="star"></span>
                        <span class="uk-margin-small-top uk-margin-small-bottom" uk-icon="star"></span>
                        <span class="uk-margin-small-top uk-margin-small-bottom" uk-icon="star"></span>
                        <span class="uk-margin-small-top uk-margin-small-bottom" uk-icon="star"></span>-->
                        <p>{{rank}}/5.0</p>
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
    </div>
</template>

<script>
export default {
    name: "course-card",
    props:{
        title: String,
        description: String,
        imgPath: String,
        rank: String,
        prevPrice: String,
        currentPrice: String,
        discount: Boolean,
        pageLink: String,
    }
}
</script>

<style>
</style>
