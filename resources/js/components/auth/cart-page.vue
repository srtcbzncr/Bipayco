<template>
    <div>
        <div class="uk-background-default border-radius-6 uk-padding uk-width">
            <div class="uk-flex uk-flex-wrap align-item-center justify-content-around">
                <h2 class="uk-margin-remove">Toplam Tutar: {{cartAmount}} <i class="fas fa-lira-sign icon-small"></i></h2>
                <button class="uk-button uk-width-1-4@s uk-button-success" @click="buyAll">Satın Al</button>
            </div>
        </div>
        <hr>
        <h3> Sepetteki Ürünler </h3>
        <div v-for="item in shoppingCart">
            <cart-element
                :course="item.course"
                :user-id="userId"
                :moduleName="item.course_type"
            ></cart-element>
        </div>
        <div v-if="shoppingCart.length<=0" class="uk-flex align-items-center justify-content-center">
            <h2>{{noContentText}}</h2>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex'
    import Axios from 'axios'
    import CartElement from "../cart-element";

    export default {
        name: "cart-page",
        components: {CartElement},
        props: {
            userId: {
                type: String,
                required: true,
            },
            removeAllText: {
                type: String,
                default: "Hepsini Temizle"
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmamaktadır"
            }
        },
        computed: {
            ...mapState([
                'shoppingCart'
            ]),
            cartAmount(){
                var amount=0;
                for(var i=0;i<this.shoppingCart.length;i++){
                    amount+=this.shoppingCart[i].course.price_with_discount;
                }
                return amount;
            }
        },
        methods: {
            ...mapActions([
                'loadShoppingCart',
                'loadCourseCard',
            ]),
            removeAll: function () {
                Axios.post('/api/basket/deleteAll/' + this.userId)
                    .then(response => {
                        this.$store.dispatch('loadShoppingCart', this.userId);
                        this.$store.dispatch('loadCourseCard');
                    })
            },
            buyAll:function(){
                Axios.post('/api/basket/buy/'+this.userId, {'userId':this.userId, 'cart':this.shoppingCart})
                    .then(response=>{
                        if(!response.data.error){
                            UIkit.notification({message:'Satın Alım Başarıyla Gerçekleşti.', status:'success'})
                        }else{
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }
                        this.$store.dispatch('loadShoppingCart', this.userId);
                    });
            },
        },
        created() {
            this.$store.dispatch('loadShoppingCart', this.userId);
        }
    }
</script>

<style scoped>

</style>
