<template>
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminUsers.data&&adminUsers.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminUsers.data&&adminUsers.data.length>0">
                <tr v-for="(item, index) in adminUsers.data">
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
        <ul v-if="adminUsers.data&&adminUsers.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminUsers.current_page>1" @click="loadNewPage(adminUsers.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminUsers.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/auth/student/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/auth/student/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminUsers.current_page<adminUsers.last_page" @click="loadNewPage(adminUsers.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="userInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{userInfoText}}</h2>
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
                    <hr>
                    <div class="uk-form-label">{{totalSpendText}}</div>
                    <h6>{{Number(selectedUser.user.totalSpend).toFixed(2)}}</h6>
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
        name: "users-page",
        data(){
            return{
                selectedIndex:-1,
                selectedPage:"/api/admin/auth/student/show?page=1"
            }
        },
        props:{
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
            nameText:{
                type:String,
                default:"Adı"
            },
            emailText:{
                type:String,
                default:"Eposta"
            },
            userInfoText:{
                type:String,
                default:"Kullanıcı Bilgisi"
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
            },
            totalSpendText:{
                type:String,
                default:"Toplam Harcama"
            }
        },
        computed:{
            ...mapState([
                'adminUsers',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminUsers.last_page; i++){
                    if(i==2 && this.adminUsers.current_page-2>3){
                        pages.push('...');
                        if(this.adminUsers.current_page+3>this.adminUsers.last_page){
                            index=this.adminUsers.last_page-6;
                        }else{
                            index=this.adminUsers.current_page-2;
                        }
                    }else if(i==8 && this.adminUsers.current_page+2<this.adminUsers.last_page-2){
                        pages.push('...');
                        index=this.adminUsers.last_page;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
            selectedUser(){
                if(this.selectedIndex>=0){
                    return this.adminUsers.data[this.selectedIndex];
                }else{
                    return { user:{}}
                }
            }
        },
        methods:{
            ...mapActions([
                'loadAdminUsers',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/auth/student/passive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminUsers'])
                        }
                    }).catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
            },
            activateItem:function (id) {
                Axios.post('/api/admin/auth/student/active/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminUsers'])
                        }
                    }).catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/auth/student/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminUsers'])
                        }
                    }).catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminUsers']);
            },
            openInfo:function (index) {
                this.selectedIndex=index;
                UIkit.modal('#userInfoArea').show();
            },
        },
        created() {
            this.$store.dispatch('loadAdminUsers');
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
