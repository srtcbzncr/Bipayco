<template>
    <div class="uk-modal-dialog uk-flex uk-flex-center" uk-height-viewport>
        <button class="uk-modal-close-full" type="button" uk-close> </button>
        <form class="uk-search uk-margin-small-left uk-margin-xlarge-top uk-search-large uk-flex-center uk-animation-slide-bottom-medium">
            <i class="fas fa-search uk-position-absolute uk-margin-top icon-xxlarge"> </i>
            <input class="uk-search-input uk-margin-large-left uk-width-medium" type="search" placeholder="Search..." autofocus>
        </form>
    </div>
</template>

<script>
    export default {
        name: "search"
    }
</script>

<style scoped>

</style>
