<template>
    <div id="modal-media-video" uk-modal>

        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-outside" type="button" uk-close></button>
            <video id="courseLessonVideo" width="400" controls controlsList="nodownload">
                <source :src="previewLessons[selectedLesson].file_path" type="video/mp4">
                <source :src="previewLessons[selectedLesson].file_path" type="video/ogg">
                Your browser does not support HTML5 video.
            </video>
            {{previewLessons[selectedLesson]}}
            <div class="tm-course-section-list uk-margin-top">
                <ul>
                    <a v-for="(lesson,index) in previewLessons" @click="changeSelected(index)" class="uk-link-reset">
                        <li>
                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
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
    import {mapState,mapActions} from 'vuex';
    export default {
        name: "course-previews",
        data(){
            return{
                selected:0,
            }
        },
        computed:{
            ...mapState([
                'previewLessons'
            ]),
            selectedLesson(){
                console.log(this.selected);
                return this.selected;
            }
        },
        props:{
            courseId:{
                type:String,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
            }
        },
        methods:{
            ...mapActions([
               'loadPreviewLessons'
            ]),
            changeSelected:function (index) {
                this.selected=index;
            }
        },
        created() {
            this.$store.dispatch('loadPreviewLessons', [this.moduleName,this.courseId])
        }
    }
</script>

<style scoped>

</style>
