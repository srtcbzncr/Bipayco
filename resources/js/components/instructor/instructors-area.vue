<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" id="instructorEmail" :placeholder="addInstructorText">
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
                    <div v-for="(instructor,index) in instructors" class="uk-margin-small">
                        <div class="uk-grid align-items-center">
                            <input type="text" hidden disabled name='instructorsId[]' :value="instructor.id">
                            <div class="uk-width-3-5@m uk-margin-small-bottom">
                                <div class="uk-form-label uk-hidden@m"> {{instructorText}}</div>
                                <div class="uk-flex align-items-center">
                                    <img class="user-profile-tiny uk-circle" :src="instructor.user.avatar">
                                    <p class="uk-margin-left uk-margin-remove-bottom uk-margin-remove-top uk-margin-remove-right"><b>{{instructor.user.first_name}} {{instructor.user.last_name}}</b> <span v-if="instructor.is_manager">({{managerText}})</span></p>
                                </div>
                            </div>
                            <div class="uk-width-1-5@m uk-margin-small-bottom">
                                <div class="uk-form-label uk-hidden@m">{{percentText}}</div>
                                <input type="number" name="percent[]" class="uk-input uk-padding-remove" max="100" min="1" required>
                            </div>
                            <div v-if="!instructor.is_manager" class="uk-width-1-5@m uk-margin-small-bottom">
                                <a class="uk-button-icon" @click="removeInstructor(index)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                            </div>
                        </div>
                        <hr class="uk-hidden@m uk-margin-medium-top">
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "instructors-area",
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
            }
        },
        data(){
            return{
                instructors:[],
                hasInstructor:true,
            }
        },
        methods:{
            addInstructor:function(instructor) {
                this.instructors.push(instructor);
            },
            searchInstructor:function(){
                var email=document.getElementById('instructorEmail').value;
                axios.get('/api/instructor/search?email='+email)
                    .then(response=>response.data)
                    .then(response=>{
                        if(response.error){
                            UIkit.notification({message:response.message , status: 'danger'});
                        }else{
                            UIkit.notification({message:this.instructorAddedText, status: 'success'});
                            this.addInstructor(response.data);
                        }
                    });
            },
            removeInstructor:function (index) {
                this.instructors.splice(index,1);
            },
        },
        created() {
            axios.get('/api/instructor/course/'+this.courseId+'/instructors')
                .then(response=>response.data.data)
                .then(response=>{
                    for (var i=0; i<response.instructor.length; i++){
                        this.addInstructor(response.instructor[i]);
                    }
                });
        }
    }
</script>

<style scoped>

</style>
