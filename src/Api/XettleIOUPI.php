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
     * /v1/service/upi/verify/$vpa
     *
     * @return mixed
     */
    public function verify_vps($vpa){
        if ( empty($vpa) ) {
            throw new XettleIOException('Empty VPA');
        }
        return $this->call_method( '/v1/service/upi/verify/'.$vpa, 'upiget' );
    }

    /**
     * /v1/service/upi/collect
     *
     * @return mixed
     */
    public function collect( $vpa, $amount, $txn_note = "" ){
        return $this->call_method( '/v1/service/upi/collect', 'upipost', ['vpa' => $vpa, 'amount' => $amount, 'txnNote' => $txn_note] );
    }

    /**
     * /v1/service/upi/merchant
     *
     * @return mixed
     */
    public function add_merchant($data){
        if ( empty($data) ) {
            throw new XettleIOException('Empty Data');
        }
        return $this->call_method( '/v1/service/upi/merchant', 'upipost', $data );
    }

    /**
     * /v1/service/payout/orders
     *
     * @return mixed
     */
    public function get_transactionStatus($txnId){
        if ( empty($txnId) ) {
            throw new XettleIOException('Empty Transaction id');
        }
        return $this->call_method( '/v1/service/upi/status/'.$txnId, 'upiget' );
    }
}
