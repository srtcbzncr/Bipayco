<template>
    <a href="#" class="uk-link-reset">
        <!-- Play icon  -->
        <span>
            <i style="color:#666666" class="fas fa-play-circle icon-medium"> </i>
        </span>
        <!-- Course title  -->
        <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{index+1}}. {{lessonName}}</div>
        <!-- preview link -->
        <div v-if="isPreview" style="color:#666666" class="uk-link-reset uk-margin-xlarge-right uk-padding-small uk-text-small uk-visible@s" href="#"> <i class="fas fa-play icon-small uk-text-grey"></i>  {{previewText}}</div>
    </a>
</template>

<script>
    export default {
        name: "lesson.vue",
        props:{
            lessonName:{
                type:String,
                required:true,
            },
            index:{
                type:Number,
                required:true,
            },
            isPreview:{
                type:Boolean,
                default:false,
            },
            previewText:{
                type:String,
                default:'Önizle'
            }
        }
    }
</script>

<style scoped>

</style>
