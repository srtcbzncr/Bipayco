<template>
    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-auto">
            <a v-if="!isLogin" :href="loginRoute" class="uk-button uk-button-white uk-float-left"> {{addCartText}}</a>
            <button v-else-if="cart" @click="removeCart" class="uk-button uk-button-white uk-float-left"> {{removeCartText}}</button>
            <button v-else @click="addCart" class="uk-button uk-button-white uk-float-left"> {{addCartText}}</button>
        </div>
    </div>
</template>

<script>
    import {mapActions} from "vuex";
    import Axios from "axios";

    export default {
        name: "add-cart-button",
        data(){
            return{
                cart:this.inCart,
            }
        },
        props:{
            loginRoute:{
                type:String,
                required:true,
            },
            moduleName:{
                type:String,
                required:true,
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
            inCart:{
                type:Boolean,
                default:false,
            }
        },
        methods: {
            ...mapActions([
                'loadShoppingCart'
            ]),
            addCart: function () {
                Axios.post('/api/basket/add', {
                    course_id: this.courseId,
                    module_name: this.moduleName,
                    user_id: this.userId,
                })
                    .then(response => {
                        if (!response.data.error) {
                            this.cart = true;
                        }
                        this.$store.dispatch('loadShoppingCart', this.userId);
                        console.log(response)
                    })
            },
            removeCart: function () {
                Axios.post('/api/basket/delete', {
                    course_id: this.courseId,
                    module_name: this.moduleName,
                    user_id: this.userId,
                })
                    .then(response => {
                        if (!response.data.error) {
                            this.cart = false;
                        }
                        this.$store.dispatch('loadShoppingCart', this.userId);
                        console.log(response)
                    })
            },
        }
    }
</script>

<style scoped>

</style>
