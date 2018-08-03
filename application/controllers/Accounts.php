<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Accounts extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index() {
		$data[ 'title' ] = lang( 'accounts' );
		$data[ 'accounts' ] = $this->Accounts_Model->get_all_accounts();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'accounts/index', $data );
		$this->load->view( 'inc/footer', $data );
	}

	function account( $id ) {
		$data[ 'title' ] = lang( 'account' );
		$data[ 'account' ] = $this->Accounts_Model->get_accounts( $id );
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'accounts/account', $data );
		$this->load->view( 'inc/footer', $data );
	}

	function create() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'type' => $this->input->post( 'type' ),
				'bankname' => $this->input->post( 'bankname' ),
				'branchbank' => $this->input->post( 'branchbank' ),
				'account' => $this->input->post( 'account' ),
				'iban' => $this->input->post( 'iban' ),
				'status_id' => 0,
			);
			$id = $this->Accounts_Model->create( $params );
			$data_account = array(
				'id' => $id,
				'name' => $this->input->post( 'name' ),
				'amount' => 0,
				'icon' => 'mdi mdi-balance',
				'status' => lang( 'accuntactive' ),
			);
			echo json_encode( $data_account );
		}
	}

	function update( $id ) {
		$data[ 'accounts' ] = $this->Accounts_Model->get_accounts( $id );
		if ( isset( $data[ 'accounts' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'bankname' => $this->input->post( 'bankname' ),
					'branchbank' => $this->input->post( 'branchbank' ),
					'account' => $this->input->post( 'account' ),
					'iban' => $this->input->post( 'iban' ),
					'status_id' => $this->input->post( 'status' ),
				);
				$this->Accounts_Model->update( $id, $params );
				echo lang( 'accountupdated' );
			} else {
				$this->load->view( 'accounts/', $data );
			}
		} else
			show_error( 'The expenses you are trying to edit does not exist.' );
	}

	function remove( $id ) {
		$accounts = $this->Accounts_Model->get_accounts( $id );
		if ( isset( $accounts[ 'id' ] ) ) {
			$this->Accounts_Model->delete_account( $id );
			redirect( 'accounts/index' );
		}
	}
}