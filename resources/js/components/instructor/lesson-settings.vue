<template>
    <div class="lessonSettings" hidden>
        <div class="uk-margin-top">
            <h4>{{editLessonText}}</h4>
        </div>
        <hr>
        <div>
            <div class="uk-form-label">{{lessonNameText}}</div>
            <input class="uk-input" type="text" :value="sections[selectedSectionIndex].lessons[selectedLessonIndex].name" id="lessonSettingsName" required>
        </div>
        <div>
            <div class="uk-form-label">{{sourcesText}}</div>
            <div class="js-upload uk-flex uk-flex-center uk-margin" uk-form-custom>
                <input type="file" id="courseSourceSettings" @change="addSource">
                <button class="uk-button uk-button-default uk-width" type="button" tabindex="-1"><span class="fas fa-upload uk-margin-small"></span> {{addSourceText}}</button>
            </div>
            <ul>
                <li v-for="source in sections[selectedSectionIndex].lessons[selectedLessonIndex].sources">
                    <div class="uk-flex align-items-center uk-margin">
                        <div class="uk-width-5-6 uk-flex uk-flex-wrap">
                            <p class="uk-margin-remove" style="text-overflow: ellipsis; overflow:hidden;">{{source.title}}</p>
                        </div>
                        <div class="uk-width-1-6">
                            <a class="uk-button-icon uk-margin-left uk-margin-remove-bottom uk-margin-remove-top uk-margin-remove-right" @click="deleteSourceFromDatabase(source.id)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                        </div>
                    </div>
                </li>
            </ul>
            <ul>
                <li v-for="(source, index) in newSources">
                    <div class="uk-flex align-items-center uk-margin">
                        <div class="uk-width-5-6 uk-flex uk-flex-wrap">
                            <p class="uk-margin-remove" style="text-overflow: ellipsis; overflow:hidden;">{{source.name}}</p>
                        </div>
                        <div class="uk-width-1-6">
                            <a class="uk-button-icon uk-margin-left uk-margin-remove-bottom uk-margin-remove-top uk-margin-remove-right" @click="deleteSource(index)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class=" uk-margin-small uk-flex justify-content-start align-items-center">
            <label>
                <input class="uk-checkbox" type="checkbox" id="settingsPreview" :checked="sections[selectedSectionIndex].lessons[selectedLessonIndex].preview">
                <span class="checkmark uk-text-small">{{isPreviewText}}</span>
            </label>
        </div>
        <div class="uk-width-1-1 uk-grid">
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-grey uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="updateLesson" uk-toggle="target: .lessonSettings">{{saveText}} </button>
            </div>
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-default uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="cancel" uk-toggle="target: .lessonSettings">{{cancelText}}</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState, mapGetters} from "vuex";

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
            },
            addSourceText:{
                type:String,
                default:"Kaynak Ekle"
            }
        },
        computed:{
            ...mapState([
                'sections',
                'selectedLessonIndex',
                'selectedSectionIndex',
            ]),
        },
        methods:{
            ...mapActions([
                'loadSelectedLessonIndex',
                'loadSelectedSectionIndex',
                'loadSections'
            ]),
            getSource:function(){
                for(var i=0;i<this.selectedLessonSources.length; i++){
                    this.lessonSources.push(this.selectedLessonSources[i]);
                }
            },
            updateLesson:function () {
                var isPreview = document.querySelector('#settingsPreview').checked ? '1' : '0';
                var formData=new FormData();
                formData.append('name', document.getElementById('lessonSettingsName').value);
                formData.append('is_preview', isPreview);
                var i=0;
                for (i;i<this.sections[this.selectedSectionIndex].lessons[this.selectedLessonIndex].sources.length;i++){
                    formData.append('source['+i+']', this.lessonSources[i]);
                }
                for (var j=0 ;j<this.newSources.length; j++){
                    formData.append('source['+i+']', this.newSources[j]);
                    i++;
                }
                formData.append('sectionId', this.sections[this.selectedSectionIndex].id);
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.sections[this.selectedSectionIndex].id+'/lessons/create/'+this.sections[this.selectedSectionIndex].lessons[this.selectedLessonIndex].id, formData)
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadSections',this.courseId);
                            this.clearForm();
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                        console.log(response)
                    })
            },
            clearForm:function () {
                this.lessonSources=[];
                this.newSources=[];
            },
            addSource(){
                this.newSources.push(document.querySelector('#courseSourceSettings').files[0]);
            },
            deleteSource(index){
                this.newSources.splice(index,1);
            },
            deleteSourceFromDatabase:function(sourceId){
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.sections[this.selectedSectionIndex].id+'/lessons/'+this.sections[this.selectedSectionIndex].lessons[this.selectedLessonIndex].id+'/source/delete/'+sourceId)
                    .then(response=>console.log(response))
                    .then(this.$store.dispatch('loadSections',this.courseId));
            },
            cancel:function () {
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.sections[this.selectedSectionIndex].id+'/lessons/'+this.sections[this.selectedSectionIndex].lessons[this.selectedLessonIndex].id+'/source/cancel')
                    .then(response=>console.log(response))
                    .then(this.$store.dispatch('loadSections',this.courseId))
                    .catch(response=>console.log(response));
                this.clearForm();
            },
            refreshDate:function () {
                this.$store.dispatch('loadSections',this.courseId)
            }
        },
    }
</script>

<style scoped>

</style>
