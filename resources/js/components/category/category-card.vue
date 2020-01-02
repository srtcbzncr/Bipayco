<template>
    <div class="uk-width uk-height">
        <div class="uk-card-default uk-card-hover card-tags uk-card-small">
            <div class="uk-padding-small card-tags-header" :style="color">
                <div uk-grid>
                    <div class="uk-width-3-5">
                        <h3 class="uk-light uk-margin-small-top uk-height-medium" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 26px; max-height: 52px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"> {{subCategoryName}}</h3>
                        <h6 class="uk-light uk-margin-small-top">{{courseCount}} {{course}}</h6>
                    </div>
                    <div class="uk-width-2-5 uk-padding-remove uk-flex uk-flex-middle">
                        <img alt="" class="uk-align-right" :src="subCategoryImg">
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small uk-margin-small-top">{{subCategoryDesc}}</p>
                <div class="uk-clearfix">
                    <div class="uk-float-left uk-margin-top">
                        <a class="card-span-ex" href="#"> {{explore}} </a>
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
                type:String,
                default:'#005b90'
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
                type:String,
                default:"0",
            },
        },
        computed:{
            color(){
                return "background:"+this.backgroundColor;
            }
        }
    }
</script>

<style scoped>

</style>
