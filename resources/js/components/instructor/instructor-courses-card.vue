<template>
    <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
        <a :href="courseRoute" class="uk-link-reset">
            <div class="course-img uk-background-center-center uk-background-cover uk-height-medium" :style="'background-image: url('+course.image+')'"></div>
        </a>
        <div class="uk-card-body">
            <a :href="courseRoute" class="uk-link-reset">
                <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 25px; max-height: 25px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{course.name}}</h4>
                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{course.description}}</p>
                <hr class="uk-margin-remove-top">
            </a>
            <div class="uk-grid uk-child-width-1-2">
                <div>
                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-user-graduate uk-margin-small-right"></i>{{studentCount}} {{studentText}}</p>
                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-calendar-alt uk-margin-small-right"></i>{{dateFormat(course.created_at)}}</p>
                </div>
                <div class="uk-flex justify-content-around align-items-center ">
                    <a class="uk-button-text uk-button" :href="editCourseRoute"><i class="fas fa-cog"></i></a>
                    <a v-if="moduleName!='live'" class="uk-button-text uk-button" href="#" @click="activationCourse"><i class="fas" :class="{'fa-times-circle':course.active, 'fa-check-circle':!course.active}"></i></a>
                    <a v-else class="uk-button-text uk-button" href="#" @click="startStream"><i class="fas fa-video" ></i></a>
                    <a class="uk-button uk-button-text" href="#" @click="deleteCourse"> <i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios'
    export default {
        name: "instructor-courses-card",
        props:{
            course:{
                type:Object,
                required:true
            },
            userId:{
                type:String,
                required:true,
            },
            courseRoute:{
                type:String,
                required:true,
            },
            editCourseRoute:{
                type:String,
                required:true,
            },
            studentCount:{
                type:String,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
            },
            minuteBeforeText:{
                type:String,
                default:"dakika önce"
            },
            hourBeforeText:{
                type:String,
                default:"saat önce"
            },
            dayBeforeText:{
                type:String,
                default:"gün önce"
            },
            monthBeforeText:{
                type:String,
                default:"ay önce"
            },
            yearBeforeText:{
                type:String,
                default:"yıl önce"
            },
            studentText:{
                type:String,
                default:"Öğrenci"
            }
        },
        methods:{
            dateFormat:function (date) {
                let created=new Date(date);
                let today=new Date();
                if(today.getFullYear()-created.getFullYear()>1){
                    return (today.getFullYear()-created.getFullYear())+" "+this.yearBeforeText;
                }else if(today.getMonth()-created.getMonth()>1){
                    return (today.getMonth()-created.getMonth())+" "+this.monthBeforeText;
                }else if(today.getDate()-created.getDate()>1) {
                    return (today.getDate() - created.getDate()) + " " + this.dayBeforeText;
                }else if(today.getHours()-created.getHours()>1) {
                    return (today.getHours() - created.getHours()) + " " + this.hourBeforeText;
                }else{
                    return (today.getMinutes() - created.getMinutes()) + " " + this.minuteBeforeText;
                }
            },
            deleteCourse:function () {
                Axios.post('/api/instructor/'+this.moduleName+'/course/'+this.course.id+'/delete', {'userId': this.userId})
                    .then(response=>{
                        console.log(response);
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.reload();},1000);
                        }else{
                            UIkit.notification({message:response.data.errorMessage, status: 'danger'});
                        }
                    })

            },
            activationCourse:function () {
                var active;
                if(this.course.active){
                    active='passive'
                }else{
                    active='active'
                }
                Axios.post('/api/instructor/'+this.moduleName+'/course/'+this.course.id+'/'+active, {'userId': this.userId})
                    .then(response=>{
                        console.log(response);
                        if(!response.data.error){
                            UIkit.notification({message:response.data.message, status: 'success'});
                            setTimeout(()=>{window.location.reload();},1000);
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                    })

            },
            startStream:function () {
                Axios.get('/api/instructor/live/course/'+this.course.id+'/createOnBBB/'+this.userId)
                .then((res)=>{
                    window.location.replace(res.data);
                });
            }
        }
    }
</script>

<style scoped>

</style>
