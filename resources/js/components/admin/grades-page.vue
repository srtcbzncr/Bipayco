<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addGradeText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr>
                    <td class="uk-width-1-3"><p>a</p></td>
                    <td class="uk-width-1-3"><p>Tiger Nixon</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
                        <a @click="openSettings(2)" :uk-tooltip="editText" ><i class="fas fa-cog"></i></a>
                        <a @click="deactivateItem()" :uk-tooltip="deactivateText"><i class="fas fa-times-circle"></i></a>
                        <a @click="deleteItem()" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                <tr>
                    <td><p>s</p></td>
                    <td><p>Tiger Nixon</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
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
        <div id="addGradeArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addGradeText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editGradeText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{iconText}}</div>
                        <select v-model="icon" class="uk-width uk-select">
                            <option value="" hidden disabled selected>{{selectIconText}}</option>
                            <option value="fa-user"><i class="fas fa-user icon-tiny"></i> user </option>
                            <option value="fa-chalkboard-teacher"><i class="fas fa-chalkboard-teacher icon-tiny"></i>  chalkboard teacher</option>
                        </select>
                        <div class="uk-form-label">{{gradeNameText}}</div>
                        <input v-model="name" class="uk-width uk-input" :placeholder="gradeNameText">
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
        name: "grades-page",
        data(){
            return{
                name:"",
                icon:"",
                hasItem:false,
                selectedGradeId:"",
            }
        },
        props:{
            addGradeText:{
                type:String,
                default:"Sınıf Ekle"
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
            selectIconText:{
                type:String,
                default:"İkon Seçiniz"
            },
            iconText:{
                type:String,
                default:"İkon"
            },
            gradeNameText:{
                type:String,
                default:"Sınıf Adı"
            },
            editGradeText:{
                type:String,
                default:"Sınıf Düzenle"
            }
        },
        computed:{
            ...mapState([
                'adminGrade',
            ]),
        },
        methods:{
            ...mapActions([
                'loadAdminGrade',
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/cr/grade/setPassive/'+id).then(response=>console.log(response.data));
            },
            activateItem:function (id) {
                Axios.post('/api/admin/cr/grade/setActive/'+id).then(response=>console.log(response.data));
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/cr/grade/delete/'+id).then(response=>console.log(response.data));
            },
            openSettings:function (id) {
                this.selectedGradeId=id;
                Axios.get('/api/admin/cr/grade/show/'+id)
                    .then(response=>this.setSelected(response.data));
            },
            openForm:function () {
                UIkit.modal('#addGradeArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                console.log(selectedData);
                this.icon=selectedData.symbol;
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addGradeArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.icon="";
                this.name="";
                this.hasItem=false;
                this.selectedGradeId="";
            },
            saveItem:function () {
                if(hasItem){
                    Axios.post('/api/admin/cr/grade/update/'+this.selectedGradeId, {
                        symbol: this.icon,
                        name: this.name,
                    }).then(this.$store.dispatch('loadAdminGrade'))
                }else{
                    Axios.post('/api/admin/cr/grade/create', {
                        symbol: this.icon,
                        name: this.name,
                    }).then(this.$store.dispatch('loadAdminGrade'));
                }
                this.clearForm();
                UIkit.modal('#addGradeArea').hide();
            }
        },
        created() {
            this.$store.dispatch('loadAdminGrade');
        }
    }
</script>

<style scoped>

</style>
