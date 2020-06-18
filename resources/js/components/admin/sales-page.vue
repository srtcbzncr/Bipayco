<template>
    <div class="uk-margin-medium-top">
        <div class="uk-child-width-1-3@m uk-card-body uk-grid-small uk-grid-divider uk-grid-match" uk-grid>
            <div class="text-center">
                <h3 class="stats-card-title uk-card-title">{{monthlyText}}</h3>
                <p>{{purchaseAsDate.total_month_purchase}} <span class="fas fa-lira-sign icon-tiny"></span></p>
            </div>
            <div class="text-center">
                <h3 class="stats-card-title uk-card-title">{{yearlyText}}</h3>
                <p>{{purchaseAsDate.total_year_purchase}} <span class="fas fa-lira-sign icon-tiny"></span></p>
            </div>
            <div class="text-center">
                <h3 class="stats-card-title uk-card-title">{{totalText}}</h3>
                <p>{{purchaseAsDate.total_purchase}} <span class="fas fa-lira-sign icon-tiny"></span></p>
            </div>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
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
                <button v-else-if="page==adminSales.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/purchase/getPurchases/'+this.userId+'?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/purchase/getPurchases/'+this.userId+'?page='+page)">{{page}}</button>
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
                    <div class="uk-flex align-items-center justify-content-center uk-margin-small-bottom">
                        <img :src="selectedSale.user.avatar" class="uk-height-small uk-width-small uk-border-circle">
                    </div>
                    <div class="uk-form-label">{{nameText}}</div>
                    <h6>{{selectedSale.user.first_name}} {{selectedSale.user.last_name}}</h6>
                    <hr>
<!--                    <div class="uk-form-label">{{usernameText}}</div>-->
<!--                    <h6>{{selectedSale.user.username}}</h6>-->
<!--                    <hr>-->
<!--                    <div class="uk-form-label">{{emailText}}</div>-->
<!--                    <h6>{{selectedSale.user.email}}</h6>-->
<!--                    <hr>-->
<!--                    <div class="uk-form-label">{{phoneText}}</div>-->
<!--                    <h6>{{selectedSale.user.phone_number}}</h6>-->
<!--                    <hr>-->
<!--                    <div class="uk-form-label">{{referenceCodeText}}</div>-->
<!--                    <h6>{{selectedSale.reference_code}}</h6>-->
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
        },
        watch:{
            selectedSale(){
                return this.selectedSale;
            }
        },
        computed:{
            ...mapState([
                'adminSales',
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
                selectedSale=null;
            },
            openInfo:function (id) {
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
