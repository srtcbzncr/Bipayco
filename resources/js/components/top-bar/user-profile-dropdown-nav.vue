<template>
    <div uk-dropdown="pos: top-right ;mode : click ;animation: uk-animation-slide-bottom-small" class="uk-dropdown  uk-dropdown-top-right  tm-dropdown-small border-radius-6 angle-top-right">
        <div class="uk-grid-small uk-flex-middle uk-margin-small-bottom" uk-grid>
            <div class="uk-width-1-4  uk-first-column">
                <img :src="profileImage" alt="Image" class="uk-align-center">
            </div>
            <div class="uk-width-3-4">
                <p class="uk-margin-remove-bottom uk-margin-small-top uk-text-bold">{{userName}} </p>
                <p class="uk-margin-remove-top uk-text-small uk-margin-small-bottom">{{userCity}}</p>
            </div>
        </div>
        <ul class="uk-nav uk-dropdown-nav">
            <li>
                <a :href="profileRoute"> <i class="fas fa-user uk-margin-small-right"></i>{{profile}}</a>
            </li>
            <li v-if="isAdmin">
                <a :href="adminModeRoute"> <i class="fas fa-user-tie uk-margin-small-right"></i>{{adminMode}}</a>
            </li>
            <li>
                <a :href="instructorModeRoute"> <i class="fas fa-chalkboard-teacher uk-margin-small-right"></i>{{instructorMode}}</a>
            </li>
            <li v-if="isGuardian">
                <a :href="guardianModeRoute"> <i class="fas fa-user-friends uk-margin-small-right"></i>{{guardianMode}}</a>
            </li>
            <li>
                <a :href="settingsRoute"> <i class="fas fa-cog uk-margin-small-right"></i>{{settings}}</a>
            </li>
            <li class="uk-nav-divider"></li>
            <li>
                <a :href="logoutRoute"> <i class="fas fa-sign-out-alt uk-margin-small-right"></i>{{logOut}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "user-profile-dropdown-nav",
        props:{
            settingsRoute:String,
            logoutRoute:String,
            profileImage:String,
            userName:String,
            userCity:String,
            settings:String,
            logOut:String,
            profile:String,
            profileRoute:String,
            instructorMode:String,
            instructorModeRoute:String,
            adminMode:String,
            adminModeRoute:String,
            guardianMode:String,
            guardianModeRoute:String,
            isAdmin:{
                type:Boolean,
                default:false
            },
            isGuardian:{
                type:Boolean,
                default:false
            },
        }
    }
</script>

<style scoped>

</style>
