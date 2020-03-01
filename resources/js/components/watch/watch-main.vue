<template>
    <div class="uk-card uk-card-default uk-align-center">
        <div class="uk-card-body uk-grid uk-padding-remove">
            <div class="uk-width-3-4@m uk-flex align-items-center justify-content-center">
                <video v-if="learnCourse.sections[selectedSectionIndex].lessons[selectedLessonIndex].is_video" width="400" controls>
                    <source :src="learnCourse.sections[selectedSectionIndex].lessons[selectedLessonIndex].file_path" type="video/mp4">
                    <source :src="learnCourse.sections[selectedSectionIndex].lessons[selectedLessonIndex].file_path" type="video/ogg">
                    Your browser does not support HTML5 video.
                </video>
                <iframe v-else :src="learnCourse.sections[selectedSectionIndex].lessons[selectedLessonIndex].file_path" class="uk-width" style="height: 550px" frameborder="0"></iframe>
            </div>
            <!-- side menu -->
            <div class="uk-width-1-4@m uk-container uk-grid-padding-remove@m" style="padding: 0;">
                <div class="tm-filters uk-background-default" id="filters">
                    <div class="uk-padding-remove uk-preserve-color">
                        <!-- Sidebar menu-->
                        <ul class="uk-child-width-expand uk-tab tm-side-course-nav uk-margin-remove uk-position-z-index" uk-switcher="animation: uk-animation-slide-right-small">
                            <li class="uk-active">
                                <a href="#" uk-tooltip="title: Course Videos ; delay: 100 ; pos: bottom-center;"> <i class="fas fa-video icon-medium uk-margin-small-right"></i>{{lessonsText}}</a>
                            </li>
                            <li>
                                <a href="#" uk-tooltip="title: Course Exercise ; delay: 100 ; pos: bottom-center;"> <i class="fas fa-file-archive icon-medium uk-margin-small-right"></i>{{sourcesText}}</a>
                            </li>
                        </ul>
                        <!-- Sidebar contents -->
                        <ul class="uk-switcher uk-height-max-large uk-overflow-auto">
                            <!-- Course Video tab  -->
                            <li>
                                <div class="demo1 tab-video" data-simplebar>
                                    <ul uk-accordion>
                                        <!-- section one -->
                                        <li v-for="(section, sectionIndex) in learnCourse.sections" class="tm-course-lesson-section uk-background-default">
                                            <a class="uk-accordion-title  uk-padding-small" href="#"><h6> section {{sectionIndex+1}}</h6> <h4 class="uk-margin-remove">{{section.name}}</h4> </a>
                                            <div class="uk-accordion-content uk-margin-remove-top">
                                                <div class="tm-course-section-list">
                                                    <ul>
                                                        <a v-for="(lesson, lessonIndex) in section.lessons" href="#" @click="selectLesson(sectionIndex, lessonIndex)" class="uk-link-reset">
                                                            <li>
                                                                <span v-if="lesson.is_video" class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                                <span v-else class="uk-icon-button icon-play"> <i class="fas fa-file-alt icon-small"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">{{lessonIndex+1}}. {{lesson.name}}</div>
                                                                <a class="uk-icon-button uk-link-reset uk-margin-small-right uk-icon uk-button-success uk-position-center-right uk-animation-scale-up" href="#" style="display:none"> <i class="fas fa-check-circle icon-small  uk-text-white"></i> </a>
                                                                <span v-if="lesson.is_video" class="uk-position-center-right time uk-margin-medium-right">  {{lesson.long}}</span>
                                                            </li>
                                                        </a>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Exicse  tab  -->
                            <li>
                                <div class="demo1 uk-background-muted" data-simplebar>
                                    <div class="tm-course-section-list">
                                        <ul>
                                            <li v-for="source in courseSources">
                                                {{source.title}}
                                                <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" @click="downloadItem(source.file_path, source.title)" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import {mapActions, mapState} from "vuex";
    export default {
        name: "watch-main",
        props:{
            courseId:{
                type:String,
                required:true,
            },
            firstLessonId:{
                type:String,
                required:true,
            },
            sourcesText:{
                type:String,
                default:"Kaynaklar"
            },
            lessonsText:{
                type:String,
                default:"Dersler"
            }
        },
        computed:{
            ...mapState([
                'learnCourse',
                'courseSources',
                'selectedLessonIndex',
                'selectedSectionIndex',
            ]),
            lessonId(){
                return this.learnCourse.sections[this.selectedSectionIndex].lessons[this.selectedLessonIndex].id;
            },
        },
        methods:{
            ...mapActions([
                'loadLearnCourse',
                'loadCourseSources',
                'loadSelectedSectionIndex',
                'loadSelectedLessonIndex',
            ]),
            downloadItem: function(url, label) {
                axios.get('/'+url, { responseType: 'blob' })
                    .then(response => {
                        const blob = new Blob([response.data], { type: 'application/pdf' });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = label;
                        link.click();
                        URL.revokeObjectURL(link.href);
                    })
                    .catch(console.error)
            },
            selectLesson:function ( sectionIndex, lessonIndex) {
                this.$store.dispatch('loadSelectedSectionIndex', sectionIndex);
                this.$store.dispatch('loadSelectedLessonIndex', lessonIndex);
                console.log(this.lessonId);
                this.$store.dispatch('loadCourseSources',[this.courseId, this.lessonId]);
                console.log('section:'+sectionIndex+' lesson:'+lessonIndex);
            }
        },
        created() {
            this.$store.dispatch('loadLearnCourse',this.courseId);
            this.$store.dispatch('loadCourseSources',[this.courseId, this.firstLessonId]);
        }
    }
</script>

<style scoped>

</style>
