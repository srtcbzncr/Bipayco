<template>
    <div class="uk-flex align-items-center justify-content-center">
        <div class="uk-width-5-6">
            <div class="uk-margin-top uk-margin-remove-right">
                <ul uk-accordion="" class="uk-accordion">
                    <li class="tm-course-lesson-section uk-background-default">
                        <a class="uk-accordion-title uk-padding-small"><h6>{{sectionText}} {{sectionIndex+1}}</h6>
                            <h4 class="uk-margin-remove">{{section.name}}</h4>
                        </a>
                        <div class="uk-accordion-content uk-margin-remove-top">
                            <div class="tm-course-section-list">
                                <ul>
                                    <li v-for="(lesson,lessonIndex) in section.lessons">
                                        <lesson
                                            :section="this.section"
                                            :lesson=lesson
                                            :lesson-index="lessonIndex"
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
                                    <li>
                                        <button class="uk-button uk-button-success uk-margin-small uk-width" @click="sendInfo" uk-toggle="target: .addLesson"><i class="fas fa-plus uk-margin-small-right"></i>{{addDefaultLessonText}}</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="uk-width-1-6">
            <a class="uk-button-icon uk-margin-small-left" @click="removeSection"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
            <a class="uk-button-icon uk-margin-small-left" @click="sendInfo" uk-toggle="target: .sectionSettings"><i class="fas fa-cog icon-small"> </i></a>
            <i class="fas fa-arrows-alt-v uk-margin-small-left uk-sortable-handle"></i>
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
                'loadSelectedSectionInfo',
            ]),
            removeSection:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/sections/delete/'+this.section.id).then(this.$store.dispatch('loadSections',this.courseId))
            },
            /*updateSection:function(){
                var formData=new FormData();
                formData.append('name', document.getElementById(this.sectionNameInput).value);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/create/'+this.section.id, formData).then(this.$store.dispatch('loadSections',this.courseId))
            },*/
            sendInfo:function () {
                this.$store.dispatch('loadSelectedSectionInfo', this.section)
            },
            /*addLesson:function () {
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
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.section.id+'/lessons/create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }})
                    .then(response=>{
                        if(!response.data.error){
                            this.$store.dispatch('loadSections',this.courseId)
                        }
                    })
            },*/
        }
    }
</script>

<style scoped>

</style>
