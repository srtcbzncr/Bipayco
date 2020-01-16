<template>
    <div id="watch-example">
        <p>
            Ask a yes/no question:
            <input v-model="question">
        </p>
        <p>{{ answer }}</p>
    </div>
</template>

<script>
    export default {
        name: "course-create-instructors",
        data(){
            return{
                email:'',
                hasInstructorAccount:"Eğitmenin Eposta Adresini Giriniz",
            }
        },
        watch:{
            email: function () {
                this.hasInstructorAccount='Yazmanı Bekliyorum';
                this.debouncedGetAnswer();
            }
        },
        created() {
            this.debouncedGetAnswer = _.debounce(this.getAnswer, 500);
        },
        methods:{
            getAnswer: function () {
                if (this.question.indexOf('?') === -1) {
                    this.answer = 'Questions usually contain a question mark. ;-)';
                    return
                }
                this.answer = 'Thinking...';
                var vm = this;
                axios.get('https://yesno.wtf/api')
                    .then(function (response) {
                        vm.answer = _.capitalize(response.data.answer);
                    })
                    .catch(function (error) {
                        vm.answer = 'Error! Could not reach the API. ' + error;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
