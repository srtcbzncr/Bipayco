<template>
    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-auto">
            <a href="" class="uk-button uk-button-white uk-float-left"> {{openStreamText}}</a>
        </div>
        <div class="uk-width-expand">
            <span class="uk-light uk-text-small uk-text-bold"> {{streamPasswordText}}</span>
            <h4 class="uk-light uk-margin-remove">772383</h4>
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
            }
        },
        methods:{

        },
        created() {
            Axios.get('/api/instructor/live/course/'+this.courseId+'/join/'+this.userId)
        }
    }
</script>

<style scoped>

</style>
