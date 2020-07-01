<template>
    <!--Mobile icon wiill close nav-side   -->
    <div id="side-nav">
        <div class="side-nav-bg"></div>
        <div class="uk-navbar-left uk-visible@s">
            <a class="" :href="homeRoute"> <img class="uk-logo" :src="logo"/> </a>
        </div>
            <ul>
                <li>
                    <a :uk-tooltip="'title:'+ generalEducationText +'; delay: 500 ; pos: right ;animation:	uk-animation-scale-up'"> <i class="fas fa-laptop-code icon-medium"> </i> </a>
                    <div class="side-menu-slide" style="overflow-y: auto">
                        <div class="side-menu-slide-content uk-width">
                            <a class="uk-background-grey uk-margin-remove general-title" style=":hover" :href="generalEducationRoute"><b>{{generalEducationText}}</b></a>
                            <ul uk-accordion>
                                <li v-for="category in categories" class=" uk-margin-remove-top">
                                    <a class="uk-accordion-title" :id="'category'+category.id"> <i class="fas" :class="category.symbol"> </i>{{category.name}}</a>
                                    <div class="uk-accordion-content uk-margin-remove-top">
                                        <a :href="'/ge/category/'+category.id">{{allOfCategory}}</a>
                                        <a v-for="subCategory in category.sub_categories.data" :href="'/ge/subCategory/'+subCategory.id" :id="'subCategory'+subCategory.id">
                                            <i class="fas" :class="subCategory.symbol"> </i>
                                            {{subCategory.name}}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            <li>
                <!-- scripts -->
                <a :uk-tooltip="'title:'+ prepareLessonsText +'; delay: 500 ; pos: right ;animation:	uk-animation-scale-up'"> <i class="fas fa-school icon-medium"/> </a>
                <div class="side-menu-slide" style="overflow-y: auto">
                    <div class="side-menu-slide-content">
                        <a class="uk-background-grey uk-margin-remove general-title" style=":hover" :href="prepareLessonsRoute"><b>{{prepareLessonsText}}</b></a>
                        <ul data-simplebar>
                            <li v-for="lesson in crLessons">
                                <a :href="'/pl/lessons/'+lesson.id" :id="'lesson'+lesson.id"> <i class="fas" :class="lesson.symbol"> </i>{{lesson.name}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <a :uk-tooltip="'title:'+ prepareExamsText +'; delay: 500 ; pos: right ;animation:	uk-animation-scale-up'"> <i class="fas fa-user-graduate icon-medium"></i> </a>
                <div class="side-menu-slide" style="overflow-y: auto">
                    <div class="side-menu-slide-content">
                        <a class="uk-background-grey uk-margin-remove general-title" style=":hover" :href="prepareExamsRoute"><b>{{prepareExamsText}}</b></a>
                        <ul data-simplebar>
                            <li v-for="exam in crExams">
                                <a :href="'/pe/exams/'+exam.id" :id="'exam'+exam.id"> <i class="fas" :class="exam.symbol"> </i>{{exam.name}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <a :href="liveRoute" class="active" :uk-tooltip="'title:'+ liveText +'; delay: 500 ; pos: right ;animation:	uk-animation-scale-up'"> <i class="fas fa-podcast icon-medium"></i> </a>
            </li>
<!--            <li>-->
<!--                &lt;!&ndash; ui compounents &ndash;&gt;-->
<!--                <a href="#" :uk-tooltip="'title:'+examsText +'; delay: 500 ; pos: right ;animation:	uk-animation-scale-up'"> <i class="fas fa-award icon-medium"></i> </a>-->

<!--            </li>-->
        </ul>
        <ul class="uk-position-bottom">
<!--            <li>-->
<!--                &lt;!&ndash; Lunch information box &ndash;&gt;-->
<!--                <a href="#" uk-tooltip="title: Lunch information box ; delay: 500 ; pos: right ;animation:	uk-animation-scale-up" uk-toggle="target: #infoBox; cls: infoBox-active"><i class="fas fa-question"></i> </a>-->
<!--            </li>-->
            <li>
                <!-- Night mode button  -->
                <a href="#" uk-tooltip="title: Night mode ; delay: 500 ; pos: right ;animation:	uk-animation-scale-up"> <i class="fas fa-moon"></i> </a>
                <div uk-drop="pos: right-bottom ;mode:click ; offset: 10;animation: uk-animation-slide-left-medium" class="uk-drop">
                    <div class="uk-card-small uk-box-shadow-xlarge uk-card-default uk-maring-small-left  border-radius-6">
                        <div class="uk-card uk-card-default border-radius-6">
                            <div class="uk-card-header">
                                <h5 class="uk-card-title uk-margin-remove-bottom">Gece Modu özelliğini değiştir</h5>
                            </div>
                            <div class="uk-card-body">
                                <p></p>
                                <p class="uk-text-small uk-align-left uk-margin-remove  uk-text-muted">KARANLIK TEMA </p>
                                <!-- night mode button -->
                                <div class="btn-night uk-align-right" id="night-mode">
                                    <label class="tm-switch">
                                        <!--<input type="checkbox" class="uk-checkbox">-->
                                        <div class="uk-switch-button"></div>
                                    </label>
                                </div>
                                <!-- end  night mode button -->
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import {mapState,mapActions} from 'vuex';
export default {
    name: "side-bar",
    props:{
        homeRoute:String,
        generalEducationText:{
            type:String,
            default:'Genel Eğitim'
        },
        prepareExamsText:{
            type:String,
            default:'Sınavlara Hazırlık'
        },
        prepareLessonsText:{
            type:String,
            default:'Derslere Hazırlık'
        },
        examsText:{
            type:String,
            default:'Deneme Sınavları'
        },
        liveText:{
            type:String,
            default:'Canlı Yayınlar'
        },
        logo:{
            type:String,
            required:true,
        },
        allOfCategory:String,
        generalEducationRoute:String,
        prepareLessonsRoute:String,
        prepareExamsRoute:String,
        liveRoute:String,
    },
    computed:{
        ...mapState([
            'categories',
            'crLessons',
            'crExams',
        ]),
    },
    methods: {
        ...mapActions([
            'loadCategories',
            'loadCrLessons',
            'loadCrExams',
        ]),
    },
    created() {
        this.$store.dispatch('loadCategories');
        this.$store.dispatch('loadCrLessons');
        this.$store.dispatch('loadCrExams');
        this.closeIcon = true;
    },
    mounted() {
        (function (window, document, undefined) {

            'use strict';
            // Feature test
            if (!('localStorage' in window)){return;}

            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode){return;}

            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function (event) {
                event.preventDefault();
                document.documentElement.classList.toggle('night-mode');
                if ( document.documentElement.classList.contains('night-mode') ) {
                    localStorage.setItem('gmtNightMode', true);
                    return;
                }
                localStorage.removeItem('gmtNightMode');
            }, false);

        })(window, document);
    }
}

</script>

<style scoped>
    .general-title:hover{
        background: white;
        color:#3F4850;
    }
    .side-menu-slide{
        width:300px !important;
    }
</style>
