<template>
    <div>
        <a class="uk-position-top-right uk-link-reset"> <i class="fas uk-align-right uk-text-small uk-padding-small" @click="removeAll"> {{removeAllText}}</i> </a>
        <hr class=" uk-margin-remove">
        <div v-if="shoppingCart&&shoppingCart.length>0" class="uk-text-left uk-height-medium">
            <div uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100"  style="overflow-y:auto" data-simplebar>
                <hr>
                <div v-for="item in shoppingCart">
                    <div class="uk-grid align-items-center shoppingItem">
                        <a class="uk-width-5-6" :href="'/'+moduleNameToModule(item.course_type)+'/course/'+item.course_id">
                            <div class="uk-flex align-item-center justify-content-between">
                                <div class="uk-width-3-4 uk-flex">
                                    <div class="uk-margin-small-left uk-card-media-left uk-cover-container uk-width-1-4">
                                        <img :src="item.course.image" alt="" uk-cover>
                                        <canvas width="600" height="400"></canvas>
                                    </div>
                                    <h5 class="uk-margin-left uk-width-3-4 uk-margin-remove-vertical uk-margin-remove-right"  style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{item.course.name}}</h5>
                                </div>
                                <h6 class="uk-width-1-4 text-center uk-margin-remove">{{item.course.price_with_discount}}  <i class="fas fa-lira-sign icon-tiny"></i></h6>
                            </div>
                        </a>
                        <div class="uk-width-1-6 text-left">
                            <i class="fas fa-trash-alt text-danger" @click="removeCourse(item.course_id, item.course_type)"></i>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div v-else class="uk-flex uk-height-medium uk-width uk-padding justify-content-around align-items-center text-center">
            <h4>{{cartEmptyText}}</h4>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex'
    import Axios from 'axios'
    export default {
        name: "messages-small-card",
        props:{
            userId:{
                type:String,
                required:true,
            },
            removeAllText:{
                type:String,
                default:"Hepsini Temizle"
            },
            cartEmptyText:{
                type:String,
                default:"Sepetinde Ürün Bulunmuyor"
            }
        },
        computed:{
            ...mapState([
                'shoppingCart'
            ]),
        },
        methods:{
            ...mapActions([
                'loadShoppingCart',
                'loadCourseCard',
                'loadIsInCart'
            ]),
            removeAll:function () {
                var module;
                switch (this.shoppingCart[0].course_type) {
                    case "prepareLessons":{
                        module="pl";
                        break;
                    }
                    case "prepareExams":{
                        module="pe";
                        break;
                    }
                    case "exams":{
                        module="exams";
                        break;
                    }
                    case "books":{
                        module="books";
                        break;
                    }
                    default:{
                        module="ge";
                        break;
                    }
                }
                Axios.post('/api/basket/deleteAll/'+this.userId)
                    .then(response=>{
                        this.$store.dispatch('loadIsInCart', [module, this.userId, this.shoppingCart[0].id]);
                        this.$store.dispatch('loadShoppingCart', this.userId);
                        this.$store.dispatch('loadCourseCard');
                    })
            },
            moduleNameToModule:function(moduleName){
                switch (moduleName) {
                    case "prepareLessons":{
                        return "pl";
                    }
                    case "prepareExams":{
                        return "pe";
                    }
                    case "exams":{
                        return "exams";
                    }
                    case "books":{
                        return "books";
                    }
                    default:{
                        return "ge";
                    }
                }
            },
            removeCourse:function (courseId, moduleName) {
                var module;
                switch (moduleName) {
                    case "prepareLessons":{
                        module="pl";
                        break;
                    }
                    case "prepareExams":{
                        module="pe";
                        break;
                    }
                    case "exams":{
                        module="exams";
                        break;
                    }
                    case "books":{
                        module="books";
                        break;
                    }
                    default:{
                        module="ge";
                        break;
                    }
                }
                Axios.post('/api/basket/delete',{
                    course_id:courseId,
                    module_name:moduleName,
                    user_id:this.userId,
                })
                .then(response=>{
                    this.$store.dispatch('loadIsInCart', [module, this.userId, courseId]);
                    this.$store.dispatch('loadShoppingCart', this.userId);
                    this.$store.dispatch('loadCourseCard');
                })
            },
        },
        created() {
            this.$store.dispatch('loadShoppingCart',this.userId);
        }
    }
</script>

<style scoped>
    .shoppingItem{
        height: 50px;
    }

    .shoppingImg{

    }

    a{
        text-decoration:none
    }
</style>
