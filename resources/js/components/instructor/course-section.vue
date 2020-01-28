<template>
    <div class="uk-flex align-items-center justify-content-center">
        <div class="uk-width-5-6">
            <div class="uk-margin-top uk-margin-remove-right">
                <ul uk-accordion="" class="uk-accordion">
                    <li class="tm-course-lesson-section uk-background-default">
                        <a class="uk-accordion-title uk-padding-small"><h6>{{sectionText}} {{sectionIndex+1}}</h6>
                            <h4 class="uk-margin-remove" :class="sectionName">{{section.name}}</h4>
                            <div class="uk-margin-remove" :class="sectionName" hidden>
                                <input class="uk-width-4-5@m uk-input uk-margin-small-top uk-padding-small" :id="sectionNameInput" :value="section.name">
                                <button class="uk-button uk-button-success uk-width-1-6@m uk-margin-small-top " @click="updateSection" :uk-toggle="toggleObject"><i class="fas fa-save"></i><span class="uk-hidden@m">  {{saveText}}</span></button>
                            </div>
                        </a>
                        <div class="uk-accordion-content uk-margin-remove-top">
                            <div class="tm-course-section-list">
                                <ul>
                                    <li>
                                        <div class="uk-width uk-flex uk-flex-row align-items-center justify-content-around">
                                            <div class="uk-flex align-items-center">
                                                <input class="uk-radio uk-margin-remove" type="radio" :name="documentType" v-model="isVideo" checked value="1">
                                                <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">Video</p>
                                            </div>
                                            <div class="uk-flex align-items-center">
                                                <input class="uk-radio uk-margin-remove" type="radio" :name="documentType" v-model="isVideo" value="0">
                                                <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">PDF</p>
                                            </div>
                                        </div>
                                        <div>
                                            <input class="uk-padding-small uk-margin-small-top uk-input uk-width" type="text" :id="lessonInput" :placeholder="addDefaultLessonText">
                                            <form class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-right uk-margin-top uk-padding-remove">
                                                <div v-if="isVideo=='1'" uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                                    <input name="document" type="file" accept="video/*" :id="courseVideo" required>
                                                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                                </div>
                                                <div v-else uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                                    <input name="document" type="file" accept="application/pdf,application/vnd.ms-excel" :id="coursePdf" required>
                                                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                                </div>
                                                <div class="js-upload uk-placeholder uk-text-center">
                                                    <div uk-form-custom>
                                                        <input type="file" :id="courseSource" multiple>
                                                        <span class="fas fa-upload uk-margin-small"></span>
                                                        <span class="uk-link">{{addSourceText}}</span>
                                                    </div>
                                                </div>
                                                <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden> </progress>
                                                <!--<div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                                    <input name="document" type="file" :id="courseSource" multiple>
                                                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="addSourceText">
                                                </div>-->
                                            </form>
                                            <div class="uk-margin uk-flex justify-content-start align-items-center">
                                                <label>
                                                    <input class="uk-checkbox" type="checkbox" :id="preview">
                                                    <span class="checkmark uk-text-small">{{isPreviewText}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <button class="uk-button uk-button-success uk-margin-small-top uk-width" @click="addLesson"><i class="fas fa-plus"></i> {{addText}}</button>
                                    </li>
                                    <li v-for="(lesson,lessonIndex) in section.lessons">
                                        <lesson
                                            :lesson=lesson
                                            :lesson-index="lessonIndex"
                                            :section-id="section.id"
                                            :add-default-lesson-text="addDefaultLessonText"
                                            :add-text="addText"
                                            :preview-text="previewText"
                                            :course-id="courseId"
                                            :instructor-id="instructorId"
                                            :is-preview-text="isPreviewText"
                                            :save-text="saveText"
                                            :saved-success-text="savedSuccessText"
                                            :select-file-text="selectFileText"
                                        > </lesson>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="uk-width-1-6">
            <a class="uk-button-icon uk-margin-left" @click="removeSection"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
            <a class="uk-button-icon uk-margin-left" :uk-toggle="toggleObject"><i class="fas fa-cog icon-small"> </i></a>
        </div>
    </div>
</template>

<script>
    import lesson from'./lesson.vue'
    import {mapActions} from "vuex";
    export default {
        name: "courseSection",
        components:{
            lesson,
        },
        data(){
            return{
                isVideo:1,
                courseVideo: 'courseVideo'+this.sectionIndex,
                coursePdf: 'coursePdf'+this.sectionIndex,
                documentType: 'documentType'+this.sectionIndex,
                preview: 'preview'+this.sectionIndex,
                sectionNameInput: 'sectionNameInput'+this.sectionIndex,
                sectionName:'sectionName'+this.sectionIndex,
                lessonInput:'lessonInput'+this.sectionIndex,
                courseSource:'courseSource'+this.sectionIndex,
            }
        },
        props:{
            sectionIndex:{
                type:Number,
                required:true,
            },
            section:{
                type:Object,
                required: true,
            },
            previewText:{
                type:String,
                default:'Önizle'
            },
            addText:{
                type:String,
                default:'Ekle',
            },
            addSourceText:{
                type:String,
                default:'Kaynak Ekle',
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
            toggleObject(){
                return 'target: .'+this.sectionName;
            },
        },
        methods:{
            ...mapActions([
                'loadSections',
            ]),
            removeSection:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/sections/delete/'+this.section.id).then(this.$store.dispatch('loadSections',this.courseId))
            },
            updateSection:function(){
                var formData=new FormData();
                formData.append('name', document.getElementById(this.sectionNameInput).value);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/create/'+this.section.id, formData).then(this.$store.dispatch('loadSections',this.courseId))
            },
            addLesson:function () {
                var isPreview = document.querySelector('#'+this.preview).checked ? 1 : 0;
                let doc;
                if(this.isVideo=='1'){
                    doc=document.querySelector('#'+this.courseVideo).files[0];
                }else{
                    doc=document.querySelector('#'+this.coursePdf).files[0];
                }
                var formData=new FormData();
                formData.append('name', document.getElementById(this.lessonInput).value);
                formData.append('is_preview', isPreview);
                formData.append('is_video', this.isVideo);
                formData.append('document', doc);
                for (var i=0; i< document.querySelector('#'+this.courseSource).files.length;i++){
                    let file=document.querySelector('#'+this.courseSource).files[i];
                    formData.append('source['+i+']', file);
                }
                formData.append('courseId', this.courseId);
                for(var pair of formData.entries()){
                    console.log(pair[0]);
                    console.log(pair[1]);
                }
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.section.id+'/lessons/create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }})
                    .then(response=>{
                        if(!response.data.error){
                            this.$store.dispatch('loadSections',this.courseId)
                        }
                    })
            },
        }
    }
</script>

<style scoped>

</style>
