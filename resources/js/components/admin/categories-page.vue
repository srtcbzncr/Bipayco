<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addCategoryText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                    <tr>
                        <th>{{categoryNameText}}</th>
                        <th>{{descriptionText}}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-if="true">
                <tr v-for="(item, index) in adminCategory.data">
                    <td @click="routeSubCategories(item.id)" class="uk-width-1-4"><p>{{item.name}}</p></td>
                    <td @click="routeSubCategories(item.id)" class="uk-width-1-2"><p>{{item.description}}</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
                        <a @click="openSettings(item.id, index)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
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
                <button v-show="adminCategory.current_page>1" @click="loadNewPage(adminCategory.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminCategory.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/ge/category/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/ge/category/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminCategory.current_page<adminCategory.last_page" @click="loadNewPage(adminCategory.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addCategoryArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addCategoryText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editCategoryText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-form-label">{{categoryNameText}}</div>
                    <input class="uk-width uk-input" v-model="name" :placeholder="categoryNameText">
<!--                    <div class="uk-form-label">{{categoryImageText}}</div>-->
<!--                    <form class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-right uk-margin-top uk-padding-remove" id="uploadForm">-->
<!--                        <div v-if="hasItem" id="imagePreview" class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image':'url('+image+')'}"></div>-->
<!--                        <div v-else id="imagePreview" class="uk-background-center-center uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" :style="{'background-image': 'url('+ defaultImagePath+')'}"></div>-->
<!--                        <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">-->
<!--                            <input name="image" type="file" accept="image/*" id="newCourseImage" @change="previewImage()" required>-->
<!--                            <input class="uk-input" type="text" tabindex="-1" disabled :placeholder="selectFileText">-->
<!--                        </div>-->
<!--                    </form>-->
                    <div class="uk-form-label">{{descriptionText}}</div>
                    <textarea class="uk-width uk-textarea uk-height-small" v-model="description" :placeholder="descriptionText"></textarea>
                    <div class="uk-form-label">{{iconText}}</div>
                    <div class="uk-flex align-items-center justify-content-between">
                        <input class="uk-input uk-width-5-6 " placeholder="fa-user" v-model="icon">
                        <i v-if="icon==''" class="fas icon-medium uk-width-1-6 text-center fa-user" ></i>
                        <i v-else class="fas icon-medium uk-width-1-6 text-center" :class="icon"></i>
                    </div>
                    <div class="uk-form-label">{{colorText}}</div>
                    <select class="uk-width uk-select" v-model="color" :style="{'background-color': color}">
                        <option selected hidden disabled value="">{{selectColorText}}</option>
                        <option value="#3659a2" class="background1"></option>
                        <option value="#c92592" class="background2"></option>
                        <option value="#9b3b5a" class="background3"></option>
                        <option value="#30826c" class="background4"></option>
                        <option value="#890ca1" class="background5"></option>
                        <option value="#7a8230" class="background6"></option>
                        <option value="#f7265c" class="background7"></option>
                        <option value="#a290da" class="background8"></option>
                        <option value="#3b8895" class="background9"></option>
                        <option value="#65e1e0" class="background0"></option>
                    </select>
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
        name: "categories-page",
        data(){
            return{
                name:"",
                icon:"",
                description:"",
                color:"",
                image:"",
                hasItem:false,
                selectedCategoryId:"",
                selectedCategoryIndex:"",
                selectedPage:"/api/admin/ge/category/show?page=1"
            }
        },
        props:{
            addCategoryText:{
                type:String,
                default:"Kategori Ekle"
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
            editCategoryText:{
                type:String,
                default:"Kategori Düzenle"
            },
            selectColorText:{
                type:String,
                default:"Renk Seçiniz"
            },
            selectIconText:{
                type:String,
                default:"İkon Seçiniz"
            },
            categoryNameText:{
                type:String,
                default:"Kategori Adı"
            },
            colorText:{
                type:String,
                default:"Renk"
            },
            iconText:{
                type:String,
                default:"İkon"
            },
            descriptionText:{
                type:String,
                default:"Açıklama"
            },
            categoryImageText:{
                type:String,
                default:"Kategori Resmi"
            },
            selectFileText:{
                type:String,
                default:"Dosya Seç"
            },
            defaultImagePath:{
                type:String,
                required:true,
            }
        },
        computed:{
            ...mapState([
                'adminCategory'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminCategory.last_page; i++){
                    if(i==2 && this.adminCategory.current_page-2>3){
                        pages.push('...');
                        if(this.adminCategory.current_page+3>this.adminCategory.last_page){
                            index=this.adminCategory.last_page-6;
                        }else{
                            index=this.adminCategory.current_page-2;
                        }
                    }else if(i==8 && this.adminCategory.current_page+2<this.adminCategory.last_page-2){
                        pages.push('...');
                        index=this.adminCategory.last_page;
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
                'loadAdminCategory',
                'loadAdminNewPage'
            ]),
            routeSubCategories:function (id) {
                window.location.replace('/admin/category/'+id+'/subCategories');
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/ge/category/setPassive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage,'setAdminCategory'])
                        }
                    });
            },
            activateItem:function (id) {
                Axios.post('/api/admin/ge/category/setActive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage,'setAdminCategory'])
                        }
                    });
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/ge/category/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage,'setAdminCategory'])
                        }
                    });
            },
            openSettings:function (id, index) {
                this.selectedCategoryIndex=index;
                this.selectedCategoryId=id;
                Axios.get('/api/admin/ge/category/show/'+id)
                    .then(response=>this.setSelected(response.data.data))
            },
            openForm:function () {
                UIkit.modal('#addCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.image=selectedData.image;
                this.name=selectedData.name;
                this.icon=selectedData.symbol;
                this.description=selectedData.description;
                this.color=selectedData.color;
                this.hasItem=true;
                UIkit.modal('#addCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.name="";
                this.icon="";
                this.description="";
                this.color="";
                this.hasItem=false;
                this.selectedCategoryId="";
                // document.getElementById('uploadForm').reset();
            },
            saveItem:function () {
                var formData = new FormData();
                // var image=document.querySelector('#newCourseImage');
                // if(image.files[0]!=undefined){
                //     formData.append('image', image.files[0]);
                // }
                formData.append('name', this.name);
                formData.append('description', this.description);
                formData.append('symbol', this.icon);
                formData.append('color', this.color);
                if(this.hasItem){
                    Axios.post('/api/admin/ge/category/update/'+this.selectedCategoryId, formData)
                        .then(response=>{
                            if(response.data.error){
                                UIkit.notification({message:response.data.message, status: 'danger'});
                            }else{
                                UIkit.notification({message:response.data.message, status: 'success'});
                                this.$store.dispatch('loadAdminNewPage',[this.selectedPage,'setAdminCategory'])
                            }
                        });
                }else{
                    Axios.post('/api/admin/ge/category/create', formData)
                        .then(response=>{
                            if(response.data.error){
                                UIkit.notification({message:response.data.message, status: 'danger'});
                            }else{
                                UIkit.notification({message:response.data.message, status: 'success'});
                                this.$store.dispatch('loadAdminNewPage',[this.selectedPage,'setAdminCategory'])
                            }
                        });
                }
                this.clearForm();
                UIkit.modal('#addCategoryArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name,'setAdminCategory']);
            },
            // previewImage: function(){
            //     var input=document.querySelector('#newCourseImage');
            //     if (input.files && input.files[0]) {
            //         var reader = new FileReader();
            //         reader.onload = function (e) {
            //             document.querySelector('#imagePreview').setAttribute('style', 'background-image:url('+e.target.result+')');
            //         };
            //         reader.readAsDataURL(input.files[0]);
            //     }
            // }
        },
        created() {
            this.$store.dispatch('loadAdminCategory');
        }
    }
</script>

<style scoped>
    tbody tr{
        cursor: pointer;
    }
    textarea{
        resize:none;
    }
    .background1{
        background-color: #3659a2;
    }
    .background2{
        background-color: #c92592;
    }
    .background3{
        background-color: #9b3b5a;
    }
    .background4{
        background-color: #30826c;
    }
    .background5{
        background-color: #890ca1;
    }
    .background6{
        background-color: #7a8230;
    }
    .background7{
        background-color: #f7265c;
    }
    .background8{
        background-color: #a290da;
    }
    .background9{
        background-color: #3b8895;
    }
    .background0{
        background-color: #65e1e0;
    }
</style>
