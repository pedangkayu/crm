<?php
class Customers_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_customers( $id ) {
		$this->db->select( '*,countries.shortname as country, customers.id as id ' );
		$this->db->join( 'countries', 'customers.country_id = countries.id', 'left' );
		return $this->db->get_where( 'customers', array( 'customers.id' => $id ) )->row_array();
	}

	function get_all_customers() {
		$this->db->select( '*,countries.shortname as country,countries.isocode as isocode, customers.id as id ' );
		$this->db->join( 'countries', 'customers.country_id = countries.id', 'left' );
		$this->db->order_by( 'customers.id', 'desc' );
		return $this->db->get_where( 'customers', array( '' ) )->result_array();
	}

	function add_customers( $params ) {
		$this->db->insert( 'customers', $params );
		$customer_id = $this->db->insert_id();
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'addedacustomer' ) . ' <a href="customers/customer/' . $this->db->insert_id() . '">' . lang( 'customer' ) . '-' . $this->db->insert_id() . '</a>' ),
			'staff_id' => $this->session->usr_id
		) );
		return $customer_id;
	}

	function update_customers( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'customers', $params );
	}

	function delete_customers( $id ) {
		$response = $this->db->delete( 'invoices', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'contacts', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'payments', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'proposals', array( 'relation_type' => 'customer', 'relation' => $id ) );
		$response = $this->db->delete( 'notes', array( 'relation_type' => 'customer', 'relation' => $id ) );
		$response = $this->db->delete( 'reminders', array( 'relation_type' => 'customer', 'relation' => $id ) );
		$response = $this->db->delete( 'expenses', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'logs', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'notifications', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'projects', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'tickets', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'sales', array( 'customer_id' => $id ) );
		$response = $this->db->delete( 'customers', array( 'id' => $id ) );
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $this->session->staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'customer' ) . '-' . $id . '' ),
			'staff_id' => $this->session->usr_id
		) );
	}

	function search_json_customer() {
		$this->db->select( 'id customer,type customertype,company company,namesurname individual,' );
		$this->db->from( 'customers' );
		return $this->db->get()->result();
	}
}