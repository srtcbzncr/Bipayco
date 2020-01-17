<template>
    <div class="uk-margin-small">
        <div class="uk-grid align-items-center">
            <input type="text" hidden disabled :value="instructorId">
            <div class="uk-width-3-5@m">
                <div class="uk-form-label uk-hidden@m"> Eğitmen</div>
                <img class="user-profile-tiny uk-circle" :src="instructorPhoto">
                <b class="uk-margin-left">{{instructorName}}</b>
            </div>
            <div class="uk-width-1-5@m">
                <div class="uk-form-label uk-hidden@m"> Percent</div>
                <input type="number" name="percent" id="percent" class="uk-input uk-padding-remove" :max="maxPercent" min="1">
            </div>
            <div class="uk-width-1-5@m">
                <i class="fas fa-trash-alt text-danger icon-small"> </i>
            </div>
        </div>
        <hr class="uk-hidden@m uk-margin-medium-top">
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
