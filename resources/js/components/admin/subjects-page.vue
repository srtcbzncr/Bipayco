<template>
    <div class="uk-margin-large-top">
        <div class="uk-flex align-items-center justify-content-between">
            <div class="text-left">
                <a @click="routeLessons" class="uk-flex align-item-center">
                    <i class="fas fa-arrow-alt-circle-left icon-medium uk-margin-small-right"></i>
                    <h6 class="uk-margin-remove">{{backText}}</h6>
                </a>
            </div>
            <div class="text-right">
                <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addSubjectText}} </button>
            </div>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr>
                    <td><p>a</p></td>
                    <td><p>Tiger Nixon</p></td>
                    <td><p>System Architect</p></td>
                    <td><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings(2)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                        <a @click="deactivateItem()" :uk-tooltip="deactivateText"><i class="fas fa-times-circle"></i></a>
                        <a @click="deleteItem()" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                <tr>
                    <td><p>s</p></td>
                    <td><p>Tiger Nixon</p></td>
                    <td><p>System Architect</p></td>
                    <td><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings(1)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                        <a @click="activateItem()" :uk-tooltip="activateText"><i class="fas fa-check-circle"></i></a>
                        <a @click="deleteItem()" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
        <div id="addSubjectArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addSubjectText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editSubjectText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{lessonText}}</div>
                        <select class="uk-width uk-select" v-model="lessonId">
                            <option value="" selected hidden disabled>{{selectLessonText}}</option>
                            <option value="1">ders1</option>
                            <option value="2">ders2</option>
                        </select>
                        <div class="uk-form-label">{{subjectNameText}}</div>
                        <input class="uk-width uk-input" v-model="name" :placeholder="subjectNameText">
                    </div>
                </div>

                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" @click="clearForm" type="button">{{cancelText}}</button>
                    <button class="uk-button uk-button-primary" type="button" @click="saveItem">{{saveText}}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "subjects-page",
        data(){
            return{
                name:"",
                lessonId:"",
                hasItem:false,
            }
        },
        props:{
            lessonsRoute:{
                type:String,
                required:true,
            },
            addSubjectText:{
                type:String,
                default:"Konu Ekle"
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmuyor"
            },
            deleteText:{
                type:String,
                default:"Sil"
            },
            activateText:{
                type:String,
                default:"Aktifleştir"
            },
            deactivateText:{
                type:String,
                default:"Pasifleştir"
            },
            editText:{
                type:String,
                default:"Düzenle"
            },
            backText:{
                type:String,
                default:"Geri"
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            },
            lessonText:{
                type:String,
                default:"Ders"
            },
            selectLessonText:{
                type:String,
                default:"Ders Seçiniz"
            },
            editSubjectText:{
                type:String,
                default:"Konu Düzenle"
            },
            subjectNameText:{
                type:String,
                default:"Konu Adı"
            },

        },
        methods:{
            routeLessons:function () {
                window.location.replace(this.lessonsRoute);
            },
            deactivateItem:function () {

            },
            activateItem:function () {

            },
            deleteItem:function () {

            },
            openSettings:function (id) {
                this.hasItem=true;
                this.name=id+". konu";
                this.lessonId=id;
                UIkit.modal('#addSubjectArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            openForm:function () {
                UIkit.modal('#addSubjectArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.lessonId="";
                this.hasItem=false;
            },
            saveItem:function () {
                this.clearForm();

                UIkit.modal('#addSubjectArea').hide();
            }
        }
    }
</script>

<style scoped>

</style>
