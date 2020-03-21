<template>
    <div>
        <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas uk-align-right uk-text-small uk-padding-small" @click="removeAll"> {{removeAllText}}</i> </a>
        <hr class=" uk-margin-remove">
        <div class="uk-text-left uk-height-medium">
            <div uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100"  style="overflow-y:auto" data-simplebar>
                <div v-for="item in shoppingCart">
                    <div class="uk-grid align-items-center shoppingItem">
                        <div class="uk-flex uk-width-5-6 align-item-center justify-content-center">
                            <p class="uk-width-3-4 align-items-center uk-margin-remove">{{item.course.name}}</p>
                            <p class="uk-width-1-4 text-center">{{item.course.price_with_discount}}  <i class="fas fa-lira-sign icon-tiny"></i></p>
                        </div>
                        <div class="uk-width-1-6 text-left">
                            <i class="fas fa-trash-alt text-danger" @click="removeCourse(item.course_id, item.course_type)"></i>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
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

        },
        computed:{
            ...mapState([
                'shoppingCart'
            ])
        },
        methods:{
            ...mapActions([
               'loadShoppingCart'
            ]),
            removeAll:function () {
                for(var course in this.shoppingCart){
                    this.removeCourse(course.course_id, course.course_type);
                }
            },
            removeCourse:function (courseId, moduleName) {
                Axios.post('/api/basket/delete',{
                    course_id:courseId,
                    module_name:moduleName,
                    user_id:this.userId,
                })
                .then(response=>{
                    console.log(response);
                    this.$store.dispatch('loadShoppingCart', this.userId)
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
        height: 75px;
    }
    .shoppingImg{

    }
</style>
