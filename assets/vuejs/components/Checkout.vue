<template>
    <section>
        formulaire de paiement

        <div id="dropin-container"></div>
        <button id="submit-button">Request payment method</button>


    </section>

</template>

<script>
    // import braintree from 'braintree-web-drop-in/dropin'

    let button = document.querySelector('#submit-button');

    braintree.dropin.create({
        authorization: 'CLIENT_AUTHORIZATION',
        container: '#dropin-container'
    }, function (createErr, instance) {
        button.addEventListener('click', function () {
            instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                // Submit payload.nonce to your server
            });
        });
    });

    export default {
        name: "Checkout"
    }
</script>

<style scoped>

</style>