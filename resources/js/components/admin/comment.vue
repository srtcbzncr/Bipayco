<template>
    <div>
        <img class="user-profile-medium uk-align-left uk-margin-small-right uk-margin-small-bottom" :src="profilePhoto" width="60"  alt="Example image">
        <p class="uk-margin-remove-top">{{comment}}</p>
        <hr>
    </div>
</template>

<script>
    export default {
        name: "comment",
        props:{
            comment:String,
            profilePhoto:String
        }
    }
</script>

<style scoped>
    p{
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
