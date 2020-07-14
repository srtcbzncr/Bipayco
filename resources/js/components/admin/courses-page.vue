<template>
    <div class="uk-margin-medium-top">
        <ul uk-tab class="uk-margin-top uk-flex-center">
            <li><a @click="changeModule('generalEducation')">{{generalEducationText}}</a></li>
            <li><a @click="changeModule('prepareLessons')">{{prepareLessonsText}}</a></li>
            <li><a @click="changeModule('prepareExams')">{{prepareExamsText}}</a></li>
            <li><a @click="changeModule('live')">{{liveStreamsText}}</a></li>
        </ul>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminCourses.data&&adminCourses.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th v-if="selectedModule=='ge'">{{categoryNameText}}</th>
                    <th v-else-if="selectedModule=='pl'">{{lessonNameText}}</th>
                    <th v-else-if="selectedModule=='pe'">{{examNameText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminCourses.data&&adminCourses.data.length>0">
                <tr v-for="item in adminCourses.data">
                    <td @click="openInfo(item.id)" class="uk-width-1-2 clickable"><p>{{item.name}}</p></td>
                    <td v-if="selectedModule=='ge'" @click="openInfo(item.id)" class="uk-width-1-4 clickable"><p>{{item.category.name}}</p></td>
                    <td v-else-if="selectedModule=='pe'" @click="openInfo(item.id)" class="uk-width-1-4 clickable"><p>{{item.exam.name}}</p></td>
                    <td v-else-if="selectedModule=='pl'" @click="openInfo(item.id)" class="uk-width-1-4 clickable"><p>{{item.lesson.name}}</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
                        <span v-if="selectedModule!='live'">
                            <a v-if="!item.active" @click="activateItem(item.id)" :uk-tooltip="activateText"><i class="fas fa-check-circle"></i></a>
                            <a v-else @click="deactivateItem(item.id)" :uk-tooltip="deactivateText"><i class="fas fa-times-circle"></i></a>
                        </span>
                        <a @click="deleteItem(item.id)" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="loadingStatus&&adminCourses.data&&adminCourses.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminCourses.current_page>1" @click="loadNewPage(adminCourses.current_page-1)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminCourses.current_page" class="uk-background-default uk-disabled" @click="loadNewPage(page)">{{page}}</button>
                <button v-else @click="loadNewPage(page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminCourses.current_page<adminCourses.last_page" @click="loadNewPage(adminCourses.current_page+1)"> > </button>
            </li>
        </ul>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "courses-page",
        data(){
            return{
                selectedIndex:-1,
                selectedModule:'ge',
                page:1,
            }
        },
        props:{
            userId:{
                type:String,
                required:true,
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
            nameText:{
                type:String,
                default:"Adı"
            },
            categoryNameText:{
                type:String,
                default:"Kategori Adı"
            },
            lessonNameText:{
                type:String,
                default:"Ders Adı"
            },
            examNameText:{
                type:String,
                default:"Sınav Adı"
            },
            generalEducationText:{
                type:String,
                default:"Genel Eğitim"
            },
            prepareExamsText:{
                type:String,
                default:"Sınavlara Hazırlık"
            },
            prepareLessonsText:{
                type:String,
                default:"Derslere Hazırlık"
            },
            liveStreamsText:{
                type:String,
                default:"Canlı Yayın"
            },
        },
        computed:{
            ...mapState([
                'adminCourses',
                'loadingStatus'
            ]),
            selectedPage(){
                return "/api/admin/course/all_"+this.selectedModule+"_courses/"+this.userId+"?page="+this.page;
            },
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminCourses.last_page; i++){
                    if(i==2 && this.adminCourses.current_page-2>3){
                        pages.push('...');
                        if(this.adminCourses.current_page+3>this.adminCourses.last_page){
                            index=this.adminCourses.last_page-6;
                        }else{
                            index=this.adminCourses.current_page-2;
                        }
                    }else if(i==8 && this.adminCourses.current_page+2<this.adminCourses.last_page-2){
                        pages.push('...');
                        index=this.adminCourses.last_page;
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
                'loadAdminCourses',
                'loadAdminNewPage',
                'loadLoadingStatus',
            ]),
            changeModule:function(moduleName){
                this.$store.dispatch('loadLoadingStatus', false);
                this.page=1;
                switch (moduleName) {
                    case 'prepareLessons':{
                        this.selectedModule='pl';
                        break;
                    }
                    case 'prepareExams':{
                        this.selectedModule='pe';
                        break;
                    }
                    case 'live':{
                        this.selectedModule='live';
                        break;
                    }
                    default:{
                        this.selectedModule='ge';
                        break;
                    }
                }
                this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminCourses']);
            },
            deactivateItem:function (id) {
                Axios.post('/api/admin/course/passive_'+this.selectedModule+'_course/'+this.userId+'/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminCourses'])
                        }
                    });
            },
            activateItem:function (id) {
                Axios.post('/api/admin/course/active_'+this.selectedModule+'_course/'+this.userId+'/'+id)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminCourses'])
                        }
                    });
            },
            deleteItem:function (id) {
                Axios.post('/api/admin/course/delete_'+this.selectedModule+'_course/'+this.userId+'/'+id)
                    .then(response=>{
                        console.log(response);
                        if(response.data.error){
                            UIkit.notification({message:response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminCourses'])
                        }
                    }).catch(response=>{
                        console.log(response);
                        UIkit.notification({message:response.message, status: 'danger'})
                    });
            },
            loadNewPage: function(page){
                this.page=page;
                this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminCourses']);
            },
            openInfo:function (courseId) {
                window.location.replace('/admin/course_detail/'+courseId+'/'+this.selectedModule);
            },
        },
        created() {
            this.$store.dispatch('loadAdminCourses' ,['ge', this.userId]);
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
