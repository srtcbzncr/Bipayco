<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addCityText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>{{cityNameText}}</th>
                    <th>{{cityCodeText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr v-for="city in cities">
                    <td @click="routeDistricts"><p>a</p></td>
                    <td @click="routeDistricts"><p>Tiger Nixon</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings(city.id)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                        <a v-if="city.active" @click="activateItem(city.id)" :uk-tooltip="activateText"><i class="fas fa-check-circle"></i></a>
                        <a v-else @click="deactivateItem(city.id)" :uk-tooltip="deactivateText"><i class="fas fa-times-circle"></i></a>
                        <a @click="deleteItem(city.id)" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
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
                            <div class="uk-form-label">{{cityNameText}}</div>
                            <input class="uk-input uk-width" v-model="name" :placeholder="cityNameText">
                            <div class="uk-form-label">{{cityCodeText}}</div>
                            <input class="uk-input uk-width" v-model="code" :placeholder="cityCodeText">
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
    import Axios from 'axios';
    export default {
        name: "cities-page",
        data(){
            return{
                name:"",
                code:"",
                hasItem:false,
                selectedCityId:"",
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
            cityNameText:{
                type:String,
                default:"Şehir Adı"
            },
            cityCodeText:{
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
            deactivateItem:function (id) {
                Axios.post('/api/admin/bs/city/setPassive/'+id).then(response=>console.log(response));
            },
            activateItem:function (id) {
                Axios.post('/api/admin/bs/city/setActive/'+id).then(response=>console.log(response));
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/bs/city/delete/'+id).then(response=>console.log(response));
            },
            openSettings:function (id) {
                this.selectedCityId=id;
                Axios.get('/api/admin/bs/city/show/'+id)
                    .then(response=>setSelected(response.data));
            },
            openForm:function () {
                this.hasItem=false;
                UIkit.modal('#addCityArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                console.log(selectedData);
                this.name=selectedData.name;
                this.code=selectedData.code;
                this.hasItem=true;
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
                if(this.hasItem){
                    Axios.post('/api/admin/bs/city/update/'+this.selectedCityId, {
                        name: this.name,
                        code: this.code,
                    }).then(response=>console.log(response));
                }else{
                    Axios.post('/api/admin/bs/city/create', {
                        name: this.name,
                        code: this.name,
                    }).then(response=>console.log(response));
                }
                this.clearForm();
                UIkit.modal('#addCityArea').hide();

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
