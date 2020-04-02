<template>
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success"><i class="fas fa-plus"></i> {{addCategoryText}} </button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <table id="categoryTable" class="uk-table uk-table-hover uk-table-striped uk-width uk-height" cellspacing="0">
                <thead v-if="true">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="true">
                <tr @click="routeDistricts">
                    <td><p>a</p></td>
                    <td><p>Tiger Nixon</p></td>
                    <td><p>System Architect</p></td>
                    <td><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings()" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                        <a @click="deactivateItem()" :uk-tooltip="deactivateText"><i class="fas fa-times-circle"></i></a>
                        <a @click="deleteItem()" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                <tr>
                    <td><p>s</p></td>
                    <td><p>Tiger Nixon</p></td>
                    <td><p>System Architect</p></td>
                    <td><p>Edinburgh</p></td>
                    <td class="uk-flex flex-wrap align-items-center justify-content-between">
                        <a @click="openSettings()" :uk-tooltip="editText"><i class="fas fa-cog"></i></a>
                        <a @click="activateItem()" :uk-tooltip="activateText"><i class="fas fa-check-circle"></i></a>
                        <a @click="deleteItem()" :uk-tooltip="deleteText"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                </tbody>
                <div v-else class=" uk-width uk-height-small uk-flex align-items-center justify-content-center">
                    <h4> {{noContentText}} </h4>
                </div>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "cities-page",
        props:{
            districtsRoute:{
                type:String,
                required:true,
            },
            addCategoryText:{
                type:String,
                default:"Kategori Ekle"
            },
            noContentText:{
                type:String,
                default:"İçerik Bulunmuyor"
            },
            deleteText:{
                type:String,
                default:"Sil"
            },
            activateText:{
                type:String,
                default:"Aktifleştir"
            },
            deactivateText:{
                type:String,
                default:"Pasifleştir"
            },
            editText:{
                type:String,
                default:"Düzenle"
            }
        },
        methods:{
            routeDistricts:function () {
                window.location.replace(this.districtsRoute);
            },
            deactivateItem:function () {

            },
            activateItem:function () {

            },
            deleteItem:function () {

            },
            openSettings:function () {

            }

        }
    }
</script>

<style scoped>
    tbody tr{
        cursor: pointer;
    }
</style>
