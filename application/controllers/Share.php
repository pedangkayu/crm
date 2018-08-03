<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Share extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model( 'Settings_Model' );
		define( 'LANG', $this->Settings_Model->get_crm_lang() );
		define( 'currency', $this->Settings_Model->get_currency() );
		$this->lang->load( LANG, LANG );
		$this->load->model( 'Invoices_Model' );
		$this->load->model( 'Proposals_Model' );
		$this->load->model( 'Report_Model' );
	}

	function invoice( $token ) {
		$invoice = $this->Invoices_Model->get_invoices_by_token( $token );
		$data[ 'invoice' ] = $this->Invoices_Model->get_invoices_by_token( $token );
		$invoice = $this->Invoices_Model->get_invoices_by_token( $token );
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $invoice[ 'id' ] ) )->result_array();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'title' ] = 'INV-' . $invoice[ 'id' ] . ' Detail';
		$this->load->view( 'share/invoice', $data );
	}

	function proposal( $token ) {
		$proposal = $this->Proposals_Model->get_proposal_by_token( $token );
		$id = $proposal[ 'id' ];
		$data[ 'title' ] = 'PRO-' . $id . ' Detail';
		$this->load->model( 'Proposals_Model' );
		$this->load->model( 'Settings_Model' );
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
		$data[ 'comments' ] = $this->db->get_where( 'comments', array( 'relation' => $id, 'relation_type' => 'proposal' ) )->result_array();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'share/proposal', $data );
	}

	function pdf( $token ) {
		$invoice = $this->Invoices_Model->get_invoices_by_token( $token );
		$id = $invoice[ 'id' ];
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$ind = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $id ) )->result_array();
		$data[ 'opt_data' ] = 'I';
		$data[ 'opt_js' ] = '';
		$this->load->view( 'invoices/pdf', $data );
	}

	function pdf_proposal( $token ) {
		$proposal = $this->Proposals_Model->get_proposal_by_token( $token );
		$id = $proposal[ 'id' ];
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'title' ] = '' . lang( 'proposalprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
		$data[ 'opt_data' ] = 'I';
		$data[ 'opt_js' ] = '';
		$this->load->view( 'proposals/pdf', $data );
	}

	function customercomment() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'content' => $this->input->post( 'content' ),
				'relation' => $this->input->post( 'relation' ),
				'relation_type' => 'proposal',
				'staff_id' => $this->session->userdata( 'usr_id' ),
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$action = $this->db->insert( 'comments', $params );
			$proposals = $this->Proposals_Model->get_pro_rel_type( $this->input->post( 'relation' ) );
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => $message = sprintf( lang( 'newcommentforproposal' ), str_pad( $proposals[ 'id' ], 6, '0', STR_PAD_LEFT ) ),
				'staff_id' => $proposals[ 'assigned' ],
				'perres' => 'customer_avatar_comment.png',
				'target' => '' . base_url( 'proposals/proposal/' . $proposals[ 'id' ] . '' ) . ''
			) );
			$this->session->set_flashdata( 'ntf1', '' . lang( 'commentadded' ) . '' );
			redirect( 'share/proposal/' . $proposals[ 'token' ] . '' );
		} else {
			redirect( 'proposals/index' );
		}
	}

	function markasproposal() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'proposal_id' => $_POST[ 'proposal_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			if ( $_POST[ 'status_id' ] == 5 ) {
				$notificationmessage = lang( 'proposaldeclined' );
			}
			if ( $_POST[ 'status_id' ] == 6 ) {
				$notificationmessage = lang( 'proposalaccepted' );
			}
			$proposals = $this->Proposals_Model->get_proposal( $_POST[ 'proposal_id' ] );
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => $message = sprintf( $notificationmessage, str_pad( $proposals[ 'id' ], 6, '0', STR_PAD_LEFT ) ),
				'staff_id' => $proposals[ 'assigned' ],
				'perres' => 'customer_avatar_comment.png',
				'target' => '' . base_url( 'proposals/proposal/' . $proposals[ 'id' ] . '' ) . ''
			) );
			$actionpro = $this->Proposals_Model->markas();
		}
	}

}