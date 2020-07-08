<template>
    <div class="uk-margin-large-top">
        <div class="uk-flex align-items-center justify-content-between">
            <div class="text-left">
                <a  @click="routeCategory" class="uk-flex align-item-center">
                    <i class="fas fa-arrow-alt-circle-left icon-medium uk-margin-small-right"></i>
                    <h6 class="uk-margin-remove">{{backText}}</h6>
                </a>
            </div>
            <div class="text-right">
                <button class="uk-button uk-button-success" @click="openForm"><i class="fas fa-plus"></i> {{addSubCategoryText}} </button>
            </div>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminSubCategory.data&&adminSubCategory.data.length>0">
                <tr>
                    <th>{{subCategoryNameText}}</th>
                    <th>{{descriptionText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminSubCategory.data&&adminSubCategory.data.length>0">
                <tr v-for="item in adminSubCategory.data">
                    <td class="uk-width-1-4"><p>{{item.name}}</p></td>
                    <td class="uk-width-1-2"><p>{{item.description}}</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
                        <a @click="openSettings(item.id)" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
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
        <ul v-if="adminSubCategory.data&&adminSubCategory.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminSubCategory.current_page>1" @click="loadNewPage(adminSubCategory.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminSubCategory.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/bs/city/'+selectedCategoryId+'/SubCategories?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/bs/city/'+selectedSubCategoryId+'/SubCategories?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminSubCategory.current_page<adminSubCategory.last_page" @click="loadNewPage(adminSubCategory.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="addSubCategoryArea" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 v-if="!hasItem" class="uk-modal-title">{{addSubCategoryText}}</h2>
                    <h2 v-else class="uk-modal-title">{{editSubCategoryText}}</h2>
                </div>

                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-form-label">{{subCategoryNameText}}</div>
                    <input class="uk-width uk-input" v-model="name" :placeholder="subCategoryNameText">
<!--                    <div class="uk-form-label">{{subCategoryImageText}}</div>-->
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
        name: "sub-categories-page",
        data(){
            return{
                color:"",
                icon:"",
                name:"",
                image:"",
                description:"",
                hasItem:false,
                selectedSubCategoryId:"",
                selectedPage:'/api/admin/ge/category/'+this.selectedCategoryId+'/subCategories?page=1'
            }
        },
        props:{
            categoriesRoute:{
                type:String,
                required: true,
            },
            selectedCategoryId:{
                type:String,
                required:true,
            },
            addSubCategoryText:{
                type:String,
                default:"Alt Kategori Ekle"
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
            categoryText:{
                type:String,
                default:"Kategori"
            },
            selectCategoryText:{
                type:String,
                default:"Kategori Seçiniz"
            },
            subCategoryNameText:{
                type:String,
                default:"Alt Kategori Adı"
            },
            iconText:{
                type:String,
                default:"İkon"
            },
            selectIconText:{
                type:String,
                default:"İkon Seçiniz"
            },
            selectColorText:{
                type:String,
                default:"Renk Seçiniz"
            },
            colorText:{
                type:String,
                default:"Renk"
            },
            editSubCategoryText:{
                type:String,
                default:"Alt Kategori Düzenle"
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            cancelText:{
                type:String,
                default:"Cancel"
            },
            descriptionText:{
                type:String,
                default:"Açıklama"
            },
            subCategoryImageText:{
                type:String,
                default:"Alt Kategori Resmi"
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
                'adminSubCategory',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminSubCategory.last_page; i++){
                    if(i==2 && this.adminSubCategory.current_page-2>3){
                        pages.push('...');
                        if(this.adminSubCategory.current_page+3>this.adminSubCategory.last_page){
                            index=this.adminSubCategory.last_page-6;
                        }else{
                            index=this.adminSubCategory.current_page-2;
                        }
                    }else if(i==8 && this.adminSubCategory.current_page+2<this.adminSubCategory.last_page-2){
                        pages.push('...');
                        index=this.adminSubCategory.last_page;
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
                'loadAdminSubCategory',
                'loadAdminNewPage'
            ]),
            routeCategory:function () {
                window.location.replace(this.categoriesRoute);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/ge/subCategory/setPassive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubCategory'])
                        }
                    })
            },
            activateItem:function (id) {
                Axios.post('/api/admin/ge/subCategory/setActive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else {
                            UIkit.notification({message: response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage', [this.selectedPage, 'setAdminSubCategory'])
                        }
                    })
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/ge/subCategory/delete/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubCategory'])
                        }
                    })
            },
            openSettings:function (id) {
                this.selectedSubCategoryId=id;
                Axios.get('/api/admin/ge/subCategory/show/'+id)
                    .then(response=>this.setSelected(response.data.data));
            },
            openForm:function () {
                UIkit.modal('#addSubCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            setSelected:function(selectedData){
                this.image=selectedData.image;
                this.description=selectedData.description;
                this.color=selectedData.color;
                this.name=selectedData.name;
                this.icon=selectedData.symbol;
                this.hasItem=true;
                UIkit.modal('#addSubCategoryArea', {
                    escClose:false,
                    bgClose:false,
                }).show();
            },
            clearForm:function () {
                this.hasItem=false;
                this.description="";
                this.color="";
                this.name="";
                this.icon="";
                this.selectedSubCategoryId="";
                // document.getElementById('uploadForm').reset();
            },
            saveItem:function () {
                var formData=new FormData();
                // var image=document.querySelector('#newCourseImage');
                // if(image.files[0]!=undefined){
                //     formData.append('image', image.files[0]);
                // }
                formData.append('name', this.name);
                formData.append('categoryId', this.selectedCategoryId);
                formData.append('symbol', this.icon);
                formData.append('color', this.color);
                formData.append('description', this.description);

                if(this.hasItem){
                    Axios.post('/api/admin/ge/subCategory/update/'+this.selectedSubCategoryId, formData)
                        .then(response=>{
                            if(response.data.error){
                                UIkit.notification({message:response.data.message, status: 'danger'});
                            }else{
                                UIkit.notification({message:response.data.message, status: 'success'});
                                this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubCategory'])
                            }
                        });
                }else{
                    Axios.post('/api/admin/ge/subCategory/create', formData)
                        .then(response=>{
                            if(response.data.error){
                                UIkit.notification({message:response.data.message, status: 'danger'});
                            }else{
                                UIkit.notification({message:response.data.message, status: 'success'});
                                this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminSubCategory'])
                            }
                        });
                }
                this.clearForm();
                UIkit.modal('#addSubCategoryArea').hide();
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminSubCategory']);
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
            this.$store.dispatch('loadAdminSubCategory', this.selectedCategoryId);
        }
    }
</script>

<style scoped>
    textarea{
        resize:none
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
    option:hover{
        box-shadow:none;
    }
</style>
