<template>
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>{{nameText}}</th>
                    <th>{{surnameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr v-for="item in adminUsers.data">
                    <td class="uk-width-3-4"><p>{{item.first_name}}</p></td>
                    <td class="uk-width-3-4"><p>{{item.last_name}}</p></td>
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
    </div>
</template>

<script>
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "users-page",
        data(){
            return{
                name:"",
                icon:"",
                hasItem:false,
                selectedGradeId:"",
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
            surnameText:{
                type:String,
                default:"Soyadı"
            },
        },
        computed:{
            ...mapState([
                'adminUsers',
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
        },
        methods:{
            ...mapActions([
                'loadAdminUsers',
                'loadAdminNewPage'
            ]),
            deactivateItem:function (id) {
                Axios.post('/api/admin/auth/student/setPassive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminUsers'])
                        }
                    });
            },
            activateItem:function (id) {
                Axios.post('/api/admin/auth/student/setActive/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminUsers'])
                        }
                    });
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
                    });
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminUsers']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminUsers');
        }
    }
</script>

<style scoped>

</style>
