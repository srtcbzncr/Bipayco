<template>
    <div class="uk-margin-medium-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addExamText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminExam.data&&adminExam.data.length>0">
                <tr>
                    <th>{{examNameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminExam.data&&adminExam.data.length>0">
                <tr v-for="item in adminExam.data">
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
        <ul v-if="adminExam.data&&adminExam.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminExam.current_page>1" @click="loadNewPage(adminExam.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminExam.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/cr/exam/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/cr/exam/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminExam.current_page<adminExam.last_page" @click="loadNewPage(adminExam.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addExamArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addExamText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editExamText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{iconText}}</div>
                        <div class="uk-flex align-items-center justify-content-between">
                            <input class="uk-input uk-width-5-6 " placeholder="fa-user" v-model="icon">
                            <i v-if="icon==''" class="fas icon-medium uk-width-1-6 text-center fa-user" ></i>
                            <i v-else class="fas icon-medium uk-width-1-6 text-center" :class="icon"></i>
                        </div>
                        <div class="uk-form-label">{{examNameText}}</div>
                        <input v-model="name" class="uk-width uk-input" :placeholder="examNameText">
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
        name: "exams-page",
        data(){
            return{
                name:"",
                icon:"",
                hasItem:false,
                selectedExamId:"",
                selectedPage:"/api/admin/cr/exam/show?page=1"
            }
        },
        props:{
            addExamText:{
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
            examNameText:{
                type:String,
                default:"Sınıf Adı"
            },
            editExamText:{
                type:String,
                default:"Sınıf Düzenle"
            }
        },
        computed:{
            ...mapState([
                'adminExam',
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminExam.last_page; i++){
                    if(i==2 && this.adminExam.current_page-2>3){
                        pages.push('...');
                        if(this.adminExam.current_page+3>this.adminExam.last_page){
                            index=this.adminExam.last_page-6;
                        }else{
                            index=this.adminExam.current_page-2;
                        }
                    }else if(i==8 && this.adminExam.current_page+2<this.adminExam.last_page-2){
                        pages.push('...');
                        index=this.adminExam.last_page;
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
                'loadAdminExam',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/cr/exam/setPassive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminExam'])
                        }
                    });
            },
            activateItem:function (id) {
                Axios.post('/api/admin/cr/exam/setActive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminExam'])
                        }
                    });
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/cr/exam/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminExam'])
                        }
                    });
            },
            openSettings:function (id) {
                this.selectedExamId=id;
                Axios.get('/api/admin/cr/exam/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addExamArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.icon=selectedData.symbol;
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addExamArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.icon="";
                this.name="";
                this.hasItem=false;
                this.selectedExamId="";
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/cr/exam/update/'+this.selectedExamId, {
                        symbol: this.icon,
                        name: this.name,
                    }).then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminExam'])
                        }
                    });
                }else{
                    Axios.post('/api/admin/cr/exam/create', {
                        symbol: this.icon,
                        name: this.name,
                    }).then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminExam'])
                        }
                    });
                }
                this.clearForm();
                UIkit.modal('#addExamArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminExam']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminExam');
        }
    }
</script>

<style scoped>

</style>
