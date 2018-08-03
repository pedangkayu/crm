<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Products extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index() {
		$data[ 'title' ] = lang( 'products' );
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'products/index', $data );
		$this->load->view( 'inc/footer', $data );
	}

	function create() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'code' => $this->input->post( 'code' ),
				'productname' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
				'purchase_price' => $this->input->post( 'purchaseprice' ),
				'sale_price' => $this->input->post( 'saleprice' ),
				'stock' => $this->input->post( 'stock' ),
				'vat' => $this->input->post( 'tax' ),
			);
			$products_id = $this->Products_Model->add_products( $params );
			echo $products_id;
		}
	}

	function update( $id ) {
		if ( isset( $id ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'code' => $this->input->post( 'code' ),
				'productname' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
				'purchase_price' => $this->input->post( 'purchaseprice' ),
				'sale_price' => $this->input->post( 'saleprice' ),
				'stock' => $this->input->post( 'stock' ),
				'vat' => $this->input->post( 'tax' ),
				);
				$this->Products_Model->update_products( $id, $params );
				echo lang( 'productupdated' );
			}
		}
	}

	function product( $id ) {
		$data[ 'title' ] = lang( 'product' );
		$data[ 'product' ] = $this->Products_Model->get_products( $id );
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'products/product', $data );
		$this->load->view( 'inc/footer', $data );
	}

	function remove( $id ) {
		$products = $this->Products_Model->get_products( $id );
		if ( isset( $products[ 'id' ] ) ) {
			$this->Products_Model->delete_products( $id );
			redirect( 'products/index' );
		} else
			show_error( 'The products you are trying to delete does not exist.' );
	}
}