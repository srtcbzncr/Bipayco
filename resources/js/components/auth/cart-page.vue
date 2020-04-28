<template>
    <div>
        <div v-for="item in shoppingCart">
            <cart-element
                :course="item.course"
                :user-id="userId"
                :moduleName="item.course_type"
            ></cart-element>
        </div>
        <hr>
        <div class="uk-flex align-item-center justify-content-around">
            <h3 class="uk-margin-remove">Toplam: {{cartAmount}} <i class="fas fa-lira-sign icon-tiny"></i></h3>
            <button class="uk-button uk-button-success" @click="buyAll"> Satın Al</button>
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
                    .then(response=>console.log(response));
            },
        },
        created() {
            this.$store.dispatch('loadShoppingCart', this.userId);
        }
    }
</script>

<style scoped>

</style>
