<template>
    <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 75%">
        <div class="uk-card-header uk-text-bold">
            {{statuName}}
        </div>
        <div class="uk-card-body">
            <form method="POST" :action="actionAddress">
                <div uk-grid class="uk-flex-center">
                    <div class="uk-width-large@m ">
                        <div class="uk-padding-remove-top ">
                            <div v-if="instructor">
                                <div class="uk-form-label"> {{idNum}} </div>
                                <input class="uk-input" type="text" name="identification_number" :value="userIdNum" required>
                            </div>
                            <div v-if="instructor">
                                <div class="uk-form-label"> {{title}}  </div>
                                <input class="uk-input" type="text" name="title" :value="userTitle" required>
                            </div>
                            <div v-if="instructor">
                                <div class="uk-form-label"> {{bio}}  </div>
                                <input class="uk-input" type="text" name="bio" :value="userBio" required>
                            </div>
                            <div v-if="instructor">
                                <div class="uk-form-label"> {{iban}}  </div>
                                <input class="uk-input" type="text" name="iban" :value="userIban" required>
                            </div>
                            <div>
                                <div class="uk-form-label"> {{refCode}}  </div>
                                <input class="uk-input" type="text" disabled name="referance_code" :value="userRefCode" required>
                            </div>
                        </div>
                        <div v-if="instructor">
                            <input class="uk-button uk-button-grey button uk-margin" type="submit" :value="signIn">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "statu",
        props:{
            instructor:Boolean,
            statuName: String,
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
            student:Boolean
        }
    }
</script>

<style scoped>

</style>
