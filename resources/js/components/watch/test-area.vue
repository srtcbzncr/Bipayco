<template>
    <div>
        <!--question area-->
        <div>
            <!--single choice-->
            <div>
                <!--image??-->
                <img src="#">
                <!--question-->
                <p>question</p>
                <div class="uk-margin-top uk-child-width-1-2@m uk-grid align-items-center">
                    <!--answers*-->
                    <div class="uk-flex align-items-center">
                        <input class="uk-radio uk-margin-small-right" type="radio">
                        <p>answer</p>
                    </div>
                </div>
            </div>
            <!--multi choice-->
            <div>
                <!--image??-->
                <img src="#">
                <!--question-->
                <p>question</p>
                <div class="uk-margin-top uk-child-width-1-2@m uk-grid align-items-center">
                    <!--answers*-->
                    <div class="uk-flex align-items-center">
                        <input class="uk-checkbox uk-margin-small-right" type="checkbox">
                        <p>answer</p>
                    </div>
                </div>
            </div>
            <!--fill in the blanks-->
            <div>
                <!--image??-->
                <img src="#">
                <div class="uk-flex uk-flex-wrap align-items-center">
                    <!--beginning of sentence-->
                    <p>beginning of sentence</p>
                    <!--blanks*
                        text*-->
                    <div>
                        <input class="uk-input uk-width-1-2">
                        <p>text</p>
                    </div>
                </div>
            </div>
            <!--true false-->
            <div>
                <!--image??-->
                <img src="#">
                <!--question-->
                <p>qustion</p>
                <!--select true or false-->
                <div class="uk-flex uk-width-1-2@m align-items-center justify-content-between">
                    <div>
                        <input class="uk-radio" name="">
                        <p>{{trueText}}</p>
                    </div>
                    <div>
                        <input class="uk-radio" name="">
                        <p>{{falseText}}</p>
                    </div>
                </div>
            </div>
            <!--order-->
            <div>
                <!--image??-->
                <img src="#">
                <!--question-->
                <p></p>
                <!--elements*-->
                <div class="tm-course-section-list">
                    <ul>
                        <li class="uk-card uk-card-default uk-padding-small uk-flex align-items-center justify-content-between">
                            <div class="uk-grid uk-margin-remove uk-padding-remove">
                                <p class="uk-text-truncate uk-margin-small-right uk-margin-remove-left uk-margin-remove-top uk-margin-remove-bottom">şık</p>
                            </div>
                            <div class="uk-margin-small-left uk-padding-remove uk-flex uk-flex-column uk-width-1-4">
                                <a @click="" v-if="true"><i class="fas fa-sort-up"></i></a>
                                <a @click="" v-if="true"><i class="fas fa-sort-down"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--match-->
            <div>
                <!--image??-->
                <!--question-->
                <!--elements*-->
                <div>
                    <!--first-->
                    <!--second-->
                </div>
            </div>
        </div>
        <div>
            <!--question paginate-->
        </div>
    </div>
</template>

<script>
    import {mapActions,mapState} from 'vuex'
    import Axios from 'axios'
    export default {
        name: "test-area",
        data(){
            return{

            }
        },
        props:{

        },
        computed:{
            ...mapState([

            ]),
        },
        methods:{
            ...mapActions([

            ]),
        },
        created(){

        },
    }
</script>

<style scoped>

</style>
