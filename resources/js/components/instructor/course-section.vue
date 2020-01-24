<template>
    <div class="uk-flex align-items-center justify-content-center">
        <div class="uk-width-5-6">
            <div class="uk-margin-top uk-margin-remove-right">
                <ul uk-accordion="" class="uk-accordion">
                    <li class="tm-course-lesson-section uk-background-default">
                        <a class="uk-accordion-title uk-padding-small"><h6>{{sectionText}} {{sectionIndex+1}}</h6>
                            <h4 class="uk-margin-remove" :class="sectionName">{{section.name}}</h4>
                            <div class="uk-margin-remove" :class="sectionName" id="test" hidden>
                                <input class="uk-width-4-5@m uk-input uk-margin-small-top uk-padding-small" :name="sectionNameInput" :value="section.name">
                                <button class="uk-button uk-button-success uk-width-1-6@m uk-margin-small-top " @click="updateSection(section.id,sectionIndex)" :uk-toggle="toggleObject"><i class="fas fa-save"></i><span class="uk-hidden@m">  {{saveText}}</span></button>
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
                                            <input class="uk-padding-small uk-margin-small-top uk-input uk-width" type="text" :id="sectionIndex" :placeholder="addDefaultLessonText">
                                            <form class="uk-margin-remove uk-padding-remove">
                                                <div v-if="isVideo=='1'" uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                                    <input name="document" type="file" accept="video/*" :id="courseVideo" required>
                                                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                                </div>
                                                <div v-else uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                                    <input name="document" type="file" accept="application/pdf,application/vnd.ms-excel" :id="coursePdf" required>
                                                    <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">
                                                </div>
                                            </form>
                                            <div class="uk-margin uk-flex justify-content-start align-items-center">
                                                <label>
                                                    <input class="uk-checkbox" type="checkbox" :id="preview">
                                                    <span class="checkmark uk-text-small">{{isPreviewText}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <button class="uk-button uk-button-success uk-margin-small-top uk-width" @click="addLesson(sectionIndex)"><i class="fas fa-plus"></i> {{addText}}</button>
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
            <a class="uk-button-icon uk-margin-left" @click="removeSection()"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
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
            }
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
                var section= document.querySelector('#test');
                formData.append('name', section.querySelector('input[name="'+this.sectionNameInput+'"]').value);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/create/'+this.section.id, formData).then(this.$store.dispatch('loadSections',this.courseId))
            },
            addLesson:function () {
                var isPreview = document.querySelector('#'+this.preview).checked ? 1 : 0;
                var doc;
                if(this.isVideo=='1'){
                    doc=document.querySelector('#'+this.courseVideo).files[0];
                }else{
                    doc=document.querySelector('#'+this.coursePdf).files[0];
                }
                var formData=new FormData();
                formData.append('name', document.getElementById('sectionInput').value);
                formData.append('is_preview', isPreview);
                formData.append('is_video', this.isVideo);
                formData.append('document', doc);
                formData.append('source',[]);
                formData.append('courseId', this.courseId);
                formData.append('sectionId', this.section.id);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.section.id+'/lesson', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }})
                    .then(response=>console.log(response)).then(this.$store.dispatch('loadSections',this.courseId))
            },
        }
    }
</script>

<style scoped>

</style>
