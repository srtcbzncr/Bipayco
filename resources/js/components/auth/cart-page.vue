<template>
    <div uk-grid>
        <div class="uk-width-1-4@m">
            <div  uk-sticky="offset: 90; bottom: true; media: @m;">
                <div class="uk-card uk-padding-remove-bottom uk-card-default border-radius-6 uk-card uk-padding-small  uk-box-shadow-medium">
                    <ul class="uk-list uk-list-divider uk-margin-remove-bottom uk-text-small" style="margin: -15px;">
                        <li class="uk-padding-small uk-margin-remove uk-flex align-item-center justify-content-center">
                            <div>
                                <p class="uk-margin-remove">Toplam Tutar: <span>{{cartAmount}}<i class="fas fa-lira-sign icon-small"></i></span></p>
                                <p class="uk-margin-remove">İndirim (%25): <span>-{{cartAmount}}<i class="fas fa-lira-sign icon-small"></i></span></p>
                                <hr class="uk-width">
                                <h5 class="uk-margin-remove">Ödenecek Tutar: <span>{{cartAmount}}<i class="fas fa-lira-sign icon-small"></i></span></h5>
                            </div>
                        </li>
                        <li class="uk-padding-remove">
                            <button class="uk-button uk-width uk-button-success" @click="buyAll">Satın Al</button>
                        </li>
                    </ul>
                </div>
                <div class="uk-card uk-margin-top uk-padding-remove-bottom uk-card-default border-radius-6 uk-card uk-padding-small  uk-box-shadow-medium">
                    <ul class="uk-list uk-list-divider uk-margin-remove-bottom uk-text-small" style="margin: -15px;">
                        <li>
                            <div class="uk-padding-small text-left">
                                <div class="uk-form-label uk-margin-remove">İndirim kodu</div>
                                <input class="uk-input uk-width uk-margin-small">
                            </div>
                        </li>
                        <li class="uk-padding-remove">
                            <button class="uk-button uk-width uk-button-primary" @click="buyAll">Uygula</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-width-3-4@m">
            <div>
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
    .uk-list-divider > li:nth-child(n+2){
        margin-top:0;
        padding-top:15px;
    }
</style>
