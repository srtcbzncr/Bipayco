<template>
    <div class="uk-child-width-1-2 uk-grid uk-margin-small">
        <div>
            <select class='uk-select uk-margin-ri' id="city" @change="loadDistrictList" required>
                <option disabled hidden selected value="">{{cityDefault}}</option>
                <option v-for='city in cities' :value='city.id'>{{city.name}}</option>
            </select>
        </div>
        <div>
            <select class="uk-select" name="district_id" required>
                <option disabled hidden selected value="">{{districtDefault}}</option>
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
            districtDefault:String
        },
        computed:{
            ...mapState([
                'cities',
                'districts'
            ]),
        },
        methods:{
            ...mapActions([
                'loadDistricts',
                'loadCities'
            ]),
            loadDistrictList: function(){
                this.$store.dispatch('loadDistricts')
            }
        },
        mounted () {
            this.$store.dispatch('loadCities');
        },
    }
</script>

<style>
</style>
