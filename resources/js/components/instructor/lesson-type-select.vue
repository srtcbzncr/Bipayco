<template>
    <div>
        {{plLessonType}}
    </div>
</template>

<script>
    import {mapState,mapActions} from "vuex";

    export default {
        name: "lesson-type-select",
        computed:{
            ...mapState([
                'plLessonType'
            ]),
        },
        methods:{
          ...mapActions([
              'loadPlLessonType'
          ])
        },
        created() {
            this.$store.dispatch('loadPlLessonType');
        }
    }
</script>

<style scoped>

</style>
