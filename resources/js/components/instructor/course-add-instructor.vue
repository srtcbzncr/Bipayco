<template>
    <div class="">
        <img class="user-profile-tiny uk-circle" :src="instructorPhoto">
        <b class="uk-margin-left">{{instructorName}}</b>
        <input type="checkbox" class="uk-checkbox">
        <input type="number">
    </div>
</template>

<script>
    export default {
        name: "course-add-instructor"
    }
</script>

<style scoped>

</style>
