<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" id="sectionInput" :placeholder="addDefaultSectionText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="addSection"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
        </div>
        <div v-for="(section, sectionIndex) in sections" class="uk-margin-top uk-flex align-items-center justify-content-center">
            <div class="uk-width-5-6">
                <div class="uk-margin-top uk-margin-remove-right">
                    <ul uk-accordion="" class="uk-accordion">
                        <li class="tm-course-lesson-section uk-background-default">
                            <a class="uk-accordion-title uk-padding-small" href="#"><h6>{{sectionText}} {{sectionIndex+1}}</h6> <h4 class="uk-margin-remove">{{section.name}}</h4> </a>
                            <div class="uk-accordion-content uk-margin-remove-top">
                                <div class="tm-course-section-list">
                                    <ul>
                                        <li>
                                            <div class="">
                                                <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" :id="sectionIndex" :placeholder="addDefaultLessonText">
                                                <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="addLesson(sectionIndex)"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
                                            </div>
                                        </li>
                                        <li v-for="(lesson,lessonIndex) in section.lessons" class="uk-flex">
                                            <div class="uk-width-5-6">
                                                <a href="#" class="uk-link-reset">
                                                    <!-- Play icon  -->
                                                    <span>
                                                        <i style="color:#666666" class="fas fa-play-circle icon-medium"> </i>
                                                    </span>
                                                    <!-- Course title  -->
                                                    <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{lessonIndex+1}}. {{lesson.name}}</div>
                                                    <!-- preview link -->
                                                    <div v-if="lesson.isPreview" style="color:#666666" class="uk-link-reset uk-margin-xlarge-right uk-padding-small uk-text-small uk-visible@s"> <i class="fas fa-play icon-small uk-text-grey"></i>  {{previewText}}</div>
                                                </a>
                                            </div>
                                            <a class="uk-button-icon uk-margin-left uk-width-1-6" @click="removeLesson(lessonIndex, sectionIndex)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <a class="uk-button-icon uk-width-1-6 uk-margin-left" @click="removeSection(sectionIndex)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
        </div>
        <div class="uk-margin">
            <input class="uk-button uk-button-grey button uk-margin uk-width-small@m" type="button" @click="postSection" :value="saveText">
        </div>
    </div>
</template>

<script>
    export default {
        name: "add-section",
        data(){
            return{
                sections:[],
            }
        },
        props:{
            previewText:{
                type:String,
                default:'Önizle'
            },
            addText:{
                type:String,
                default:'Ekle',
            },
            addDefaultSectionText:{
                type:String,
                default:'Bölüm Ekle'
            },
            addDefaultLessonText:{
                type:String,
                default:'Ders Ekle'
            },
            sectionText:{
                type:String,
                default:'Bölüm'
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            courseId:{
                type:String,
                required:true,
            }
        },
        computed:{
        },
        methods:{
            addSections:function (section) {
                this.sections.push(section);
            },
            addSection:function () {
                this.addSections({'name':document.getElementById('sectionInput').value, 'lessons':[]})
            },
            removeSection:function (index) {
                this.sections.splice(index,1)
            },
            addLessons: function (lesson,index) {
                this.sections[index].lessons.push(lesson)
            },
            addLesson:function (index) {
                this.addLessons({'name':document.getElementById(index).value, 'isPreview':true}, index);
            },
            removeLesson:function (lessonIndex, sectionIndex) {
                this.sections[sectionIndex].lessons.splice(lessonIndex, 1)
            },
            postSection:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/sections', this.sections).then(response=>console.log(response))
            }
        },
    }
</script>

<style scoped>

</style>
