<template>
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>{{nameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr v-for="(item, index) in adminInstructor.data">
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
        <ul class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminInstructor.current_page>1" @click="loadNewPage(adminInstructor.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminInstructor.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/auth/instructor/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/auth/instructor/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminInstructor.current_page<adminInstructor.last_page" @click="loadNewPage(adminInstructor.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="instructorInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{instructorInfoText}}</h2>
                </div>
                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-flex align-items-center justify-content-center uk-margin-small-bottom">
                        <img :src="selectedUser.user.avatar" class="uk-height-small uk-width-small uk-border-circle">
                    </div>
                    <div class="uk-form-label">{{nameText}}</div>
                    <h6>{{selectedUser.user.first_name}} {{selectedUser.user.last_name}}</h6>
                    <hr>
                    <div class="uk-form-label">{{titleText}}</div>
                    <h6>{{selectedUser.title}}</h6>
                    <hr>
                    <div class="uk-form-label">{{emailText}}</div>
                    <h6>{{selectedUser.user.email}}</h6>
                    <hr>
                    <div class="uk-form-label">{{phoneText}}</div>
                    <h6>{{selectedUser.user.phone_number}}</h6>
                    <hr>
                    <div class="uk-form-label">{{ibanText}}</div>
                    <h6>{{selectedUser.iban}}</h6>
                    <hr>
                    <div class="uk-form-label">{{idNumText}}</div>
                    <h6>{{selectedUser.identification_number}}</h6>
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
                selectedPage:"/api/admin/auth/instructor/show?page=1"
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
            instructorInfoText:{
                type:String,
                default:"Eğitmen Bilgisi"
            },
            referenceCodeText:{
                type:String,
                default:"Referans Kodu"
            },
            phoneText:{
                type:String,
                default:"Telefon"
            },
            titleText:{
                type:String,
                default:"Ünvan"
            },
            idNumText:{
                type:String,
                default:"Kimlik Numarası"
            },
            ibanText:{
                type:String,
                default:"IBAN"
            }
        },
        computed:{
            ...mapState([
                'adminInstructor',
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminInstructor.last_page; i++){
                    if(i==2 && this.adminInstructor.current_page-2>3){
                        pages.push('...');
                        if(this.adminInstructor.current_page+3>this.adminInstructor.last_page){
                            index=this.adminInstructor.last_page-6;
                        }else{
                            index=this.adminInstructor.current_page-2;
                        }
                    }else if(i==8 && this.adminInstructor.current_page+2<this.adminInstructor.last_page-2){
                        pages.push('...');
                        index=this.adminInstructor.last_page;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
            selectedUser(){
                if(this.selectedIndex>=0){
                    return this.adminInstructor.data[this.selectedIndex];
                }else{
                    return { user:{}}
                }
            }
        },
        methods:{
            ...mapActions([
                'loadAdminInstructor',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/auth/instructor/passive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminInstructor'])
                        }
                    });
            },
            activateItem:function (id) {
                Axios.post('/api/admin/auth/instructor/active/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminInstructor'])
                        }
                    });
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/auth/instructor/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminInstructor'])
                        }
                    });
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminInstructor']);
            },
            openInfo:function (index) {
                this.selectedIndex=index;
                UIkit.modal('#instructorInfoArea').show();
            },
        },
        created() {
            this.$store.dispatch('loadAdminInstructor');
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
