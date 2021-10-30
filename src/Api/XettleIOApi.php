<?php

namespace XettleWrapper\Api;

use Curl\Curl;
use XettleWrapper\Exceptions\XettleIOException;

abstract class XettleIOApi{

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
     * @param string $endpoint
     * @param string $method
     * @param array $payload
     * @return string
     * @throws XettleIOException
     */
    protected function get_signature( $endpoint, $method, $payload ){
        $signature                = "";

        switch( strtoupper( $method ) ){
            case 'GET':
                $signature        = hash('sha256', $endpoint . $this->config['client_id'] .  "####" . $this->config['salt']);
                break;
            case 'POST':
                $PostPayload      = is_array($payload) ? json_encode($payload) : $payload;
                $signature        = hash('sha256', base64_encode($PostPayload) . $endpoint . $this->config['client_id'] .  "####" . $this->config['salt']);
                break;
        }

        if ( empty($signature) ) {
            throw new XettleIOException('Empty Signature');
        }

        return $signature;
    }

    /**
     * Calls a Xettle API Call function.
     *
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @return array
     * @throws XettleIOException
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
            case 'UPIGET':
                $response    = $this->upiget( $endpoint );
                break;
            case 'UPIPOST':
                $response    = $this->upipost( $endpoint, $data );
                break;
        }

        return $response;
    }

    /**
     * Calls a Xettle API Get function.
     *
     * @param string $url
     * @param string $signature
     * @param array $data
     * @return array
     * @throws XettleIOException
     */
    protected function get( $endpoint ){
        $signature      = $this->get_signature( $endpoint, 'get', "" );
        $url            = $this->config['base_url'] . $endpoint;
        $curl           = new Curl();
        $curl->setBasicAuthentication($this->config['client_id'], $this->config['client_secret']);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setHeader('Accept', 'application/json');
        $curl->setHeader('Signature', $signature);
        $curl->get( $url );

        if ($curl->error ) {
            throw new XettleIOException( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage );
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
     * @throws XettleIOException
     */
    protected function post( $endpoint, $data ){
        $signature      = $this->get_signature( $endpoint, 'post', $data );
        $url            = $this->config['base_url'] . $endpoint;
        $curl           = new Curl();
        $curl->setBasicAuthentication($this->config['client_id'], $this->config['client_secret']);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setHeader('Accept', 'application/json');
        $curl->setHeader('Signature', $signature);
        $curl->post( $url, $data );

        if ($curl->error ) {
            throw new XettleIOException( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage );
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
     * @throws XettleIOException
     */
    protected function upiget( $endpoint ){
        $url            = $this->config['base_url'] . $endpoint;
        $curl           = new Curl();
        $curl->setBasicAuthentication($this->config['client_id'], $this->config['client_secret']);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setHeader('Accept', 'application/json');
        $curl->get( $url );

        if ($curl->error ) {
            throw new XettleIOException( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage );
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
     * @throws XettleIOException
     */
    protected function upipost( $endpoint, $signature, $data ){
        $url            = $this->config['base_url'] . $endpoint;
        $curl           = new Curl();
        $curl->setBasicAuthentication($this->config['client_id'], $this->config['client_secret']);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setHeader('Accept', 'application/json');
        $curl->post( $url, $data );

        if ($curl->error ) {
            throw new XettleIOException( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage );
        } else {
            return $curl->response;
        }
    }
}
