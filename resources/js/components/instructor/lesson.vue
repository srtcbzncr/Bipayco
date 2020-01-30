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
        <div class="uk-width-5-6" :class="lessonName" hidden>
            <div>
                <div class="uk-form-label">{{lessonNameText}}</div>
                <input class="uk-input" type="text" :value="lesson.name" required>
            </div>
            <div>
                <div v-if="lesson.sources!=null&&lesson.sources!=undefined&&lesson.source!=[]" class="uk-form-label">{{sourcesText}}</div>
                <ul>
                    <li v-for="item in lesson.sources">
                        <div class="uk-flex align-items-center uk-margin">
                            <div class="uk-width-5-6 uk-flex uk-flex-wrap">
                                <p class="uk-margin-remove" style="text-overflow: ellipsis; overflow:hidden;">{{item.title}}</p>
                            </div>
                            <input :name="inputName" hidden disabled :value="item.file_path">
                            <div class="uk-width-1-6">
                                <a class="uk-button-icon uk-margin-left uk-margin-remove-bottom uk-margin-remove-top uk-margin-remove-right" @click="removeSource(item.id)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class=" uk-margin-small uk-flex justify-content-start align-items-center">
                <label>
                    <input v-if="lesson.preview=='1'" class="uk-checkbox" checked type="checkbox" :id="preview">
                    <input v-else class="uk-checkbox" type="checkbox" :id="preview">
                    <span class="checkmark uk-text-small">{{isPreviewText}}</span>
                </label>
            </div>
            <div class="uk-width-1-1">
                <button class="uk-button uk-button-success uk-width uk-margin-small-top" @click="updateLesson" :uk-toggle="toggleObject"><i class="fas fa-save"></i>  {{saveText}}</button>
            </div>
        </div>
        <div class="uk-width-1-6 uk-flex flex-wrap uk-padding-remove">
            <a class="uk-button-icon uk-padding-remove uk-margin-left" @click="removeLesson()"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
            <a class="uk-button-icon uk-padding-remove uk-margin-left" :uk-toggle="toggleObject"><i class="fas fa-cog icon-small"> </i></a>
        </div>
    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "lesson",
        data(){
            return{
                lessonName: 'lessonName'+this.lessonIndex,
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
            },
            inputName:{
                type:String,
            }
        },
        computed:{
          toggleObject(){
              return 'target: .'+this.lessonName;
          }
        },
        methods:{
            ...mapActions([
                'loadSections',
            ]),
            removeLesson:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.sectionId+'/lessons/delete/'+this.lesson.id).then(this.$store.dispatch('loadSections',this.courseId)).then(response=>{
                    console.log(this.lesson)
                });
                },
            updateLesson:function () {
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
            },
            removeSource:function(sourceId){
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.sectionId+'/lessons/'+this.lesson.id+'/source/delete/'+sourceId).then(this.$store.dispatch('loadSections',this.courseId))
            }
        }
    }
</script>

<style scoped>

</style>
