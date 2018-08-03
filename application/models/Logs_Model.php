<?php

class Logs_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_logs( $date ) {

		return $this->db->get_where( 'logs', array( 'date' => $date ) )->row_array();
	}
	function getlog_json() {
		$this->db->select( 'detail detail,date date' );
		$this->db->from( 'logs' );
		return $this->db->get()->result();
	}


	function get_all_logs() {

		$this->db->select( '*,,staff.staffname as staffmembername, staff.staffavatar as staffimage, logs.date as date ' );
		$this->db->join( 'staff', 'logs.staff_id = staff.id', 'left' );
		$this->db->order_by( "date", "desc" );
		return $this->db->get_where( 'logs', array( '' ) )->result_array();
	}

	function panel_last_logs() {

		$this->db->select( '*,,staff.staffname as staffmembername, staff.staffavatar as staffimage, logs.date as date ' );
		$this->db->join( 'staff', 'logs.staff_id = staff.id', 'left' );
		$this->db->order_by( "date", "desc" );
		return $this->db->get_where( 'logs', array( '' ) )->result_array();
	}
	
	function get_logs_by_customer($id) {

		$this->db->select( '*,,staff.staffname as staffmembername, staff.staffavatar as staffimage, logs.date as date ' );
		$this->db->join( 'staff', 'logs.staff_id = staff.id', 'left' );
		$this->db->order_by( "date", "desc" );
		return $this->db->get_where( 'logs', array( 'id',$id ) )->result_array();
	}
	
	function project_logs( $id ) {
		return $this->db->get_where( 'logs', array( 'logs.project_id' => $id ) )->result_array();
	}

	function staffmember_log() {

		$this->db->select( '*,,staff.staffname as staffmembername, staff.staffavatar as staffimage, logs.date as date ' );
		$this->db->join( 'staff', 'logs.staff_id = staff.id', 'left' );
		$this->db->limit( 5 );
		$this->db->order_by( "date", "desc" );
		return $this->db->get_where( 'logs', array( 'staff_id' => $this->session->userdata( 'usr_id' ) ) )->result_array();
	}

	function delete_logs( $date ) {
		$response = $this->db->delete( 'logs', array( 'date' => $date ) );
		if ( $response ) {
			return "Logs Deleted";
		} else {
			return "Log eror";
		}
	}
}