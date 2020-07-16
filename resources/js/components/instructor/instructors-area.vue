<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" v-model="instructorEmail" :placeholder="addInstructorText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="searchInstructor"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
        </div>
        <div class="uk-margin-medium">
            <hr class="uk-hidden@m">
            <div class="uk-grid uk-visible@m">
                <div class="uk-width-3-5@m ">
                    <b class="uk-margin-left">{{instructorText}}</b>
                </div>
                <div class="uk-width-1-5@m">
                    <b>{{percentText}}</b>
                </div>
            </div>
            <form id="instructorForm">
                <div class="uk-margin-small" id="instructorsArea">
                    <div v-for="(info,index) in instructorsInfo" class="uk-margin-small">
                        <div class="uk-grid align-items-center">
                            <input type="text" hidden disabled name='instructorsId[]' :value="info.instructor.id">
                            <div class="uk-width-3-5@m uk-margin-small-bottom">
                                <div class="uk-form-label uk-hidden@m"> {{instructorText}}</div>
                                <div class="uk-flex align-items-center">
                                    <img class="user-profile-tiny uk-circle" :src="info.instructor.user.avatar">
                                    <p class="uk-margin-left uk-margin-remove-bottom uk-margin-remove-top uk-margin-remove-right"><b>{{info.instructor.user.first_name}} {{info.instructor.user.last_name}}</b> <span v-if="info.instructor.is_manager">({{managerText}})</span></p>
                                </div>
                            </div>
                            <div class="uk-width-1-5@m uk-margin-small-bottom">
                                <div class="uk-form-label uk-hidden@m">{{percentText}}</div>
                                <input type="number" name="percent[]" v-model="info.percent" class="uk-input uk-padding-remove" max="100" min="1" required>
                            </div>
                            <div v-if="!info.instructor.is_manager" class="uk-width-1-5@m uk-margin-small-bottom">
                                <a class="uk-button-icon" @click="removeInstructor(index)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                            </div>
                        </div>
                        <hr class="uk-hidden@m uk-margin-medium-top">
                    </div>
                </div>
            </form>
        </div>
        <div class="uk-margin">
            <input class="uk-button uk-button-grey uk-margin uk-width-small@m" type="button" @click="instructorPost(courseId)"  :value="saveText">
        </div>
    </div>
</template>

<script>
    import Axios from 'axios'
    export default {
        name: "instructors-area",
        data(){
            return{
                instructorsInfo:[],
                instructorEmail:"",
                hasInstructor:true,
            }
        },
        props:{
            instructorText:{
                type:String,
                default:'Eğitmen'
            },
            percentText:{
                type:String,
                default:'Yüzde'
            },
            managerText:{
                type:String,
                default:'Yönetici',
            },
            addText:{
                type:String,
                default:'Ekle'
            },
            addInstructorText:{
                type:String,
                default:'Eğitmen Ekle'
            },
            userName:{
                type:String,
                required:true,
            },
            userImg:{
                type:String,
                required: true,
            },
            userId:{
                type:String,
                required:true,
            },
            instructorAddedText:{
                type:String,
                default:'Eğitmen Eklendi'
            },
            hasInstructorText:{
                type:String,
                default:'Eğitmen Zaten Eklendi'
            },
            courseId:{
                type:String,
                required:true,
            },
            saveText:{
                type:String,
                default:"Kaydet"
            },
            moduleName:{
                type:String,
                required:true
            }
        },
        methods:{
            addInstructor:function(info) {
                this.instructorsInfo.push(info);
            },
            searchInstructor:function(){
                let hasInstructorInArray=false;
                Axios.get('/api/instructor/search?email='+this.instructorEmail)
                    .then(response=>response.data)
                    .then(response=>{
                        if(response.error){
                            UIkit.notification({message:response.message , status: 'danger'});
                        }else
                            for(let i=0;i<this.instructorsInfo.length;i++) {
                                if (this.instructorsInfo[i].instructor.id == response.data.id) {
                                    hasInstructorInArray = true;
                                    UIkit.notification({message: "Eğitmen zaten eklendi", status: 'danger'});
                                    break;
                                }
                            }
                            if(!hasInstructorInArray){
                                UIkit.notification({message:this.instructorAddedText, status: 'success'});
                                this.instructorsInfo[0].percent-=1;
                                this.addInstructor({instructor:response.data, percent:1});
                            }
                        }).catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
                this.instructorEmail="";
            },
            removeInstructor:function (index) {
                if(this.instructorsInfo[0].percent+this.instructorsInfo[index].percent>100){
                    this.instructorsInfo[0].percent=100;
                }else{
                    this.instructorsInfo[0].percent+=this.instructorsInfo[index].percent;
                }
                this.instructorsInfo.splice(index,1);
            },
            instructorPost:function(courseId) {
                var instructors=[];
                for(var i=0;i<this.instructorsInfo.length; i++) {
                    var id=this.instructorsInfo[i].instructor.id;
                    var percent=this.instructorsInfo[i].percent;
                    instructors.push({'instructor_id':id,'percent': percent});
                }
                Axios.post('/api/instructor/'+this.moduleName+'/course/'+courseId+'/instructors',instructors)
                    .then(response=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
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
        },
        created() {
            Axios.get('/api/instructor/'+this.moduleName+'/course/'+this.courseId+'/instructors')
                .then(response=>response.data.data)
                .then(response=>{
                    for(var i=0;i<response.instructor.length;i++){
                        this.addInstructor({instructor:response.instructor[i], percent:response.instructor[i].percent})
                    }
                })
        }
    }
</script>

<style scoped>

</style>
