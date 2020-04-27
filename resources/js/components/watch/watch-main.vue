<template>
    <div class="uk-card uk-card-default uk-align-center">
        <div class="uk-card-body uk-grid uk-padding-remove">
            <div class="uk-width-3-4@m uk-flex align-items-center justify-content-center uk-overflow-auto">
                <test-area v-if="moduleName=='prepareLessons'&&isTest"
                    :lesson-id="course.lesson_id"
                    :subject-id="selectedSection.subject_id"
                    :test-type="testType"
                    :section-id="selectedSection.id"
                    :module-name="moduleName"
                    :user-id="userId"
                    :course-id="courseId"
                ></test-area>
                <video v-else-if="selectedLesson.is_video" id="courseLessonVideo" @timeupdate="watched" width="400" controls controlsList="nodownload">
                    <source :src="selectedLesson.file_path" type="video/mp4">
                    <source :src="selectedLesson.file_path" type="video/ogg">
                    Your browser does not support HTML5 video.
                </video>
                <div v-else class="uk-width uk-margin-remove-bottom uk-padding-remove">
                    <iframe :src="selectedLesson.file_path" @load="completed" class="uk-width" style="height: 550px" frameborder="0"></iframe>
                    <button v-if="course.nextLessonId!=null" @click="selectLesson(course.nextLessonId)" class="uk-button uk-button-primary uk-margin-small-top uk-margin-small-bottom uk-margin-small-right uk-margin-small-left float-right">{{nextLessonText}} <i class="fas fa-arrow-right uk-margin-small-left"></i></button>
                    <button @click="openNewTab" class="uk-button uk-button-secondary uk-margin-small-top uk-margin-small-bottom uk-margin-small-right uk-margin-small-left float-right"><i class="fas fa-expand-arrows-alt uk-margin-small-right"></i> {{fullScreenText}}</button>
                </div>
            </div>
            <!-- side menu -->
            <div class="uk-width-1-4@m uk-container uk-grid-padding-remove@m" style="padding: 0;">
                <div class="tm-filters uk-background-default" id="filters">
                    <div class="uk-padding-remove uk-preserve-color">
                        <!-- Sidebar menu-->
                        <ul class="uk-child-width-expand uk-tab tm-side-course-nav uk-margin-remove uk-position-z-index" uk-switcher="animation: uk-animation-slide-right-small">
                            <li class="uk-active">
                                <a> <i class="fas fa-video icon-medium uk-margin-small-right"></i>{{lessonsText}}</a>
                            </li>
                            <li>
                                <a> <i class="fas fa-file-archive icon-medium uk-margin-small-right"></i>{{sourcesText}}</a>
                            </li>
                        </ul>
                        <!-- Sidebar contents -->
                        <ul class="uk-switcher uk-height-max-large uk-overflow-auto">
                            <li>
                                <div class="demo1 tab-video" data-simplebar>
                                    <ul uk-accordion>
                                        <!-- section one -->
                                        <li v-for="(section, sectionIndex) in course.sections" class="tm-course-lesson-section uk-background-default" :class="{'uk-open':isOpen(section.id)}">
                                            <a class="uk-accordion-title  uk-padding-small"><h6> {{sectionText}} {{sectionIndex+1}}</h6> <h4 class="uk-margin-remove">{{section.name}}</h4> </a>
                                            <div class="uk-accordion-content uk-margin-remove-top">
                                                <div class="tm-course-section-list">
                                                    <ul v-if="section.canAccess">
                                                        <a v-if="moduleName=='prepareLessons'" :href="'/learn/pl/test/firstTest/'+courseId+'/'+section.id" class="uk-link-reset">
                                                            <li v-if="isTest&&testType=='0'&&selectedSection.id==section.id" class="uk-background-primary currentLesson align-items-center">
                                                                <span class="uk-icon-button currentLesson icon-play uk-button-primary"> <i class="fas fa-star icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Ön Test</div>
                                                            </li>
                                                            <li v-else class="uk-background-default align-items-center">
                                                                <span class="uk-icon-button icon-play"> <i class="fas fa-star icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Ön Test</div>
                                                            </li>
                                                        </a>
                                                        <a v-for="(lesson, lessonIndex) in section.lessons" @click="selectLesson(lesson.id)" class="uk-link-reset">
                                                            <li v-if="lesson.id==selectedLesson.id&&!isTest" class="currentLesson uk-background-primary align-items-center">
                                                                <span v-if="lesson.is_video" class="uk-icon-button icon-play currentLesson uk-button-primary"> <i class="fas fa-play icon-small"></i> </span>
                                                                <span v-else class="uk-icon-button icon-play currentLesson uk-button-primary"> <i class="fas fa-file-alt icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">{{lessonIndex+1}}. {{lesson.name}}</div>
                                                                <span v-if="lesson.is_video" class="uk-position-center-right uk-margin-medium-right">  {{lesson.long}}</span>
                                                            </li>
                                                            <li v-else-if="lesson.is_completed" class="completedLesson uk-background-success">
                                                                <span class="uk-icon-button icon-play completedLesson uk-button-success"><i class="fas fa-check-circle icon-medium uk-margin-remove"></i></span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">{{lessonIndex+1}}. {{lesson.name}}</div>
                                                                <span v-if="lesson.is_video" class="uk-position-center-right time uk-margin-medium-right">  {{lesson.long}}</span>
                                                            </li>
                                                            <li v-else class="uk-background-default">
                                                                <span v-if="lesson.is_video" class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                                <span v-else class="uk-icon-button icon-play"> <i class="fas fa-file-alt icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">{{lessonIndex+1}}. {{lesson.name}}</div>
                                                                <span v-if="lesson.is_video" class="uk-position-center-right time uk-margin-medium-right">  {{lesson.long}}</span>
                                                            </li>
                                                        </a>
                                                        <a v-if="moduleName=='prepareLessons'" :href="'/learn/pl/test/lastTest/'+courseId+'/'+section.id" class="uk-link-reset">
                                                            <li v-if="isTest&&testType=='1'&&selectedSection.id==section.id" class="uk-background-default currentLesson align-items-center">
                                                                <span class="uk-icon-button icon-play uk-button-primary currentLesson "> <i class="fas fa-star icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Son Test</div>
                                                            </li>
                                                            <li v-else class="uk-background-default align-items-center">
                                                                <span class="uk-icon-button icon-play"> <i class="fas fa-star icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Son Test</div>
                                                            </li>
                                                        </a>
                                                    </ul>
                                                    <ul v-else>
                                                        <a v-if="moduleName=='prepareLessons'" class="uk-link-reset">
                                                            <li class="uk-background-default align-items-center">
                                                                <span class="uk-icon-button icon-play"> <i class="fas fa-lock icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Ön Test</div>
                                                            </li>
                                                        </a>
                                                        <a v-for="(lesson, lessonIndex) in section.lessons" class="uk-link-reset">
                                                            <li class="uk-background-default">
                                                                <span class="uk-icon-button icon-play"> <i class="fas fa-lock icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">{{lessonIndex+1}}. {{lesson.name}}</div>
                                                                <span v-if="lesson.is_video" class="uk-position-center-right time uk-margin-medium-right">  {{lesson.long}}</span>
                                                            </li>
                                                        </a>
                                                        <a v-if="moduleName=='prepareLessons'" class="uk-link-reset">
                                                            <li class="uk-background-default align-items-center">
                                                                <span class="uk-icon-button icon-play"> <i class="fas fa-lock icon-small uk-margin-remove"></i> </span>
                                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Son Test</div>
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
                                            <li v-for="source in selectedLesson.sources">
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
    import Axios from 'axios';
    import {mapActions, mapState} from "vuex";
    import TestArea from "./test-area";
    export default {
        name: "watch-main",
        components: {TestArea},
        data(){
            return{
                posted:false,
            }
        },
        props:{
            courseId:{
                type:String,
                required:true,
            },
            course:{
                type:Object,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
            },
            userId:{
                type:String,
                required:true,
            },
            selectedLesson:{
                type:Object,
                required:true,
            },
            selectedSection:{
                type:Object,
            },
            lessonsText:{
                type:String,
                default:"Dersler"
            },
            sourcesText:{
                type:String,
                default:"Kaynaklar"
            },
            sectionText:{
                type:String,
                default:"Bölüm"
            },
            fullScreenText:{
                type:String,
                default:"Tam Ekran"
            },
            nextLessonText:{
                type:String,
                default:"Sonraki Ders"
            },
            testType:{
                type:String,
                default:""
            },
            isTest:{
                type:Boolean,
                default:false
            }
        },
        computed:{
            nextLessonId(){
                if(this.course.nextLessonId!=null){
                    return this.course.nextLessonId;
                }else{
                    return ''
                }
            }
        },
        methods:{
            downloadItem: function(url, label) {
                Axios.get(url, { responseType: 'blob' })
                    .then(response => {
                        const blob = new Blob([response.data], );
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = label;
                        link.click();
                        URL.revokeObjectURL(link.href);
                    })
                    .catch()
            },
            selectLesson:function (lessonId) {
                switch(this.moduleName){
                    case 'generalEducation':{
                        window.location.replace('/learn/ge/course/'+this.courseId+'/lesson/'+lessonId);
                        break;
                    }
                    case 'prepareLessons':{
                        if(lessonId=='lastTest'){
                            window.location.replace('/learn/pl/test/lastTest/'+this.courseId+'/'+this.selectedLesson.section_id);
                        }else{
                            window.location.replace('/learn/pl/course/'+this.courseId+'/lesson/'+lessonId);
                        }
                        break;
                    }
                }
            },
            watched:function () {
                var videoPlayer=document.getElementById('courseLessonVideo');
                if(!(this.selectedLesson.is_completed) && !(this.posted) && videoPlayer.currentTime>=videoPlayer.duration-7){
                    this.triggerTruePosted();
                    this.completed();
                }else if( videoPlayer.currentTime==videoPlayer.duration && this.course.nextLessonId!=null){
                    switch(this.moduleName){
                        case 'generalEducation':{
                            setTimeout(()=>{window.location.replace('/learn/ge/course/'+this.courseId+'/lesson/'+this.course.nextLessonId);},3000);
                            break;
                        }
                        case 'prepareLessons':{
                            if(this.course.nextLessonId=='lastTest'){
                                setTimeout(()=>{window.location.replace('/learn/pl/test/lastTest/'+this.courseId+'/'+this.selectedLesson.section_id)},3000);
                            }else{
                                setTimeout(()=>{window.location.replace('/learn/pl/course/'+this.courseId+'/lesson/'+this.course.nextLessonId);},3000);
                            }
                            break;
                        }
                    }
                }
            },
            triggerTruePosted(){
                this.posted=true;
            },
            completed:function(){
                Axios.post('/api/learn/'+this.moduleName+'/'+this.courseId+'/lesson/'+this.selectedLesson.id+'/complete', {user_id: this.userId});
            },
            openNewTab:function () {
                window.open(this.selectedLesson.file_path);
            },
            isOpen:function (sectionId) {
                if(this.moduleName=='generalEducation'){
                    return sectionId==this.selectedLesson.section_id;
                }else{
                    return sectionId==this.selectedSection.id;
                }
            }
        },
    }
</script>

<style scoped>
    .currentLesson{
        background-color: #1e87f0;
    }

    .completedLesson{
        background-color: #4cd964;
    }
</style>
