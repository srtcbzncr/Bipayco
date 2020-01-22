<template>
    <div class="uk-margin-top uk-width-4-5@m">
        <ul uk-accordion="" class="uk-accordion">
            <li class="tm-course-lesson-section uk-background-default">
                <a class="uk-accordion-title uk-padding-small" href="#"><h6>{{sectionText}} {{index+1}}</h6> <h4 class="uk-margin-remove">{{sectionName}}</h4> </a>
                <div class="uk-accordion-content uk-margin-remove-top">
                    <div class="tm-course-section-list">
                        <ul>
                            <li>
                                <div class="">
                                    <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" :id="lessonInput" :placeholder="addDefaultLessonText">
                                    <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="add"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
                                </div>
                            </li>
                            <li v-for="(lesson,index) in lessons" class="uk-flex">
                                <div>
                                    <lesson v-if="lesson.isPreview"
                                            :lesson-name="lesson.name"
                                            :index="index"
                                            is-preview
                                            :preview-text="previewText"
                                    > </lesson>
                                    <lesson v-else
                                            :lesson-name="lesson.name"
                                            :index="index"
                                            :preview-text="previewText"
                                    > </lesson>
                                </div>
                                <a class="uk-button-icon uk-margin-left" @click="removeLesson(index)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import lesson from './lesson.vue'
    export default {
        name: "add-lesson",
        components:{
            lesson,
        },
        data(){
            return{
                lessons:[],
            }
        },
        props:{
            index:{
                type:Number,
                required:true,
            },
            sectionName:{
                type:String,
                required:true,
            },
            sectionText:{
                type:String,
                default:'Bölüm'
            },
            addText:{
                type:String,
                default: 'Ekle'
            },
            addDefaultLessonText:{
                type:String,
                default:'Ders Ekle'
            },
            previewText:{
                type:String,
                default:'Önizle',
            }
        },
        computed:{
              lessonInput(){
                  return 'lessonInput'+this.index
              }
        },
        methods:{
            addLesson: function (lesson) {
                this.lessons.push(lesson)
            },
            add:function () {
                this.addLesson({'name':document.getElementById(this.lessonInput).value, 'isPreview':true});
            },
            removeLesson:function (index) {
                this.lesson.splice(index,1)
            }
        }
    }
</script>

<style scoped>

</style>
