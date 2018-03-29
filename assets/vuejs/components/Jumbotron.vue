<template>
    <section class="jumbotron-fluid">
        <h2>{{ jumbotronTile }}</h2>
        <p>Plein de photos à vendre :) (Mettre un texte de présentation)</p>
    </section>
</template>

<script>
    export default {
        name: "Jumbotron",
        props: {
            jumbotronTile: {
                type: String,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>