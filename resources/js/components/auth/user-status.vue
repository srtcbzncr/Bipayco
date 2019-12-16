<template>
    <div class="uk-margin-medium">
        <div uk-grid>
            <form>
                <div v-if="Instructor === 'true'" class="uk-width-1-2@m">
                    <div class="uk-card-small uk-card-default">
                        <div class="uk-card-header uk-text-bold">
                            <i class="fas fa-envelope uk-margin-small-right"></i> Change  Email
                        </div>
                        <div class="uk-card-body uk-padding-remove-top">
                            <div class="uk-form-label"> {{userIdNum}} </div>
                            <input class="uk-input" type="text" name="identification_number">
                            <div class="uk-form-label"> {{userTitle}}  </div>
                            <input class="uk-input" type="text" name="title">
                            <div class="uk-form-label"> {{userBio}}  </div>
                            <input class="uk-input" type="text" name="bio">
                            <div class="uk-form-label"> {{userIban}}  </div>
                            <input class="uk-input" type="text" name="iban">
                            <div class="uk-form-label"> {{userRefCode}}  </div>
                            <input class="uk-input" type="text" disabled name="referance_code">
                        </div>
                    </div>
                    <input class="uk-button uk-button-grey button uk-margin" type="submit" value="Sign in">
                </div>
            </form>
            <form>
                <div v-if="Guardian === 'true'" class="uk-width-1-2@m">
                    <div class="uk-card-small uk-card-default">
                        <div class="uk-card-header uk-text-bold">
                            <i class="fas fa-lock uk-margin-small-right"></i> Change password
                        </div>
                        <div class="uk-card-body uk-padding-remove-top">
                            <div class="uk-form-label"> {{userIdNum}} </div>
                            <input class="uk-input" type="text" name="identification_number">
                            <div class="uk-form-label"> {{userTitle}}  </div>
                            <input class="uk-input" type="text" name="title">
                            <div class="uk-form-label"> {{userBio}}  </div>
                            <input class="uk-input" type="text" name="bio">
                            <div class="uk-form-label"> {{userIban}}  </div>
                            <input class="uk-input" type="text" name="iban">
                            <div class="uk-form-label"> {{userRefCode}}  </div>
                            <input class="uk-input" type="text" disabled name="referance_code">
                        </div>
                    </div>
                    <input class="uk-button uk-button-grey button uk-margin" type="submit" value="Sign in">
                </div>
            </form>
            <form>
                <div v-if="Manager === 'true'" class="uk-width-1-2@m">
                    <div class="uk-card-small uk-card-default">
                        <div class="uk-card-header uk-text-bold">
                            <i class="fas fa-lock uk-margin-small-right"></i> Change password
                        </div>
                        <div class="uk-card-body uk-padding-remove-top">
                            <div class="uk-form-label"> {{userIdNum}} </div>
                            <input class="uk-input" type="text" name="identification_number">
                            <div class="uk-form-label"> {{userTitle}}  </div>
                            <input class="uk-input" type="text" name="title">
                            <div class="uk-form-label"> {{userBio}}  </div>
                            <input class="uk-input" type="text" name="bio">
                            <div class="uk-form-label"> {{userIban}}  </div>
                            <input class="uk-input" type="text" name="iban">
                            <div class="uk-form-label"> {{userRefCode}}  </div>
                            <input class="uk-input" type="text" disabled name="referance_code">
                        </div>
                    </div>
                    <input class="uk-button uk-button-grey button uk-margin" type="submit" value="Sign in">
                </div>
            </form>
            <form>
                <div v-if="Admin ==='true'" class="uk-width-1-2@m">
                    <div class="uk-card-small uk-card-default">
                        <div class="uk-card-header uk-text-bold">
                            <i class="fas fa-lock uk-margin-small-right"></i> Change password
                        </div>
                        <div class="uk-card-body uk-padding-remove-top">
                            <div class="uk-form-label"> {{userIdNum}} </div>
                            <input class="uk-input" type="text" name="identification_number">
                            <div class="uk-form-label"> {{userTitle}}  </div>
                            <input class="uk-input" type="text" name="title">
                            <div class="uk-form-label"> {{userBio}}  </div>
                            <input class="uk-input" type="text" name="bio">
                            <div class="uk-form-label"> {{userIban}}  </div>
                            <input class="uk-input" type="text" name="iban">
                            <div class="uk-form-label"> {{userRefCode}}  </div>
                            <input class="uk-input" type="text" disabled name="referance_code">
                        </div>
                    </div>
                    <input class="uk-button uk-button-grey button uk-margin" type="submit" value="Sign in">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "user-status",
        props:{
            Instructor:String,
            Guardian:String,
            Manager:String,
            Admin:String,
            userIdNum:String,
            userTitle:String,
            userBio:String,
            userIban:String,
            userRefCode:String,
        }
    }
</script>

<style scoped>

</style>
