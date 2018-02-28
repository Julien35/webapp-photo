<template>
    <div id="app">
        <main-header/>

        <main class="container">
            <upload-images></upload-images>
        </main>

        <main-footer/>
    </div>
</template>

<script>
    import MainHeader from './common/main-header/main-header'
    import MainFooter from './common/main-footer/main-footer'
    import Contact from './common/contact/contact'
    import UploadImages from './components/upload-images/upload-images'

    class TestClassSyntax {

    }

    export default {
        name: 'app',
        components: {
            MainHeader,
            MainFooter,
            Contact,
            UploadImages
        }
    }
</script>

<style>
</style>

<style lang="scss">
</style>
