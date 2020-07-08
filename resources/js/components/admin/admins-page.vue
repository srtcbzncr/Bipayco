<template>
    <div class="uk-margin-medium-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addAdminText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                    <div class="loader"></div>
                </div>
                <thead v-else-if="adminAdmins.data&&adminAdmins.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminAdmins.data&&adminAdmins.data.length>0">
                <tr v-for="(item,index) in adminAdmins.data">
                    <td @click="openInfo(index)" class="uk-width-3-4 clickable"><p>{{item.user.first_name}} {{item.user.last_name}}</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
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
        <ul v-if="adminAdmins.data&&adminAdmins.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
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
                        <div class="uk-form-label">{{emailText}}</div>
                        <input v-model="email" class="uk-width uk-input" :placeholder="emailText">
                    </div>
                </div>

                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" @click="clearForm" type="button">{{cancelText}}</button>
                    <button class="uk-button uk-button-primary" type="button" @click="saveItem">{{saveText}}</button>
                </div>
            </div>
        </div>
        <div id="adminInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{adminInfoText}}</h2>
                </div>
                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-flex align-items-center justify-content-center uk-margin-small-bottom">
                        <img :src="selectedUser.user.avatar" class="uk-height-small uk-width-small uk-border-circle">
                    </div>
                    <div class="uk-form-label">{{nameText}}</div>
                    <h6>{{selectedUser.user.first_name}} {{selectedUser.user.last_name}}</h6>
                    <hr>
                    <div class="uk-form-label">{{usernameText}}</div>
                    <h6>{{selectedUser.user.username}}</h6>
                    <hr>
                    <div class="uk-form-label">{{emailText}}</div>
                    <h6>{{selectedUser.user.email}}</h6>
                    <hr>
                    <div class="uk-form-label">{{phoneText}}</div>
                    <h6>{{selectedUser.user.phone_number}}</h6>
                    <hr>
                    <div class="uk-form-label">{{referenceCodeText}}</div>
                    <h6>{{selectedUser.reference_code}}</h6>
                </div>
                <div class="uk-modal-footer">
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
                selectedIndex:-1,
                selectedPage:"/api/admin/auth/admin/show?page=1"
            }
        },
        props:{
            addAdminText:{
                type:String,
                default:"Yönetici Ekle"
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
            nameText:{
                type:String,
                default:"Adı"
            },
            emailText:{
                type:String,
                default:"Eposta"
            },
            adminInfoText:{
                type:String,
                default:"Yönetici Bilgisi"
            },
            referenceCodeText:{
                type:String,
                default:"Referans Kodu"
            },
            phoneText:{
                type:String,
                default:"Telefon"
            },
            usernameText:{
                type:String,
                default:"Kullanıcı Adı"
            }
        },
        computed:{
            ...mapState([
                'adminAdmins',
                'loadingStatus'
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
            selectedUser(){
                if(this.selectedIndex>=0){
                    return this.adminAdmins.data[this.selectedIndex];
                }else{
                    return { user:{}}
                }
            }
        },
        methods:{
            ...mapActions([
                'loadAdminAdmins',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/auth/admin/passive/'+id)
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
                Axios.post('/api/admin/auth/admin/active/'+id)
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
            openForm:function () {
                UIkit.modal('#addAdminArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            openInfo:function (index) {
                this.selectedIndex=index;
                UIkit.modal('#adminInfoArea').show();
            },
            clearForm:function () {
                this.email="";
            },
            saveItem:function () {
                Axios.post('/api/admin/auth/admin/create', {
                    email: this.email,
                    authorityId:1,
                    active:1
                }).then(response=>{
                    if(response.data.error){
                        UIkit.notification({message:response.data.message, status: 'danger'});
                    }else{
                        UIkit.notification({message:response.data.message, status: 'success'});
                        this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminAdmins'])
                    }
                });
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
h6{
    margin:0
}
.clickable{
    cursor: pointer;
}
</style>
