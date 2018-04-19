<template>
    <section>

        <DropIn
                :authToken="authToken"
                :collectCardHolderName="true"
                :enableDataCollector="true"
                :enablePayPal="false"
       />

    </section>

</template>

<script>
    import DropIn from './DropIn';

    export default {
        name: 'Checkout',
        components: {
            DropIn,
        },
        data() {
            return {
                authToken: 'sandbox_53q9zvq5_rwrmmxc7khxd9hgp',

            }
        },
        methods: {
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