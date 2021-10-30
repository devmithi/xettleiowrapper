<?php

namespace XettleWrapper\Api;

use XettleWrapper\Api\XettleIOApi;
use XettleWrapper\Exceptions\XettleIOException;

class XettleIOUPI extends XettleIOApi{

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
    public function collect( $vpa, $amount, $txn_note ){
        return $this->call_method( '/v1/service/upi/collect', 'post', ['vpa' => $vpa, 'amount' => $amount, 'txnNote' => $txn_note] );
    }

    /**
     * /v1/service/payout/orders
     *
     * @return mixed
     */
    public function verify_vps($vpa){
        if ( empty($vpa) ) {
            throw new XettleIOException('Empty VPA');
        }
        return $this->call_method( '/v1/service/upi/verify/'.$vpa, 'upiget' );
    }
}
