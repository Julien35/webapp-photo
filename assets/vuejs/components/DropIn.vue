<template>
    <div>
        <div id="dropin-container"></div>

        <input id="nonce" name="payment_method_nonce" type="hidden"/>
        <button class="btn btn-default" type="submit" id="submitTransaction"
                @click="dropinRequestPaymentMethod">Drop-in Test
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
        },
        created() {
            this.dropinCreate();

            this.$parent.$on('tokenize', () => {
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
                    if (dropinError) {
                        this.errorMessage = 'There was an error setting up the client instance. Message: ' + dropinError.message;
                        this.$emit('bt.error', this.errorMessage);
                        return;
                    }

                    this.dropinInstance = dropinInstance;
                });
            },

            dropinRequestPaymentMethod() {
                console.log("dropinRequestPaymentMethod");
                this.dropinInstance.requestPaymentMethod((requestErr, payload) => {

                    if (requestErr) {
                        this.errorMessage = 'There was an error setting up the client instance. Message: ' + requestErr.message;
                        this.$emit('bt.error', this.errorMessage);
                        return;
                    }

                    document.querySelector('#nonce').value = payload.nonce;
                    console.log('dropinRequestPaymentMethod payload : ', payload);
                    this.paymentPayload = payload;
                    // do something with the payload/nonce
                    // Send payload.nonce to your server
                    this.transaction(12, this.paymentPayload.nonce);
                });
            },

            transaction(amount, nonce) {


                HTTP
                    .post('/checkout/transaction', {
                        amount: amount,
                        nonce: nonce
                    })
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((response) => {
                        console.log(response);
                    });
            }

        },
    };
</script>
