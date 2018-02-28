<template>
    <div id="app">
        <main-header/>

        <main class="container">
            <!--<upload-images></upload-images>-->
        </main>

        <main-footer/>
    </div>
</template>

<script>
    import MainHeader from './common/main-header/main-header'
    import MainFooter from './common/main-footer/main-footer'

    class TestClassSyntax {

    }

    export default {
        name: 'app',
        components: {
            MainHeader,
            MainFooter
        }
    }
</script>

<style>
</style>

<style lang="scss">
</style>
