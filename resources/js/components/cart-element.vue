<template>
    <div class="uk-flex align-items-center uk-margin-medium-left">
        <a class="uk-width-5-6 uk-margin" :href="'/'+module+'/course/'+course.id">
            <div class="uk-card uk-card-default border-radius-6 uk-card-small uk-grid-collapse" uk-grid>
                <div class="uk-card-media-left uk-cover-container uk-width-1-4@s">
                    <img :src="course.image" alt="" uk-cover>
                    <canvas width="600" height="400"></canvas>
                </div>
                <div class="uk-width-3-4@s">
                    <div class="uk-card-body">
                        <div class="uk-card-title">
                            <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 25px; max-height: 25px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-margin-remove">{{course.name}}</h4>
                            <stars-rating v-if="moduleName!='live'" :rating="course.point"></stars-rating>
                            <p v-else><span class="fas fa-calendar-alt"></span> {{expectedDateText}}: {{new Date(course.datetime).toLocaleString()}}</p>
                        </div>
                        <hr class="uk-margin-remove">
                        <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{course.description}}</p>
                        <div class="uk-float-right uk-flex text-center  ">
                            <h5 class="uk-margin-remove">
                                {{course.price_with_discount}}
                                <i class="fas fa-lira-sign icon-tiny"></i>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <div class="uk-width-1-6 text-center">
            <a @click="removeCourse"><i class="fas fa-trash-alt text-danger"></i></a>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";
    import Axios from 'axios'

    export default {
        name: "cart-element",
        props:{
            course:{
                type:Object,
                required:true,
            },
            userId:{
                type:String,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
            }
        },
        computed:{
            ...mapState([
                'shoppingCart'
            ]),
            module(){
                switch (this.moduleName) {
                    case "prepareLessons":{
                        return "pl";
                    }
                    case "prepareExams":{
                        return "pe";
                    }
                    case "exams":{
                        return "exams";
                    }
                    case "live":{
                        return "live";
                    }
                    default:{
                        return "ge";
                    }
                }
            }
        },
        methods: {
            ...mapActions([
                'loadShoppingCart',
                'loadCourseCard',
                'loadIsInCart'
            ]),
            removeCourse:function () {
                Axios.post('/api/basket/delete',{
                    course_id:this.course.id,
                    module_name:this.moduleName,
                    user_id:this.userId,
                })
                    .then(()=>{
                        this.$store.dispatch('loadIsInCart', [this.module, this.userId, this.course.id]);
                        this.$store.dispatch('loadShoppingCart', this.userId);
                        this.$store.dispatch('loadCourseCard');
                    })
            },
        },
    }
</script>

<style scoped>
 a{
     text-decoration:none;
 }
</style>
