<template>
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated"
             role="progressbar" :style="'width:' + percentage + '%'"
             :aria-valuenow="percentage"
             aria-valuemin="0"
             aria-valuemax="100">
        </div>
    </div>
</template>

<script>
    export default {
        name: "progress-bar",
        props: {
            percentage: {
                type: Number,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>