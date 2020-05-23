<template>
    <li>
        <a href="#"><i style="color: #424242" class="fas fa-bell icon-medium" :uk-tooltip="'title:'+notificationsText+' ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up'"> </i><span style="margin-left:-5px" class="float-right uk-margin-bottom"><i class=" fas fa-circle text-danger icon-tiny"></i></span></a>
        <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-small border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
            <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> {{notificationsText}} </h5>
            <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas fa-trash uk-align-right   uk-text-small uk-padding-small"> {{removeAllText}}</i></a>
            <hr class=" uk-margin-remove">
            <div class="uk-text-left uk-height-medium">
                <div data-simplebar style="overflow-y:auto">
                    <div class="uk-padding-small"  uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100">
                        <div>
                            <div class="uk-flex-middle uk-grid-small" uk-grid>
                                <div class="uk-width-5-6">
                                    <p> selam naber naılsın deneme yanılma yazıları bunlar neasıl şeyler de yazılarım var dfsdf selam naber naılsın deneme yanılma yazıları bunlar neasıl şeyler de yazılarım var dfsdf</p>
                                </div>
                                <div class="uk-width-1-6 uk-flex flex-column align-items-center justify-content-around">
                                    <a><i class="text-success fas fa-check icon-medium uk-margin-small-top uk-margin-small-bottom"></i></a>
                                    <a><i class="text-danger fas fa-times icon-medium uk-margin-small-top uk-margin-small-bottom"></i></a>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
    import Axios from 'axios';
    export default {
        name: "notification-card",
        data(){
            return{

            }
        },
        props:{
            userId:{
              type:String,
              required:true,
            },
            notificationsText:{
                type:String,
                default:"Bildirimler"
            },
            removeAllText:{
                type:String,
                default: "Hepsini Kaldır"
            }
        },
        computed:{

        },
        methods:{

        },
        created() {

        }
    }
</script>

<style scoped>

</style>
