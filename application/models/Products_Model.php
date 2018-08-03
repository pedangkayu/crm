<?php

class Products_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_products( $id ) {
		return $this->db->get_where( 'products', array( 'id' => $id ) )->row_array();
	}

	function get_all_products() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'products', array( '' ) )->result_array();
	}

	function getallproductsjson() {
		$this->db->select( 'id id,code code,productname label,sale_price sale_price,vat vat' );
		$this->db->from( 'products' );
		return $this->db->get()->result();
	}

	function add_products( $params ) {
		$this->db->insert( 'products', $params );
		$product = $this->db->insert_id();
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('addedanewproduct').' <a href="products/product/' . $product . '"> '.lang('product').'' . $product . '</a>' ),
			'staff_id' => $loggedinuserid
		) );
		return $product;
	}

	function update_products( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update('products', $params );
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('updated').' <a href="products/product/' . $id . '"> '.lang('product').'' . $id . '</a>' ),
			'staff_id' => $loggedinuserid
		) );
		
	}
	function delete_products( $id ) {
		$response = $this->db->delete( 'products', array( 'id' => $id ) );
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('deleted').' '.lang('product').'-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}
}