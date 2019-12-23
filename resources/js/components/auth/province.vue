<template>
    <div class="uk-child-width-1-2@l uk-grid">
        <div>
            <select class='uk-select uk-margin-right uk-margin-small-bottom form-control' name="city" id="city" @change="loadDistrictList" >
                <option v-if="hasSelectedOption" disabled hidden selected :value="selectedCityId">{{selectedCity}} </option>
                <option v-if="!(hasSelectedOption)" disabled hidden selected value="">{{cityDefault}}</option>
                <option v-for='city in cities' :value='city.id'>{{city.name}}</option>
            </select>
        </div>
        <div>
            <select class="uk-select form-control" name="district_id" >
                <option v-if="hasSelectedOption&&hasChange" disabled selected hidden :value="selectedDistrictId">{{selectedDistrict}} </option>
                <option v-if="!(hasSelectedOption)" disabled hidden selected value="">{{districtDefault}}</option>
                <option v-for='district in districts' :value='district.id'>{{district.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex';
    export default {
        name: "province",
        props:{
            cityDefault:String,
            districtDefault:String,
            hasSelectedOption:Boolean,
            selectedDistrict:String,
            selectedCity:String,
            selectedDistrictId:String,
            selectedCityId:String,
        },
        data(){
            return {
                changing:Boolean
            }
        },
        computed:{
            hasChange:function () {
                return this.changing;
            },
            ...mapState([
                'cities',
                'districts',
            ]),
        },
        methods:{
            ...mapActions([
                'loadDistricts',
                'loadCities'
            ]),
            loadDistrictList: function(){
                this.$store.dispatch('loadDistricts');
                this.changing=document.getElementById('city').value===this.selectedCityId;
            },
        },
        mounted () {
            this.$store.dispatch('loadCities');
        },
    }
</script>

<style>
</style>
