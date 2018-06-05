<template>
    <section v-show="loading.state">
        <div class="loading">
            <i class="fas fa-3x fa-spinner fa-spin">
            </i>
        </div>
        <p class="message">{{loading.message}}</p>
    </section>
</template>

<script>
    import {HTTP} from '../http-common';

    export default {
        name: 'Spinner',

        data() {
            return {
                loading: {
                    state: false,
                    message: ''
                },
            }
        },

        created() {
            this.$eventBus.$on('loading', (loading) => {
                this.loading.state = loading.state;
                this.loading.message = loading.message;
            });

            // Add a request interceptor
            HTTP.interceptors.request.use((config) => {
                    this.loading.state = true;
                    return config;
                }
            );

            // Add a response interceptor
            HTTP.interceptors.response.use((response) => {
                    this.loading.state = false;
                    return response;
                }
            );
        },

        beforeDestroy() {
            this.$eventBus.$off('loading');
        },

    }
</script>

<style lang="scss" scoped>
    /* Absolute Center Spinner */
    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        padding-top: 2em;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    .message {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: fit-content;
        padding-top: 10em;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        font-size: 1.1em;
        font-weight: bold;
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
</style>