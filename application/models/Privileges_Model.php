<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Privileges_Model extends CI_MODEL {

	function __construct() {
		parent::__construct();
	}

	function get_staff_permissions( $id ) {
		$result = $this->db->select( 'permission_id' )->where( 'staff_id', $id )->get( 'privileges' );
		return array_column( $result->result_array(), 'permission_id' );
	}

	function has_privilege( $path ) {
		$staff_id = $this->session->usr_id;
		$query = $this->db->query( "SELECT *  FROM `privileges` JOIN permissions ON permissions.id = privileges.permission_id WHERE privileges.staff_id = $staff_id AND permissions.key = '$path';" );
		$rows = $query->num_rows();
		return ( $rows > 0 ) ? TRUE : FALSE;
	}

	function get_privileges() {
		$query = $this->db->get( 'privileges' );
		return $query->result_array();
	}

	function get_all_permissions() {
		return $this->db->get( 'permissions' )->result_array();
	}

	function add_privilege( $id, $privileges ) {
		$delete_old = $this->db->where( 'staff_id', $id )->delete( 'privileges' );
		$data = array();
		foreach ( $privileges as $key ) {
			$arr = array(
				'staff_id' => ( int )$id,
				'permission_id' => ( int )$key
			);

			array_push( $data, $arr );
		}
		$insert_new = $this->db->insert_batch( 'privileges', $data );

		if ( $insert_new ) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

}