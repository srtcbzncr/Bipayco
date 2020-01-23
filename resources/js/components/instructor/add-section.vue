<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" id="sectionInput" :placeholder="addDefaultSectionText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="addSection"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
        </div>
        <div v-for="(section, sectionIndex) in sections" class="uk-margin-top uk-flex align-items-center justify-content-center">
            <div class="uk-width-5-6" :id="sectionIndex">
                <div class="uk-margin-top uk-margin-remove-right">
                    <ul uk-accordion="" class="uk-accordion">
                        <li class="tm-course-lesson-section uk-background-default">
                            <a class="uk-accordion-title uk-padding-small" href="#"><h6>{{sectionText}} {{sectionIndex}}</h6>
                                <h4 class="uk-margin-remove section-name">{{section.name}}</h4>
                                <div class="uk-margin-remove section-name uk-grid" hidden>
                                    <input class="uk-width-4-5@m uk-input uk-padding-small" :value="section.name">
                                    <button class="uk-margin-small-left uk-button uk-button-success uk-width-1-6@m uk-padding-remove" @click="updateSection" uk-toggle="target: .section-name;"><i class="fas fa-save"></i></button>
                                </div>
                            </a>
                            <div class="uk-accordion-content uk-margin-remove-top">
                                <div class="tm-course-section-list">
                                    <ul>
                                        <li>
                                            <div class="uk-width uk-flex uk-flex-row align-items-center justify-content-around">
                                                <div class="uk-flex align-items-center">
                                                    <input class="uk-radio uk-margin-remove" type="radio" name="documentType" v-model="isVideo" checked value="1">
                                                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">Video</p>
                                                </div>
                                                <div class="uk-flex align-items-center">
                                                    <input class="uk-radio uk-margin-remove" type="radio" name="documentType" v-model="isVideo" value="0">
                                                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">PDF</p>
                                                </div>
                                            </div>
                                            <div>
                                                <input class="uk-padding-small uk-margin-small-top uk-input uk-width" type="text" :id="sectionIndex" :placeholder="addDefaultLessonText">
                                                <form class="uk-margin-remove uk-padding-remove">
                                                    <div v-if="isVideo=='1'" uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                                        <input name="document" type="file" accept="video/*" id="courseVideo" required>
                                                        <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                                    </div>
                                                    <div v-else uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                                        <input name="document" type="file" accept="application/pdf,application/vnd.ms-excel" id="coursePdf" required>
                                                        <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                                    </div>
                                                </form>
                                                <div class="uk-margin uk-flex justify-content-start align-items-center">
                                                    <label>
                                                        <input class="uk-checkbox" type="checkbox" id="preview">
                                                        <span class="checkmark uk-text-small">{{isPreviewText}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <button class="uk-button uk-button-success uk-margin-small-top uk-width" @click="addLesson(sectionIndex)"><i class="fas fa-plus"></i> {{addText}}</button>
                                        </li>
                                        <li v-for="(lesson,lessonIndex) in section.lessons" class="uk-flex align-items-center">
                                            <div class="uk-width-4-6">
                                                <a href="#" class="uk-link-reset uk-flex align-items-center">
                                                    <!-- Play icon  -->
                                                    <span>
                                                        <i v-if="lesson.is_video=='1'" style="color:#666666" class="fas fa-play-circle icon-medium"> </i>
                                                        <i v-else style="color:#666666" class="fas fa-file-alt icon-medium"> </i>
                                                    </span>
                                                    <!-- Course title  -->
                                                    <div class="uk-text-truncate uk-margin-small-right "><p class="uk-margin-remove">{{lessonIndex+1}}. {{lesson.name}}</p></div>
                                                </a>
                                            </div>
                                            <div style="color:#666666" class="uk-width-1-6"> <i v-if="lesson.preview" class="fas fa-play icon-tiny uk-text-grey uk-visible@s"></i> </div>
                                            <a class="uk-button-icon uk-margin-left uk-width-1-6" @click="removeLesson(lessonIndex, sectionIndex)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                                            <a class="uk-button-icon uk-margin-left uk-width-1-6" @click="removeLesson(lessonIndex, sectionIndex)"><i class="fas fa-cog text-danger icon-small"> </i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="uk-width-1-6">
                <a class="uk-button-icon uk-margin-left" @click="removeSection(section.id)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                <a class="uk-button-icon uk-margin-left" uk-toggle="target: .section-name ;"><i class="fas fa-cog icon-small"> </i></a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from "vuex";

    export default {
        name: "add-section",
        data(){
            return{
                isVideo:1,
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
            },
            instructorId:{
                type:String,
                required:true,
            },
            selectFileText:{
                type:String,
                default:'Dosya Seç'
            },
            isPreviewText:{
                type:String,
                default:'Önizleme'
            },
            savedSuccessText:{
                type:String,
                default:'Başarıyla Kaydedildi'
            }
        },
        computed:{
            ...mapState([
                'sections',
            ]),
        },
        methods:{
            ...mapActions([
                'loadSections',
            ]),
            addSection:function () {
                var formData=new FormData();
                formData.append('name', document.getElementById('sectionInput').value);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/create', formData).then(response=>console.log(response)).then(this.$store.dispatch('loadSections',this.courseId))
            },
            removeSection:function (sectionId) {
                axios.post('/api/instructor/course/'+this.courseId+'/sections/delete/'+sectionId).then(this.$store.dispatch('loadSections',this.courseId))
            },
            updateSection:function(sectionId){
                var formData=new FormData();
                formData.append('name', document.getElementById('sectionInput').value);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/create/'+sectionId, formData).then(response=>console.log(response)).then(this.$store.dispatch('loadSections',this.courseId))
            },
            addLessons: function (lesson,index) {
                if(lesson.name.trim()!=""&&lesson.name!=null&&lesson.name!=undefined) {
                    this.sections[index].lessons.push(lesson)
                }
            },
            addLesson:function (index) {
                var isPreview = document.querySelector('#preview').checked ? 1 : 0;
                var doc;
                if(this.isVideo=='1'){
                    doc=document.querySelector('#courseVideo').files[0];
                }else{
                    doc=document.querySelector('#coursePdf').files[0];
                }
                this.addLessons({'name':document.getElementById(index).value, 'is_preview':isPreview, 'source':[], 'is_video':this.isVideo, 'document':doc }, index);
            },
            removeLesson:function (lessonIndex, sectionIndex) {
                this.sections[sectionIndex].lessons.splice(lessonIndex, 1)
            },
        },
        mounted() {
            this.$store.dispatch('loadSections',this.courseId);
            console.log('çalışıyor')
        },
    }
</script>

<style scoped>

</style>
