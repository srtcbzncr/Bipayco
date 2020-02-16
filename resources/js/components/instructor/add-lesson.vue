<template>
    <div class='addLesson' hidden>
        <div class="uk-margin-top">
            <h4>{{addLessonText}}</h4>
        </div>
        <hr>
        <div class="uk-form-label">{{lessonNameText}}</div>
        <input class="uk-padding-small uk-margin-small-top uk-input uk-width" type="text" id="lessonNameInput" :placeholder="lessonNameText">
        <div class="uk-margin-top">
            <div class="uk-form-label">{{fileTypeText}}</div>
            <div class="uk-width uk-flex uk-flex-row align-items-center justify-content-around">
                <div class="uk-flex align-items-center">
                    <input class="uk-radio uk-margin-remove" type="radio" name="document" checked @click="isVideo=1">
                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{videoText}}</p>
                </div>
                <div class="uk-flex align-items-center">
                    <input class="uk-radio uk-margin-remove" type="radio" name="document" @click="isVideo=0">
                    <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">{{pdfText}}</p>
                </div>
            </div>
        </div>
        <form class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-right uk-margin-top uk-padding-remove">
            <div v-if="isVideo==1">
                <div class="uk-form-label">{{uploadVideoText}}</div>
                <div uk-form-custom="target: true" class="uk-flex uk-flex-center">
                    <input id="courseVideo" type="file" accept="video/*" required>
                    <input class="uk-input" type="text" tabindex="-1" :placeholder="uploadVideoText" disabled>
                </div>
            </div>
            <div v-else>
                <div class="uk-form-label">{{uploadDocumentText}}</div>
                <div uk-form-custom="target: true" class="uk-flex uk-flex-center">
                    <input id="coursePdf" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                    <input class="uk-input" type="text" tabindex="-1" :placeholder="uploadDocumentText" disabled>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label">{{addSourceText}}</div>
                <div class="js-upload uk-flex uk-flex-center" uk-form-custom>
                    <input type="file" id="courseSource" @change="addSource">
                    <button class="uk-button uk-button-default uk-width" type="button" tabindex="-1"><span class="fas fa-upload uk-margin-small"></span> {{addSourceText}}</button>
                </div>
            </div>
            <ul>
                <li v-for="(source,index) in sources">
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
        </form>
        <div class="uk-margin uk-flex justify-content-start align-items-center">
            <label>
                <input class="uk-checkbox" id="lessonPreview" type="checkbox">
                <span class="checkmark uk-text-small">{{previewText}}</span>
            </label>
        </div>
        <div class="uk-grid">
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-default uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="cancel" uk-toggle="target: .addLesson">{{cancelText}}</button>
            </div>
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-grey uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="addLesson" uk-toggle="target: #modal-example">{{saveText}}</button>
            </div>
        </div>
        <div id="modal-example" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title toggleByAxios" hidden>{{uploadingText}}</h2>
                <h2 class="uk-modal-title toggleByAxios">{{notificationMessage}}</h2>
                <progress max="100" class="uk-progress toggleByAxios" :value.prop="uploadPercentage" hidden></progress>
                <p class="uk-text-right">
                    <button hidden disabled class="uk-button uk-button-default toggleButton" type="button">{{continueText}}</button>
                    <button class="uk-button uk-button-default uk-modal-close toggleButton" uk-toggle="target: .addLesson" type="button" >{{continueText}}</button>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "add-lesson",
        data(){
            return{
                isVideo: 1,
                uploadPercentage: 0,
                message:"",
                sources:[],
            }
        },
        props:{
            courseId:{
                type:String,
                required:true,
            },
            lessonNameText:{
                type:String,
                default:"Ders Adı"
            },
            uploadVideoText:{
                type:String,
                default:"Video Seç"
            },
            uploadDocumentText:{
                type:String,
                default:"Döküman Seç"
            },
            addLessonText:{
                type:String,
                default:"Ders Ekle"
            },
            addSourceText:{
                type:String,
                default:"Kaynak Ekle"
            },
            previewText:{
                type:String,
                default:"Önizleme"
            },
            continueText:{
                type:String,
                default:"Devam Et"
            },
            uploadingText:{
                type:String,
                default:"Yükleniyor"
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            },
            videoText:{
                type:String,
                default:"Video"
            },
            pdfText:{
                type:String,
                default:"Döküman"
            },
            fileTypeText:{
                type:String,
                default:"Dosya Tipi"
            }
        },
        computed:{
            ...mapState([
                'selectedSectionInfo',
            ]),
            notificationMessage(){
                return this.message;
            },
        },
        methods:{
            ...mapActions([
                'loadSelectedSectionInfo',
            ]),
            changeMessage: function(message){
                this.message=message;
            },
            addLesson: function () {
                var isPreview = document.querySelector('#lessonPreview').checked ? '1' : '0';
                let doc;
                if(this.isVideo== 1){
                    doc=document.querySelector('#courseVideo').files[0];
                }else{
                    doc=document.querySelector('#coursePdf').files[0];
                }
                var formData=new FormData();
                formData.append('name', document.getElementById('lessonNameInput').value);
                formData.append('is_preview', isPreview);
                formData.append('is_video', this.isVideo);
                formData.append('document', doc);
                for (var i=0; i< this.sources.length;i++){
                    let file=this.sources[i];
                    formData.append('source['+i+']', file);
                }
                formData.append('courseId', this.courseId);
                for(var pair of formData){
                   console.log(pair[0]);
                   console.log(pair[1])
                }
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.selectedSectionInfo.id+'/lessons/create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function( progressEvent ) {
                        this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                    }.bind(this)})
                    .then(response=>{
                        if(!response.data.error){
                            this.$store.dispatch('loadSections',this.courseId);
                            this.$store.dispatch('loadSelectedSectionInfo',{});
                            this.changeMessage(response.data.message);
                            UIkit.toggle( {
                                target:".toggleByAxios",
                                cls:false,
                            }).toggle();
                            UIkit.toggle( {
                                target:".toggleButton",
                                cls:false,
                            }).toggle();
                            this.clearForm();
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                            this.changeMessage("Ders Yüklenemedi");
                            UIkit.toggle( {
                                target:".toggleByAxios",
                                cls:false,
                            }).toggle();
                            UIkit.toggle( {
                                target:".toggleButton",
                                cls:false,
                            }).toggle();
                            this.uploadPercentage=0;
                            this.clearForm();
                        }
                    })
                    .catch(response=>{
                        this.changeMessage("" +
                            "Ders Yüklenemedi");
                        UIkit.toggle( {
                            target:".toggleByAxios",
                            cls:false,
                        }).toggle();
                        UIkit.toggle( {
                            target:".toggleButton",
                            cls:false,
                        }).toggle();
                        this.uploadPercentage=0;
                        this.clearForm();
                    })
            },
            clearForm: function(){
                document.getElementById('lessonNameInput').value="";
            },
            toggleLesson:function(){
                UIkit.toggle(".addLesson").toggle()
            },
            addSource:function(){
                this.sources.push(document.querySelector('#courseSource').files[0]);
            },
            deleteSource:function(index){
                this.sources.splice(index,1);
            },
            cancel:function(){
                UIkit.toggle( {
                    target:".toggleByAxios",
                    cls:false,
                }).toggle();
                UIkit.toggle( {
                    target:".toggleButton",
                    cls:false,
                }).toggle();
            }
        },
        created() {
        }
    }
</script>

<style scoped>

</style>
