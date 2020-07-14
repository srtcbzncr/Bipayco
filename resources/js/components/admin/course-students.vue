<template>
    <div class="uk-margin-medium-top">
        <div class="text-left">
            <a  @click="routeAdminCourses" class="uk-flex align-item-center">
                <i class="fas fa-arrow-alt-circle-left icon-medium uk-margin-small-right"></i>
                <h6 class="uk-margin-remove">{{backText}}</h6>
            </a>
        </div>
        <div>
            <div class="uk-width uk-flex uk-flex-center uk-child-width-1-2@s">
                <div class="uk-cover-container">
                    <img :src="courseDetail.image" alt="" uk-cover>
                    <canvas width="600" height="400"></canvas>
                </div>
            </div>
            <div class="uk-child-width-1-2@m uk-grid-divider uk-padding-small uk-padding-remove-vertical" uk-grid>
                <div>
                    <div class="uk-form-label">{{nameText}}</div>
                    <h6><a :href="'/ge/course/'+courseDetail.id">{{courseDetail.name}}</a></h6>
                </div>
                <div>
                    <div class="uk-form-label">{{pointText}}</div>
                    <h6>{{courseDetail.point}}</h6>
                </div>
                <div class="uk-width">
                    <div class="uk-form-label">{{descriptionText}}</div>
                    <h6>{{courseDetail.description}}</h6>
                </div>
                <div>
                    <div class="uk-form-label">{{priceText}}</div>
                    <h6>{{courseDetail.price}} <span class="fas fa-lira-sign icon-tiny"></span></h6>
                </div>
                <div>
                    <div class="uk-form-label">{{instructorText}}</div>
                    <h6><a :href="courseDetail.instructor">{{courseDetail.instructor}}</a></h6>
                </div>
            </div>
        </div>
        <hr>
        <div class="uk-form-label uk-margin-top uk-margin-small-left">{{registeredStudentsText}}</div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminCourseStudent.data&&adminCourseStudent.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th>{{emailText}}</th>
                </tr>
                </thead>
                <tbody v-if="adminCourseStudent.data&&adminCourseStudent.data.length>0">
                <tr v-for="item in adminCourseStudent.data">
                    <td class="uk-width-1-2"><p>{{item.student.user.first_name}} {{item.student.user.last_name}}</p></td>
                    <td class="uk-width-1-2"><p>{{item.student.user.email}}</p></td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="adminCourseStudent.data&&adminCourseStudent.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminCourseStudent.current_page>1" @click="loadNewPage(adminCourseStudent.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminCourseStudent.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/cr/grade/show?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/cr/grade/show?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminCourseStudent.current_page<adminCourseStudent.last_page" @click="loadNewPage(adminCourseStudent.next_page_url)"> > </button>
            </li>
        </ul>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "course-detail-page",
        data(){
            return{
                courseDetail:{},
            }
        },
        props:{
            courseId:{
                type:String,
                required:true
            },
            userId:{
                type:String,
                required:true
            },
            module:{
                type:String,
                required:true
            },
            adminCoursesRoute:{
                type:String,
                required:true
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmuyor"
            },
            emailText:{
                type:String,
                default:"Eposta"
            },
            nameText:{
                type:String,
                default:"Ad"
            },
            backText:{
                type:String,
                default:"Geri"
            },
            priceText:{
                type:String,
                default:"Fiyat"
            },
            descriptionText:{
                type:String,
                default:"Açıklama"
            },
            instructorText:{
                type:String,
                default:"Eğitmen"
            },
            pointText:{
                type:String,
                default:"Puan"
            },
            registeredStudentsText:{
                type:String,
                default:"Kayıtlı Öğrenciler"
            },
        },
        computed:{
            ...mapState([
                'adminCourseStudent',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminCourseStudent.last_page; i++){
                    if(i==2 && this.adminCourseStudent.current_page-2>3){
                        pages.push('...');
                        if(this.adminCourseStudent.current_page+3>this.adminCourseStudent.last_page){
                            index=this.adminCourseStudent.last_page-6;
                        }else{
                            index=this.adminCourseStudent.current_page-2;
                        }
                    }else if(i==8 && this.adminCourseStudent.current_page+2<this.adminCourseStudent.last_page-2){
                        pages.push('...');
                        index=this.adminCourseStudent.last_page;
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
                'loadAdminCourseStudent',
                'loadAdminNewPage'
            ]),
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminCourseStudent']);
            },
            routeAdminCourses:function () {
                window.location.replace(this.adminCoursesRoute);
            },
        },
        created(){
            this.$store.dispatch('loadAdminCourseStudent', ['ge', this.userId, this.courseId]);
            Axios.get('/api/admin/course/detail_'+this.module+'/'+this.userId+'/'+this.courseId)
            .then((res)=>{
                this.courseDetail=res.data.data;
            });
        }
    }
</script>

<style scoped>
</style>
