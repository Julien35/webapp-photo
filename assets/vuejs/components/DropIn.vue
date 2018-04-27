<template>
    <div>
        <div id="dropin-container"></div>

        <input id="nonce" name="payment_method_nonce" type="hidden"/>
        <button v-if="enableDropInTestButton" class="btn btn-default" type="submit"
                id="submitTransaction" @click="dropinRequestPaymentMethod">Drop-in Test
        </button>
    </div>
</template>

<script>
    import {HTTP} from '../http-common';

    export default {
        name: 'DropIn',
        props: {
            authToken: {
                value: String,
            },
            loaderClass: {
                value: String,
            },
            inputClass: {
                value: String,
            },
            collectCardHolderName: {
                value: Boolean,
            },
            collectPostalCode: {
                value: Boolean,
            },
            enableDataCollector: {
                value: Boolean,
            },
            enablePayPal: {
                value: Boolean,
            },
            enableDropInTestButton: {
                value: Boolean,
            },
            totalCart: {
                value: Number,
            },
        },
        created() {
            this.dropinCreate();

            this.$parent.$on('tokenizeChild', () => {
                this.dropinRequestPaymentMethod();
            });
        },
        data() {
            return {
                errorMessage: '',
                dropinInstance: '',
                paymentPayload: '',
                dataCollectorPayload: '',
            }
        },
        methods: {
            dropinCreate() {
                const dropin = require('braintree-web-drop-in');

                // setup drop-in options
                const dropinOptions = {
                    authorization: this.authToken,
                    selector: '#dropin-container',
                };

                // if PayPal enabled, add to options settings
                if (this.enablePayPal) {
                    dropinOptions.paypal = {
                        flow: 'vault'
                    };
                }

                dropin.create(dropinOptions, (dropinError, dropinInstance) => {

                    // todo: BUG HERE
                    if (dropinError) {
                        this.errorMessage = 'There was an error setting up the client instance. Message: ' + dropinError.message;
                        this.$emit('bt.error', this.errorMessage);
                        return;
                    }

                    this.dropinInstance = dropinInstance;
                });
            },

            dropinRequestPaymentMethod() {
                this.dropinInstance.requestPaymentMethod((requestErr, payload) => {

                    // todo: BUG HERE
                    if (requestErr) {
                        this.errorMessage = 'There was an error setting up the client instance. Message: ' + requestErr.message;
                        this.$emit('bt.error', this.errorMessage);
                        return;
                    }

                    document.querySelector('#nonce').value = payload.nonce;
                    this.paymentPayload = payload;
                    // do something with the payload/nonce
                    // Send payload.nonce to your server
                    this.transaction(this.totalCart, this.paymentPayload.nonce);
                });
            },

            transaction(amount, nonce) {
                HTTP
                    .post('/checkout/transaction', {
                        amount: amount,
                        nonce: nonce
                    })
                    .then((response) => {
                        console.log(response, 'ok');

                        if (response.data.success) {
                            this.$eventBus.$emit('transaction-status', true);
                        } else {
                            this.$eventBus.$emit('transaction-status', false);
                        }

                    })
                    .catch((response) => {
                        console.log(response, 'ko');
                    });
            }

        },
    };
</script>
