<template>
    <div class="uk-margin-top">
        <ul uk-accordion="" class="uk-accordion">
            <li class="tm-course-lesson-section uk-background-default">
                <a class="uk-accordion-title uk-padding-small" href="#"><h6>Bölüm {{index}}</h6> <h4 class="uk-margin-remove">{{sectionName}}</h4> </a>
                <div class="uk-accordion-content uk-margin-remove-top">
                    <div class="tm-course-section-list">
                        <ul>
                            <li>
                                <div class="">
                                    <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" placeholder="addDefaultText">
                                    <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m"><i class="fas fa-plus"></i> <span class="uk-hidden@m">ekle</span></button>
                                </div>
                            </li>
                            <li v-for="(lesson,index) in lessons">
                                <lesson
                                    :lesson-name="lesson"
                                    :index="index"
                                > </lesson>
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
                type:String,
                required:true,
            },
            sectionName:{
                type:String,
                required:true,
            },
        }
    }
</script>

<style scoped>

</style>
