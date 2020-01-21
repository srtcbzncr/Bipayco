<template>
        <a href="#" class="uk-link-reset">
            <!-- Play icon  -->
            <span>
                <i style="color:#2ED24A" class="fas fa-check-circle icon-medium" uk-tooltip="title: @lang('front/auth.watch_again')  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"></i>
            </span>
            <!-- Course title  -->
            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{lessonName}}</div>
            <!-- preview link -->
            <span style="color:#666666" class="uk-visible@m uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i> $lesson->long}}</span>
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
                type:String,
                required:true,
            }
        }
    }
</script>

<style scoped>

</style>
