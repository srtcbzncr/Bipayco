<template>
    <div class="uk-margin">
        <input class="uk-input uk-width uk-margin-bottom" type="text" required>
        <textarea class="uk-height-small uk-textarea uk-overflow-auto" required></textarea>
    </div>
</template>

<script>
    export default {
        name: "fill-blank"
    }
</script>

<style scoped>
    textarea{
        resize:none;
    }
</style>
