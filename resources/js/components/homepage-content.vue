<template>
    <div class="uk-container">
        <ul uk-tab class="uk-margin-top uk-flex-center">
            <li><a @click="changeModule('generalEducation')">{{generalEducationText}}</a></li>
            <li><a @click="changeModule('prepareLessons')">{{prepareLessonsText}}</a></li>
            <li><a @click="changeModule('prepareExams')">{{prepareExamsText}}</a></li>
            <li><a @click="changeModule('exams')">{{examsText}}</a></li>
            <li><a @click="changeModule('books')">{{booksText}}</a></li>
        </ul>
        <ul class="uk-margin uk-margin-medium-top">
            <li>
                <div v-if="courses==null || courses.length<1" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                    <h4 class="uk-text-bold uk-margin-remove-top">{{noContentText}}</h4>
                </div>
                <div v-else>
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        <div v-for="course in courses">
                            <course-card
                                v-if="authCheck"
                                :course="course"
                                :page-link="'/'+module+'/course/'+course.id"
                                style-full-star-color="#F4C150"
                                style-empty-star-color="#C1C1C1"
                                :course-id="course.id"
                                :module-name="moduleName"
                                is-login
                                :user-id="userId"
                            ></course-card>
                            <course-card
                                v-else
                                :course="course"
                                :page-link="'/'+module+'/course/'+course.id"
                                style-full-star-color="#F4C150"
                                style-empty-star-color="#C1C1C1"
                                :course-id="course.id"
                                :module-name="moduleName"
                            ></course-card>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <span class="uk-width-1-4"></span>
                        <a :href="'/'+module+'/index'" class="uk-button uk-button-grey uk-width-1-2">{{seeMoreText}}</a>
                        <span class="uk-width-1-4"></span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "homepage-content",
        data(){
            return{
                courses:this.generalEducation,
                moduleName:'generalEducation',
                module:'ge'
            }
        },
        props:{
            generalEducation:{
                type:Array,
                required:true,
            },
            prepareLessons:{
                type:Array,
                required:true,
            },
            prepareExams:{
                type:Array,
                required:true,
            },
            exams:{
                type:Array,
                required:true,
            },
            books:{
                type:Array,
                required:true,
            },
            authCheck:{
                type:Boolean,
                required:true,
            },
            userId:{
                type:String,
            },
            generalEducationText:{
                type:String,
                default:"Genel Eğitim"
            },
            prepareLessonsText:{
                type:String,
                default:"Derslere Hazırlık"
            },
            prepareExamsText:{
                type:String,
                default:"Sınavlara Hazırlık"
            },
            examsText:{
                type:String,
                default:"Denemeler"
            },
            booksText:{
                type:String,
                default:"Soru Bankaları"
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmamaktadır"
            },
            seeMoreText:{
                type:String,
                default:"Daha Fazlasını Gör"
            }
        },
        methods:{
            changeModule:function(moduleName){
                this.moduleName=moduleName;
                switch (moduleName) {
                    case 'prepareLessons':{
                        this.courses=this.prepareLessons;
                        this.module='pl';
                        break;
                    }
                    case 'prepareExams':{
                        this.courses=this.prepareExams;
                        this.module='pe';
                        break;
                    }
                    case 'exams':{
                        this.courses=this.exams;
                        this.module='exams';
                        break;
                    }
                    case 'books':{
                        this.courses=this.books;
                        this.module='books';
                        break;
                    }
                    default:{
                        this.courses=this.generalEducation;
                        this.module='ge';
                        break;
                    }
                }
            }
        }
    }
</script>

<style scoped>
li{
    list-style-type: none;
}
</style>
