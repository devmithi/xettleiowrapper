<?php

namespace MyfulfillmentWrapper\Api;

use MyfulfillmentWrapper\Api\MyFulfillmentIOApi;

class MyfulfillmentIOProduct extends MyFulfillmentIOApi{

    /**
     * Create a new XettleIOAccount Instance.
     */
    public function __construct($config){
        parent::__construct($config);
    }

    /**
     * /api/v1/products
     *
     * @return mixed
     */
    public function getProducts(){
        return $this->call_method( '/api/v1/products', 'get' );
    }

    /**
     * /api/v1/products
     *
     * @return mixed
     */
    public function createProducts( $data ){
        return $this->call_method( '/api/v1/products', 'post', $data );
    }
}
