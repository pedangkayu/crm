<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Pay extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library( 'paypal_lib' );
		$this->load->model( 'Invoices_Model' );
	}

	function success() {
		$this->load->view('paypal/success');
	}
	function cancel() {
		$this->load->view('paypal/cancel');
	}
	function invoice( $id ) {
		//Set variables for paypal form
		$returnURL = base_url() . 'pay/success';
		$cancelURL = base_url() . 'pay/cancel';
		$notifyURL = base_url().'pay/ipn'; //ipn url
		//get particular product data
		$invoice = $this->Invoices_Model->get_invoices( $id );
		$userID = 1; //current user id
		$invoiceno = 'INV-' . str_pad( $invoice[ 'id' ], 6, '0', STR_PAD_LEFT ) . '';
		$logo = base_url() . 'assets/img/logo.png';
		$this->paypal_lib->add_field( 'return', $returnURL );
		$this->paypal_lib->add_field( 'cancel_return', $cancelURL );
		$this->paypal_lib->add_field( 'notify_url', $notifyURL );
		$this->paypal_lib->add_field( 'item_name', $invoiceno );
		$this->paypal_lib->add_field( 'custom', $userID );
		$this->paypal_lib->add_field( 'item_number', str_pad( $invoice[ 'id' ], 6, '0', STR_PAD_LEFT ) );
		$this->paypal_lib->add_field( 'amount', $invoice[ 'total' ] );
		$this->paypal_lib->image( $logo );
		$this->paypal_lib->paypal_auto_form();
	}
}