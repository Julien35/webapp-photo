<?php

namespace App\Service;


use Braintree_Configuration;
use Braintree_Gateway;

class BrainTreeCheckout
{
    /**
     * @var Braintree_Configuration
     */
    private $config;

    /**
     * @var Braintree_Gateway
     */
    private $gateway;


    /**
     * BrainTreeCheckout constructor.
     * @throws \Braintree\Exception\Configuration
     */
    public function __construct()
    {
        $this->config = new Braintree_Configuration([
            'environment' => 'sandbox',
            'merchantId' => 'rwrmmxc7khxd9hgp',
            'publicKey' => '2xcnb8gxxsyvwxv2',
            'privateKey' => '94d2f1c70959f81036ecb439b2357983'
        ]);

        $this->gateway = new Braintree_Gateway($this->config);
    }

    /**
     * @param float $amount
     * @return array
     */
    public function createTransaction(float $amount)
    {
        $clientToken = $this->gateway->clientToken()->generate();

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => 'fake-valid-nonce',
            'options' => ['submitForSettlement' => true]
        ]);

        if ($result->success) {
            $msg[] =("success!: " . $result->transaction->id);
        } else if ($result->transaction) {
            $msg[] =("Error processing transaction:");
            $msg[] =("\n  code: " . $result->transaction->processorResponseCode);
            $msg[] =("\n  text: " . $result->transaction->processorResponseText);
        } else {
            $msg[] =("Validation errors: \n");
            $msg[] =($result->errors->deepAll());
        }

        return $msg;
    }

}
