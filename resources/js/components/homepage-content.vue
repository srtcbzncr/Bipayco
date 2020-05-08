 <template>
    <div class="uk-container">
        <ul uk-tab class="uk-margin-top uk-flex-center">
            <li><a @click="changeModule('generalEducation')">{{generalEducationText}}</a></li>
            <li><a @click="changeModule('prepareLessons')">{{prepareLessonsText}}</a></li>
            <li><a @click="changeModule('prepareExams')">{{prepareExamsText}}</a></li>
            <li><a @click="changeModule('books')">{{booksText}}</a></li>
            <li><a @click="changeModule('exams')">{{examsText}}</a></li>
        </ul>
        <ul class="uk-margin uk-margin-medium-top">
            <li>
                <div v-if="courseCard==null || courseCard.length<1" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                    <h4 class="uk-text-bold uk-margin-remove-top">{{noContentText}}</h4>
                </div>
                <div v-else>
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        <div v-for="course in courseCard">
                            <course-card
                                v-if="authCheck"
                                :course="course"
                                style-full-star-color="#F4C150"
                                style-empty-star-color="#C1C1C1"
                                :course-id="course.id"
                                :module-name="moduleName"
                                is-login
                                :user-id="userId"
                                :module="module"
                            ></course-card>
                            <course-card
                                v-else
                                :course="course"
                                style-full-star-color="#F4C150"
                                style-empty-star-color="#C1C1C1"
                                :course-id="course.id"
                                :module-name="moduleName"
                                :module="module"
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
    import {mapState,mapActions} from 'vuex'
    export default {
        name: "homepage-content",
        data(){
            return{
                moduleName:'generalEducation',
                module:'ge',
            }
        },
        props:{
            authCheck:{
                type:Boolean,
                default:false,
            },
            userId:{
                type:String,
                default:"",
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
        computed:{
            ...mapState([
               'courseCard',
                'urlForCourseCard',
            ]),
            url(){
                return '/api/home/'+this.module+'/'+this.userId;
            }
        },
        methods:{
            ...mapActions([
                'loadCourseCard',
                'loadUrlForCourseCard'
            ]),
            changeModule:function(moduleName){
                this.moduleName=moduleName;
                switch (moduleName) {
                    case 'prepareLessons':{
                        this.module='pl';
                        break;
                    }
                    case 'prepareExams':{
                        this.module='pe';
                        break;
                    }
                    case 'exams':{
                        this.module='exams';
                        break;
                    }
                    case 'books':{
                        this.module='books';
                        break;
                    }
                    default:{
                        this.module='ge';
                        break;
                    }
                }
                this.$store.dispatch('loadUrlForCourseCard', this.url);
            }
        },
        created() {
            this.$store.dispatch('loadUrlForCourseCard', this.url);
        }
    }
</script>

<style scoped>
li{
    list-style-type: none;
}
</style>
