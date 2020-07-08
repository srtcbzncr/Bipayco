<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addLessonText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminLesson.data&&adminLesson.data.length>0">
                <tr>
                    <th>{{lessonNameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminLesson.data&&adminLesson.data.length>0">
                <tr v-for="item in adminLesson.data">
                    <td @click="routeSubjects(item.id)" class="uk-width-3-4"><p>{{item.name}}</p></td>
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
        <ul v-if="adminLesson.data&&adminLesson.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminLesson.current_page>1" @click="loadNewPage(adminLesson.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminLesson.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/cr/lesson/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/cr/lesson/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminLesson.current_page<adminLesson.last_page" @click="loadNewPage(adminLesson.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addLessonArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addLessonText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editLessonText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-form-label">{{iconText}}</div>
                        <div class="uk-flex align-items-center justify-content-between">
                            <input class="uk-input uk-width-5-6 " placeholder="fa-user" v-model="icon">
                            <i v-if="icon==''" class="fas icon-medium uk-width-1-6 text-center fa-user" ></i>
                            <i v-else class="fas icon-medium uk-width-1-6 text-center" :class="icon"></i>
                        </div>
                        <div class="uk-form-label">{{lessonNameText}}</div>
                        <input class="uk-width uk-input" v-model="name" :placeholder="lessonNameText">
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
        name: "lessons-page",
        data(){
            return{
                name:"",
                icon:"",
                hasItem:false,
                selectedLessonId:"",
                selectedPage:"/api/admin/cr/lesson/show?page=1"
            }
        },
        props:{
            addLessonText:{
                type:String,
                default:"Ders Ekle"
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
            editLessonText:{
                type:String,
                default:"Ders Düzenle"
            },
            lessonNameText:{
                type:String,
                default:"Ders Adı"
            },
            iconText:{
                type:String,
                default:"İkon"
            },
            selectIconText:{
                type:String,
                default:"İkon Seçiniz"
            },
        },
        computed:{
            ...mapState([
                'adminLesson',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminLesson.last_page; i++){
                    if(i==2 && this.adminLesson.current_page-2>3){
                        pages.push('...');
                        if(this.adminLesson.current_page+3>this.adminLesson.last_page){
                            index=this.adminLesson.last_page-6;
                        }else{
                            index=this.adminLesson.current_page-2;
                        }
                    }else if(i==8 && this.adminLesson.current_page+2<this.adminLesson.last_page-2){
                        pages.push('...');
                        index=this.adminLesson.last_page;
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
                'loadAdminLesson',
                'loadAdminNewPage'
            ]),
            routeSubjects:function (id) {
                window.location.replace('/admin/lesson/'+id+'/subjects');
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/cr/lesson/setPassive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminLesson'])
                        }
                    });
            },
            activateItem:function (id) {
                Axios.post('/api/admin/cr/lesson/setActive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminLesson'])
                        }
                    });
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/cr/lesson/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminLesson'])
                        }
                    });
            },
            openSettings:function (id) {
                this.selectedLessonId=id;
                Axios.get('/api/admin/cr/lesson/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addLessonArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.icon=selectedData.symbol;
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addLessonArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.icon="";
                this.name="";
                this.hasItem=false;
                this.selectedLessonId="";
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/cr/lesson/update/'+this.selectedLessonId,{
                        symbol:this.icon,
                        name: this.name,
                    }).then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminLesson'])
                        }
                    });
                }else{
                    Axios.post('/api/admin/cr/lesson/create', {
                        symbol:this.icon,
                        name: this.name,
                    }).then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminLesson'])
                        }
                    });
                }
                this.clearForm();
                UIkit.modal('#addLessonArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminLesson']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminLesson')
        }
    }
</script>

<style scoped>
    tbody tr{
        cursor: pointer;
    }
</style>
