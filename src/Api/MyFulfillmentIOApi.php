<?php

namespace MyfulfillmentWrapper\Api;

use Curl\Curl;
use MyfulfillmentWrapper\Exceptions\MyFulfillmentIOException;

abstract class MyFulfillmentIOApi{

    /**
     * @var array
     */
    protected $config;

    /**
     * Creates a new XettleIOApi instance.
     *
     * @param array $config
     */
    public function __construct($config){
        $this->config = $config;
    }

    /**
     * Validate and, if necessary, retrieves a token or the cached token
     *
     * @return string
     * @throws MyFulfillmentIOException
     */
    protected function get_token(){
        $api_key        = $this->config['api_key'];
        $api_secret     = $this->config['api_secret'];

        $url            = $this->config['base_url'] . '/api/v1/gettoken';

        $curl           = new Curl();
        $curl->setHeader('Content-Type', 'application/json');
        $curl->post( $url, ['apikey' => $api_key, 'secretkey' => $api_secret] );

        if ($curl->error ) {
            throw new MyFulfillmentIOException( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\nResponse:" . json_encode($curl->response) );
        }
        $response       = $curl->response;

        if ( !isset( $response->token ) || empty( $response->token ) ) {
            throw new MyFulfillmentIOException( 'Error: Empty token' );
        }

        return $response->token;
    }

    /**
     * Calls a Xettle API Call function.
     *
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @return array
     * @throws MyFulfillmentIOException
     */
    protected function call_method( $endpoint, $method, $data = null ){
        $response            = "";
        switch( strtoupper( $method ) ){
            case 'GET':
                $response    = $this->get( $endpoint );
                break;
            case 'POST':
                $response    = $this->post( $endpoint, $data );
                break;
        }

        return $response;
    }

    /**
     * Calls a MyFulfillmentIO API Get function.
     *
     * @param string $url
     * @param string $signature
     * @param array $data
     * @return array
     * @throws MyFulfillmentIOException
     */
    protected function get( $endpoint ){
        $token          = $this->get_token();
        $url            = $this->config['base_url'] . $endpoint;
        $curl           = new Curl();
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setHeader('Authorization', 'Bearer ' . $token);
        $curl->get( $url );

        if ($curl->error ) {
            throw new MyFulfillmentIOException( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\nResponse:" . json_encode($curl->response) );
        } else {
            return $curl->response;
        }
    }

    /**
     * Calls a Xettle API Get function.
     *
     * @param string $url
     * @param string $signature
     * @param array $data
     * @return array
     * @throws MyFulfillmentIOException
     */
    protected function post( $endpoint, $data ){
        $token          = $this->get_token();
        $url            = $this->config['base_url'] . $endpoint;
        $curl           = new Curl();
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setHeader('Authorization', 'Bearer ' . $token);
        $curl->post( $url, $data );

        if ($curl->error ) {
            throw new MyFulfillmentIOException( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\nResponse:" . json_encode($curl->response) );
        } else {
            return $curl->response;
        }
    }
}
