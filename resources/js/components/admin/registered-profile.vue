<template>
    <div>
        <a :href="profilePath" class="uk-link-reset">
            <div class="uk-padding-remove uk-text-center">
                <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" :src="imgPath">
                <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">{{username}}</h5>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        name: "registered-profile",
        props:{
            profilePath:String,
            imgPath:String,
            username:String,
        }
    }
</script>

<style scoped>

</style>
