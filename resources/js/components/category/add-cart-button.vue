<template>
    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-auto">
            <a v-if="!isLogin" :href="loginRoute" class="uk-button uk-button-white uk-float-left"> {{addCartText}}</a>
            <button v-else-if="isInCart" @click="removeCart" class="uk-button uk-button-white uk-float-left"> {{removeCartText}}</button>
            <button v-else @click="addCart" class="uk-button uk-button-white uk-float-left"> {{addCartText}}</button>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from "vuex";
    import Axios from "axios";

    export default {
        name: "add-cart-button",
        props:{
            loginRoute:{
                type:String,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
            },
            module:{
                type:String,
                required:true
            },
            userId:{
                type:String,
                default:""
            },
            courseId:{
                type:String,
                required:true,
            },
            isLogin:{
                type:Boolean,
                default:false,
            },
            addCartText:{
                type:String,
                default:"Sepete Ekle"
            },
            removeCartText:{
                type:String,
                default:"Sepetten Çıkar"
            },
        },
        computed:{
            ...mapState([
                'isInCart'
            ])
        },
        methods: {
            ...mapActions([
                'loadShoppingCart',
                'loadIsInCart'
            ]),
            addCart: function () {
                Axios.post('/api/basket/add', {
                    course_id: this.courseId,
                    module_name: this.moduleName,
                    user_id: this.userId,
                })
                    .then(response => {
                        this.$store.dispatch('loadShoppingCart', this.userId);
                        this.$store.dispatch('loadIsInCart', [this.module, this.userId, this.courseId]);
                    })
            },
            removeCart: function () {
                Axios.post('/api/basket/delete', {
                    course_id: this.courseId,
                    module_name: this.moduleName,
                    user_id: this.userId,
                })
                    .then(response => {
                        this.$store.dispatch('loadShoppingCart', this.userId);
                        this.$store.dispatch('loadIsInCart', [this.module, this.userId, this.courseId]);
                    })
            },
        },
        created() {
            if(this.isLogin){
                this.$store.dispatch('loadIsInCart', [this.module, this.userId, this.courseId])
            }
        }
    }
</script>

<style scoped>

</style>
