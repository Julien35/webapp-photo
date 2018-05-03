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
     * @var string $clientToken
     */
    private $clientToken;


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
        $this->clientToken = $this->gateway->clientToken()->generate();
//        $this->clientToken = $this->config->getEnvironment() .'_' . $this->gateway->clientToken()->generate();
    }

    /**
     * @return string
     */
    public function getClientToken(): string
    {
        return $this->clientToken;
    }

    /**
     * @param float $amount
     * @param string $nonce
     * @return \Braintree\Result\Error|\Braintree\Result\
     */
    public function createTransaction(float $amount, string $nonce)
    {
        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => ['submitForSettlement' => true]
        ]);
        return $result;
    }

}
