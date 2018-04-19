<template>
    <div>
        <div id="dropin-container"></div>

        <button type="submit" style="padding-top: 1rem;" id="submitTransaction"
                @click="dropinRequestPaymentMethod">Drop-in Test
        </button>
    </div>
</template>

<script>
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

                    this.paymentPayload = payload;
                    console.log(payload);
                    // do something with the payload/nonce
                    // Send payload.nonce to your server
                });
            },
        },
    };
</script>
