<template>
    <div class="uk-card uk-card-default uk-align-center" style="max-width: 75%">
        <div class="uk-card-header uk-text-bold">
            {{statuName}}
        </div>
        <div class="uk-card-body">
            <form method="POST" :action="actionAddress">
                <div uk-grid class="uk-flex-center">
                    <div class="uk-width-1-2@m ">
                        <div class="uk-padding-remove-top ">
                            <div class="uk-form-label"> {{idNum}} </div>
                            <input class="uk-input" type="text" name="identification_number" :value="instructorIdNum" required>
                            <div class="uk-form-label"> {{title}}  </div>
                            <input class="uk-input" type="text" name="title" :value="instructorTitle" required>
                            <div class="uk-form-label"> {{bio}}  </div>
                            <input class="uk-input" type="text" name="bio" :value="instructorBio" required>
                            <div class="uk-form-label"> {{iban}}  </div>
                            <input class="uk-input" type="text" name="iban" :value="instructorIban" required>
                            <div class="uk-form-label"> {{refCode}}  </div>
                            <input class="uk-input" type="text" disabled name="referance_code" :value="instructorRefCode" required>
                        </div>
                        <input class="uk-button uk-button-grey button uk-margin" type="submit" :value="signIn">
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
            statuName: String,
            instructorIdNum: String,
            instructorTitle: String,
            instructorBio: String,
            instructorIban: String,
            instructorRefCode: String,
            title:String,
            idNum:String,
            bio:String,
            iban:String,
            refCode:String,
            signIn:String,
            actionAddress:String,
        }
    }
</script>

<style scoped>

</style>
