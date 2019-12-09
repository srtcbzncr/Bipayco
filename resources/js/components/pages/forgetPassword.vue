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
                        <div id="forget" class="tabcontent animation: uk-animation-slide-bottom-medium">
                            <h2 class="uk-text-bold"> Forget password  </h2>
                            <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom">to reset your password fill inter your email</p>
                            <form>
                                <div>
                                    <div class="uk-form-label">Email address</div>
                                    <div class="uk-inline">
                                        <span class="uk-form-icon"><i class="fas fa-lock icon-medium"></i></span>
                                        <input class="uk-input uk-form-width-large" placeholder="name@example.com" type="text">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <input class="uk-button uk-button-success button" type="submit" value="Reset password">
                                </div>
                            </form>
                            <span class="uk-text-small">
                                Not registered?
                                <a href="#" class="tablinks" onclick="openTabs(event, 'register')"> Create account  </a>
                                Or
                                <a href="#" class="tablinks" onclick="openTabs(event, 'login')"> Sign in  </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "forgetPassword",
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

<style>

</style>
