<template>
    <div>
        <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas uk-align-right   uk-text-small uk-padding-small"> Hepsini Temizle</i> </a>
        <hr class=" uk-margin-remove">
        <div class="uk-text-left uk-height-medium">
            <div uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100"  style="overflow-y:auto" data-simplebar>

                <!--<div v-for="course in coursesInCart" class=" uk-padding-small  uk-background-light uk-inline-clip uk-transition-toggle" tabindex="0">
                    <div class="uk-transition-slide-right-small uk-position-top-right uk-position-z-index uk-margin-small-right">
                        <a class="uk-button uk-padding-remove" uk-icon="icon: trash" href="#"></a>
                    </div>
                    <div class="uk-transition-slide-right-medium uk-position-top-right uk-margin-medium-right">
                        <a class="uk-button uk-padding-remove" uk-icon="icon: reply" href="#"></a>
                    </div>
                    <div class="uk-flex-middle uk-grid-small uk-grid" uk-grid="">
                        <div class="uk-width-3-4">
                            <p class="uk-margin-remove-bottom uk-text-bold">{{course.name}}  </p>
                            <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; font-weight: bold; font-size: 16px;">{{currentPrice.toFixed(2)}}$</p>
                            <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right" style="float:right; text-decoration: line-through; opacity: 0.75; font-size: 13px" v-if="discount">{{prevPrice.toFixed(2)}}$</p>
                            <p class="uk-margin-remove-top uk-text-small uk-text-muted"></p>
                        </div>
                        <div class="uk-width-1-4 uk-flex-first uk-first-column">
                            <img src="#" alt="Image" class="uk-border-circle">
                        </div>
                    </div>
                </div>-->

                <div class="uk-card uk-card-default uk-grid-divider uk-child-width-1-4@s uk-margin" uk-grid>
                    <div class="uk-card-media-left uk-cover-container">
                        <img src="" alt="" class="img-small" uk-cover>
                    </div>
                    <div>
                        <div class="uk-card-body">
                            <h5 class="uk-card-title">Media Left</h5>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "messages-small-card",
        props:{
            userId:{
                type:String,

            }
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
