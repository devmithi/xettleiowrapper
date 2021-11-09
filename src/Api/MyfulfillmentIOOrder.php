<?php

namespace MyfulfillmentWrapper\Api;

use MyfulfillmentWrapper\Api\MyFulfillmentIOApi;

class MyfulfillmentIOOrder extends MyFulfillmentIOApi{
	const API_STATUS_RESERVED    = 'RESERVED';
	const API_STATUS_WAITPAYMENT = 'WAITPAY';
	const API_STATUS_RECVPAYMENT = 'RECVPAY';
	const API_STATUS_APPROVED    = 'APPROVED';
	const API_STATUS_PICKING     = 'PICKING';
	const API_STATUS_PROCESSING  = 'PROCESSING';
	const API_STATUS_SHIPPED     = 'SHIPPED';
	const API_STATUS_DELIVERED   = 'DELIVERED';
	const API_STATUS_UNKNOWN     = 'UNKNOWN';

	private $order_items         = array();
	
	private $customer            = NULL;
	
	private $delivery_mode       = NULL;

	private $attachments         = array();

	public function getOrderNumber() {
		return $this->order_number;
	}
	public function setOrderNumber($order_number) {
		$this->order_number = $order_number;
		return $this;
	}

	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setAddress($address) {
		$this->address = $address;
		return $this;
	}

	public function getPostcode() {
		return $this->postcode;
	}

	public function setPostcode($postcode) {
		$this->postcode = $postcode;
		return $this;
	}

	public function getPhoneNumber() {
		return $this->phone_number;
	}

	public function setPhoneNumber($phone_number) {
		$this->phone_number = $phone_number;
		return $this;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	public function setTotalPrice($totalPrice) {
		$this->total_price = $totalPrice;
		return $this;
	}

	public function getTotalPrice() {
		return $this->total_price;
	}

	public function getShop()
	{
		if ( $this->shop == NULL ) {
			// FIXME
		}
		return $this->shop;
	}

	public function getOrderItems()
	{
		return $this->order_items;
	}

	public function getAttachments()
	{
		return $this->attachments;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function setCustomer( $customer )
	{
		$this->customer = $customer;
		return $this;
	}

	public function getDeliveryMode()
	{
		return $this->delivery_mode;
	}

	public function setDeliveryMode( $delivery_mode )
	{
		$this->delivery_mode = $delivery_mode;
		return $this;
	}

	public function getNote()
	{
		return $this->note;
	}

	public function setNote( $note )
	{
		$this->note = $note;
		return $this;
	}

	public function addOrderItem( $order_item )
	{
		$this->order_items[] = $order_item;
		return $this;
	}

	public function addProduct( $product_id, $quantity, $price )
	{
		$order_item          = [ 'product_id' => $product_id, 'quantity' => $quantity, 'price' => $price ];
		$this->addOrderItem( $order_item );
		return $this;
	}

    /**
     * Create a new Order Instance.
     */
    public function __construct($config){
        parent::__construct($config);
    }

    /**
     * /api/v1/orders
     *
     * @return mixed
     */
    public function getOrders(){
        return $this->call_method( '/api/v1/products', 'get' );
    }

    /**
     * /api/v1/orders
     *
     * @return mixed
     */
    public function createOrder(){
		$order                         = NULL;
        $payload                       = array();

		$payload['interface_type']     = "WEBHOOK";
		$payload['name']               = $this->getName();
		$payload['email']              = $this->getEmail();
		$payload['note']               = $this->getNote();
		$payload['address']            = $this->getAddress();
		$payload['postcode']           = $this->getPostcode();
		$payload['phone_number']       = $this->getPhoneNumber();
		$payload['status']             = $this->getStatus();
		$payload['delivery_mode_id']   = $this->getDeliveryMode();
        $payload['order_items']        = $this->getOrderItems();
        $payload['total_price']        = $this->getTotalPrice();
        $payload['order_number']       = $this->getOrderNumber();
        return $this->call_method( '/api/v1/orders', 'post', $payload );
    }
}
