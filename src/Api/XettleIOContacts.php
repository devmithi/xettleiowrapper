<?php

namespace XettleWrapper\Api;

use XettleWrapper\Api\XettleIOApi;
use XettleWrapper\Exceptions\XettleIOException;

class XettleIOContacts extends XettleIOApi{

    /**
     * Create a new XettleIOContact Instance.
     */
    public function __construct($config){
        parent::__construct($config);
    }

    /**
     * /v1/service/payout/contacts
     *
     * @return mixed
     */
    public function get_allContacts(){
        return $this->call_method( '/v1/service/payout/contacts', 'get' );
    }

    /**
     * /v1/service/payout/contacts
     *
     * @return mixed
     */
    public function get_contact($id){
        if ( empty($id) ) {
            throw new XettleIOException('Empty Contact ID');
        }
        return $this->call_method( '/v1/service/payout/contacts/'.$id, 'get' );
    }

    /**
     * /v1/service/payout/contacts
     *
     * @return mixed
     */
    public function create_contact($data){
        if ( empty($data) ) {
            throw new XettleIOException('Empty data');
        }
        return $this->call_method( '/v1/service/payout/contacts', 'post', $data );
    }
}
