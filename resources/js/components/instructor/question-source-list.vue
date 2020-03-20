<template>
    <div>
        <div v-for="(question, index) in questionSource" class="uk-grid align-items-center justify-content-center uk-margin-top">
            <div class="uk-width-1-6">
                <div class="uk-form-label"> {{index+1}} </div>
            </div>
            <div class="uk-width-1-2">
                <div class="uk-form-label"> {{question.text}} </div>
            </div>
            <div class="uk-width-1-6">
                <div class="uk-form-label"> {{question.lesson}} </div>
            </div>
            <div class="uk-width-1-6">
                <div class="uk-form-label"> {{question.level}} </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState,mapActions} from 'vuex'
    export default {
        name: "question-source-list",
        props:{
            userId:{
                type:String,
                required:true,
            }
        },
        computed:{
            ...mapState([
                'questionSource'
            ])
        },
        methods:{
            ...mapActions([
                'loadQuestionSource'
            ])
        },
        created() {
            this.$store.dispatch('loadQuestionSource', this.userId)
        }
    }
</script>

<style scoped>

</style>
