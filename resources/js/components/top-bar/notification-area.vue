<template>
    <li>
        <a><i style="color: #424242" class="fas fa-bell icon-medium" :uk-tooltip="'title:'+notificationsText+' ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up'"> </i><span v-if="notifications&&notifications.length>0" style="margin-left:-5px" class="float-right uk-margin-bottom"><i class=" fas fa-circle text-danger icon-tiny"></i></span></a>
        <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-small border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
            <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> {{notificationsText}} </h5>
            <hr class=" uk-margin-remove">
            <div v-if="notifications&&notifications.length>0" class="uk-text-left uk-height-medium">
                <div data-simplebar style="overflow-y:auto">
                    <div class="uk-padding-small"  uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100">
                        <div v-for="notification in notifications">
                            <div class="uk-flex-middle uk-grid-small" uk-grid>
                                <div class="uk-width-5-6">
                                    <p>{{notification.content}}</p>
                                </div>
                                <div class="uk-width-1-6 uk-flex flex-column align-items-center justify-content-around">
                                    <a @click="notificationChoice(notification.accept_url, notification.id)" v-if="notification.is_choice"><i class="text-success fas fa-check icon-small uk-margin-bottom"></i></a>
                                    <a v-if="notification.is_choice" @click="notificationChoice(notification.reject_url, notification.id)"><i class="text-danger fas fa-times icon-small uk-margin-top"></i></a>
                                    <a v-else @click="deleteNotification(notification.id)"><i class="text-danger fas fa-times icon-small"></i></a>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="uk-flex uk-height-medium uk-width justify-content-around uk-padding align-items-center text-center">
                <h4>{{haveNoNewNotificationText}}</h4>
            </div>
        </div>
    </li>
</template>

<script>
    import Axios from 'axios';
    export default {
        name: "notification-card",
        data(){
            return{
                notifications:[],
            }
        },
        props:{
            userId:{
              type:String,
              required:true,
            },
            notificationsText:{
                type:String,
                default:"Bildirimler"
            },
            removeAllText:{
                type:String,
                default: "Hepsini Kaldır"
            },
            haveNoNewNotificationText:{
                type:String,
                default: "Hiç Yeni Bildirimin Bulunmuyor"
            }
        },
        methods:{
            fetchNotification:function(){
                Axios.get('/api/notification/show/'+this.userId)
                    .then((res)=>{this.notifications=res.data.data;})
            },
            notificationChoice:function (url, id) {
                Axios.post('/api/'+url)
                    .then((res)=>{
                        console.log(res);
                        if(res.data.error){
                            UIkit.notification({message:res.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message:res.data.message, status: 'success'});
                            this.deleteNotification(id);
                            this.fetchNotification();
                        }
                    }).catch((error)=>{
                    if(error.response) {
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }});
            },
            deleteNotification:function (id) {
                Axios.post('/api/notification/delete/'+id)
            }
        },
        created() {
            this.fetchNotification();
        }
    }
</script>

<style scoped>
</style>
