<template>
    <div class="uk-margin-medium-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addGradeText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminGrade.data&&adminGrade.data.length>0">
                <tr>
                    <th>{{gradeNameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminGrade.data&&adminGrade.data.length>0">
                    <tr v-for="item in adminGrade.data">
                        <td class="uk-width-3-4"><p>{{item.name}}</p></td>
                        <td class="uk-flex flex-wrap align-items-center justify-content-around">
                            <a @click="openSettings(item.id)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                            <a @click="deleteItem(item.id)" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                        </td>
                    </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="adminGrade.data&&adminGrade.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminGrade.current_page>1" @click="loadNewPage(adminGrade.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminGrade.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/cr/grade/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/cr/grade/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminGrade.current_page<adminGrade.last_page" @click="loadNewPage(adminGrade.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addGradeArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addGradeText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editGradeText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{iconText}}</div>
                        <div class="uk-flex align-items-center justify-content-between">
                            <input class="uk-input uk-width-5-6 " placeholder="fa-user" v-model="icon">
                            <i v-if="icon==''" class="fas icon-medium uk-width-1-6 text-center fa-user" ></i>
                            <i v-else class="fas icon-medium uk-width-1-6 text-center" :class="icon"></i>
                        </div>
                        <div class="uk-form-label">{{gradeNameText}}</div>
                        <input v-model="name" class="uk-width uk-input" :placeholder="gradeNameText">
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
        name: "grades-page",
        data(){
            return{
                name:"",
                icon:"",
                hasItem:false,
                selectedGradeId:"",
                selectedPage:"/api/admin/cr/grade/show?page=1"
            }
        },
        props:{
            addGradeText:{
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
                'adminGrade',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminGrade.last_page; i++){
                    if(i==2 && this.adminGrade.current_page-2>3){
                        pages.push('...');
                        if(this.adminGrade.current_page+3>this.adminGrade.last_page){
                            index=this.adminGrade.last_page-6;
                        }else{
                            index=this.adminGrade.current_page-2;
                        }
                    }else if(i==8 && this.adminGrade.current_page+2<this.adminGrade.last_page-2){
                        pages.push('...');
                        index=this.adminGrade.last_page;
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
                'loadAdminGrade',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/cr/grade/setPassive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGrade'])
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
                Axios.post('/api/admin/cr/grade/setActive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGrade'])
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
                Axios.post('/api/admin/cr/grade/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGrade'])
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
            openSettings:function (id) {
                this.selectedGradeId=id;
                Axios.get('/api/admin/cr/grade/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addGradeArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.icon=selectedData.symbol;
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addGradeArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.icon="";
                this.name="";
                this.hasItem=false;
                this.selectedGradeId="";
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/cr/grade/update/'+this.selectedGradeId, {
                        symbol: this.icon,
                        name: this.name,
                    }).then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGrade'])
                        }
                    }).catch((error)=>{
                        if(error.response) {
                            if(error.response.errorMessage){
                                UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                            }else{
                                UIkit.notification({message: error.response.data.message, status: 'danger'});
                            }
                        }});
                }else{
                    Axios.post('/api/admin/cr/grade/create', {
                        symbol: this.icon,
                        name: this.name,
                    }).then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminGrade'])
                        }
                    }).catch((error)=>{
                        if(error.response) {
                            if(error.response.errorMessage){
                                UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                            }else{
                                UIkit.notification({message: error.response.data.message, status: 'danger'});
                            }
                        }});
                }
                this.clearForm();
                UIkit.modal('#addGradeArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminGrade']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminGrade');
        }
    }
</script>

<style scoped>

</style>
