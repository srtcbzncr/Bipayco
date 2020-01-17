<template>
    <div class="">
        <input type="text" hidden disabled :value="instructorId">
        <img class="user-profile-tiny uk-circle" :src="instructorPhoto">
        <b class="uk-margin-left" style="flex-grow: 5">{{instructorName}}</b>
        <input type="checkbox" name="isManager" id="isManager"  style="flex-grow: 3" class="uk-checkbox">
        <input type="number" name="percent" id="percent" class="uk-input uk-width-small" :max="maxPercent" min="1">
    </div>
</template>

<script>
    export default {
        name: "add-instructor",
        props:{
            instructorId:{
                type:String,
                required:true,
            },
            instructorPhoto:{
                type:String,
                required:true,
            },
            instructorName:{
                type:String,
                required:true,
            },
            maxPercent:{
                type:String,
                default:'100'
            }
        }
    }
</script>

<style scoped>

</style>
