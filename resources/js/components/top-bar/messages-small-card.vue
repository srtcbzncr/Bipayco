<template>
    <div class=" uk-padding-small  uk-background-light uk-inline-clip uk-transition-toggle" tabindex="0">
        <div class="uk-transition-slide-right-small uk-position-top-right uk-position-z-index uk-margin-small-right">
            <a class="uk-button uk-padding-remove" uk-icon="icon: trash" href="#"></a>
        </div>
        <div class="uk-transition-slide-right-medium uk-position-top-right uk-margin-medium-right">
            <a class="uk-button uk-padding-remove" uk-icon="icon: reply" href="#"></a>
        </div>
        <div class="uk-flex-middle uk-grid-small uk-grid" uk-grid="">
            <div class="uk-width-3-4">
                <p class="uk-margin-remove-bottom uk-text-bold">John keni  </p>
                <p class="uk-margin-remove">Lorem ipsum dolor sit ame ..</p>
                <p class="uk-margin-remove-top uk-text-small uk-text-muted">25 min</p>
            </div>
            <div class="uk-width-1-4 uk-flex-first uk-first-column">
                <img src="#" alt="Image" class="uk-border-circle">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "messages-small-card"
    }
</script>

<style scoped>

</style>
