<template>
    <div class="uk-margin-large-top">
        <div class="uk-flex align-items-center justify-content-between">
            <div class="text-left">
                <a class="uk-flex align-item-center">
                    <i class="fas fa-arrow-alt-circle-left icon-medium uk-margin-small-right"></i>
                    <h6 class="uk-margin-remove">{{backText}}</h6>
                </a>
            </div>
            <div class="text-right">
                <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addSubCategoryText}} </button>
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
                <tr @click="routeCategory">
                    <td><p>a</p></td>
                    <td><p>Tiger Nixon</p></td>
                    <td><p>System Architect</p></td>
                    <td><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings()" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
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
                        <a @click="openSettings()" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
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
        <div id="addSubCategoryArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addSubCategoryText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editSubCategoryText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div>{{categoryText}}</div>
                    <select class="uk-width uk-select" v-model="categoryId">
                        <option selected hidden disabled value="">{{selectCategoryText}}</option>
                    </select>
                    <div class="uk-form-label">{{subCategoryNameText}}</div>
                    <input class="uk-width uk-input" v-model="name" :placeholder="subCategoryNameText">
                    <img>
                    <input>
                    <div class="uk-form-label">{{iconText}}</div>
                    <select class="uk-width uk-select" v-model="icon">
                        <option selected hidden disabled value="">{{selectIconText}}</option>
                    </select>
                    <div class="uk-form-label">{{colorText}}</div>
                    <select class="uk-width uk-select" v-model="color">
                        <option selected hidden disabled value="">{{selectColorText}}</option>
                    </select>
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
        name: "sub-categories-page",
        data(){
            return{
                color:"",
                icon:"",
                name:"",
                categoryId:"",
                description:"",
                hasItem:false,
                selectedSubCategoryId:"",
            }
        },
        props:{
            categoryRoute:{
                type:String,
                required:true,
            },
            addSubCategoryText:{
                type:String,
                default:"Alt Kategori Ekle"
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
            categoryText:{
                type:String,
                default:"Kategori"
            },
            selectCategoryText:{
                type:String,
                default:"Kategori Seçiniz"
            },
            subCategoryName:{
                type:String,
                default:"Alt Kategori Adı"
            },
            subCategoryImg:{
                type:String,
                default:"Alt Kategori Resmi"
            },
            iconText:{
                type:String,
                default:"İkon"
            },
            selectIconText:{
                type:String,
                default:"İkon Seçiniz"
            },
            selectColorText:{
                type:String,
                default:"Renk Seçiniz"
            },
            colorText:{
                type:String,
                default:"Renk"
            },
            editSubCategoryText:{
                type:String,
                default:"Alt Kategori Düzenle"
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            cancelText:{
                type:String,
                default:"Cancel"
            }
        },
        computed:{
            ...mapState([
                'adminSelectedId',
                'adminSubCategory'
            ]),
        },
        methods:{
            ...mapActions([
                'loadAdminSubCategory'
            ]),
            routeCategory:function () {
                window.location.replace(this.subCategoryRoute);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/ge/subCategory/setPassive/'+id).then(response=>console.log(response))
            },
            activateItem:function (id) {
                Axios.post('/api/admin/ge/subCategory/setActive/'+id).then(response=>console.log(response))
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/ge/subCategory/delete/'+id).then(response=>console.log(response))
            },
            openSettings:function (id) {
                this.selectedSubCategoryId=id;
                Axios.get('/api/admin/ge/subCategory/show/'+id).then(response=>this.setSelected(response.data));
            },
            openForm:function () {
                UIkit.modal('#addSubCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                console.log(selectedData);
                this.description=selectedData.description;
                this.color=selectedData.color;
                this.name=selectedData.name;
                this.icon=selectedData.symbol;
                this.categoryId=selectedData.categoryId;
                this.hasItem=true;
                UIkit.modal('#addSubCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.hasItem=false;
                this.description="";
                this.color="";
                this.name="";
                this.icon="";
                this.categoryId="";
                this.selectedSubCategoryId="";
            },
            saveItem:function () {
                var formData=new FormData();
                formData.append('name', this.name);
                formData.append('categoryId', this.categoryId);
                formData.append('symbol', this.icon);
                formData.append('color', this.color);
                formData.append('description', this.description);

                if(hasItem){
                    Axios.post('/api/admin/ge/subCategory/update/'+this.selectedSubCategoryId, formData)
                        .then(this.$store.dispatch('loadAdminSubCategory', this.adminSelectedId));
                }else{
                    Axios.post('/api/admin/ge/subCategory/create', formData)
                        .then(this.$store.dispatch('loadAdminSubCategory', this.adminSelectedId));
                }
                this.clearForm();
                UIkit.modal('#addSubCategoryArea').hide();
            }
        },
        created() {
            this.$store.dispatch('loadAdminSubCategory', this.adminSelectedId)
        }
    }
</script>

<style scoped>
    textarea{
        resize:none
    }
</style>
