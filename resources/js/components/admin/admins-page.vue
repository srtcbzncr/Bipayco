<template>
    <div class="uk-margin-medium-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addAdminText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>{{nameText}}</th>
                    <th>{{surnameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr v-for="item in adminAdmins.data">
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
                <button v-show="adminAdmins.current_page>1" @click="loadNewPage(adminAdmins.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminAdmins.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/cr/admin/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/cr/admin/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminAdmins.current_page<adminAdmins.last_page" @click="loadNewPage(adminAdmins.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addAdminArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{addAdminText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{gradeNameText}}</div>
                        <input v-model="email" class="uk-width uk-input" :placeholder="gradeNameText">
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
        name: "admin-page",
        data(){
            return{
                email:"",
                hasItem:false,
                selectedAdminId:"",
                selectedPage:"/api/admin/auth/admin/show?page=1"
            }
        },
        props:{
            addAdminText:{
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
                'adminAdmins',
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminAdmins.last_page; i++){
                    if(i==2 && this.adminAdmins.current_page-2>3){
                        pages.push('...');
                        if(this.adminAdmins.current_page+3>this.adminAdmins.last_page){
                            index=this.adminAdmins.last_page-6;
                        }else{
                            index=this.adminAdmins.current_page-2;
                        }
                    }else if(i==8 && this.adminAdmins.current_page+2<this.adminAdmins.last_page-2){
                        pages.push('...');
                        index=this.adminAdmins.last_page;
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
                'loadAdminAdmins',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/auth/admin/setPassive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminAdmins'])
                        }
                    });
            },
            activateItem:function (id) {
                Axios.post('/api/admin/auth/admin/setActive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminAdmins'])
                        }
                    });
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/auth/admin/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminAdmins'])
                        }
                    });
            },
            openSettings:function (id) {
                this.selectedAdminId=id;
                Axios.get('/api/admin/auth/admin/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addAdminArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.icon=selectedData.symbol;
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addAdminArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.icon="";
                this.name="";
                this.hasItem=false;
                this.selectedAdminId="";
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/auth/admin/create', {
                        email: this.email,
                    }).then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminAdmins'])
                        }
                    });
                }
                this.clearForm();
                UIkit.modal('#addAdminArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminAdmins']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminAdmins');
        }
    }
</script>

<style scoped>

</style>
