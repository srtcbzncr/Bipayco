<template>
    <div uk-grid>
        <div class="uk-width-1-4@m">
            <div  uk-sticky="offset: 90; bottom: true; media: @m;">
                <div class="uk-card uk-padding-remove-bottom uk-card-default border-radius-6 uk-card uk-padding-small  uk-box-shadow-medium">
                    <ul class="uk-list uk-list-divider uk-margin-remove-bottom uk-text-small" style="margin: -15px;">
                        <li class="uk-padding-small uk-margin-remove uk-flex align-item-center justify-content-center">
                            <div>
                                <p class="uk-margin-remove">{{totalAmountText}}: <span>{{cartAmount}}<i class="fas fa-lira-sign icon-tiny"></i></span></p>
                                <p class="uk-margin-remove" v-if="usedCoupon">{{discountText}} (%25): <span>-{{discount}}<i class="fas fa-lira-sign icon-tiny"></i></span></p>
                                <hr class="uk-width">
                                <h5 class="uk-margin-remove">{{willPayAmountText}}: <span>{{payAmount}}<i class="fas fa-lira-sign icon-small"></i></span></h5>
                            </div>
                        </li>
                        <li class="uk-padding-remove">
                            <button class="uk-button uk-width uk-button-success" @click="buyAll">{{buyText}}</button>
                        </li>
                    </ul>
                </div>
                <div class="uk-card uk-margin-top uk-padding-remove-bottom uk-card-default border-radius-6 uk-card uk-padding-small  uk-box-shadow-medium">
                    <ul class="uk-list uk-list-divider uk-margin-remove-bottom uk-text-small" style="margin: -15px;">
                        <li>
                            <div class="uk-padding-small text-left">
                                <div class="uk-form-label uk-margin-remove">{{discountCouponText}}</div>
                                <input v-model="couponCode" class="uk-input uk-width uk-margin-small">
                            </div>
                        </li>
                        <li class="uk-padding-remove">
                            <button class="uk-button uk-width uk-button-primary" @click="couponControl">{{applyText}}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-width-3-4@m">
            <div>
                <h3> {{courseInCartText}} </h3>
                <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                    <div class="loader"></div>
                </div>
                <div v-else-if="shoppingCart.length>0" v-for="item in shoppingCart">
                    <cart-element
                        :course="item.course"
                        :user-id="userId"
                        :moduleName="item.course_type"
                    ></cart-element>
                </div>
                <div v-else class="uk-flex align-items-center justify-content-center">
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
        data(){
            return{
                rawHtml:"",
                isLoaded:false,
                usedCoupon:false,
                discountPercent:25,
                couponCode:"",
                coupon:null,
            }
        },
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
            },
            applyText:{
                type:String,
                default:"Uygula"
            },
            buyText:{
                type:String,
                default:"Satın Al"
            },
            willPayAmountText:{
                type:String,
                default:"Ödenecek Tutar"
            },
            discountText:{
                type:String,
                default:"İndirim"
            },
            discountCouponText:{
                type:String,
                default:"İndirim Kuponu"
            },
            totalAmountText:{
                type:String,
                default:"Toplam Tutar"
            },
            courseInCartText:{
                type:String,
                default:"Sepetteki Kurslar"
            },
            identityNumberText:{
                type:String,
                default:"Kimlik Numarası"
            },
            countryText:{
                type:String,
                default:"Ülke"
            },
            cityText:{
                type:String,
                default:"Şehir"
            },
            zipCodeText:{
                type:String,
                default:"Posta Kodu"
            },
            nameText:{
                type:String,
                default:"Ad"
            },
            surnameText:{
                type:String,
                default:"Soyad"
            },
            phoneNumberText:{
                type:String,
                default:"Telefon Numarası"
            },
            emailText:{
                type:String,
                default:"Eposta"
            },
            addressText:{
                type:String,
                default:"Adres"
            },
            skipCheckoutText:{
                type:String,
                default:"Ödeme Aşamasına Geç"
            },
            invoiceInfoRoute:{
                type:String,
                required:true,
            }
        },
        computed: {
            ...mapState([
                'shoppingCart',
                'loadingStatus'
            ]),
            cartAmount(){
                var amount=0;
                for(var i=0;i<this.shoppingCart.length;i++){
                    amount+=this.shoppingCart[i].course.price_with_discount;
                }
                return amount.toFixed(2);
            },
            payAmount(){
                return (this.cartAmount-this.discount).toFixed(2);
            },
            discount(){
                if(this.usedCoupon){
                    return (this.cartAmount*this.discountPercent/100).toFixed(2);
                }else{
                    return 0;
                }
            },
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
                window.location.replace(this.invoiceInfoRoute+'?user_id='+this.userId+'&coupon='+this.coupon);
            },
            couponControl:function () {
                Axios.get('/api/basket/referenceControl/'+this.userId+'/'+this.couponCode)
                .then((res)=>{
                    this.usedCoupon=res.data.data;
                    if(!res.data.data){
                        UIkit.notification({message:"Hatalı Bir Kod Girdiniz", status: 'danger'});
                        this.coupon=null;
                    }else{
                        this.coupon=this.couponCode;
                    }
                }).catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
            }
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

    textarea{
        resize:none;
    }
</style>
