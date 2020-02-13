<template>
    <div class='addLesson' hidden>
        <div class="uk-margin-top">
            <h4>@lang('front/auth.add_lessons')</h4>
        </div>
        <hr>
        <input class="uk-padding-small uk-margin-small-top uk-input uk-width" type="text" id="lessonNameInput">
        <div class="uk-width uk-flex uk-flex-row align-items-center justify-content-around uk-margin-top">
            <div class="uk-flex align-items-center">
                <input class="uk-radio uk-margin-remove" type="radio" name="isVideo" uk-toggle="target: .document" checked value="1">
                <p class="uk-margin-small-left uk-margin-remove-top uk-margin-remove-bottom uk-margin-remove-right">Video</p>
            </div>
            <div class="uk-flex align-items-center">
                <input class="uk-radio uk-margin-remove" type="radio" name="isVideo" uk-toggle="target: .document" value="0">
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
                <button class="uk-button uk-button-default uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" uk-toggle="target: .addLesson">@lang('front/auth.cancel')</button>
            </div>
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-grey uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" @click="addLesson" uk-toggle="target: .addLesson">@lang('front/auth.save')</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "add-lesson",
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
                var isPreview = document.querySelector('#lessonPreview').checked ? 1 : 0;
                let doc;
                if(document.getElementsByName('isVideo')=='1'){
                    doc=document.querySelector('#courseVideo').files[0];
                }else{
                    doc=document.querySelector('#coursePdf').files[0];
                }
                var formData=new FormData();
                formData.append('name', document.getElementById('lessonNameInput').value);
                formData.append('is_preview', isPreview);
                formData.append('is_video', document.getElementsByName('isVideo'));
                formData.append('document', doc);
                for (var i=0; i< document.querySelector('#courseSource').files.length;i++){
                    let file=document.querySelector('#courseSource').files[i];
                    formData.append('source['+i+']', file);
                }
                formData.append('courseId', this.courseId);
                axios.post('/api/instructor/course/'+this.courseId+'/sections/'+this.selectedSectionInfo.id+'/lessons/create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }})
                    .then(response=>{
                        if(!response.data.error){
                            this.$store.dispatch('loadSections',this.courseId);
                            this.$store.dispatch('loadSelectedSectionInfo',{})
                        }
                    })
            },
        },
        created() {
        }
    }
</script>

<style scoped>

</style>
