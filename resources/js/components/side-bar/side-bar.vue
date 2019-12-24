<template>
    <!--Mobile icon wiill close nav-side   -->
    <div id="side-nav">
        <div class="side-nav-bg"></div>
        <div class="uk-navbar-left uk-visible@s">
            <a class="uk-logo" :href="homeRoute"> <i class="fas fa-graduation-cap"/> </a>
        </div>
            <ul>
                <li>
                    <a href="#"> <i class="fas fa-play"> </i> </a>
                    <div class="side-menu-slide" style="overflow-y: auto">
                        <div class="side-menu-slide-content" >
                            <a class="uk-background-grey uk-margin-remove general-title" style=":hover "><b>{{generalEducation}}</b></a>
                            <ul uk-accordion>
                                <li v-for="category in categories" class=" uk-margin-remove-top">
                                    <a class="uk-accordion-title" :id="category.id"> <i class="fas fa-layer-group"> </i>{{category.name}}</a>
                                    <div class="uk-accordion-content uk-margin-remove-top">
                                        <a :href="homeRoute+'/ge/category/'+category.id">{{allOfCategory}}</a>
                                        <a v-for="subCategory in category.sub_categories.data" :href="homeRoute+'/ge/subCategory/'+subCategory.id" :id="subCategory.id">
                                            {{subCategory.name}}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            <li>
                <!-- scripts -->
                <a href="#"> <i class="fas fa-code"/> </a>
                <div class="side-menu-slide">
                    <div class="side-menu-slide-content">
                        <ul>
                            <li>
                                <a href="Scripts.html"> <i class="fas fa-code icon-medium"/> Browse All Scripts </a>
                            </li>
                            <li>
                                <a href="Scripts_single_page.html"> <i class="fab fa-wordpress icon-medium"/>   Cms Plugins </a>
                            </li>
                            <li>
                                <a href="Scripts_single_page.html"> <i class="fab fa-php icon-medium"/>   PHP Scripts </a>
                            </li>
                            <li>
                                <a href="Scripts_single_page.html"> <i class="fab fa-wordpress-simple icon-medium"/> Cms themes </a>
                            </li>
                            <li>
                                <a href="Scripts_single_page.html"> <i class="fab fa-html5 icon-medium"/> Html templates  </a>
                            </li>
                            <li>
                                <a href="Scripts_single_page.html"> <i class="fab fa-android icon-medium"/>  Apps Source codes </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <a href="Discussion.html" class="active" uk-tooltip="title: Discussion ; delay: 500 ; pos: right ;animation:	uk-animation-scale-up"> <i class="fas fa-comment-alt"></i> </a>
            </li>
            <li>
                <!-- blog -->
                <a href="Blog.html" class="active" uk-tooltip="title: Blogs ; delay: 500 ; pos: right ;animation:	uk-animation-scale-up"> <i class="fas fa-file-alt"></i> </a>
            </li>
            <li>
                <!-- ui compounents -->
                <a href="#"> <i class="fas fa-columns"></i> </a>
                <div class="side-menu-slide">
                    <div class="side-menu-slide-content">
                        <ul uk-accordion>

                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <!-- Site pages -->
                <a href="#"> <i class="fas fa-clone"></i> </a>
                <div class="side-menu-slide">
                    <div class="side-menu-slide-content">
                        <ul>
                            <li>
                                <a href="pages-about.html"> <i class="fas fa-question"></i>   About  </a>
                                <div uk-drop="pos: right-center;animation: uk-animation-slide-left-medium" class="uk-drop uk-drop-right-center">
                                    <div class="uk-card  uk-box-shadow-xlarge uk-card-default uk-maring-small-left">
                                        <img src="#" alt="">
                                        <p class="uk-padding-small uk-margin-remove"> About Page is : ipsum dolor sit amet, consectetur adipiscing elit.. </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="pages-faq.html"> <i class="fas fa-comment-alt"></i> FAQ  </a>
                                <div uk-drop="pos: right-center;animation: uk-animation-slide-left-medium" class="uk-drop uk-drop-right-center">
                                    <div class="uk-card  uk-box-shadow-xlarge uk-card-default uk-maring-small-left">
                                        <img src="#" alt="">
                                        <p class="uk-padding-small uk-margin-remove">  FAQ is : ipsum dolor sit amet, consectetur adipiscing elit </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="pages-terms.html"> <i class="fas fa-comment-dots"></i>  Terms &amp; Services </a>
                                <div uk-drop="pos: right-center;animation: uk-animation-slide-left-medium" class="uk-drop uk-drop-right-center">
                                    <div class="uk-card  uk-box-shadow-xlarge uk-card-default uk-maring-small-left">
                                        <img src="#" alt="">
                                        <p class="uk-padding-small uk-margin-remove">  Term Services ipsum dolor sit amet, consectetur adipiscing elit </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="pages-help.html"> <i class="fas fa-comments"></i> Help </a>
                                <div uk-drop="pos: right-center;animation: uk-animation-slide-left-medium" class="uk-drop uk-drop-right-center">
                                    <div class="uk-card  uk-box-shadow-xlarge uk-card-default uk-maring-small-left">
                                        <img src="#" alt="">
                                        <p class="uk-padding-small uk-margin-remove">  help Page ipsum dolor sit amet, consectetur adipiscing elit </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="uk-position-bottom">
            <li>
                <!-- Lunch information box -->
                <a href="#" uk-tooltip="title: Lunch information box ; delay: 500 ; pos: right ;animation:	uk-animation-scale-up" uk-toggle="target: #infoBox; cls: infoBox-active"><i class="fas fa-question"></i> </a>
            </li>
            <li>
                <!-- Night mode button  -->
                <a href="#" uk-tooltip="title: Night mode ; delay: 500 ; pos: right ;animation:	uk-animation-scale-up"> <i class="fas fa-moon"></i> </a>
                <div uk-drop="pos: right-bottom ;mode:click ; offset: 10;animation: uk-animation-slide-left-medium" class="uk-drop">
                    <div class="uk-card-small uk-box-shadow-xlarge uk-card-default uk-maring-small-left  border-radius-6">
                        <div class="uk-card uk-card-default border-radius-6">
                            <div class="uk-card-header">
                                <h5 class="uk-card-title uk-margin-remove-bottom">Swich to night mode</h5>
                            </div>
                            <div class="uk-card-body">
                                <p>Turns the light surfaces of the page dark, creating an experience ideal for night. Try it!</p>
                                <p class="uk-text-small uk-align-left uk-margin-remove  uk-text-muted">DARK THEME </p>
                                <!-- night mode button -->
                                <div class="btn-night uk-align-right" id="night-mode">
                                    <label class="tm-switch">
                                        <div class="uk-switch-button"></div>
                                    </label>
                                </div>
                                <!-- end  night mode button -->
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import {mapState,mapActions} from 'vuex';
export default {
    name: "side-bar",
    props:{
        homeRoute:String,
        generalEducation:String,
        allOfCategory:String,
    },
    computed:{
        ...mapState([
            'categories',
        ]),
    },
    methods: {
        ...mapActions([
            'loadCategories'
        ]),
    },
    created() {
        this.$store.dispatch('loadCategories');
    },
}
</script>

<style scoped>
    .general-title:hover{
        background: white;
        color:#3F4850;
    }
</style>
