<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addLessonText}} </button>
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
                    <td @click="routeSubjects"><p>a</p></td>
                    <td @click="routeSubjects"><p>Tiger Nixon</p></td>
                    <td @click="routeSubjects"><p>System Architect</p></td>
                    <td @click="routeSubjects"><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings(1)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                        <a @click="deactivateItem()" :uk-tooltip="deactivateText"><i class="fas fa-times-circle"></i></a>
                        <a @click="deleteItem()" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                <tr>
                    <td @click="routeSubjects"><p>s</p></td>
                    <td @click="routeSubjects"><p>Tiger Nixon</p></td>
                    <td @click="routeSubjects"><p>System Architect</p></td>
                    <td @click="routeSubjects"><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings(2)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
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
        <div id="addLessonArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addLessonText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editLessonText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{iconText}}</div>
                        <select class="uk-width uk-select" v-model="icon">
                            <option value="">{{selectIconText}}</option>
                            <option value="fa-user"> user </option>
                            <option value="fa-chalkboard-teacher"> chalkboard teacher </option>
                        </select>
                        <div class="uk-form-label">{{lessonNameText}}</div>
                        <input class="uk-width uk-input" v-model="name" :placeholder="lessonNameText">
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
        name: "lessons-page",
        data(){
            return{
                name:"",
                icon:"",
                hasItem:false,
                selectedLessonId:"",
            }
        },
        props:{
            subjectsRoute:{
                type:String,
                required:true,
            },
            addLessonText:{
                type:String,
                default:"Ders Ekle"
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
            saveText:{
                type:String,
                default:"Kaydet"
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            },
            editLessonText:{
                type:String,
                default:"Ders Düzenle"
            },
            lessonNameText:{
                type:String,
                default:"Ders Adı"
            },
            iconText:{
                type:String,
                default:"İkon"
            },
            selectIconText:{
                type:String,
                default:"İkon Seçiniz"
            },
        },
        methods:{
            routeSubjects:function () {
                window.location.replace(this.subjectsRoute);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/cr/lesson/setPassive/'+id).then(response=>console.log(response));
            },
            activateItem:function (id) {
                Axios.post('/api/admin/cr/lesson/setActive/'+id).then(response=>console.log(response));
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/cr/lesson/delete/'+id).then(response=>console.log(response));
            },
            openSettings:function (id) {
                this.selectedLessonId=id;
                Axios.get('/api/admin/cr/lesson/show/'+id)
                    .then(response=>this.setSelected(response.data));
            },
            openForm:function () {
                UIkit.modal('#addLessonArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.icon=selectedData.symbol;
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addLessonArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.icon="";
                this.name="";
                this.hasItem=false;
                this.selectedLessonId="";
            },
            saveItem:function () {
                if(hasItem){
                    Axios.post('/api/admin/cr/lesson/update/'+this.selectedLessonId,{
                        symbol:this.icon,
                        name: this.name,
                    }).then(response=>console.log(response));
                }else{
                    Axios.post('/api/admin/cr/lesson/create', {
                        symbol:this.icon,
                        name: this.name,
                    }).then(response=>console.log(response))
                }
                this.clearForm();
                UIkit.modal('#addLessonArea').hide();
            }
        },
        created() {

        }
    }
</script>

<style scoped>
    tbody tr{
        cursor: pointer;
    }
</style>
