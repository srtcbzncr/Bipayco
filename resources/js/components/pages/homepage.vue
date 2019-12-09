<template>
    <div>
        <div class="side-nav uk-animation-slide-left-medium" id="side-nav">
            <span class="uk-animation-fade tm-mobile-close-icon" uk-toggle="target: #side-nav; cls: side-nav-active"> <i class="fas fa-times icon-large"></i></span>
            <side-bar/>
        </div>
        <div class="app">
            <top-bar/>
            <div data-src="../assets/images/backgrounds/Homepage-logo.jpg" style="background-color: #3e474f57;background-blend-mode: color-burn;" uk-img class="tm-hero uk-height-large uk-background-norepeat  uk-background-center-center uk-section uk-flex uk-flex-bottom uk-background-cover">
                <div class="uk-width-1-1 uk-container uk-margin-large-top uk-margin-large-left ">
                    <h1 class="uk-text-bold uk-text-white uk-margin-small-bottom"> Learn to code. <br>  One project at a time</h1>
                    <h4 class="uk-text-bold uk-light uk-margin-remove-top">Learn how to Build websites apps & games for free   </h4>
                    <a class="uk-button tm-button-grey" href="#browse-corses" uk-scroll>
                        Browse Courses </a>
                </div>
            </div>
            <!--page contents-->
            <div class="uk-container uk-margin-medium-top" id="more">
                <div uk-grid>
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        <course-card/>
                        <course-card/>
                        <course-card/>
                        <course-card/>
                        <course-card/>
                        <course-card/>
                        <course-card/>
                        <course-card/>
                        <course-card/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import TopBar from "../top-bar/top-bar.vue";
import SideBar from "../side-bar/side-bar.vue";
import CourseCard from "../course-card.vue";
export default {
    name: 'homepage',
    components: {
        CourseCard,
        SideBar,
        TopBar,
    }
}
</script>

<style>

</style>
