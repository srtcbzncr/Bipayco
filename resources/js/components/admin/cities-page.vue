<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addCityText}} </button>
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
                    <td @click="routeDistricts"><p>a</p></td>
                    <td @click="routeDistricts"><p>Tiger Nixon</p></td>
                    <td @click="routeDistricts"><p>System Architect</p></td>
                    <td @click="routeDistricts"><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings(1)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
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
        <div id="addCityArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addCityText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editCityText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-margin-bottom">
                            <input hidden disabled value="1" id="countryId">
                            <div class="uk-form-label">{{cityName}}</div>
                            <input class="uk-input uk-width" v-model="name" :placeholder="cityName">
                            <div class="uk-form-label">{{cityCode}}</div>
                            <input class="uk-input uk-width" v-model="code" :placeholder="cityCode">
                        </div>
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
        name: "cities-page",
        data(){
            return{
                name:"",
                code:"",
                hasItem:false,
            }
        },
        props:{
            districtsRoute:{
                type:String,
                required:true,
            },
            addCityText:{
                type:String,
                default:"Şehir Ekle"
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
            cityName:{
                type:String,
                default:"Şehir Adı"
            },
            cityCode:{
                type:String,
                default:"Şehir Kodu"
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            },
            editCityText:{
                type:String,
                default:"Şehir Düzenle"
            }
        },
        methods:{
            routeDistricts:function () {
                window.location.replace(this.districtsRoute);
            },
            deactivateItem:function () {

            },
            activateItem:function () {

            },
            deleteItem:function () {

            },
            openSettings:function (id) {
                this.hasItem=true;
                this.code=id+". şehirin Kodu var burda";
                this.name=id+". şehrin adı var burda";

                UIkit.modal('#addCityArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            openForm:function () {
                this.hasItem=false;
                UIkit.modal('#addCityArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.code="";
            },
            saveItem:function () {
                this.clearForm();
                UIkit.modal('#addCityArea').hide();
            }
        }
    }
</script>

<style scoped>
    tbody tr{
        cursor: pointer;
    }
</style>
