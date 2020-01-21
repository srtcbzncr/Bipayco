<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" :placeholder="addDefaultSectionText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
        </div>
        <div v-for="(section, index) in sections" class="uk-margin-top">
            <add-lesson
            :index="index"
            :section-name="section"
            :preview-text="previewText"
            :add-text="addText"
            :add-default-lesson-text="addDefaultLessonText"
            :section-text="sectionText"
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
        props:{
            previewText:{
                type:String,
                default:'Önizle'
            },
            addText:{
                type:String,
                default:'Ekle',
            },
            addDefaultSectionText:{
                type:String,
                default:'Bölüm Ekle'
            },
            addDefaultLessonText:{
                type:String,
                default:'Ders Ekle'
            },
            sectionText:{
                type:String,
                default:'Bölüm'
            }
        },
        methods:{

        }
    }
</script>

<style scoped>

</style>
