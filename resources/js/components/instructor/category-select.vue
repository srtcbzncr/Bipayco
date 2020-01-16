<template>
    <div class="uk-grid">
        <div class="uk-width-1-2@l">
            <select class='uk-select uk-margin-small-bottom' name="category" id="category" v-model="selectedId" @change="loadSubCategoryList" required>
                <option v-if="hasSelectedOption" hidden selected :value="selectedCategoryId">{{selectedCategory}} </option>
                <option v-if="!(hasSelectedOption)" disabled hidden selected value="">{{categoryDefault}}</option>
                <option v-for='category in categories' :value='category.id'>{{category.name}}</option>
            </select>
        </div>
        <div class="uk-width-1-2@l">
            <select class="uk-select" name="subCategory" id="subCategory" required>
                <option v-if="hasSelectedOption && hasChange" selected hidden :value="selectedSubCategoryId">{{selectedSubCategory}} </option>
                <option v-if="!(hasSelectedOption)|| !hasChange" disabled hidden selected value="">{{subCategoryDefault}}</option>
                <option v-for='subCategory in subCategories.data' :value='subCategory.id'>{{subCategory.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex';
    export default {
        name:'categorySelect',
        props:{
            categoryDefault:String,
            subCategoryDefault:String,
            hasSelectedOption:{
                type:Boolean,
                default:false,
            },
            selectedSubCategory:String,
            selectedCategory:String,
            selectedSubCategoryId:String,
            selectedCategoryId:{
                type:String,
                default: "",
            },
        },
        data(){
            return {
                selected: this.selectedCategoryId,
                changing:Boolean,
            }
        },
        computed:{
            hasChange:function () {
                return this.changing;
            },
            selectedId: function () {
                return this.selected;
            },
            ...mapState([
                'categories',
                'subCategories'
            ]),
        },
        methods:{
            ...mapActions([
                'loadCategories',
                'loadSubCategories'
            ]),
            loadSubCategoryList: function(){
                this.$store.dispatch('loadSubCategories', this.selectedId);
                this.changing=document.getElementById('category').value===this.selectedCategoryId;
            },
        },
        mounted () {
            this.$store.dispatch('loadCategories');
        },
    }
</script>

<style>
</style>

