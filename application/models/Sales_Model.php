<?php
class Sales_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	// Get sales by id
	function get_sales( $id ) {
		return $this->db->get_where( 'sales', array( 'id' => $id ) )->row_array();
	}

	// Get all sales
	function get_all_sales() {
		return $this->db->get( 'sales' )->result_array();
	}

	// Function to add new sales
	function add_sales( $params ) {
		$this->db->insert( 'sales', $params );
		return $this->db->insert_id();
	}

	// Function to update sales
	function update_sales( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'sales', $params );
	}

	// Function to delete sales
	function delete_sales( $id ) {
		$response = $this->db->delete( 'sales', array( 'id' => $id ) );
	}
}