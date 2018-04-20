<template>
    <section>

        <DropIn v-if="authToken !== null"
                :authToken="authToken"
                :collectCardHolderName="true"
                :enableDataCollector="true"
                :enablePayPal="false"
        />

    </section>

</template>

<script>
    import DropIn from './DropIn';
    import {HTTP} from '../http-common';

    export default {
        name: 'Checkout',
        components: {
            DropIn,
        },
        data() {
            return {
                authToken: null,
            }
        },

        created() {
            this.getToken();
        },

        methods: {
            getToken() {
                HTTP
                    .get('/checkout/client-token')
                    .then((response) => {
                        this.authToken = response.data;
                    })
                    .catch((response) => {
                        console.log(response);
                    });
            },


            btHFError(message) {
                console.error(message);
                // do something with the error message
            },
            btHFPayload(payload) {
                console.log(payload);
                // do something with the token payload
            },
            submitTransaction() {
                console.log('submitTransaction');
                this.$emit('tokenize');
            }
        }
    }
</script>

<style scoped>

</style>