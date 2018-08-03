<?php
class Contacts_Model extends CI_Model {
	private $table = null;

	function __construct() {
		$this->table = 'contacts';
		parent::__construct( $this->table );
	}

	function get_contacts( $id ) {
		return $this->db->get_where( 'contacts', array( 'id' => $id ) )->row_array();
	}

	function get_all_contacts() {
		return $this->db->get( 'contacts' )->result_array();
	}
	
	function get_customer_contacts($id) {
		return $this->db->get_where( 'contacts', array( 'customer_id' => $id ) )->result_array();
	}

	function create( $params ) {
		$this->db->insert( 'contacts', $params );
		$contact = $this->db->insert_id();
		$customer = $this->input->post( 'customer' );
		$staffname = $this->session->staffname;
		$contactname = $this->input->post( 'name' );
		$contactsurname = $this->input->post( 'surname' );
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => (''.$message = sprintf(lang('addedcontact'), $staffname, $contactname,$contactsurname).''),
			'staff_id' => $loggedinuserid,
			'customer_id' => $customer,
		) );
		return $this->db->insert_id();
	}

	function update( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'contacts', $params );
	}

	function delete( $id ) {
		$response = $this->db->delete( 'contacts', array( 'id' => $id ) );
	}
	public

	function isDuplicate( $email ) {
		$this->db->get_where( 'contacts', array( 'email' => $email ), 1 );
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}

	public

	function insertToken( $contact_id ) {
		$token = substr( sha1( rand() ), 0, 30 );
		$date = date( 'Y-m-d' );

		$string = array(
			'token' => $token,
			'contact_id' => $contact_id,
			'created' => $date
		);
		$query = $this->db->insert_string( 'tokens', $string );
		$this->db->query( $query );
		return $token . $contact_id;

	}

	public

	function isTokenValid( $token ) {
		$tkn = substr( $token, 0, 30 );
		$uid = substr( $token, 30 );

		$q = $this->db->get_where( 'tokens', array(
			'tokens.token' => $tkn,
			'tokens.contact_id' => $uid ), 1 );

		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();

			$created = $row->created;
			$createdTS = strtotime( $created );
			$today = date( 'Y-m-d' );
			$todayTS = strtotime( $today );

			if ( $createdTS != $todayTS ) {
				return false;
			}

			$user_info = $this->getUserInfo( $row->contact_id );
			return $user_info;

		} else {
			return false;
		}

	}

	public

	function getUserInfo( $id ) {
		$q = $this->db->get_where( 'contacts', array( 'id' => $id ), 1 );
		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();
			return $row;
		} else {
			error_log( 'no user found getUserInfo(' . $id . ')' );
			return false;
		}
	}

	public

	function updateUserInfo( $post ) {
		$data = array(
			'password' => $post[ 'password' ],
			'last_login' => date( 'Y-m-d h:i:s A' ),
			'inactive' => $this->inactive[ 1 ]
		);
		$this->db->where( 'id', $post[ 'contact_id' ] );
		$this->db->update( 'contacts', $data );
		$success = $this->db->affected_rows();

		if ( !$success ) {
			error_log( 'Unable to updateUserInfo(' . $post[ 'contact_id' ] . ')' );
			return false;
		}

		$user_info = $this->getUserInfo( $post[ 'contact_id' ] );
		return $user_info;
	}

	public

	function getUserInfoByEmail( $email ) {
		$q = $this->db->get_where( 'contacts', array( 'email' => $email ), 1 );
		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();
			return $row;
		} else {
			error_log( 'no user found getUserInfo(' . $email . ')' );
			return false;
		}
	}

	public

	function updatePassword( $post ) {
		$this->db->where( 'id', $post[ 'contact_id' ] );
		$this->db->update( 'contacts', array( 'password' => $post[ 'password' ] ) );
		$success = $this->db->affected_rows();

		if ( !$success ) {
			error_log( 'Unable to updatePassword(' . $post[ 'contact_id' ] . ')' );
			return false;
		}
		return true;
	}
}