<?php
class Payments_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function addpayment( $params ) {

		if ( $this->input->post( 'balance' ) == 0 ) {
			$response = $this->db->where( 'id', $this->input->post( 'invoice' ) )->update( 'invoices', array( 'status_id' => 2, 'duedate' => 0 ) );
			$response = $this->db->where( 'invoice_id', $this->input->post( 'invoice' ) )->update( 'sales', array(
				'status_id' => 2,
				'staff_id' => $this->session->usr_id,
				'customer_id' => $this->input->post( 'customer' ),
				'total' => $this->input->post( 'total' ),
			) );
		} else {
			$response = $this->db->where( 'id', $this->input->post( 'invoice' ) )->update( 'invoices', array( 'status_id' => 3 ) );
			$response = $this->db->where( 'invoice_id', $this->input->post( 'invoice' ) )->update( 'sales', array(
				'status_id' => 3,
				'staff_id' => $this->session->usr_id,
				'customer_id' => $this->input->post( 'customer' ),
				'total' => $this->input->post( 'total' ),
			) );
		}
		$this->db->insert( 'payments', $params );
		return $this->db->insert_id();
	}

	function todaypayments() {
		return $this->db->get_where( 'payments', array( 'DATE(date)' => date( 'Y-m-d' ) ) )->result_array();
	}
}