<template>
    <div class="uk-margin-medium-top">
        <div class="uk-child-width-1-3@m uk-card-body uk-grid-small uk-grid-divider uk-grid-match" uk-grid>
            <div class="text-center">
                <h3 class="stats-card-title uk-card-title">{{monthlyText}}</h3>
                <p>{{Number(purchaseAsDate.total_month_purchase).toFixed(2)}} <span class="fas fa-lira-sign icon-tiny"></span></p>
            </div>
            <div class="text-center">
                <h3 class="stats-card-title uk-card-title">{{yearlyText}}</h3>
                <p>{{Number(purchaseAsDate.total_year_purchase).toFixed(2)}} <span class="fas fa-lira-sign icon-tiny"></span></p>
            </div>
            <div class="text-center">
                <h3 class="stats-card-title uk-card-title">{{totalText}}</h3>
                <p>{{Number(purchaseAsDate.total_purchase).toFixed(2)}} <span class="fas fa-lira-sign icon-tiny"></span></p>
            </div>
        </div>
        <hr>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminSales.data&&adminSales.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th>{{paymentIdText}}</th>
                    <th>{{paymentStatusText}}</th>
                    <th>{{dateText}}</th>
                </tr>
                </thead>
                <tbody v-if="adminSales.data&&adminSales.data.length>0">
                <tr v-for="item in adminSales.data"  @click="openInfo(item.payment_id)">
                    <td class="uk-width-1-4 clickable"><p>{{item.user.first_name}} {{item.user.last_name}}</p></td>
                    <td class="uk-width-1-4 clickable"><p>{{item.payment_id}}</p></td>
                    <td class="uk-width-1-4 clickable"><p>{{item.payment_status}}</p></td>
                    <td class="uk-width-1-4 clickable"><p>{{new Date(item.updated_at).toLocaleDateString()}}</p></td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="adminSales.data&&adminSales.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminSales.current_page>1" @click="loadNewPage(adminSales.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminSales.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/purchase/getPurchases/'+userId+'?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/purchase/getPurchases/'+userId+'?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminSales.current_page<adminSales.last_page" @click="loadNewPage(adminSales.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="saleInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{saleInfoText}}</h2>
                </div>
                <div class="uk-modal-body" v-if="selectedSale!=null" uk-overflow-auto>
                    <!--<h5 class="text-primary" v-if="selectedSale.course.isRebate === true"><span class="fas fa-donate" :uk-tooltip="refundText"></span>  {{refundedText}}</h5>-->
                    <div class="uk-form-label">{{statusText}}</div>
                    <h6>{{selectedSale.status}}</h6>
                    <hr>
                    <div class="uk-form-label">{{iyzicoCommissionText}}</div>
                    <h6>{{selectedSale.iyziCommissionFee}} <span class="fas fa-lira-sign icon-tiny"></span></h6>
                    <hr>
                    <div class="uk-form-label">{{totalPriceText}}</div>
                    <h6>{{selectedSale.paidPrice}} <span class="fas fa-lira-sign icon-tiny"></span></h6>
                    <hr>
                    <div class="uk-form-label">{{productsText}}</div>
                    <div v-for="item in selectedSale.itemTransactions" class="uk-margin-small-bottom">
                        <div class="uk-grid align-items-center ">
                            <div class="uk-width uk-flex align-items-center">
                                <div class="uk-margin-small-left uk-card-media-left uk-cover-container uk-width-1-4">
                                    <img :src="item.course.image" alt="" uk-cover>
                                    <canvas width="600" height="400"></canvas>
                                </div>
                                <div class="uk-margin-left uk-width-3-4">
                                    <h5 class="uk-margin-remove-right text-primary" v-if="item.course.isRebate"><span class="fas fa-donate" :uk-tooltip="refundText"></span>  {{refundedText}}</h5>
                                    <h5 class="uk-margin-remove-vertical uk-margin-remove-right" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{item.course.name}}</h5>
                                    <p>{{transactionIdText}}: {{item.paymentTransactionId}}</p>
                                    <p>{{transactionStatusText}}: {{item.transactionStatus}}</p>
                                    <p>{{transactionPriceText}}: {{Number(item.paidPrice).toFixed(2)}} <span class="fas fa-lira-sign icon-tiny"></span></p>
                                    <p>{{iyzicoCommissionText}}: {{Number(item.iyziCommissionFee).toFixed(2)}} <span class="fas fa-lira-sign icon-tiny"></span></p>
                                    <p>{{merchantPayoutAmountText}}: {{Number(item.merchantPayoutAmount).toFixed(2)}} <span class="fas fa-lira-sign icon-tiny"></span></p>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="uk-modal-footer">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "sales-page",
        data(){
            return{
                purchaseAsDate:{},
                selectedSale:null,
            }
        },
        props: {
            userId:{
                type:String,
                required:true,
            },
            noContentText: {
                type: String,
                default: "İçerik Bulunmuyor"
            },
            monthlyText: {
                type: String,
                default: "Aylık"
            },
            yearlyText: {
                type: String,
                default: "Yıllık"
            },
            totalText: {
                type: String,
                default: "Toplam"
            },
            nameText: {
                type: String,
                default: "Adı"
            },
            paymentIdText: {
                type: String,
                default: "Ödeme ID"
            },
            saleInfoText: {
                type: String,
                default: "Satış Bilgisi"
            },
            paymentStatusText: {
                type: String,
                default: "Ödeme Durumu"
            },
            dateText: {
                type: String,
                default: "Tarih"
            },
            statusText:{
                type:String,
                default:"Durum",
            },
            iyzicoCommissionText:{
                type:String,
                default:"İyzico Komisyon Tutarı",
            },
            totalPriceText:{
                type:String,
                default:"Toplam Tutar"
            },
            transactionIdText:{
                type:String,
                default:"İşlem Numarası"
            },
            transactionStatusText:{
                type:String,
                default:"İşlem Durumu"
            },
            merchantPayoutAmountText:{
                type:String,
                default:"Satıcı Ödeme Tutarı"
            },
            transactionPriceText:{
                type:String,
                default:"İşlem Tutarı"
            },
            productsText:{
                type:String,
                default:"Ürünler"
            },
            refundText:{
                type:String,
                default:"İade"
            },
            refundedText:{
                type:String,
                default:"İade Edildi"
            }
        },
        watch:{
            selectedSale(){
                return this.selectedSale;
            }
        },
        computed:{
            ...mapState([
                'adminSales',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminSales.last_page; i++){
                    if(i==2 && this.adminSales.current_page-2>3){
                        pages.push('...');
                        if(this.adminSales.current_page+3>this.adminSales.last_page){
                            index=this.adminSales.last_page-6;
                        }else{
                            index=this.adminSales.current_page-2;
                        }
                    }else if(i==8 && this.adminSales.current_page+2<this.adminSales.last_page-2){
                        pages.push('...');
                        index=this.adminSales.last_page;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
        },
        methods:{
            ...mapActions([
                'loadAdminSales',
                'loadAdminNewPage'
            ]),
            loadNewPage: function(name){
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminSales']);
                this.selectedSale=null;
            },
            openInfo:function (id,) {
                Axios.get('/api/admin/purchase/getPurchaseDetail/'+id)
                    .then((res)=>{this.selectedSale=res.data.data});
                UIkit.modal('#saleInfoArea').show();
            },
        },
        created() {
            this.$store.dispatch('loadAdminSales', this.userId);
        },
        mounted() {
            Axios.get('/api/admin/purchase/getPurchasesAsDate/'+this.userId)
                .then((res)=>{this.purchaseAsDate=res.data.data});
        }
    }
</script>

<style scoped>
    h6{
        margin:0
    }

    .clickable{
        cursor: pointer;
    }

</style>
