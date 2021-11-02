<?php

namespace XettleWrapper;

use XettleWrapper\Exceptions\XettleIOException;
use XettleWrapper\Api\XettleIOAccount;
use XettleWrapper\Api\XettleIOContacts;
use XettleWrapper\Api\XettleIOOrders;
use XettleWrapper\Api\XettleIOUPI;

class XettleIOManager{

    /**
     * @var string
     */
    const PRODUCTION_BASE_URL         = 'https://api.xettle.io';
    const SANDBOX_BASE_URL            = 'https://uat.xettle.io';

    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * Create a new Xettle Instance.
     *
     * @param Repository $config
     * @throws XettleIOException
     */
    public function __construct($config){
        // Setup credentials
        $this->config                     = $config;
        $this->config['base_url']         = ($config['env'] ?? 'test') == 'prod' ? self::PRODUCTION_BASE_URL :  self::SANDBOX_BASE_URL;

        // Credentials check
        if (!array_key_exists('client_id', $this->config) || !array_key_exists('client_secret', $this->config)) {
            throw new XettleIOException('Credentials are required!');
        }
    }

    /**
     * Accounts API
     *
     * @return Devmithi\XettleIO\Api\XettleIOAccount
     */
    public function account(){
        return new XettleIOAccount($this->config);
    }

    /**
     * Contacts API
     *
     * @return Devmithi\XettleIO\Api\XettleIOContact
     */
    public function contacts(){
        return new XettleIOContacts($this->config);
    }

    /**
     * Orders API
     *
     * @return Devmithi\XettleIO\Api\XettleIOContact
     */
    public function orders(){
        return new XettleIOOrders($this->config);
    }

    /**
     * UPI API
     *
     * @return Devmithi\XettleIO\Api\XettleIOContact
     */
    public function upi(){
        return new XettleIOUPI($this->config);
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
