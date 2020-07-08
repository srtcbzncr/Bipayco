<template>
    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-auto">
            <button v-if="isStreamStarted" @click="joinStream" class="uk-button uk-button-white uk-float-left"> {{openStreamText}}</button>
            <button v-else class="uk-button uk-disabled uk-button-white uk-float-left"> {{streamNotStartedText}}</button>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios'
    export default {
        name: "live-stream-button",
        props:{
            openStreamText:{
                type:String,
                default:"Canlı Yayını Aç"
            },
            streamPasswordText:{
                type:String,
                default:"Canlı Yayın Şifresi"
            },
            userId:{
                type:String,
                required:true,
            },
            courseId:{
                type:String,
                required:true,
            },
            isStreamStarted:{
                type:String,
                required:true,
            },
            streamNotStartedText:{
                type:String,
                default:"Canlı Yayın Henüz Başlamadı"
            }
        },
        methods:{
            joinStream:function () {
                Axios.get('/api/instructor/live/course/'+this.courseId+'/join/'+this.userId)
                    .then((res)=>{
                        console.log(res);
                        // window.location.replace(res.data.data);
                    });
            }
        },
    }
</script>

<style scoped>

</style>
