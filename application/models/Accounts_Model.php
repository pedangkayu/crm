<?php
class Accounts_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_accounts( $id ) {
		return $this->db->get_where( 'accounts', array( 'id' => $id ) )->row_array();
	}

	function get_all_accounts() {
		return $this->db->get_where( 'accounts', array( '' ) )->result_array();
	}
	
	function get_all_transactions() {
		return $this->db->get_where( 'payments', array( '' ) )->result_array();
	}

	function create( $params ) {
		$this->db->insert( 'accounts', $params );
		$account = $this->db->insert_id();
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('addedanewaccount').' <a href="accounts/account/' . $account . '"> '.lang('account').'-' . $account . '</a>' ),
			'staff_id' => $loggedinuserid
		) );
		return $account;
		
	}

	function update( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'accounts', $params );
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('updated').' <a href="accounts/account/' . $id . '"> '.lang('account').'-' . $id . '</a>' ),
			'staff_id' => $loggedinuserid
		) );
	}

	function delete_account( $id ) {
		$response = $this->db->delete( 'accounts', array( 'id' => $id ) );
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('deleted').' '.lang('account').'-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}
}