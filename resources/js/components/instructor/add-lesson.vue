<template>
    <div class='addLesson' hidden>
        <div class="uk-margin-top">
            <h4>@lang('front/auth.add_lessons')</h4>
        </div>
        <hr>
        <input class="uk-padding-small uk-margin-small-top uk-input uk-width" type="text" id="lessonNameInput">
        <div class="uk-width uk-flex uk-flex-row align-items-center justify-content-around uk-margin-top">
            <div class="uk-flex align-items-center">
                <input class="uk-radio uk-margin-remove" type="radio" name="isVideo" uk-toggle="target: .document" checked v-model="isVideo" value="1">
                <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">Video</p>
            </div>
            <div class="uk-flex align-items-center">
                <input class="uk-radio uk-margin-remove" type="radio" name="isVideo" uk-toggle="target: .document" v-model="isVideo" value="0">
                <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">PDF</p>
            </div>
        </div>
        <form class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-right uk-margin-top uk-padding-remove">
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin document">
                <input id="courseVideo" type="file" accept="video/*" required>
                <input class="uk-input" type="text" tabindex="-1" disabled>
            </div>
            <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin document" hidden>
                <input id="coursePdf" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                <input class="uk-input" type="text" tabindex="-1" disabled>
            </div>
            <div class="js-upload uk-placeholder uk-text-center">
                <div uk-form-custom>
                    <input type="file" id="courseSource" multiple>
                    <span class="fas fa-upload uk-margin-small"></span>
                    <span class="uk-link"> </span>
                </div>
            </div>
            <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden> </progress>
            <!--<div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                <input name="document" type="file" :id="courseSource" multiple>
                <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="addSourceText">
                </div>-->
        </form>
        <div class="uk-margin uk-flex justify-content-start align-items-center">
            <label>
                <input class="uk-checkbox" id="lessonPreview" type="checkbox">
                <span class="checkmark uk-text-small">Preview</span>
            </label>
        </div>
        <div class="uk-grid">
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-default uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="clearForm" uk-toggle="target: .addLesson">@lang('front/auth.cancel')</button>
            </div>
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-grey uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="addLesson" uk-toggle="target: #modal-example">@lang('front/auth.save')</button>
            </div>
        </div>
        <div id="modal-example" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h2 v-if="uploadPercentage<100" class="uk-modal-title">Yükleniyor</h2>
                <h2 v-if="uploadPercentage>=100" class="uk-modal-title">Yükleme Tamamlandı</h2>
                <progress v-if="uploadPercentage<100" max="100" class="uk-progress" :value.prop="uploadPercentage"></progress>
                <p class="uk-text-right">
                    <button v-if="uploadPercentage<100" disabled class="uk-button uk-button-default" type="button">Devam Et</button>
                    <button v-else class="uk-button uk-button-default uk-modal-close" type="button" uk-toggle="target: .addLesson">Devam Et</button>
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
                isVideo:'1',
                uploadPercentage: 0,
            }
        },
        props:{
            courseId:{
                type:String,
                required:true,
            },
        },
        computed:{
            ...mapState([
                'selectedSectionInfo',
            ]),
        },
        methods:{
            ...mapActions([
                'loadSelectedSectionInfo',
            ]),
            addLesson: function () {
                var isPreview = document.querySelector('#lessonPreview').checked ? '1' : '0';
                let doc;
                if(this.isVideo=='1'){
                    doc=document.querySelector('#courseVideo').files[0];
                }else{
                    doc=document.querySelector('#coursePdf').files[0];
                }
                var formData=new FormData();
                formData.append('name', document.getElementById('lessonNameInput').value);
                formData.append('is_preview', isPreview);
                formData.append('is_video', this.isVideo);
                formData.append('document', doc);
                for (var i=0; i< document.querySelector('#courseSource').files.length;i++){
                    let file=document.querySelector('#courseSource').files[i];
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
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.clearForm();
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                            this.uploadPercentage=0;
                        }
                    })
            },
            clearForm: function(){
                document.querySelector('#lessonPreview').checked=false;
                document.querySelector('#courseVideo').files=undefined;
                document.querySelector('#coursePdf').files=undefined;
                document.querySelector('#courseSource').files=undefined;
                document.getElementById('lessonNameInput').value="";
            },
        },
        created() {
        }
    }
</script>

<style scoped>

</style>
