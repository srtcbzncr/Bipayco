<template>
    <div class="uk-container uk-margin-large-top">
        <div v-if="purchaseHistory.data&&purchaseHistory.data.length>0" v-for="(purchase, index) in purchaseHistory.data" class="uk-margin">
            <div class="uk-card uk-card-default border-radius-6 uk-card-small uk-margin-remove uk-grid uk-grid-collapse">
                <a :class="{'uk-width-5-6@s':purchase.course.isRebate, 'uk-width':!(purchase.course.isRebate)}" class=" uk-padding-small card-link" :href="'/'+convertModule(purchase.course.course_type)+'/course/'+purchase.course.id">
                    <div class="uk-flex uk-flex-wrap align-items-center">
                        <div class="uk-card-media-left uk-cover-container uk-width-1-4@s">
                            <img :src="purchase.course.image" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas>
                        </div>
                        <div class="uk-width-3-4@s">
                            <div class="uk-card-body">
                                <div class="uk-card-title">
                                    <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 25px; max-height: 25px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;" class="uk-margin-remove">{{purchase.course.name}}</h4>
                                    <stars-rating :rating="purchase.course.point"></stars-rating>
                                </div>
                                <hr class="uk-margin-remove">
                                <h6 class="uk-margin-small">{{purchaseDate}}: {{new Date(purchase.created_at).toLocaleDateString()}}</h6>
                                <div class="uk-float-right uk-flex text-center  ">
                                    <h5 class="uk-margin-remove">
                                        {{purchase.price}}
                                        <i class="fas fa-lira-sign icon-tiny"></i>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <div v-if="purchase.course.isRebate" class="uk-width-1-6@s uk-padding-small auto-border uk-flex uk-flex-center">
                    <button class="uk-button uk-button-link  text-danger" @click="openModal(index)">{{createRefundRequestText}}</button>
                </div>
            </div>
        </div>
        <ul v-if="purchaseHistory.data&&purchaseHistory.data.length>0" class="uk-pagination uk-flex-center uk-margin-medium admin-content-inner uk-margin-remove-top uk-padding-remove">
            <li>
                <button v-show="purchaseHistory.current_page>1" @click="loadNewPage(purchaseHistory.prev_page_url)"> < </button>
            </li>
            <li v-for="page in pageNumber">
                <button class="uk-disabled" v-if="page=='...'">{{page}}</button>
                <button v-else-if="page==purchaseHistory.current_page" class="uk-background-default uk-disabled" @click="loadNewPage('/api/purchases/'+this.userId+'?page='+page)">{{page}}</button>
                <button v-else @click="loadNewPage('/api/purchases/'+this.userId+'?page='+page)">{{page}}</button>
            </li>
            <li>
                <button v-show="purchaseHistory.current_page<purchaseHistory.last_page" @click="loadNewPage(purchaseHistory.next_page_url)"> > </button>
            </li>
        </ul>
        <div v-else class="uk-flex align-items-center justify-content-center">
            <h2>{{noContentText}}</h2>
        </div>
        <div id="reason" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">{{refundReasonText}}</h2>
                </div>
                <div class="uk-modal-body" uk-overflow-auto>
                    <div class="uk-form-label">{{refundReasonText}}</div>
                    <input v-model="reason" required class="uk-input" type="text">
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" @click="clearForm" type="button">{{cancelText}}</button>
                    <button class="uk-button uk-button-primary" @click="sendRefundRequest" type="button">{{doRefundText}}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {mapState, mapActions} from 'vuex';
    export default {
        name: "purchase-history-page",
        data(){
            return{
                reason:"",
                selectedPageUrl:"/api/purchases/"+this.userId,
                selectedIndex:0,
            }
        },
        props:{
            userId:{
                type:String,
                required:true,
            },
            purchaseDate:{
                type:String,
                default:'Satın Alım Tarihi'
            },
            noContentText:{
                type:String,
                default:"Kayıt Bulunamadı"
            },
            refundReasonText:{
                type:String,
                default:"İade Sebebi",
            },
            refundText:{
                type:String,
                default:"İade",
            },
            doRefundText:{
                type:String,
                default:"İade Et",
            },
            cancelText:{
                type:String,
                default:"Vazgeç",
            },
            createRefundRequestText:{
                type:String,
                default:"İade Talebi Oluştur"
            }
        },
        computed:{
            ...mapState([
                'purchaseHistory'
            ]),
            pageNumber(){
                var pages=['1'];
                var index=2;
                for(var i=2; index<=this.purchaseHistory.last_page; i++){
                    if(i==2 && this.purchaseHistory.current_page-2>3){
                        pages.push('...');
                        if(this.purchaseHistory.current_page+3>this.purchaseHistory.last_page){
                            index=this.purchaseHistory.last_page-6;
                        }else{
                            index=this.purchaseHistory.current_page-2;
                        }
                    }else if(i==8 && this.purchaseHistory.current_page+2<this.purchaseHistory.last_page-2){
                        pages.push('...');
                        index=this.purchaseHistory.last_page;
                    }else{
                        pages.push(index);
                        index++;
                    }
                }
                return pages;
            },
            selectedPurchase(){
                return this.purchaseHistory.data[this.selectedIndex];
            }
        },
        methods:{
            ...mapActions([
                'loadMyCourses',
                'loadPurchaseHistory',
                'loadPurchaseHistoryNewPage'
            ]),
            openModal:function (index) {
                UIkit.modal('#reason', {escClose:false, bgClose:false}).show();
                this.selectedIndex=index;
            },
            sendRefundRequest:function () {
                Axios.post('/api/rebateCourse',{message:this.reason, purchases_id:this.selectedPurchase.id, student_id:this.selectedPurchase.student_id,  course_id:this.selectedPurchase.course.id, course_type:this.selectedPurchase.course.course_type, user_id:this.userId})
                    .then((res)=>{
                        if(res.data.error){
                            UIkit.notification({message:res.data.message, status: 'danger'});
                        }else{
                            UIkit.notification({message:res.data.message, status: 'success'});
                        }
                    });
                this.$store.dispatch('loadMyCourses', this.userId);
                this.$store.dispatch('loadPurchaseHistoryNewPage', this.selectedPageUrl);
                UIkit.modal('#reason').hide();
                this.clearForm();
            },
            clearForm:function(){
                this.reason="";
            },
            loadNewPage: function(name){
                this.selectedPageUrl=name;
                this.$store.dispatch('loadPurchaseHistoryNewPage',name);
                this.selectedIndex=0;
            },
            convertModule:function (moduleName) {
                switch (moduleName) {
                    case "generalEducation":return "ge";
                    case "prepareLessons":return "pl";
                    case "prepareExams":return "pe";
                }
            }
        },
        created() {
            this.$store.dispatch('loadPurchaseHistory', this.userId);
        }
    }
</script>

<style scoped>
    .auto-border{
        border-top: 1px solid #dee2e6;
    }

    @media (min-width: 640px){
        .auto-border{
            border-top:none;
            border-left: 1px solid #dee2e6 !important;
        }
    }
</style>
