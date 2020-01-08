<template>
    <!--  Top bar nav -->
    <nav class=" tm-mobile-header uk-animation-slide-top uk-background-blend-lighten uk-position-z-index" uk-navbar >
        <!-- mobile icon for side nav on nav-mobile-->
        <span class="uk-hidden@m tm-mobile-menu-icon" uk-toggle="target: #side-nav; cls: side-nav-active"><i class="fas fa-bars icon-large"></i></span>
        <!-- mobile icon for user icon on nav-mobile -->
        <span class="uk-hidden@m tm-mobile-user-icon uk-align-right" uk-toggle="target: #tm-show-on-mobile; cls: tm-show-on-mobile-active"><i class="far fa-user icon-large"></i></span>
        <!-- mobile logo -->
        <a class="uk-hidden@m uk-logo" :href="homeRoute"> Bipayco </a>
        <div class="uk-navbar-left uk-visible@m" v-if="hasLogin === true">
            <a class="uk-navbar-item back-to-dashboard uk-button-text " href="#" style="color: #424242" uk-tooltip="title: back-to-dashboard ; delay: 700 ; pos: bottom-left ;animation:	uk-animation-scale-up">Kontrol Panelim</a>
            <a class="uk-navbar-item back-to-dashboard uk-button-text " style="color: #424242" href="#">Browse Books</a>
        </div>
        <div class="uk-navbar-right tm-show-on-mobile uk-flex-right" id="tm-show-on-mobile" >
            <!-- this will clouse after display user icon -->
            <span class="uk-hidden@m tm-mobile-user-close-icon uk-align-right" uk-toggle="target: #tm-show-on-mobile; cls: tm-show-on-mobile-active"><i class="fas fa-times icon-large"></i></span>
            <ul class="uk-navbar-nav uk-flex-middle">
                <li>
                    <a href="#modal-full" uk-toggle><i style="color: #424242" class="fas fa-search icon-medium"></i></a>
                </li>

                <li v-if="hasLogin === true">
                    <!-- your courses -->
                    <a href="#"> <i style="color: #424242" class="fas fa-play icon-medium" uk-tooltip="title: Kurslarım ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"></i></a>
                    <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown border-radius-6  uk-dropdown-top-right tm-dropdown-large uk-padding-remove">
                        <div class="uk-clearfix">
                            <div class="uk-float-left">
                                <h5  class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left">  Kurslarım </h5>
                            </div>
                        </div>
                        <hr class=" uk-margin-remove">
                        <div class="uk-padding-smaluk-text-left uk-height-medium">
                            <div v-if="myCourses.courses != null" class="demo1" data-simplebar style="overflow-y:auto">
                                <div v-if="myCourses.courses.ge.length>0" class="uk-child-width-1-2@s  uk-grid-small uk-padding-small"  uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100 ;repeat: true" uk-grid>
                                    <div  v-for="myCourse in myCourses.courses.ge">
                                        <a :href="'/ge/course/'+myCourse.course.id" class="uk-link-reset">
                                            <div class="uk-padding-small uk-card-default">
                                                <progress id="js-progressbar" class="uk-progress progress-green uk-margin-small-bottom" :value="myCourse.progress" max="100" style="height: 7px;"></progress>
                                                <img :src="myCourse.course.image" class="uk-align-left  uk-margin-small-right uk-margin-small-bottom  uk-width-1-3  uk-visible@s" alt="">
                                                <p class="uk-text-bold uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{myCourse.course.name}} </p>
                                                <p class="uk-text-small uk-margin-remove" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{myCourse.course.description}}</p>
                                                <div class="uk-margin-small">
                                                    <a class="Course-tags uk-margin-small-right   border-radius-6" href=""> <i class="fas fa-play"></i> Devam Et</a>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class=" uk-margin-remove">
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold uk-text-center"><a class="uk-link-heading" href="#"> Tümünü Gör </a> </h5>
                    </div>
                </li>
                <li v-if="hasLogin === true">
                    <!-- messages -->
                    <a href="#"><i style="color: #424242" class="fas fa-shopping-cart icon-medium" uk-tooltip="title: Sepetim ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"></i></a>
                    <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-medium border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> Sepetim </h5>
                        <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas fa-trash uk-align-right   uk-text-small uk-padding-small"> Hepsini Temizle</i> </a>
                        <hr class=" uk-margin-remove">
                        <div class="uk-text-left uk-height-medium">
                            <div uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100"  style="overflow-y:auto" data-simplebar>
                                <messages-small-card/>
                                <hr class=" uk-margin-remove">
                                <messages-small-card/>
                                <hr class=" uk-margin-remove">
                                <messages-small-card/>
                                <hr class=" uk-margin-remove">
                                <messages-small-card/>
                                <hr class=" uk-margin-remove">
                                <messages-small-card/>
                                <hr class=" uk-margin-remove">
                                <messages-small-card/>
                                <hr class="uk-margin-remove">
                            </div>
                        </div>
                        <hr class=" uk-margin-remove">
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold uk-text-center"><a class="uk-link-heading" href=""> Satın Al </a> </h5>
                    </div>
                </li>
                <li v-if="hasLogin === true">
                    <!-- Notifications -->
                    <a href="#"><i style="color: #424242" class="fas fa-bell icon-medium" uk-tooltip="title: Bildirimler ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"> </i></a>
                    <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-small border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> Bildirimler </h5>
                        <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas fa-trash uk-align-right   uk-text-small uk-padding-small"> Hepsini Temizle</i></a>
                        <hr class=" uk-margin-remove">
                        <div class="uk-text-left uk-height-medium">
                            <div data-simplebar style="overflow-y:auto">
                                <div class="uk-padding-small"  uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                    <notification-card/>
                                    <hr class="uk-margin-remove">
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li v-if="hasLogin === true">
                    <!-- User profile -->
                    <a href="#">
                        <img :src="profileImage" alt="" class="uk-border-circle user-profile-tiny">
                    </a>
                    <user-profile-dropdown-nav
                        :settings-route="settingsRoute"
                        :logout-route="logoutRoute"
                        :profile-image="profileImage"
                        :user-name="userName"
                        :user-city="userCity"
                        :log-out="logOut"
                        :settings="settings"
                        :profile="profile"
                        :profile-route="profileRoute"
                    />
                </li>
                <li v-if="hasLogin === false">
                   <a :href="loginRoute" class="uk-padding-remove uk-margin-small-left"><button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical">{{loginName}}</button></a>
                </li>
                <li v-if="hasLogin === false">
                    <a :href="registerRoute" class="uk-padding-remove uk-margin-small-left"><button class="uk-button uk-button-danger uk-padding-small uk-padding-remove-vertical">{{registerName}}</button></a>
                </li>
            </ul>
        </div>
        <div id="modal-full" class="uk-modal-full uk-modal uk-animation-scale-down" uk-modal>
            <div class="uk-modal-dialog uk-flex uk-flex-center" uk-height-viewport>
                <button class="uk-modal-close-full" type="button" uk-close> </button>
                <form class="uk-search uk-margin-xlarge-top uk-search-large uk-animation-slide-bottom-medium">
                    <i class="fas fa-search uk-position-absolute uk-margin-top icon-xxlarge"> </i>
                    <input class="uk-search-input uk-margin-large-left" type="search" placeholder="Search..." autofocus>
                </form>
            </div>
        </div>
    </nav>
