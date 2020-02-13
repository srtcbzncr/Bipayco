<template>
    <div class="lessonSettings" hidden>
        <div class="uk-margin-top">
            <h4>{{editLessonText}}</h4>
        </div>
        <hr>
        <div>
            <div class="uk-form-label">{{lessonNameText}}</div>
            <input class="uk-input" type="text" :value="selectedLessonInfo.name" id="lessonSettingsName" required>
        </div>
        <div>
            <div class="uk-form-label">{{sourcesText}}</div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin document" hidden>
                <input id="addSource" type="file">
                <input class="uk-input" type="text" tabindex="-1" disabled>
            </div>
            <ul>
                <li v-for="source in lessonSources">
                    <div class="uk-flex align-items-center uk-margin">
                        <div class="uk-width-5-6 uk-flex uk-flex-wrap">
                            <p class="uk-margin-remove" style="text-overflow: ellipsis; overflow:hidden;">{{source.title}}</p>
                        </div>
                        <div class="uk-width-1-6">
                            <a class="uk-button-icon uk-margin-left uk-margin-remove-bottom uk-margin-remove-top uk-margin-remove-right"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class=" uk-margin-small uk-flex justify-content-start align-items-center">
            <label>
                <input v-if="selectedLessonInfo.preview=='0'" class="uk-checkbox" id="settingsPreview" type="checkbox">
                <input v-else checked class="uk-checkbox" type="checkbox" id="settingsPreview">
                <span class="checkmark uk-text-small">{{isPreviewText}}</span>
            </label>
        </div>
        <div class="uk-width-1-1 uk-grid">
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-default uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="clearForm" uk-toggle="target: .lessonSettings">{{cancelText}}</button>
            </div>
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-grey uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="updateLesson" uk-toggle="target: .lessonSettings">{{saveText}} </button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "lesson-settings",
        data(){
            return{
                lessonSources: [],
                newSources:[],
            }
        },
        props:{
            editLessonText:{
                type:String,
                default:'Ders Düzenle'
            },
            lessonNameText:{
                type:String,
                default:'Ders Adı'
            },
            sourcesText:{
                type:String,
                default:'Kaynaklar'
            },
            isPreviewText:{
                type:String,
                default:'Önizleme'
            },
            saveText:{
                type:String,
                default:'Kaydet'
            },
            cancelText:{
                type:String,
                default:'Vazgeç'
            },
            courseId:{
                type:String,
                required:true,
            }
        },
        computed:{
            ...mapState([
                'selectedLessonInfo',
                'selectedSectionInfo',
            ]),
        },
        methods:{
            ...mapActions([
                'loadSelectedLessonInfo',
                'loadSelectedSectionInfo',
            ]),
            removeSource:function(index){
                this.lessonSources.splice(index,1);
            },
            getSource:function(){
                for( let doc of this.lesson.sources){
                    this.lessonSources.push(doc)
                }
            },
            updateLesson:function () {
                var isPreview = document.querySelector('#settingsPreview').checked ? '1' : '0';
                var formData=new FormData();
                formData.append('name', document.getElementById('lessonSettingsName').value);
                formData.append('is_preview', isPreview);
                for (var i=0;i<this.lessonSources.length;i++){
                    formData.append('source['+i+']', this.lessonSources[i]);
                }
                formData.append('sectionId', this.selectedSectionInfo.id);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.selectedSectionInfo.id+'/lessons/create/'+this.selectedLessonInfo.id, formData)
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadSections',this.courseId);
                            this.$store.dispatch('loadSelectedLessonInfo',{});
                            this.$store.dispatch('loadSelectedSectionInfo',{});
                            this.clearForm();
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    })
            },
            clearForm:function () {
                document.querySelector('#settingsPreview').checked=false;
                document.getElementById('lessonSettingsName').value="";
                this.lessonSources=[];
                this.newSources=[];
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
