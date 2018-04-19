<?php

namespace App\Service;


use Braintree_Configuration;
use Braintree_Gateway;

class BrainTreeCheckout
{
    /**
     * @var Braintree_Configuration $config
     */
    private $config;

    /**
     * @var Braintree_Gateway $gateway
     */
    private $gateway;

    /**
     * @var array $braintree_parameters
     */
    private $braintree_parameters;


    /**
     * BrainTreeCheckout constructor.
     * @param array $braintree_parameters
     * @throws \Braintree\Exception\Configuration
     */
    public function __construct(array $braintree_parameters)
    {
        $this->braintree_parameters = $braintree_parameters;
        $this->config = new Braintree_Configuration($this->braintree_parameters);
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
