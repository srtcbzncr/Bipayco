<template>
    <div uk-dropdown="pos: top-right ;mode : click ;animation: uk-animation-slide-bottom-small" class="uk-dropdown  uk-dropdown-top-right  tm-dropdown-small border-radius-6 angle-top-right">
        <div class="uk-grid-small uk-flex-middle uk-margin-small-bottom" uk-grid>
            <div class="uk-width-1-4  uk-first-column">
                <img :src="profileImage" alt="Image" class="uk-align-center uk-border-circle">
            </div>
            <div class="uk-width-3-4">
                <p class="uk-margin-remove-bottom uk-margin-small-top uk-text-bold"> Hamse Mohamoud  </p>
                <p class="uk-margin-remove-top uk-text-small uk-margin-small-bottom"> Bankook China</p>
            </div>
        </div>
        <ul class="uk-nav uk-dropdown-nav">
            <li>
                <a href="Profile.html"> <i class="fas fa-user uk-margin-small-right"></i> Profile</a>
            </li>
            <li>
                <a href="#"> <i class="fas fa-envelope uk-margin-small-right"></i> Messages </a>
            </li>
            <li>
                <a href="#"> <i class="fas fa-share uk-margin-small-right"></i> Invite freind</a>
            </li>
            <li>
                <a :href="settingsRoute"> <i class="fas fa-cog uk-margin-small-right"></i> Setting</a>
            </li>
            <li class="uk-nav-divider"></li>
            <li>
                <a :href="logoutRoute"> <i class="fas fa-sign-out-alt uk-margin-small-right"></i> Log out</a>
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
            profileImage:String
        }
    }
</script>

<style scoped>

</style>
