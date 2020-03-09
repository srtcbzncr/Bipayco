<template>
    <div id="modal-media-video" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-outside" type="button" uk-close></button>
            <video id="courseLessonVideo" width="400" controls controlsList="nodownload">
                <source src="" type="video/mp4">
                <source src="" type="video/ogg">
                Your browser does not support HTML5 video.
            </video>
            <div class="tm-course-section-list uk-margin-top">
                <ul>
                    <a v-if="lesson in previewLessons" href="#" class="uk-link-reset">
                        <li>
                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-ssmall"></i> </span>
                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">{{lesson.name}}</div>
                            <a class="uk-icon-button uk-link-reset uk-margin-small-right uk-icon uk-button-success uk-position-center-right uk-animation-scale-up" href="#" style="display:none"> <i class="fas fa-check-circle icon-small  uk-text-white"></i> </a>
                            <span  class="uk-position-center-right time uk-margin-medium-right">{{lesson.long}}</span>
                        </li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex'
    export default {
        name: "course-previews",
        data(){
            return{

            }
        },
        computed:{
            ...mapState([
                'previewLessons'
            ]),
        },
        props:{
            courseId:{
                type:String,
                required:true,
            }
        },
        methods:{
            ...mapActions([
               'loadPreviewLessons'
            ]),
        },
        created() {
            this.$store.dispatch('loadPreviewLessons', this.coureId)
        }
    }
</script>

<style scoped>

</style>
