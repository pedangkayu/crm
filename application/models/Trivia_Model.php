<?php
class Trivia_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	// Get todos by staff id
	function get_todos() {
		return $this->db->get_where( 'todo', array( 'done' => 0, 'staff_id' => $this->session->userdata( 'usr_id' ) ) )->result_array();
	}

	function get_done_todos() {
		return $this->db->get_where( 'todo', array( 'done' => 1, 'staff_id' => $this->session->userdata( 'usr_id' ) ) )->result_array();
	}

	// Function to add new todo ajax
	function add_todo( $params ) {
		$this->db->insert( 'todo', $params );
		return $this->db->insert_id();
	}

	function removetodo() {
		if ( isset( $_POST[ 'todo' ] ) ) {
			$todoid = $_POST[ 'todo' ];
			$response = $this->db->delete( 'todo', array( 'id' => $todoid ) );
		}
	}

	function add_note( $params ) {
		$this->db->insert( 'notes', $params );
		return $this->db->insert_id();
	}

	function get_note( $id ) {
		return $this->db->get_where( 'notes', array( 'id' => $id ) )->row_array();
	}
	function get_reminder( $id ) {
		return $this->db->get_where( 'reminders', array( 'id' => $id ) )->row_array();
	}

	function delete_note( $id ) {
		$response = $this->db->delete( 'notes', array( 'id' => $id ) );
	}
	function delete_reminder( $id ) {
		$response = $this->db->delete( 'reminders', array( 'id' => $id ) );
	}
	function removereminder() {
		if ( isset( $_POST[ 'reminder' ] ) ) {
			$reminderid = $_POST[ 'reminder' ];
			$response = $this->db->delete( 'reminders', array( 'id' => $reminderid ) );
		}
	}
	function removenote() {
		if ( isset( $_POST[ 'notes' ] ) ) {
			$noteid = $_POST[ 'notes' ];
			$response = $this->db->delete( 'notes', array( 'id' => $noteid ) );
		}
	}
	function add_reminder( $params ) {
		$this->db->insert( 'reminders', $params );
		return $this->db->insert_id();
	}
	function get_reminders() {
		$this->db->select( '*,staff.staffname as remindercreator,staff.staffavatar as staffpicture,reminders.id as id ' );
		$this->db->join( 'staff', 'reminders.addedfrom = staff.id', 'left' );
		$this->db->where( 'CURDATE() >= date AND date != "0000.00.00" AND isnotified != "1" AND staff_id = '. $this->session->userdata( 'usr_id' ) .'' );
		return $this->db->get( 'reminders')->result_array();
	}
}