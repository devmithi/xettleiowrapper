<?php

namespace XettleWrapper\Api;

use XettleWrapper\Api\XettleIOApi;
use XettleWrapper\Exceptions\XettleIOException;

class XettleIOOrders extends XettleIOApi{

    /**
     * Create a new XettleIOOrders Instance.
     */
    public function __construct($config){
        parent::__construct($config);
    }

    /**
     * /v1/service/payout/orders
     *
     * @return mixed
     */
    public function get_allOrders(){
        return $this->call_method( '/v1/service/payout/orders', 'get' );
    }

    /**
     * /v1/service/payout/orders
     *
     * @return mixed
     */
    public function get_order($id){
        if ( empty($id) ) {
            throw new XettleIOException('Empty Order ID');
        }
        return $this->call_method( '/v1/service/payout/orders/'.$id, 'get' );
    }

    /**
     * /v1/service/payout/orders
     *
     * @return mixed
     */
    public function create_order( $data ){
        if ( empty($data) ) {
            throw new XettleIOException('Empty Order Data');
        }
        return $this->call_method( '/v1/service/payout/orders', 'post', $data );
    }

    /**
     * /v1/service/payout/cancelOrder
     *
     * @return mixed
     */
    public function cancel_order( $data ){
        if ( empty($data) ) {
            throw new XettleIOException('Empty Order Data');
        }
        return $this->call_method( '/v1/service/payout/cancelOrder', 'post', $data );
    }
}
