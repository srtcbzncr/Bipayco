<template>
    <div class="uk-width-1-2@s uk-width-1-3@m">
        <div class="uk-card-default uk-card-hover card-tags uk-card-small">
            <div class="uk-padding-small card-tags-header" :style="backgroundColor">
                <div uk-grid>
                    <div class="uk-width-3-5">
                        <h3 class="uk-light uk-margin-small-top"> {{subCategoryName}}</h3>
                        <h6 class="uk-light uk-margin-small-top">{{courseCount}} {{course}}</h6>
                    </div>
                    <div class="uk-width-2-5 uk-padding-remove uk-flex uk-flex-middle">
                        <img alt="" class="uk-align-right" :src="subCategoryImg">
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>{{subCategoryDesc}}</p>
                <div class="uk-clearfix">
                    <div class="uk-float-left">
                        <a class="card-span-ex" href="#"> {{explore}} </a>
                    </div>
                    <div class="uk-float-right">
                        <a class="Course-tags Course-tags-more" :href="subCategoryRoute"> </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttom-shadow1"></div>
        <div class="buttom-shadow2"></div>
    </div>
</template>

<script>
    export default {
        name: "categoryCard",
        props:{
            backgroundColor:{
                color:{
                    type:String,
                    default:'#005b90'
                },
            },
            subCategoryName: {
                type: String,
                required: true,
            },
            subCategoryDesc:String,
            explore:{
                type:String,
                default: 'Keşfet'
            },
            subCategoryRoute:{
                type:String,
                required: true,
            },
            subCategoryImg:{
                type:String,
                required:true,
            },
            course: {
                type:String,
                default:'Kurs'
            },
            courseCount:{
                type:Number,
                default:0,
            },
        }
    }
</script>

<style scoped>

</style>
