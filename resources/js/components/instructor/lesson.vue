<template>
    <div class="uk-grid align-items-center uk-padding-remove">
        <div class="uk-width-5-6 uk-grid uk-margin-remove uk-padding-remove" :class="lessonName">
            <div class="uk-width-5-6@m uk-width uk-padding-remove-right">
                <a href="#" class="uk-link-reset uk-width uk-flex align-items-center">
                    <span class="uk-visible@s">
                        <i v-if="lesson.is_video=='1'" style="color:#666666" class="fas fa-play-circle icon-medium"> </i>
                        <i v-else style="color:#666666" class="fas fa-file-alt icon-medium"> </i>
                    </span>
                    <p class="uk-text-truncate uk-margin-small-right uk-margin-remove-left uk-margin-remove-top uk-margin-remove-bottom"><span class="uk-visible@s uk-padding-remove uk-margin-remove">{{lessonIndex+1}}.  </span> {{lesson.name}}</p>
                </a>
            </div>
            <div style="color:#666666" class="uk-width-1-6@m uk-visible@m">
                <i v-if="lesson.preview" class="fas fa-play icon-tiny uk-text-grey uk-visible@s"> </i>
            </div>
        </div>
        <div class="uk-width-1-6 uk-flex flex-wrap uk-padding-remove">
            <a class="uk-button-icon uk-padding-remove uk-margin-left" @click="removeLesson()"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
            <a class="uk-button-icon uk-padding-remove uk-margin-left" @click="sendInfo" uk-toggle="target: .lessonSettings"><i class="fas fa-cog icon-small"> </i></a>
        </div>
    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "lesson",
        data(){
            return{
                lessonSources: [],
                lessonName: 'lessonName'+this.lessonIndex,
                inputName:'inputName'+this.lessonIndex,
                preview: 'lessonPreview'+this.lessonIndex,
            }
        },
        props:{
            lesson:{
                type:Object,
                required:true,
            },
            lessonIndex:{
                type:Number,
                required:true,
            },
            lessonNameText:{
                type:String,
                default:'Ders Adı'
            },
            sourcesText:{
              type:String,
              default:'Kaynaklar'
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
            section:{
                type:Object,
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
            sectionIndex:{
                type:Number,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
            }
        },
        computed:{
            toggleObject(){
                return 'target: .'+this.lessonName;
            },
        },
        methods:{
            ...mapActions([
                'loadSections',
                'loadSelectedLessonIndex',
                'loadSelectedSectionIndex'
            ]),
            removeLesson:function () {
                axios.post('/api/instructor/'+this.moduleName+'/course/'+this.courseId+'/sections/'+this.section.id+'/lessons/delete/'+this.lesson.id)
                    .then(this.$store.dispatch('loadSections',[this.moduleName, this.courseId]))
            },
            removeSource:function(index){
                this.lessonSources.splice(index,1);
            },
            getSource:function(){
                for( let doc of this.lesson.sources){
                    this.lessonSources.push(doc)
                }
            },
            sendInfo:function () {
                this.$store.dispatch('loadSelectedSectionIndex',this.sectionIndex);
                this.$store.dispatch('loadSelectedLessonIndex', this.lessonIndex);
            }
        },
        created(){
            if(this.lesson!=null && this.lesson!==[]){
                this.getSource();
            }
        },
    }
</script>

<style scoped>

</style>
