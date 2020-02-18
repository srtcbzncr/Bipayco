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
                                            :section="section"
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
                                            :section-index="sectionIndex"
                                        > </lesson>
                                    </li>
                                    <li>
                                        <button class="uk-button uk-button-success uk-margin-small uk-width" @click="sendInfo(sectionIndex)" uk-toggle="target: .addLesson"><i class="fas fa-plus uk-margin-small-right"></i>{{addDefaultLessonText}}</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="uk-width-1-6 uk-flex align-items-center">
            <a class="uk-button-icon uk-margin-small-left uk-width-1-4" @click="removeSection"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
            <a class="uk-button-icon uk-margin-small-left uk-width-1-4" @click="sendInfo(sectionIndex)" uk-toggle="target: .sectionSettings"><i class="fas fa-cog icon-small"> </i></a>
            <div class="uk-margin-small-left uk-padding-remove uk-flex uk-flex-column uk-width-1-4">
                <a @click="sectionUp"><i class="fas fa-sort-up"></i></a>
                <a @click="sectionDown"><i class="fas fa-sort-down"></i></a>
            </div>
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
                'loadSelectedSectionIndex',
            ]),
            removeSection:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/sections/delete/'+this.section.id).then(this.$store.dispatch('loadSections',this.courseId))
            },
            sendInfo:function (index) {
                this.$store.dispatch('loadSelectedSectionIndex', index);
                UIkit.toggle( {
                    target:".toggleByAxios",
                    cls:false,
                }).toggle();
                UIkit.toggle( {
                    target:".toggleButton",
                    cls:false,
                }).toggle();
            },
            sectionUp:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/section/'+this.section.id+'/up').then(response=>console.log(response.data))
                    .then(this.$store.dispatch('loadSections',this.courseId))
            },
            sectionDown:function(){
                axios.post('/api/instructor/course/'+this.courseId+'/section/'+this.section.id+'/down').then(response=>console.log(response.data))
                    .then(this.$store.dispatch('loadSections',this.courseId))
            }
        }
    }
</script>

<style scoped>

</style>
