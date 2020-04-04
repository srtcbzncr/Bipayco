<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addCategoryText}} </button>
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
                <tr v-for="item in adminCategory">
                    <td @click="routeSubCategories(item.id)"><p>{{item.name}}</p></td>
                    <td @click="routeSubCategories(item.id)"><p>{{item.description}}</p></td>
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
        <div id="addCategoryArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addCategoryText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editCategoryText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-form-label">{{categoryNameText}}</div>
                    <input class="uk-width uk-input" v-model="name" :placeholder="categoryNameText">
                    <img>
                    <input>
                    <textarea class="uk-width uk-textarea" v-model="description"></textarea>
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
        name: "categories-page",
        data(){
            return{
                name:"",
                icon:"",
                description:"",
                color:"",
                hasItem:false,
                selectedCategoryId:"",
            }
        },
        props:{
            subCategoriesRoute:{
                type:String,
                required:true,
            },
            addCategoryText:{
                type:String,
                default:"Kategori Ekle"
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
            editCategoryText:{
                type:String,
                default:"Kategori Düzenle"
            },
            selectColorText:{
                type:String,
                default:"Renk Seçiniz"
            },
            selectIconText:{
                type:String,
                default:"İkon Seçiniz"
            },
            categoryNameText:{
                type:String,
                default:"Kategori Adı"
            },
            colorText:{
                type:String,
                default:"Renk"
            },
            iconText:{
                type:String,
                default:"İkon"
            },
            imageText:{
                type:String,
                default:"Kategori Resmi"
            },
            descriptionText:{
                type:String,
                default:"Açıklama"
            }
        },
        computed:{
            ...mapState([
                'adminCategory'
            ]),
        },
        methods:{
            ...mapActions([
                'loadAdminCategory',
                'loadAdminSelectedId'
            ]),
            routeSubCategories:function (id) {
                this.$store.dispatch('loadAdminSelectedId', id);
                window.location.replace(this.subCategoriesRoute);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/ge/category/setPassive/'+id).then(response=>console.log(response));
            },
            activateItem:function (id) {
                Axios.post('/api/admin/ge/category/setActive/'+id).then(response=>console.log(response));
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/ge/category/delete/'+id).then(response=>console.log(response));
            },
            openSettings:function (id) {
                this.selectedCategoryId=id;
                Axios.get('/api/admin/ge/category/show/'+id)
                    .then(response=>this.setSelected(response.data.data))
            },
            openForm:function () {
                UIkit.modal('#addCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                console.log(selectedData);
                this.name=selectedData.name;
                this.icon=selectedData.symbol;
                this.description=selectedData.description;
                this.color=selectedData.color;
                this.hasItem=true;
                UIkit.modal('#addCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.icon="";
                this.description="";
                this.color="";
                this.hasItem=false;
                this.selectedCategoryId="";
            },
            saveItem:function () {
                var formData = new FormData();
                formData.append('name', this.name);
                formData.append('description', this.description);
                formData.append('symbol', this.icon);
                formData.append('color', this.color);
                if(this.hasItem){
                    Axios.post('/api/admin/ge/category/update/'+this.selectedCategoryId, formData)
                        .then(this.$store.dispatch('loadAdminCategory'));
                }else{
                    Axios.post('/api/admin/ge/category/create', formData)
                        .then(this.$store.dispatch('loadAdminCategory'));
                }
                this.clearForm();
                UIkit.modal('#addCategoryArea').hide();
            }
        },
        created() {
            this.$store.dispatch('loadAdminCategory');
        }
    }
</script>

<style scoped>
    tbody tr{
        cursor: pointer;
    }
    textarea{
        resize:none;
    }
</style>
