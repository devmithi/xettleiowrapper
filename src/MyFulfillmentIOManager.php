<?php

namespace MyfulfillmentWrapper;

use MyfulfillmentWrapper\Exceptions\MyFulfillmentIOException;
use MyfulfillmentWrapper\Api\MyfulfillmentIOProduct;
use MyfulfillmentWrapper\Api\MyfulfillmentIOOrder;

class MyFulfillmentIOManager{

    /**
     * @var string
     */
    const PRODUCTION_BASE_URL         = 'https://api.mycloudfulfillment.com';
    const SANDBOX_BASE_URL            = 'https://testaws-api.mycloudfulfillment.com';

    /**
     * @var array
     */
    private $config;

    /**
     * Create a new MyFulfillmentIOManager Instance.
     *
     * @param Repository $config
     * @throws MyFulfillmentIOException
     */
    public function __construct($config){
        // Setup credentials
        $this->config                     = $config;
        $this->config['base_url']         = ($config['env'] ?? 'test') == 'prod' ? self::PRODUCTION_BASE_URL :  self::SANDBOX_BASE_URL;

        // Credentials check
        if (!array_key_exists('api_key', $this->config) || !array_key_exists('api_secret', $this->config)) {
            throw new MyFulfillmentIOException('Credentials are required!');
        }

        if (!array_key_exists('cache_token', $this->config)) {
            $this->config['cache_token'] = false;
        }
    }

    /**
     * Product API
     *
     * @return MyfulfillmentWrapper\Api\MyfulfillmentIOProduct
     */
    public function product(){
        return new MyfulfillmentIOProduct($this->config);
    }

    /**
     * Order API
     *
     * @return MyfulfillmentWrapper\Api\MyfulfillmentIOOrder
     */
    public function order(){
        return new MyfulfillmentIOOrder($this->config);
    }

    /**
     * client_id getter.
     *
     * @return string
     */
    public function get_clientId(){
        return $this->client_id;
    }

    /**
     * client_secret getter.
     *
     * @return string
     */
    public function get_clientSecret(){
        return $this->client_secret;
    }
}
