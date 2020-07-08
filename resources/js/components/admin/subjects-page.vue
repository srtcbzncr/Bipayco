<template>
    <div class="uk-margin-large-top">
        <div class="uk-flex align-items-center justify-content-between">
            <div class="text-left">
                <a @click="routeLessons" class="uk-flex align-item-center">
                    <i class="fas fa-arrow-alt-circle-left icon-medium uk-margin-small-right"></i>
                    <h6 class="uk-margin-remove">{{backText}}</h6>
                </a>
            </div>
            <div class="text-right">
                <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addSubjectText}} </button>
            </div>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminSubject.data&&adminSubject.data.length>0">
                <tr>
                    <th>{{subjectNameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminSubject.data&&adminSubject.data.length>0">
                    <tr v-for="item in adminSubject.data">
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
        <ul v-if="adminSubject.data&&adminSubject.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminSubject.current_page>1" @click="loadNewPage(adminSubject.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminSubject.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/bs/city/'+selectedLessonId+'/subjects?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/bs/city/'+selectedLessonId+'/subjects?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminSubject.current_page<adminSubject.last_page" @click="loadNewPage(adminSubject.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addSubjectArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addSubjectText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editSubjectText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-margin-bottom">
                        <div class="uk-flex align-items-center justify-content-between">
                            <input class="uk-input uk-width-5-6 " placeholder="fa-user" v-model="icon">
                            <i v-if="icon==''" class="fas icon-medium uk-width-1-6 text-center fa-user" ></i>
                            <i v-else class="fas icon-medium uk-width-1-6 text-center" :class="icon"></i>
                        </div>
                        <div class="uk-form-label">{{subjectNameText}}</div>
                        <input class="uk-width uk-input" v-model="name" :placeholder="subjectNameText">
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
        name: "subjects-page",
        data(){
            return{
                name:"",
                icon:"",
                hasItem:false,
                selectedSubjectId:"",
                selectedPage:'/api/admin/cr/lesson/'+this.selectedLessonId+'/subjects?page=1'
            }
        },
        props:{
            lessonsRoute:{
                type:String,
                required:true,
            },
            selectedLessonId:{
                type:String,
                required:true,
            },
            addSubjectText:{
                type:String,
                default:"Konu Ekle"
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
            saveText:{
                type:String,
                default:"Kaydet"
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            },
            lessonText:{
                type:String,
                default:"Ders"
            },
            selectLessonText:{
                type:String,
                default:"Ders Seçiniz"
            },
            editSubjectText:{
                type:String,
                default:"Konu Düzenle"
            },
            subjectNameText:{
                type:String,
                default:"Konu Adı"
            },
            selectIconText:{
                type:String,
                default:"İkon seç"
            },
            iconText:{
                type:String,
                default:"İkon"
            }

        },
        computed:{
            ...mapState([
                'adminSubject',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminSubject.last_page; i++){
                    if(i==2 && this.adminSubject.current_page-2>3){
                        pages.push('...');
                        if(this.adminSubject.current_page+3>this.adminSubject.last_page){
                            index=this.adminSubject.last_page-6;
                        }else{
                            index=this.adminSubject.current_page-2;
                        }
                    }else if(i==8 && this.adminSubject.current_page+2<this.adminSubject.last_page-2){
                        pages.push('...');
                        index=this.adminSubject.last_page;
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
                'loadAdminSubject',
                'loadAdminNewPage'
            ]),
            routeLessons:function () {
                window.location.replace(this.lessonsRoute);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/cr/subject/setPassive/'+id).then(this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubject']))
            },
            activateItem:function (id) {
                Axios.post('/api/admin/cr/subject/setActive/'+id).then(this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubject']))
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/cr/subject/delete/'+id).then(this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubject']))
            },
            openSettings:function (id) {
                this.selectedGradeId=id;
                Axios.get('/api/admin/cr/subject/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addSubjectArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.selectedSubjectId=selectedData.id;
                this.icon=selectedData.symbol;
                this.name=selectedData.name;
                this.hasItem=true;
                UIkit.modal('#addSubjectArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.icon="";
                this.hasItem=false;
                this.selectedSubjectId="";
            },
            saveItem:function () {
                if(this.hasItem){
                    Axios.post('/api/admin/cr/subject/update/'+this.selectedSubjectId, {
                        symbol:this.icon,
                        name:this.name,
                        lessonId:this.selectedLessonId,
                    }).then(this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubject']))
                }else{
                    Axios.post('/api/admin/cr/subject/create', {
                        symbol:this.icon,
                        name:this.name,
                        lessonId:this.selectedLessonId,
                    }).then(this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubject']))
                }
                this.clearForm();
                UIkit.modal('#addSubjectArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminSubject']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminSubject', this.selectedLessonId);
        }
    }
</script>

<style scoped>

</style>
