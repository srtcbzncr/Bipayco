<template>
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminGuardian.data&&adminGuardian.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminGuardian.data&&adminGuardian.data.length>0">
                <tr v-for="(item,index) in adminGuardian.data">
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
        <ul v-if="adminGuardian.data&&adminGuardian.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminGuardian.current_page>1" @click="loadNewPage(adminGuardian.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminGuardian.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/auth/guardian/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/auth/guardian/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminGuardian.current_page<adminGuardian.last_page" @click="loadNewPage(adminGuardian.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="guardianInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{guardianInfoText}}</h2>
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
        name: "guardians-page",
        data(){
            return{
                selectedIndex:-1,
                selectedPage:"/api/admin/auth/guardian/show?page=1"
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
            guardianInfoText:{
                type:String,
                default:"Veli Bilgisi"
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
                'adminGuardian',
                'loadingStatus'
            ]),
            selectedUser(){
                if(this.selectedIndex>=0){
                    return this.adminGuardian.data[this.selectedIndex];
                }else{
                    return { user:{}}
                }
            },
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminGuardian.last_page; i++){
                    if(i==2 && this.adminGuardian.current_page-2>3){
                        pages.push('...');
                        if(this.adminGuardian.current_page+3>this.adminGuardian.last_page){
                            index=this.adminGuardian.last_page-6;
                        }else{
                            index=this.adminGuardian.current_page-2;
                        }
                    }else if(i==8 && this.adminGuardian.current_page+2<this.adminGuardian.last_page-2){
                        pages.push('...');
                        index=this.adminGuardian.last_page;
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
                'loadAdminGuardian',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/auth/guardian/passive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGuardian'])
                        }
                    });
            },
            openInfo:function (index) {
                this.selectedIndex=index;
                UIkit.modal('#guardianInfoArea').show();
            },
            activateItem:function (id) {
                Axios.post('/api/admin/auth/guardian/active/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGuardian'])
                        }
                    });
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/auth/guardian/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGuardian'])
                        }
                    });
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminGuardian']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminGuardian');
        }
    }
</script>

<style scoped>
h6{
    margin:0;
}
.clickable{
    cursor: pointer;
}
</style>
