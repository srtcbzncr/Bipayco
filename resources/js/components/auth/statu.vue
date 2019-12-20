
<template>
    <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 75%">
        <div class="uk-card-header uk-text-bold">
            <span class="fas icon-medium uk-margin-small-right" :class="statuLogo"></span>
            {{statuName}}
        </div>
        <div class="uk-card-body">
            <vue-form method="POST" :action="actionAddress">
                <input hidden :value="csrfToken" name="_token">

                <input hidden
                    v-if="['GET', 'POST'].indexOf(method.toUpperCase()) === -1"
                    :value="method"
                    name="_method"
                >
                <div uk-grid class="uk-flex-center">
                    <div class="uk-width-large@m uk-padding-remove-top">
                        <fieldset class="uk-fieldset uk-margin-small-bottom">
                            <div v-if="instructor">
                                <div class="uk-form-label"> {{idNum}} </div>
                                <input class="uk-input" type="text" name="identification_number" :value="userIdNum" required>
                            </div>
                            <div v-if="instructor">
                                <div class="uk-form-label"> {{title}}  </div>
                                <input class="uk-input" type="text" name="title" :value="userTitle" required>
                            </div>

                            <div v-if="instructor">
                                <div class="uk-form-label"> {{iban}}  </div>
                                <input class="uk-input" type="text" name="iban" :value="userIban" required>
                            </div>
                            <div v-if="instructor">
                                <div class="uk-form-label"> {{bio}}  </div>
                                <textarea class="uk-textarea" type="text" rows="5" name="bio" :value="userBio" required> </textarea>
                            </div>
                            <div>
                                <div class="uk-form-label"> {{refCode}}  </div>
                                <input class="uk-input" type="text" disabled name="referance_code" :value="userRefCode" required>
                            </div>
                        </fieldset>
                        <div v-if="instructor">
                            <input class="uk-button uk-button-grey button uk-margin" type="submit" :value="signIn">
                        </div>
                    </div>
                </div>
            </vue-form>
        </div>
    </div>
</template>

<script>
    import VueForm from "./vueForm";
    export default {
        name: "statu",
        components: {VueForm},
        props:{
            method: { default: 'POST' },
            instructor:Boolean,
            statuName: String,
            statuLogo:String,
            userIdNum: String,
            userTitle: String,
            userBio: String,
            userIban: String,
            userRefCode: String,
            title:String,
            idNum:String,
            bio:String,
            iban:String,
            refCode:String,
            signIn:String,
            actionAddress:String,
            student:Boolean,
        },
        data() { return { csrfToken: null }},
        created() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
    }
</script>

<style scoped>

</style>
