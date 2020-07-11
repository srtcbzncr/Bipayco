<template>
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminPromotionPayments.data&&adminPromotionPayments.data.length>0">
                <tr>
                    <th>{{nameText}}</th>
                    <th>{{amountToBePaidText}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="adminPromotionPayments.data&&adminPromotionPayments.data.length>0">
                <tr v-for="item in adminPromotionPayments.data"  @click="openInfo(item.id)">
                    <td class="uk-width-1-2 clickable"><p>{{item.user.first_name}} {{item.user.last_name}}</p></td>
                    <td class="uk-width-1-4 clickable"><p>{{item.fee}} <span class="fas fa-lira-sign icon-tiny"></span></p> </td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
                        <a @click="paidPost(item.id)" :uk-tooltip="paidText"><i class="fas fa-file-invoice-dollar"></i></a>
                    </td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="adminPromotionPayments.data&&adminPromotionPayments.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminPromotionPayments.current_page>1" @click="loadNewPage(adminPromotionPayments.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminPromotionPayments.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/purchase/getPurchases/'+this.userId+'?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/purchase/getPurchases/'+this.userId+'?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminPromotionPayments.current_page<adminPromotionPayments.last_page" @click="loadNewPage(adminPromotionPayments.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="saleInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{saleInfoText}}</h2>
                </div>
                <div class="uk-modal-body" v-if="selected!=null" uk-overflow-auto>
                    <div class="uk-flex align-items-center justify-content-center uk-margin-small-bottom">
                        <img :src="selected.instructor.user.avatar" class="uk-height-small uk-width-small uk-border-circle">
                    </div>
                    <div class="uk-form-label">{{nameText}}</div>
                    <h6>{{selected.instructor.user.first_name}} {{selected.instructor.user.last_name}}</h6>
                    <hr>
                    <div class="uk-form-label">{{ibanText}}</div>
                    <h6>{{selected.instructor.iban}}</h6>
                    <hr>
                    <div class="uk-form-label">{{emailText}}</div>
                    <h6>{{selected.instructor.user.email}}</h6>
                    <hr>
                    <div class="uk-form-label">{{phoneText}}</div>
                    <h6>{{selected.instructor.user.phone_number}}</h6>
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
                                    <h5 class="uk-margin-remove-vertical uk-margin-remove-right" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{item.course.name}}</h5>
                                    <p>{{transactionIdText}}: {{item.paymentTransactionId}}</p>
                                    <p>{{transactionStatusText}}: {{item.transactionStatus}}</p>
                                    <p>{{transactionPriceText}}: {{item.paidPrice}} <span class="fas fa-lira-sign icon-tiny"></span></p>
                                    <p>{{iyzicoCommissionText}}: {{item.iyziCommissionFee}} <span class="fas fa-lira-sign icon-tiny"></span></p>
                                    <p>{{merchantPayoutAmountText}}: {{item.merchantPayoutAmount}} <span class="fas fa-lira-sign icon-tiny"></span></p>
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
        name: "promotion-payment-page",
        data(){
            return{
                purchaseAsDate:{},
                selected:null,
                selectedPage:"/api/admin/auth/student/show?page=1",
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
            amountToBePaidText: {
                type: String,
                default: "Ödenecek Tutar"
            },
            saleInfoText: {
                type: String,
                default: "Satış Bilgisi"
            },
            paymentStatusText: {
                type: String,
                default: "Ödeme Durumu"
            },
            paidText:{
                type:String,
                default:"Ödendi",
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
            }
        },
        watch:{
            selected(){
                return this.selected;
            }
        },
        computed:{
            ...mapState([
                'adminPromotionPayments',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminPromotionPayments.last_page; i++){
                    if(i==2 && this.adminPromotionPayments.current_page-2>3){
                        pages.push('...');
                        if(this.adminPromotionPayments.current_page+3>this.adminPromotionPayments.last_page){
                            index=this.adminPromotionPayments.last_page-6;
                        }else{
                            index=this.adminPromotionPayments.current_page-2;
                        }
                    }else if(i==8 && this.adminPromotionPayments.current_page+2<this.adminPromotionPayments.last_page-2){
                        pages.push('...');
                        index=this.adminPromotionPayments.last_page;
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
                'loadAdminPromotionPayments',
                'loadAdminNewPage'
            ]),
            loadNewPage: function(name){
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminSales']);
                this.selectedPage=name;
                this.selected=null;
            },
            openInfo:function (id) {
                Axios.get('/api/admin/purchase/getInstructorEarnByReferenceCode/'+this.userId+'/'+id)
                    .then((res)=>{this.selected=res.data.data});
                UIkit.modal('#saleInfoArea').show();
            },
            paidPost:function (id) {
                Axios.post('/api/admin/purchase/confirmInstructorPriceByReferenceCode/'+this.userId+'/'+id)
                    .then((response)=>{
                        if(response.data.error){
                            UIkit.notification({message:response.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:response.data.message, status: 'success'});
                            this.$store.dispatch('loadAdminNewPage',[this.selectedPage, 'setAdminPromotionPayments'])
                        }
                    })

            }
        },
        created() {
            this.$store.dispatch('loadAdminPromotionPayments', this.userId);
        },
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

