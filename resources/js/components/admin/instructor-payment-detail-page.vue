<template>
    <div class="uk-margin-large-top">
        <div class="text-left">
            <a  @click="routePromotionPayment" class="uk-flex align-item-center">
                <i class="fas fa-arrow-alt-circle-left icon-medium uk-margin-small-right"></i>
                <h6 class="uk-margin-remove">{{backText}}</h6>
            </a>
        </div>
        <div>
            <div class="uk-flex align-items-center justify-content-center uk-margin-medium-bottom">
                <img :src="selectedInstructor.user.avatar" class="uk-height-small uk-width-small uk-border-circle">
            </div>
        </div>
        <div class="uk-child-width-1-2@m uk-grid-divider uk-padding-small uk-padding-remove-vertical" uk-grid>
            <div>
                <div class="uk-form-label">{{nameText}}</div>
                <h6>{{selectedInstructor.user.first_name}} {{selectedInstructor.user.last_name}}</h6>
            </div>
            <div>
                <div class="uk-form-label">{{ibanText}}</div>
                <h6>{{selectedInstructor.iban}}</h6>
            </div>
        </div>
        <hr>
        <div class="uk-child-width-1-2@m uk-grid-divider uk-padding-small uk-padding-remove-vertical" uk-grid>
            <div>
                <div class="uk-form-label">{{emailText}}</div>
                <h6>{{selectedInstructor.user.email}}</h6>
            </div>
            <div>
                <div class="uk-form-label">{{phoneText}}</div>
                <h6>{{selectedInstructor.user.phone_number}}</h6>
            </div>
        </div>
        <hr>
        <div class="uk-child-width-1-2@m uk-grid-divider uk-padding-small uk-padding-remove-vertical" uk-grid>
            <div>
                <div class="uk-form-label">{{identificationNumberText}}</div>
                <h6>{{selectedInstructor.identification_number}}</h6>
            </div>
            <div>
                <div class="uk-form-label">{{totalCommissionAmountText}}</div>
                <h6>{{selectedInstructor.user.phone_number}} <span class="fas fa-lira-sign icon-tiny"></span></h6>
            </div>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-medium-top border-radius-6">
            <div v-if="!loadingStatus" class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <div class="loader"></div>
            </div>
            <table v-else id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="adminPromotionPurchaseDetail.data&&adminPromotionPurchaseDetail.data.length>0">
                <tr>
                    <th>{{productNameText}}</th>
                    <th>{{productPriceText}}</th>
                    <th>{{instructorCommissionText}}</th>
                </tr>
                </thead>
                <tbody v-if="adminPromotionPurchaseDetail.data&&adminPromotionPurchaseDetail.data.length>0">
                <tr v-for="item in adminPromotionPurchaseDetail.data">
                    <td class="uk-width-1-2"><p>{{item.course.name}}</p></td>
                    <td class="uk-width-1-2"><p>{{item.course.price_with_discount}} <span class="fas fa-lira-sign icon-tiny"></span></p></td>
                    <td class="uk-width-1-4"><p>{{item.fee}} <span class="fas fa-lira-sign icon-tiny"></span></p></td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
        <ul v-if="adminPromotionPurchaseDetail.data&&adminPromotionPurchaseDetail.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="adminPromotionPurchaseDetail.current_page>1" @click="loadNewPage(adminPromotionPurchaseDetail.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==adminPromotionPurchaseDetail.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/purchase/getInstructorsEarnByReferenceCode/'+this.userId+'/'+this.selectedInstructor.id+'?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/purchase/getInstructorsEarnByReferenceCode/'+this.userId+'/'+this.selectedInstructor.id+'?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminPromotionPurchaseDetail.current_page<adminPromotionPurchaseDetail.last_page" @click="loadNewPage(adminPromotionPurchaseDetail.next_page_url)"> > </button>
            </li>
        </ul>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "instructor-payment-detail-page",
        data(){
            return{
                selectedPage:'/api/admin/purchase/getInstructorEarnByReferenceCode/'+this.userId+'/'+this.selectedInstructor.id+'?page=1',
                selectedPurchase:null
            }
        },
        props:{
            promotionPaymentRoute:{
                type:String,
                required:true,
            },
            selectedInstructor:{
                type:Object,
                required:true,
            },
            userId:{
                type:String,
                required:true,
            },
            ibanText:{
                type:String,
                default:"Iban"
            },
            productNameText:{
                type:String,
                default:"Ürün Adı"
            },
            productPriceText:{
                type:String,
                default:"Ürün Fiyatı"
            },
            instructorCommissionText:{
                type:String,
                default:"Eğitmen Komisyonu"
            },
            phoneText:{
                type:String,
                default:"Telefon",
            },
            emailText:{
                type:String,
                default:"Eposta"
            },
            nameText:{
                type:String,
                default:"Ad",
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmuyor"
            },
            backText:{
                type:String,
                default:"Geri"
            },
            identificationNumberText:{
                type:String,
                default:"Kimlik Numarası"
            },
            totalCommissionAmountText:{
                type:String,
                default:"Toplam Komisyon Tutarı"
            },
        },
        computed:{
            ...mapState([
                'adminPromotionPurchaseDetail',
                'loadingStatus'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.adminPromotionPurchaseDetail.last_page; i++){
                    if(i==2 && this.adminPromotionPurchaseDetail.current_page-2>3){
                        pages.push('...');
                        if(this.adminPromotionPurchaseDetail.current_page+3>this.adminPromotionPurchaseDetail.last_page){
                            index=this.adminPromotionPurchaseDetail.last_page-6;
                        }else{
                            index=this.adminPromotionPurchaseDetail.current_page-2;
                        }
                    }else if(i==8 && this.adminPromotionPurchaseDetail.current_page+2<this.adminPromotionPurchaseDetail.last_page-2){
                        pages.push('...');
                        index=this.adminPromotionPurchaseDetail.last_page;
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
                'loadAdminPromotionPurchaseDetail',
                'loadAdminNewPage'
            ]),
            routePromotionPayment:function () {
                window.location.replace(this.promotionPaymentRoute);
            },
            loadNewPage: function(name){
                this.selectedPage=name;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminPromotionPurchaseDetail']);
            }
        },
        created() {
            this.$store.dispatch('loadAdminPromotionPurchaseDetail', [this.userId, this.selectedInstructor.id]);
        }
    }
</script>

<style scoped>

</style>
