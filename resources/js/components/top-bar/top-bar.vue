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
            <a class="uk-navbar-item back-to-dashboard uk-button-text " href="#" uk-tooltip="title: back-to-dashboard ; delay: 700 ; pos: bottom-left ;animation:	uk-animation-scale-up">My Dashboard</a>
            <a class="uk-navbar-item back-to-dashboard uk-button-text " href="#">Browse Books</a>
        </div>
        <div class="uk-navbar-right tm-show-on-mobile uk-flex-right" id="tm-show-on-mobile" >
            <!-- this will clouse after display user icon -->
            <span class="uk-hidden@m tm-mobile-user-close-icon uk-align-right" uk-toggle="target: #tm-show-on-mobile; cls: tm-show-on-mobile-active"><i class="fas fa-times icon-large"></i></span>
            <ul class="uk-navbar-nav uk-flex-middle">
                <li>
                    <a href="#modal-full" uk-toggle><i class="fas fa-search icon-medium"></i></a>
                </li>

                <li v-if="hasLogin === true">
                    <!-- your courses -->
                    <a href="#"> <i class="fas fa-play uk-hidden@m"></i> <span class="uk-visible@m"> Your Courses</span> </a>
                    <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown border-radius-6  uk-dropdown-top-right tm-dropdown-large uk-padding-remove">
                        <div class="uk-clearfix">
                            <div class="uk-float-left">
                                <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left">  Your Courses </h5>
                            </div>
                            <div class="uk-float-right">
                                <i class="fas fa-check uk-align-right  uk-margin-remove uk-margin-remove-left  uk-padding-small uk-text-small"> Completed 3 / 5 </i>
                            </div>
                        </div>
                        <hr class=" uk-margin-remove">
                        <div class="uk-padding-smaluk-text-left uk-height-medium">
                            <div class="demo1" data-simplebar style="overflow-y:auto">
                                <div class="uk-child-width-1-2@s  uk-grid-small uk-padding-small"  uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100 ;repeat: true" uk-grid>
                                    <your-course-card/>
                                    <your-course-card/>
                                    <your-course-card/>
                                    <your-course-card/>
                                </div>
                            </div>
                        </div>
                        <hr class=" uk-margin-remove">
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold uk-text-center"><a class="uk-link-heading" href="#"> See all </a> </h5>
                    </div>
                </li>
                <li v-if="hasLogin === true">
                    <!-- messages -->
                    <a href="#"><i class="fas fa-envelope icon-large"></i></a>
                    <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-medium border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> Messages </h5>
                        <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas fa-trash uk-align-right   uk-text-small uk-padding-small"> Clear all</i> </a>
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
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold uk-text-center"><a class="uk-link-heading" href=""> See all </a> </h5>
                    </div>
                </li>
                <li v-if="hasLogin === true">
                    <!-- Notifications -->
                    <a href="#"><i class="fas fa-bell icon-large"></i></a>
                    <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-small border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
                        <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> Notifications </h5>
                        <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas fa-trash uk-align-right   uk-text-small uk-padding-small"> Clear all</i></a>
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
                <button class="uk-modal-close-full" type="button" uk-close></button>
                <form class="uk-search uk-margin-xlarge-top uk-search-large uk-animation-slide-bottom-medium">
                    <i class="fas fa-search uk-position-absolute uk-margin-top icon-xxlarge"></i>
                    <input class="uk-search-input uk-margin-large-left" type="search" placeholder="Search..." autofocus>
                </form>
            </div>
        </div>
    </nav>
</template>

<script>
import YourCourseCard from "./your-course-card";
import MessagesSmallCard from "./messages-small-card";
import NotificationCard from "./notification-card";
import UserProfileDropdownNav from "./user-profile-dropdown-nav";
export default {
    name: "top-bar",
    props:{
        homeRoute:String,
        profileImage:String,
        settingsRoute:String,
        logoutRoute:String,
        hasLogin:Boolean,
        registerName:String,
        registerRoute:String,
        loginRoute:String,
        loginName:String,
        userName:String,
        userCity:String,
        settings:String,
        logOut:String,
        profile:String
    },
    components: {
        UserProfileDropdownNav,
        NotificationCard,
        MessagesSmallCard,
        YourCourseCard
    }
}
</script>

<style>

</style>
