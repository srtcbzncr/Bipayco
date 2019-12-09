<template>
    <div uk-height-viewport="offset-top: true; offset-bottom: true" class="uk-flex uk-flex-middle">
        <div class="uk-width-2-3@m uk-width-1-2@s uk-margin-auto  border-radius-6 ">
            <div class="uk-child-width-1-2@m uk-background-grey uk-grid-collapse" uk-grid>
                <div class="uk-text-middle uk-margin-auto-vertical uk-text-center uk-padding-small uk-animation-scale-up">
                    <p> <i class="fas fa-graduation-cap uk-text-white" style="font-size:60px"></i> </p>
                    <h1 class="uk-text-white uk-margin-small"> Bipayco </h1>
                    <h5 class="uk-margin-small uk-text-muted uk-text-bold uk-text-nowrap"> Bilgi Paylaştıkça Çoğalır. </h5>
                </div>
                <div>
                    <div class="uk-card-default uk-padding uk-card-small">
                        <div id="register" class="tabcontent animation: uk-animation-slide-left-medium">
                            <h2 class="uk-text-bold"> Register </h2>
                            <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom"> Create your free account</p>
                            <div class="uk-form-label">Full name</div>
                            <div class="uk-inline">
                                <span class="uk-form-icon"><i class="far fa-User icon-medium"></i></span>
                                <input class="uk-input uk-form-width-large" placeholder="Full name" type="text">
                            </div>
                            <div class="uk-form-label">Email address</div>
                            <div class="uk-inline">
                                <span class="uk-form-icon"><i class="far fa-envelope icon-medium"></i></span>
                                <input class="uk-input uk-form-width-large" placeholder="name@example.com" type="text">
                            </div>
                            <form class="uk-child-width-1-2@m uk-grid-small" uk-grid>
                                <div>
                                    <div class="uk-form-label">Password </div>
                                    <input class="uk-input" placeholder="Password" type="Password" id="password-1">
                                </div>
                                <div>
                                    <div class="uk-form-label">Confirm password</div>
                                    <input class="uk-input" placeholder="Password" type="Password"  id="password-2">
                                </div>
                            </form>
                            <div>
                                <label>
                                    <input class="uk-checkbox" type="checkbox" data-show-pw="#password-1 ,#password-2">
                                    <span class="checkmark uk-text-small"> Show passwords </span>
                                </label>
                            </div>
                            <div class="uk-margin">
                                <label>
                                    <input class="uk-checkbox" type="checkbox" checked>
                                    <span class="checkmark uk-text-small"> I agree to the </span>
                                    <a href="#modal-overflow" class="uk-text-bold uk-text-small" uk-toggle> Terms and Conditions  </a>
                                </label>
                            </div>
                            <div class=" uk-flex-middle" uk-grid>
                                <div class="uk-width-expand@m">
                                    <input class="uk-button uk-button-success button" type="submit" value="Create">
                                </div>
                                <div class="uk-width-auto@m">
                                    <span class="uk-text-small"> Already registered? <a href="#" class="tablinks uk-text-bold" onclick="openTabs(event, 'login')"> Sign in </a>  </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "register",
        data () {
            return {
                test: 'HI',
                email:'',
                password:'',
            }
        },
        methods: {
            onSubmit () {
                this.test = this.email+" "+this.password;
            }
        }
    }
</script>

<style scoped>

</style>
