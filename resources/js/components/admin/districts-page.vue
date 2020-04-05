<template>
    <div class="uk-margin-large-top">
        <div class="uk-flex align-items-center justify-content-between">
            <div class="text-left">
                <a  @click="routeCities" class="uk-flex align-item-center">
                    <i class="fas fa-arrow-alt-circle-left icon-medium uk-margin-small-right"></i>
                    <h6 class="uk-margin-remove">{{backText}}</h6>
                </a>
            </div>
            <div class="text-right">
                <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addDistrictText}} </button>
            </div>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>{{districtNameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                    <tr v-for="item in adminDistrict.data">
                        <td class="uk-width-3-4"><p>{{item.name}}</p></td>
                        <td class="uk-flex flex-wrap align-items-center justify-content-around">
                            <a @click="openSettings(item.id)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                            <a v-if="!item.active" @click="activateItem(item.id)" :uk-tooltip="activateText"><i class="fas fa-check-circle"></i></a>
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
        <ul class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminDistrict.current_page>1" @click="loadNewPage(adminDistrict.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminDistrict.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/bs/city/'+selectedCityId+'/districts?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/bs/city/'+selectedCityId+'/districts?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminDistrict.current_page<adminDistrict.last_page" @click="loadNewPage(adminDistrict.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addDistrictArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addDistrictText}}</h2>
                    <h2 v-else class="uk-modal-title">{{addDistrictText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-margin-bottom">
                            <div class="uk-form-label">{{districtNameText}}</div>
                            <input v-model="name" class="uk-width uk-input" :placeholder="districtNameText">
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
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "districts-page",
        data(){
          return{
              name:"",
              hasItem:false,
              selectedDistrictId:"",
              selectedDistrict:{
                  name:"",
                  cityId:"",
              },
              selectedPage:'/api/admin/bs/city/'+this.selectedCityId+'/districts?page=1'
          }
        },
        props:{
            citiesRoute:{
                type:String,
                required:true,
            },
            selectedCityId:{
                type:String,
                required:true,
            },
            addDistrictText:{
                type:String,
                default:"İlçe Ekle"
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
            selectCityText:{
                type:String,
                default:"İl Seçiniz"
            },
            cityText:{
                type:String,
                default:"İl"
            },
            districtNameText:{
                type:String,
                default:"İlçe Adı",
            },
            districtCodeText:{
                type:String,
                default:"İlçe Kodu"
            },
            saveText:{
                type:String,
                default:"Kaydet",
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            },
        },
        computed:{
            ...mapState([
                'adminDistrict'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminDistrict.last_page; i++){
                    if(i==2 && this.adminDistrict.current_page-2>3){
                        pages.push('...');
                        if(this.adminDistrict.current_page+3>this.adminDistrict.last_page){
                            index=this.adminDistrict.last_page-6;
                        }else{
                            index=this.adminDistrict.current_page-2;
                        }
                    }else if(i==8 && this.adminDistrict.current_page+2<this.adminDistrict.last_page-2){
                        pages.push('...');
                        index=this.adminDistrict.last_page;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
        },
        methods:{
            ...mapActions([
                'loadAdminDistrict',
                'loadAdminNewPage'
            ]),
            routeCities:function () {
                window.location.replace(this.citiesRoute);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/bs/district/setPassive/'+id).then( this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminDistrict']));
            },
            activateItem:function (id) {
                Axios.post('/api/admin/bs/district/setActive/'+id).then( this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminDistrict']));
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/bs/district/delete/'+id).then( this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminDistrict']));
            },
            openSettings:function (id) {
                this.selectedDistrictId=id;
                Axios.get('/api/admin/bs/district/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addDistrictArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.hasItem=false;
                this.selectedDistrictId="";
            },
            setSelected:function(selectedData){
                console.log(selectedData);
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addDistrictArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/bs/district/update/'+this.selectedDistrictId, {
                        name: this.name,
                        cityId: this.selectedCityId,
                    }).then( this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminDistrict']));
                }else{
                    Axios.post('/api/admin/bs/district/create', {
                        name: this.name,
                        cityId: this.selectedCityId,
                    }).then( this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminDistrict']));
                }
                this.clearForm();
                UIkit.modal('#addDistrictArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminDistrict']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminDistrict', this.selectedCityId);
        }
    }
</script>

<style scoped>

</style>
