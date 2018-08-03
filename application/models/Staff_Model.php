<?php
class Staff_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_staff( $id ) {
		$this->db->select( '*,languages.name as stafflanguage,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		$this->db->join( 'languages', 'staff.language = languages.foldername', 'left' );
		return $this->db->get_where( 'staff', array( 'staff.id' => $id ) )->row_array();
	}


	function get_all_staff() {
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		return $this->db->get_where( 'staff', array( '' ) )->result_array();
	}

	function add_staff( $params ) {
		$this->db->insert( 'staff', $params );
		$staffmember = $this->db->insert_id();
		$staffname = $this->session->staffname;
		$stafadded = $this->input->post( 'staffname' );
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $message = sprintf( lang( 'xaddedstaff' ), $staffname, $stafadded ) . '' ),
			'staff_id' => $loggedinuserid,
		) );
		return $this->db->insert_id();
	}

	function update_staff( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'staff', $params );
	}

	function delete_staff( $id ) {
		$response = $this->db->delete( 'staff', array( 'id' => $id ) );
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'staff' ) . '-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}

	function delete_avatar( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'staff', array( 'staffavatar' => 'n-img.jpg' ) );
	}

	function total_sales_by_staff($id) {
		$this->db->select_sum( 'total' );
		$this->db->from( 'sales' );
		$sales_total =  $this->db->get_where( '', array( 'staff_id' => $id ) )->row()->total;
		if (isset($sales_total)){
			$total = $sales_total;
		} else {
			$total = 0;
		}
		return $total;
	}

	function total_custoemer_by_staff( $id ) {
		$this->db->from( 'customers' );
		return $this->db->get_where( '', array( 'staff_id' => $id ) )->num_rows();
	}

	function total_ticket_by_staff( $id ) {
		$this->db->from( 'tickets' );
		return $this->db->get_where( '', array( 'staff_id' => $id ) )->num_rows();
	}
	
	function isDuplicate( $email ) {
		$this->db->get_where( 'staff', array( 'email' => $email ), 1 );
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}

	function insertToken( $user_id ) {
		$token = substr( sha1( rand() ), 0, 30 );
		$date = date( 'Y-m-d' );

		$string = array(
			'token' => $token,
			'user_id' => $user_id,
			'created' => $date
		);
		$query = $this->db->insert_string( 'tokens', $string );
		$this->db->query( $query );
		return $token . $user_id;

	}

	function isTokenValid( $token ) {
		$tkn = substr( $token, 0, 30 );
		$uid = substr( $token, 30 );

		$q = $this->db->get_where( 'tokens', array(
			'tokens.token' => $tkn,
			'tokens.user_id' => $uid ), 1 );

		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();

			$created = $row->created;
			$createdTS = strtotime( $created );
			$today = date( 'Y-m-d' );
			$todayTS = strtotime( $today );

			if ( $createdTS != $todayTS ) {
				return false;
			}

			$user_info = $this->getUserInfo( $row->user_id );
			return $user_info;

		} else {
			return false;
		}

	}

	function getUserInfo( $id ) {
		$q = $this->db->get_where( 'staff', array( 'id' => $id ), 1 );
		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();
			return $row;
		} else {
			error_log( 'no user found getUserInfo(' . $id . ')' );
			return false;
		}
	}

	function updateUserInfo( $post ) {
		$data = array(
			'password' => $post[ 'password' ],
			'last_login' => date( 'Y-m-d h:i:s A' ),
			'inactive' => $this->inactive[ 1 ]
		);
		$this->db->where( 'id', $post[ 'user_id' ] );
		$this->db->update( 'staff', $data );
		$success = $this->db->affected_rows();

		if ( !$success ) {
			error_log( 'Unable to updateUserInfo(' . $post[ 'user_id' ] . ')' );
			return false;
		}

		$user_info = $this->getUserInfo( $post[ 'user_id' ] );
		return $user_info;
	}

	function getUserInfoByEmail( $email ) {
		$q = $this->db->get_where( 'staff', array( 'email' => $email ), 1 );
		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();
			return $row;
		} else {
			error_log( 'no user found getUserInfo(' . $email . ')' );
			return false;
		}
	}

	function updatePassword( $post ) {
		$this->db->where( 'id', $post[ 'user_id' ] );
		$this->db->update( 'staff', array( 'password' => $post[ 'password' ] ) );
		$success = $this->db->affected_rows();

		if ( !$success ) {
			error_log( 'Unable to updatePassword(' . $post[ 'user_id' ] . ')' );
			return false;
		}
		return true;
	}

}