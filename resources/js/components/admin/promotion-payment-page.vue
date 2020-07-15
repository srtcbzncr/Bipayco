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
                <tr v-for="item in adminPromotionPayments.data">
                    <td class="uk-width-1-2 clickable" @click="openInfo(item.id)"><p>{{item.user.first_name}} {{item.user.last_name}}</p></td>
                    <td class="uk-width-1-4 clickable" @click="openInfo(item.id)"><p>{{item.fee.toFixed(2)}} <span class="fas fa-lira-sign icon-tiny"></span></p> </td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-around">
                        <a @click="paidPost(item.id)" :uk-tooltip="markAsPaidText"><i class="fas fa-file-invoice-dollar"></i></a>
                        <a @click="openDetail(item.id)" :uk-tooltip="seeMoreDetailText"><i class="fas fa-arrow-alt-circle-right"></i></a>
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
                <button v-else-if="page==adminPromotionPayments.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/admin/purchase/getInstructorsEarnByReferenceCode/'+this.userId+'?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/admin/purchase/getInstructorsEarnByReferenceCode/'+this.userId+'?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="adminPromotionPayments.current_page<adminPromotionPayments.last_page" @click="loadNewPage(adminPromotionPayments.next_page_url)"> > </button>
            </li>
        </ul>
        <div id="selectedInfoArea" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{instructorInfoText}}</h2>
                </div>
                <div class="uk-modal-body" v-if="selected!=null" uk-overflow-auto>
                    <div class="uk-flex align-items-center justify-content-center uk-margin-small-bottom">
                        <img :src="selected.user.avatar" class="uk-height-small uk-width-small uk-border-circle">
                    </div>
                    <div class="uk-form-label">{{nameText}}</div>
                    <h6>{{selected.user.first_name}} {{selected.user.last_name}}</h6>
                    <hr>
                    <div class="uk-form-label">{{identificationNumberText}}</div>
                    <h6>{{selected.identification_number}}</h6>
                    <hr>
                    <div class="uk-form-label">{{ibanText}}</div>
                    <h6>{{selected.iban}}</h6>
                    <hr>
                    <div class="uk-form-label">{{emailText}}</div>
                    <h6>{{selected.user.email}}</h6>
                    <hr>
                    <div class="uk-form-label">{{phoneText}}</div>
                    <h6>{{selected.user.phone_number}}</h6>
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
                selected:null,
                selectedPage:"/api/admin/purchase/getInstructorsEarnByReferenceCode/"+this.userId+"?page=1",
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
            nameText: {
                type: String,
                default: "Adı"
            },
            amountToBePaidText: {
                type: String,
                default: "Ödenecek Tutar"
            },
            ibanText: {
                type: String,
                default: "Iban"
            },
            markAsPaidText:{
                type:String,
                default:"Ödendi Olarak İşaretle",
            },
            seeMoreDetailText:{
                type:String,
                default:"Daha Fazla Detay Gör"
            },
            phoneText:{
                type:String,
                default:"Telefon"
            },
            emailText:{
                type:String,
                default:"Eposta"
            },
            instructorInfoText:{
                type:String,
                default:"Eğitmen Bilgisi"
            },
            identificationNumberText:{
                type:String,
                default:"Kimlik Numarası",
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
                this.selectedPage=name;
                this.selected=null;
                this.$store.dispatch('loadAdminNewPage',[name, 'setAdminPromotionPayments']);
            },
            openDetail:function (id) {
                window.location.replace('/admin/purchase_detail/'+id);
            },
            openInfo:function(id){
                Axios.get('/api/admin/auth/instructor/get/'+id)
                    .then((res)=>{this.selected=res.data.data});
                UIkit.modal('#selectedInfoArea').show();
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
                    }).catch((error)=>{
                    if(error.response) {
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }});

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

