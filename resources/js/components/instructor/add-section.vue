<template>
    <div>
        <div class="">
            <form id="addSectionForm">
                <select v-if="moduleName=='prepareLessons'" id="courseSubject" class="uk-width uk-select">
                    <option disabled hidden selected value=""> {{subjectNameText}} </option>
                    <option v-for="subject in courseSubjects" :value="subject.id" > {{subject.name}}</option>
                </select>
                <cr-lesson-select
                    v-if="moduleName=='prepareExams'"
                    :lesson-default-text="addDefaultLessonText"
                    :subject-default-text="addDefaultSectionText"
                ></cr-lesson-select>
            </form>
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" id="sectionInput" :placeholder="addDefaultSectionText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="addSection"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
        </div>
        <div>
            <div v-for="(section,sectionIndex) in sections" class="uk-margin-top">
                <course-section
                    :section="section"
                    :section-index="sectionIndex"
                    :section-text="sectionText"
                    :add-default-lesson-text="addDefaultLessonText"
                    :add-text="addText"
                    :preview-text="previewText"
                    :course-id="courseId"
                    :instructor-id="instructorId"
                    :is-preview-text="isPreviewText"
                    :save-text="saveText"
                    :saved-success-text="savedSuccessText"
                    :select-file-text="selectFileText"
                    :module-name="moduleName"
                    :sections-length="sections.length"
                > </course-section>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from "vuex";
    import courseSection from "./course-section.vue";
    import axios from'axios'

    export default {
        name: "add-section",
        components: {courseSection},
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
            addDefaultSubjectText:{
                type:String,
                default:'Konu Ekle'
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
            },
            moduleName:{
                type:String,
                required:true,
            },
            subjectNameText:{
                type:String,
                default:"Konu"
            }
        },
        computed:{
            ...mapState([
                'sections',
                'courseSubjects',
            ]),
        },
        methods:{
            ...mapActions([
                'loadSections',
                'loadCourseSubjects',
            ]),
            addSection:function () {
                var formData=new FormData();
                formData.append('name', document.getElementById('sectionInput').value);
                formData.append('courseId', this.courseId);
                if(this.moduleName=='prepareLessons'){
                    formData.append('subjectId', document.getElementById('courseSubject').value);
                }else if(this.moduleName=='prepareExams'){
                    formData.append('subjectId', document.getElementById('crSubjectId').value);
                    formData.append('lessonId', document.getElementById('crLessonId').value);
                }
                axios.post('/api/instructor/'+this.moduleName+'/course/'+this.courseId+'/sections/create', formData)
                    .then(response=>response.data)
                    .then(response=>{
                        if(response.error){
                            UIkit.notification({message:response.message, status: 'danger'});
                        }else{
                            this.$store.dispatch('loadSections',[this.moduleName, this.courseId]);
                            UIkit.notification({message:response.message, status: 'success'});
                        }
                    });
                this.clearForm();
            },
            clearForm:function () {
                document.getElementById('addSectionForm').reset();
                document.getElementById('sectionInput').value="";
            }
        },
        created() {
            this.$store.dispatch('loadSections',[this.moduleName, this.courseId]);
            if(this.moduleName=='prepareLessons'){
                this.$store.dispatch('loadCourseSubjects', [this.moduleName, this.courseId]);
            }
        },
    }
</script>

<style scoped>

</style>
