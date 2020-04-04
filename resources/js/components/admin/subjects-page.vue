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
                    <tr v-for="item in adminSubject">
                        <td><p>{{item.name}}</p></td>
                        <td><p>{{item.lessonId}}</p></td>
                        <td class="uk-flex flex-wrap align-items-center justify-content-between">
                            <a @click="openSettings(item.id)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                            <a v-if="item.active" @click="activateItem(item.id)" :uk-tooltip="activateText"><i class="fas fa-check-circle"></i></a>
                            <a v-else @click="deactivateItem(item.id)" :uk-tooltip="deactivateText"><i class="fas fa-times-circle"></i></a>
                            <a @click="deleteItem(item.id)" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
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
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "subjects-page",
        data(){
            return{
                name:"",
                lessonId:"",
                hasItem:false,
                selectedSubjectId:"",
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
        computed:{
            ...mapState([
                'adminSelectedId',
                'adminSubject'
            ]),
        },
        methods:{
            ...mapActions([
                'loadAdminSubject'
            ]),
            routeLessons:function () {
                window.location.replace(this.lessonsRoute);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/cr/subject/setPassive/'+id).then(response=>console.log(response.data))
            },
            activateItem:function (id) {
                Axios.post('/api/admin/cr/subject/setActive/'+id).then(response=>console.log(response.data))
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/cr/subject/delete/'+id).then(response=>console.log(response.data))
            },
            openSettings:function (id) {
                this.selectedGradeId=id;
                Axios.get('/api/admin/cr/subject/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addSubjectArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.name=selectedData.name;
                this.lessonId=selectedData.lessonId;
                this.hasItem=true;
                UIkit.modal('#addSubjectArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.lessonId="";
                this.hasItem=false;
                this.selectedSubjectId="";
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/cr/subject/update/'+this.selectedSubjectId, {
                        name:this.name,
                        lessonId:this.lessonId,
                    }).then(this.$store.dispatch('loadAdminSubject', this.adminSelectedId))
                }else{
                    Axios.post('/api/admin/cr/subject/create', {
                        name:this.name,
                        lessonId:this.lessonId,
                    }).then(this.$store.dispatch('loadAdminSubject', this.adminSelectedId))
                }
                this.clearForm();
                UIkit.modal('#addSubjectArea').hide();
            }
        },
    }
</script>

<style scoped>

</style>
