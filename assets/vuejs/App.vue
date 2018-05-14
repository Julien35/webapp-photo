<template>
    <div id="app">
        <main-header/>

        <main>
            <div v-show="loading" class="loading"><i class="fas fa-3x fa-spinner fa-spin"></i></div>
            <router-view/>
        </main>

        <main-footer/>
    </div>

</template>

<script>
    import {HTTP} from './http-common';
    import MainHeader from './common/main-header/main-header'
    import MainFooter from './common/main-footer/main-footer'

    export default {
        name: 'app',
        components: {
            MainHeader,
            MainFooter
        },
        data() {
            return {
                loading: true
            }
        },
        created() {
            // Add a request interceptor
            HTTP.interceptors.request.use((config) => {
                    this.loading = true;
                    return config;
                }
            );

            // Add a response interceptor
            HTTP.interceptors.response.use((response) => {
                    this.loading = false;
                    return response;
                }
            );
        }
    }
</script>

<style lang="scss" scoped>
    main {
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }
        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
        }

    }
</style>
