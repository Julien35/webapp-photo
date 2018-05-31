<template>
    <div id="app">
        <main-header/>

        <main>
            <spinner/>
            <router-view/>
        </main>

        <main-footer/>
    </div>

</template>

<script>
    import MainHeader from './common/main-header/main-header'
    import MainFooter from './common/main-footer/main-footer'
    import Spinner from './common/spinner'

    export default {
        name: 'app',
        components: {
            MainHeader,
            MainFooter,
            Spinner
        },
        data() {
            return {}
        },
    }
</script>

<style lang="scss" scoped>
</style>
