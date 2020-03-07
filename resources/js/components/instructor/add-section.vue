<template>
    <div>
        <div class="">
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
                > </course-section>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from "vuex";
    import courseSection from "./course-section.vue";

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
                axios.post('/api/instructor/'+this.moduleName+'course/'+this.courseId+'/sections/create', formData)
                    .then(response=>response.data)
                    .then(response=>{
                        if(response.error){
                            UIkit.notification({message:response.message, status: 'danger'});
                        }else{
                            this.$store.dispatch('loadSections',[this.moduleName, this.courseId]);
                            UIkit.notification({message:response.message, status: 'success'});
                        }
                    });
                document.getElementById('sectionInput').value="";
            },
        },
        created() {
            this.$store.dispatch('loadSections',[this.moduleName, this.courseId]);
        },
    }
</script>

<style scoped>

</style>
