<template>
    <div id="Course-Videos" class="tabcontent  animation: uk-animation-slide-right-medium">
        <ul uk-accordion="" class="uk-accordion">
            <li v-if="sections.length>0" v-for="section in sections" class="tm-course-lesson-section uk-background-default">
                <a class="uk-accordion-title uk-padding-small" href="#"><h6> {{sectionText}}  {{section.no}}</h6> <h4 class="uk-margin-remove"> {{section.name}}</h4> </a>
                <div class="uk-accordion-content uk-margin-remove-top">
                    <div class="tm-course-section-list">
                        <ul>
                            <li v-if="section.lessons.length>0" v-for="lesson in section.lessons">
                                <a class="uk-link-reset" @click="openPreview(lesson.file_path, lesson.is_video, lesson.preview, lesson.id)">
                                    <!-- Play icon  -->
                                    <span>
                                        <i v-if="authCheck && lesson.is_completed" style="color:#2ED24A" class="fas fa-check-circle icon-medium"></i>
                                        <i v-else-if="lesson.is_video" style="color:#666666" class="fas fa-play-circle icon-medium"></i>
                                        <i v-else style="color:#666666" class="fas fa-file-alt icon-medium"></i>
                                    </span>
                                    <!-- Course title  -->
                                    <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{lesson.name}}</div>
                                </a>
                                <a v-if="lesson.preview" style="color:#666666" class="uk-link-reset uk-margin-xlarge-right uk-position-center-right uk-padding-small uk-text-small uk-visible@s"> <i class="fas fa-play icon-small uk-text-grey"></i> {{previewText}}  </a>
                                <!-- time -->
                                <span v-if="lesson.is_video" style="color:#666666" class="uk-visible@m uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  {{lesson.long}}</span>
                            </li>
                            <p v-else>{{noContentText}}</p>
                        </ul>
                    </div>
                </div>
            </li>
            <p v-else>{{noContentText}}</p>
        </ul>
        <div v-for="lesson in previewLessons" :id="'preview'+lesson.id" uk-modal>
            <div class="uk-modal-dialog uk-margin-auto-vertical">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <video v-if="lesson.is_video" id="courseLessonVideo" controls controlsList="nodownload">
                    <source :src="lesson.file_path" type="video/mp4">
                    <source :src="lesson.file_path" type="video/ogg">
                    Your browser does not support HTML5 video.
                </video>
                <iframe v-else :src="lesson.file_path" class="uk-width uk-height-large" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex'
    export default {
        name: "course-previews",
        data(){
            return{
                selectedPath:"",
                isVideo:false,
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
            },
            authCheck:{
                type:Boolean,
                default:false,
            },
            previewText:{
                type:String,
                default:"Önizleme"
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmuyor"
            },
            sectionText:{
                type:String,
                default:"Bölüm"
            }
        },
        computed:{
            ...mapState([
               'sections',
                'previewLessons'
            ]),
        },
        methods:{
            ...mapActions([
                'loadSections',
                'loadPreviewLessons'
            ]),
            openPreview:function (filePath, isVideo, isPreview, lessonId) {
                if(isPreview){
                    this.selectedPath=filePath;
                    this.isVideo=isVideo;
                    UIkit.modal('#preview'+lessonId).show();
                }
            }
        },
        created(){
            this.$store.dispatch('loadSections', [this.moduleName, this.courseId])
            this.$store.dispatch('loadPreviewLessons', [this.moduleName, this.courseId])
        }
    }
</script>

<style scoped>

</style>
