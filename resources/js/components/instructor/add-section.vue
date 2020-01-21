<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" placeholder="addDefaultText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m"><i class="fas fa-plus"></i> <span class="uk-hidden@m">ekle</span></button>
        </div>
        <div v-for="(section, index) in sections" class="uk-margin-top">
            <add-lesson
            :index="index"
            :section-name="section"
            > </add-lesson>
        </div>
    </div>
</template>

<script>
    import addLesson from './add-lesson.vue'
    export default {
        name: "add-section",
        components:{
            addLesson,
        },
        data(){
            return{
                sections:[],
            }
        },
        methods:{

        }
    }
</script>

<style scoped>

</style>
