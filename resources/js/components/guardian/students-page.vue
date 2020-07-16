<template>
    <div class="uk-margin-medium-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addStudentText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="guardianStudents.data&&guardianStudents.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="guardianStudents.data&&guardianStudents.data.length>0">
                <tr v-for="(item,index) in guardianStudents.data">
                    <td v-if="item.active" @click="openInfo(index)" class="uk-width-3-4 clickable"><p>{{item.user.first_name}} {{item.user.last_name}}</p></td>
                    <td v-else class="uk-width-3-4 clickable"><p>{{item.user.first_name}} {{item.user.last_name}} ({{waitingConfirmText}})</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
                        <a @click="deleteItem(item.user.id)" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{haveNoStudentText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="guardianStudents.data&&guardianStudents.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="guardianStudents.current_page>1" @click="loadNewPage(guardianStudents.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==guardianStudents.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/guardian/getStudents/'+this.userId+'?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/guardian/getStudents/'+this.userId+'?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="guardianStudents.current_page<guardianStudents.last_page" @click="loadNewPage(guardianStudents.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addStudentArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{addStudentText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{referenceCodeText}}</div>
                        <input v-model="referenceCode" class="uk-width uk-input" :placeholder="referenceCodeText">
                    </div>
                </div>

                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" @click="clearForm" type="button">{{cancelText}}</button>
                    <button class="uk-button uk-button-primary" type="button" @click="saveItem">{{saveText}}</button>
                </div>
            </div>
        </div>
        <div id="studentInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{studentInfoText}}</h2>
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
<!--                    <hr>-->
<!--                    <div class="uk-form-label">{{referenceCodeText}}</div>-->
<!--                    <h6>{{selectedUser.reference_code}}</h6>-->
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
        name: "students-page",
        data(){
            return{
                referenceCode:"",
                selectedIndex:-1,
                selectedPage:"/api/guardian/getStudents/"+this.userId+"?page=1"
            }
        },
        props:{
            userId:{
                type:String,
                required:true,
            },
            addStudentText:{
                type:String,
                default:"Öğrenci Ekle"
            },
            haveNoStudentText:{
                type:String,
                default:"Öğrenci Bulunmuyor"
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
            studentInfoText:{
                type:String,
                default:"Öğrenci Bilgisi"
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
            waitingConfirmText:{
                type:String,
                default:"Onay Bekliyor"
            }
        },
        computed:{
            ...mapState([
                'guardianStudents',
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.guardianStudents.last_page; i++){
                    if(i==2 && this.guardianStudents.current_page-2>3){
                        pages.push('...');
                        if(this.guardianStudents.current_page+3>this.guardianStudents.last_page){
                            index=this.guardianStudents.last_page-6;
                        }else{
                            index=this.guardianStudents.current_page-2;
                        }
                    }else if(i==8 && this.guardianStudents.current_page+2<this.guardianStudents.last_page-2){
                        pages.push('...');
                        index=this.guardianStudents.last_page;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
            selectedUser(){
                if(this.selectedIndex>=0){
                    return this.guardianStudents.data[this.selectedIndex];
                }else{
                    return { user:{}}
                }
            }
        },
        methods:{
            ...mapActions([
                'loadGuardianStudents',
                'loadGuardianNewPage'
            ]),
            deleteItem:function (id) {
                Axios.post('/api/guardian/deleteStudent/'+this.userId+'/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadGuardianNewPage', this.selectedPage)
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
            openForm:function () {
                UIkit.modal('#addStudentArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            openInfo:function (index) {
                this.selectedIndex=index;
                UIkit.modal('#studentInfoArea').show();
            },
            clearForm:function () {
                this.referenceCode="";
            },
            saveItem:function () {
                Axios.post('/api/guardian/addStudent', {
                    referenceCode: this.referenceCode,
                    guardianUserId:this.userId,
                }).then(response=>{
                    if(response.data.error){
                        UIkit.notification({message:response.data.message, status: 'danger'});
                    }else{
                        UIkit.notification({message:response.data.message, status: 'success'});
                        this.$store.dispatch('loadGuardianNewPage',this.selectedPage)
                    }
                }).catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
                this.clearForm();
                UIkit.modal('#addStudentArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadGuardianNewPage',name);
            }
        },
        created() {
            this.$store.dispatch('loadGuardianStudents', this.userId);
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
