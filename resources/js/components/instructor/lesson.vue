<template>
    <div class="uk-flex align-items-center">
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
        <a class="uk-button-icon uk-margin-left uk-width-1-6" @click="removeLesson()"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "lesson",
        props:{
            lesson:{
                type:Object,
                required:true,
            },
            lessonIndex:{
                type:Number,
                required:true,
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
            sectionId:{
                type:Number,
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
        methods:{
            ...mapActions([
                'loadSections',
            ]),
            removeLesson:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.sectionId+'/lessons/delete/'+this.lesson.id).then(this.$store.dispatch('loadSections',this.courseId));
            },
        }
    }
</script>

<style scoped>

</style>
