<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" id="id" placeholder="addDefaultText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m"><i class="fas fa-plus"></i> <span class="uk-hidden@m">ekle</span></button>
        </div>
        <div class="uk-margin-top">
            <ul uk-accordion="" class="uk-accordion">
                <li class="tm-course-lesson-section uk-background-default">
                    <a class="uk-accordion-title uk-padding-small" href="#"><h6>Bölüm 1</h6> <h4 class="uk-margin-remove">bölüm adı</h4> </a>
                    <div class="uk-accordion-content uk-margin-remove-top">
                        <div class="tm-course-section-list">
                            <ul>
                                <li>
                                    <a href="#" class="uk-link-reset">
                                        <!-- Play icon  -->
                                        <span>
                                            <i style="color:#2ED24A" class="fas fa-check-circle icon-medium" uk-tooltip="title: @lang('front/auth.watch_again')  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"></i>
                                        </span>
                                        <!-- Course title  -->
                                        <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">lesson->name}}</div>
                                        <!-- preview link -->
                                    <span style="color:#666666" class="uk-visible@m uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i> $lesson->long}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import addLesson from './add-lesson.vue'
    export default {
        name: "add-section",
        components:{
            addLesson,
        },
    }
</script>

<style scoped>

</style>
