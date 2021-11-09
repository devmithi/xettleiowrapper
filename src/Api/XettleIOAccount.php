<?php

namespace XettleWrapper\Api;

use XettleWrapper\Api\XettleIOApi;

class XettleIOAccount extends XettleIOApi{

    /**
     * Create a new XettleIOAccount Instance.
     */
    public function __construct($config){
        parent::__construct($config);
    }

    /**
     * /v1/service/payout/accountInfo
     *
     * @return mixed
     */
    public function get_accountInfo(){
        return $this->call_method( '/v1/service/payout/accountInfo', 'get' );
    }
}
