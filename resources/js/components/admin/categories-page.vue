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
                    <tr>
                        <td @click="routeSubCategories"><p>a</p></td>
                        <td @click="routeSubCategories"><p>Tiger Nixon</p></td>
                        <td @click="routeSubCategories"><p>System Architect</p></td>
                        <td @click="routeSubCategories"><p>Edinburgh</p></td>
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
        <div id="addCategoryArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addCategoryText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editCategoryText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <input>
                    <input>
                    <input>
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
        name: "categories-page",
        data(){
            return{
                name:"",
                icon:"",
                image:"",
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
            }
        },
        methods:{
            routeSubCategories:function () {
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
                this.hasItem=true;
                UIkit.modal('#addCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            openForm:function () {
                UIkit.modal('#addCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.icon="";
                this.image="";
                this.color="";
                this.hasItem=false;
                this.selectedCategoryId="";
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/ge/update/'+this.selectedCategoryId, {

                    }).then(response=>console.log(response));
                }else{
                    Axios.post('/api/admin/ge/create', {

                    }).then(response=>console.log(response));
                }
                this.clearForm();
                UIkit.modal('#addCategoryArea').hide();
            }
        }
    }
</script>

<style scoped>
    tbody tr{
        cursor: pointer;
    }
</style>
