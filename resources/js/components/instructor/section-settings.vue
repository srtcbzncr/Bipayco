<template>
    <div class="sectionSettings" hidden>
        <div class="uk-margin-top">
            <h4>{{editSectionText}}</h4>
        </div>
        <hr>
        <div class="uk-margin-small-top">
            <div class="uk-form-label">{{sectionNameText}}</div>
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width" id="sectionSettingsName" type="text" :value="sections[selectedSectionIndex].name">
        </div>
        <div class="uk-margin-remove-top">
            <div class="uk-form-label">{{lessonsText}}</div>
            <div class="tm-course-section-list">
                <ul v-if="sections[selectedSectionIndex].lessons!=null && sections[selectedSectionIndex].lessons!=undefined">
                    <li v-for="(lesson,lessonIndex) in sections[selectedSectionIndex].lessons" class="uk-card uk-card-default uk-padding-small uk-flex align-items-center justify-content-between">
                        <div class="uk-grid uk-margin-remove uk-padding-remove">
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
                        <div class="uk-margin-small-left uk-padding-remove uk-flex uk-flex-column uk-width-1-4">
                            <a @click="lessonUp"><i class="fas fa-sort-up"></i></a>
                            <a @click="lessonDown"><i class="fas fa-sort-down"></i></a>
                        </div>
                    </li>
                </ul>
                <h4 v-if="sections[selectedSectionIndex].lessons==null || sections[selectedSectionIndex].lessons==undefined">{{hasNoLessonText}}</h4>
            </div>
        </div>
        <div class="uk-grid uk-margin-top">
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-grey uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="updateSection" uk-toggle="target: .sectionSettings">{{saveText}}</button>
            </div>
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-default uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" uk-toggle="target: .sectionSettings"> {{cancelText}} </button>
            </div>
        </div>
    </div>
</template>

<script>
    import lesson from'./lesson.vue';
    import {mapActions, mapState} from "vuex";

    export default {
        name: "section-settings",
        components:{
            lesson,
        },
        props:{
            editSectionText:{
                type:String,
                default:'Bölüm Düzenle'
            },
            lessonsText:{
                type:String,
                default:'Dersler'
            },
            sectionNameText:{
                type:String,
                default:'Bölüm Adı'
            },
            lessonNameText:{
                type:String,
                default:'Ders Adı'
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
            savedSuccessText:{
                type:String,
                default:'Başarıyla Kaydedildi'
            },
            cancelText:{
                type:String,
                default:'Vazgeç'
            },
            hasNoLessonText:{
                type:String,
                default:'Ders Bulunmuyor'
            }
        },
        computed:{
            ...mapState([
                'sections',
                'selectedSectionIndex',
            ]),

        },
        methods:{
            ...mapActions([
                'loadSections',
                'loadSelectedSectionIndex',
            ]),
            updateSection:function(){
                var formData=new FormData();
                formData.append('name', document.getElementById('sectionSettingsName').value);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/create/'+this.sections[this.selectedSectionIndex].id, formData)
                    .then(response=>{
                        if(!response.data.error){
                            this.$store.dispatch('loadSections',this.courseId);
                            UIkit.notification({message:response.data.message, status: 'success'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    })
            },
            lessonUp:function (lessonId) {
                axios.post('/api/instructor/course/'+this.courseId+'/section/'+this.sections[this.selectedSectionIndex].id+'/lesson/'+lessonId+"/up").then(response=>console.log(response.data))
                    .then(this.$store.dispatch('loadSections',this.courseId))
            },
            lessonDown:function (lessonId) {
                axios.post('/api/instructor/course/'+this.courseId+'/section/'+this.sections[this.selectedSectionIndex].id+'/lesson/'+lessonId+'/up').then(response=>console.log(response.data))
                    .then(this.$store.dispatch('loadSections',this.courseId))
            }
        },
    }
</script>
<style scoped>
</style>