</template>

<script>
import MessagesSmallCard from "./messages-small-card";
import NotificationCard from "./notification-card";
import UserProfileDropdownNav from "./user-profile-dropdown-nav";
import {mapActions, mapState} from "vuex";
export default {
    name: "top-bar",
    props:{
        homeRoute:{
            type:String,
            required:true,
        },
        profileImage:String,
        settingsRoute:{
            type:String,
            required:true,
        },
        logoutRoute:{
            type:String,
            required:true,
        },
        hasLogin:Boolean,
        registerName:String,
        registerRoute:{
            type:String,
            required:true,
        },
        loginRoute:{
            type:String,
            required:true,
        },
        loginName:String,
        settings:String,
        logOut:String,
        profile:String,
        profileRoute:{
            type:String,
            required:true,
        },
        userId:{
            type:String,
            required:true,
        },
        userCity:{
            type:String,
            required:true,
        },
        userName:{
            type:String,
            required:true,
        },
        noContent:{
            type:String,
            default:'Hiç Kursa Sahip Değilsin'
        }
    },
    computed:{
        ...mapState([
            'myCourses',
        ]),
    },
    methods:{
        ...mapActions([
            'loadMyCourses'
        ]),
    },
    mounted () {
        this.$store.dispatch('loadMyCourses',this.userId);
    },
    components: {
        UserProfileDropdownNav,
        NotificationCard,
        MessagesSmallCard
    }
}
</script>

<style>

</style>
