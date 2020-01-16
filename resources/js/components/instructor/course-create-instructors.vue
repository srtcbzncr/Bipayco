<template>
    <div id="watch-example">
        <p>
            Ask a yes/no question:
            <input v-model="email">
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
                this.debouncedGethasInstructorAccount();
            }
        },
        created() {
            this.debouncedGethasInstructorAccount = _.debounce(this.getAnswer, 500);
        },
        methods:{
            getAnswer: function () {
                if (this.email.indexOf('?') === -1) {
                    this.hasInstructorAccount = 'Questions usually contain a question mark. ;-)';
                    return
                }
                this.hasInstructorAccount = 'Thinking...';
                var vm = this;
                axios.get('https://yesno.wtf/api')
                    .then(function (response) {
                        vm.hasInstructorAccount = _.capitalize(response.data.hasInstructorAccount);
                    })
                    .catch(function (error) {
                        vm.hasInstructorAccount = 'Error! Could not reach the API. ' + error;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
