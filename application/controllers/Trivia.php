<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Trivia extends CIUIS_Controller {

	function index() {
		echo 'Trivia';
	}

	function addtodo() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $_POST[ 'tododetail' ],
				'staff_id' => $this->session->userdata( 'usr_id' ),
				'date' => date( 'Y-m-d H:i:s' ),
			);
			$this->db->insert( 'todo', $params );
			$data[ 'insert_id' ] = $this->db->insert_id();;
			return json_encode( $data );
		}
	}

	function donetodo() {
		if ( isset( $_POST[ 'todo' ] ) ) {
			$todo = $_POST[ 'todo' ];
			$response = $this->db->where( 'id', $todo )->update( 'todo', array( 'done' => 1 ) );
		}
	}

	function undonetodo() {
		if ( isset( $_POST[ 'todo' ] ) ) {
			$todo = $_POST[ 'todo' ];
			$response = $this->db->where( 'id', $todo )->update( 'todo', array( 'done' => 0 ) );
		}
	}

	function removetodo() {
		$this->Trivia_Model->removetodo();
	}

	function addnote() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'relation_type' => $_POST[ 'relation_type' ],
				'relation' => $_POST[ 'relation' ],
				'description' => $_POST[ 'description' ],
				'addedfrom' => $this->session->userdata( 'usr_id' ),
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$this->db->insert( 'notes', $params );
			$data[ 'insert_id' ] = $this->db->insert_id();;
			echo json_encode( $data );
		}
	}

	function addreminder() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'relation_type' => $_POST[ 'relation_type' ],
				'relation' => $_POST[ 'relation' ],
				'description' => $_POST[ 'description' ],
				'staff_id' => $_POST[ 'staff' ],
				'addedfrom' => $this->session->userdata( 'usr_id' ),
				'date' => $_POST[ 'date' ],
			);
			$this->db->insert( 'reminders', $params );
			$data[ 'insert_id' ] = $this->db->insert_id();;
			echo json_encode( $data );
		}
	}

	function removenote() {
		$this->Trivia_Model->removenote();
	}

	function removereminder() {
		$this->Trivia_Model->removereminder();
	}

	function markreadreminder() {
		if ( isset( $_POST[ 'reminder_id' ] ) ) {
			$response = $this->db->where( 'id', $_POST[ 'reminder_id' ] )->update( 'reminders', array( 'isnotified' => 1 ) );
		}
	}
	
	function mark_read_notification($id) {
		if ( isset( $id ) ) {
			$response = $this->db->where( 'id', $id )->update( 'notifications', array( 'markread' => ( '1' ) ) );
		}
	}
}