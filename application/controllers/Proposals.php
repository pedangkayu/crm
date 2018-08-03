<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Proposals extends CIUIS_Controller {

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
		$data[ 'title' ] = lang( 'proposals' );
		$data[ 'proposals' ] = $this->Proposals_Model->get_all_proposals();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'proposals/index', $data );
	}

	function create() {
		$data[ 'title' ] = lang( 'createproposal' );
		$proposal_type = $this->input->post( 'proposal_type' );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			if ( $proposal_type != true ) {
				$relation_type = 'customer';
				$relation = $this->input->post( 'customer' );
			} else {
				$relation_type = 'lead';
				$relation = $this->input->post( 'lead' );
			};
			$allow_comment = $this->input->post( 'comment' );
			if ( $allow_comment != true ) {
				$comment_allow = 0;
			} else {
				$comment_allow = 1;
			};
			$params = array(
				'token' => md5( uniqid() ),
				'subject' => $this->input->post( 'subject' ),
				'content' => $this->input->post( 'content' ),
				'date' => _pdate( $this->input->post( 'date' ) ),
				'created' => _pdate( $this->input->post( 'created' ) ),
				'opentill' => _pdate( $this->input->post( 'opentill' ) ),
				'relation_type' => $relation_type,
				'relation' => $relation,
				'assigned' => $this->input->post( 'assigned' ),
				'addedfrom' => $this->session->usr_id,
				'datesend' => _pdate( $this->input->post( 'datesend' ) ),
				'comment' => $comment_allow,
				'status_id' => $this->input->post( 'status' ),
				'invoice_id' => $this->input->post( 'invoice' ),
				'dateconverted' => $this->input->post( 'dateconverted' ),
				'sub_total' => $this->input->post( 'sub_total' ),
				'total_discount' => $this->input->post( 'total_discount' ),
				'total_tax' => $this->input->post( 'total_tax' ),
				'total' => $this->input->post( 'total' ),
			);
			$proposals_id = $this->Proposals_Model->proposal_add( $params );
			echo $proposals_id;
		} else {
			$this->load->view( 'proposals/create', $data );
		}
	}

	function update( $id ) {
		$data[ 'title' ] = lang( 'updateproposal' );
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$data[ 'proposal' ] = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( isset( $pro[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				switch ( $this->input->post( 'proposal_type' ) ) {
					case 'true':
						$relation_type = 'lead';
						$relation = $this->input->post( 'lead' );
						break;
					case 'false':
						$relation_type = 'customer';
						$relation = $this->input->post( 'customer' );
						break;
				};
				switch ( $this->input->post( 'comment' ) ) {
					case 'true':
						$comment_allow = 1;
						break;
					case 'false':
						$comment_allow = 0;
						break;
				};
				$params = array(
					'subject' => $this->input->post( 'subject' ),
					'content' => $this->input->post( 'content' ),
					'date' => _pdate( $this->input->post( 'date' ) ),
					'created' => _pdate( $this->input->post( 'created' ) ),
					'opentill' => _pdate( $this->input->post( 'opentill' ) ),
					'relation_type' => $relation_type,
					'relation' => $relation,
					'assigned' => $this->input->post( 'assigned' ),
					'addedfrom' => $this->session->usr_id,
					'datesend' => _pdate( $this->input->post( 'datesend' ) ),
					'comment' => $comment_allow,
					'status_id' => $this->input->post( 'status' ),
					'invoice_id' => $this->input->post( 'invoice' ),
					'dateconverted' => $this->input->post( 'dateconverted' ),
					'sub_total' => $this->input->post( 'sub_total' ),
					'total_discount' => $this->input->post( 'total_discount' ),
					'total_tax' => $this->input->post( 'total_tax' ),
					'total' => $this->input->post( 'total' ),
				);
				$this->Proposals_Model->update_proposals( $id, $params );
				echo $id;
			} else {
				$this->load->view( 'proposals/update', $data );
			}
		} else
			$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'proposalediterror' ) );
	}

	function proposal( $id ) {
		$data[ 'title' ] = lang( 'proposal' );
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$this->load->view( 'proposals/proposal', $data );
	}

	function pdf( $id ) {
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

	function print_( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'title' ] = '' . lang( 'proposalprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
		$data[ 'opt_data' ] = 'I';
		$data[ 'opt_js' ] = 'print(true)';
		$this->load->view( 'proposals/pdf', $data );
	}

	function download( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'title' ] = '' . lang( 'proposalprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'D', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
		$data[ 'opt_data' ] = 'D';
		$data[ 'opt_js' ] = '';
		$this->load->view( 'proposals/pdf', $data );
	}

	function share( $id ) {
		// SEND EMAIL SETTINGS
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$this->load->library( 'email' );
		$config = array();
		$config[ 'protocol' ] = 'smtp';
		$config[ 'smtp_host' ] = $setconfig[ 'smtphost' ];
		$config[ 'smtp_user' ] = $setconfig[ 'smtpusername' ];
		$config[ 'smtp_pass' ] = $setconfig[ 'smtppassoword' ];
		$config[ 'smtp_port' ] = $setconfig[ 'smtpport' ];
		$sender = $setconfig[ 'sendermail' ];
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			switch ( $proposal[ 'type' ] ) {
				case '0':
					$proposalto = $proposal[ 'customercompany' ];
					break;
				case '1':
					$proposalto = $proposal[ 'namesurname' ];
					break;
			}
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$proposalto = $proposal[ 'leadname' ];
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		//
		$data = array(
			'customer' => $proposalto,
			'customermail' => $proposaltoemail,
			'proposallink' => '' . base_url( 'share/proposal/' . $pro[ 'token' ] . '' ) . ''
		);
		$body = $this->load->view( 'email/proposals/send.php', $data, TRUE );
		$this->email->initialize( $config );
		$this->email->set_newline( "\r\n" );
		$this->email->set_mailtype( "html" );
		$this->email->from( $sender );
		$this->email->to( $proposaltoemail );
		$this->email->subject( lang( 'newproposal' ) );
		$this->email->message( $body );
		if ( $this->email->send() ) {
			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		}


	}

	function expiration( $id ) {
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		// SEND EMAIL SETTINGS
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$this->load->library( 'email' );
		$config = array();
		$config[ 'protocol' ] = 'smtp';
		$config[ 'smtp_host' ] = $setconfig[ 'smtphost' ];
		$config[ 'smtp_user' ] = $setconfig[ 'smtpusername' ];
		$config[ 'smtp_pass' ] = $setconfig[ 'smtppassoword' ];
		$config[ 'smtp_port' ] = $setconfig[ 'smtpport' ];
		$sender = $setconfig[ 'sendermail' ];
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			switch ( $proposal[ 'type' ] ) {
				case '0':
					$proposalto = $proposal[ 'customercompany' ];
					break;
				case '1':
					$proposalto = $proposal[ 'namesurname' ];
					break;
			}
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$proposalto = $proposal[ 'leadname' ];
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		//
		$data = array(
			'customer' => $proposalto,
			'customermail' => $proposaltoemail,
			'proposallink' => '' . base_url( 'share/proposal/' . $pro[ 'token' ] . '' ) . ''
		);
		$body = $this->load->view( 'email/proposals/expiration.php', $data, TRUE );
		$this->email->initialize( $config );
		$this->email->set_newline( "\r\n" );
		$this->email->set_mailtype( "html" );
		$this->email->from( $sender );
		$this->email->to( $proposaltoemail );
		$this->email->subject( lang( 'proposalexpiryreminder' ) );
		$this->email->message( $body );
		if ( $this->email->send() ) {
			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		}
	}

	function convert_invoice( $id ) {
		$data[ 'title' ] = lang( 'convertproposaltoinvoice' );
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $proposal[ 'id' ] ) )->result_array();
		$date = strtotime( "+7 day" );
		if ( isset( $proposal['id'] ) ) {
			$params = array(
				'token' => md5( uniqid() ),
				'no' => null,
				'serie' => null,
				'customer_id' => $proposal[ 'relation' ],
				'staff_id' => $this->session->usr_id,
				'status_id' => 3,
				'created' => date( 'Y-m-d H:i:s' ),
				'duedate' => date( 'Y-m-d H:i:s', $date ),
				'datepayment' => 0,
				'duenote' => null,
				'proposal_id' => $proposal[ 'id' ],
				'sub_total' => $proposal[ 'sub_total' ],
				'total_discount' => $proposal[ 'total_discount' ],
				'total_tax' => $proposal[ 'total_tax' ],
				'total' => $proposal[ 'total' ],
			);
			$this->db->insert( 'invoices', $params );
			$invoice = $this->db->insert_id();
			$i = 0;
			foreach ( $items as $item ) {
				$this->db->insert( 'items', array(
					'relation_type' => 'invoice',
					'relation' => $invoice,
					'product_id' => $item[ 'product_id' ],
					'code' => $item[ 'code' ],
					'name' => $item[ 'name' ],
					'description' => $item[ 'description' ],
					'quantity' => $item[ 'quantity' ],
					'unit' => $item[ 'unit' ],
					'price' => $item[ 'price' ],
					'tax' => $item[ 'tax' ],
					'discount' => $item[ 'discount' ],
					'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
				) );
				$i++;
			};
			//LOG
			$staffname = $this->session->staffname;
			$loggedinuserid = $this->session->usr_id;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="invoices/invoice/' . $invoice . '">' . lang( 'invoiceprefix' ) . '-' . $invoice . '</a>.' ),
				'staff_id' => $loggedinuserid,
				'customer_id' => $proposal[ 'relation' ]
			) );
			//NOTIFICATION
			$staffname = $this->session->staffname;
			$staffavatar = $this->session->staffavatar;
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewinvoice' ) . '' ),
				'customer_id' => $proposal[ 'relation' ],
				'perres' => $staffavatar,
				'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
			) );
			//--------------------------------------------------------------------------------------
			$this->db->insert( $this->db->dbprefix . 'sales', array(
				'invoice_id' => '' . $invoice . '',
				'status_id' => 3,
				'staff_id' => $loggedinuserid,
				'customer_id' => $proposal[ 'relation' ],
				'total' => $proposal[ 'total' ],
				'date' => date( 'Y-m-d H:i:s' )
			) );

			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'invoice_id' => $invoice, 'status_id' => 6, 'dateconverted' => date( 'Y-m-d H:i:s' ) ) );
			redirect( 'invoices/update/' . $invoice . '' );
		}
	}

	function markas() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'proposal_id' => $_POST[ 'proposal_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Proposals_Model->markas();
		}
	}

	function cancelled() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'proposal' => $_POST[ 'proposal_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Proposals_Model->cancelled();
		}
	}

	function remove( $id ) {
		$proposals = $this->Proposals_Model->get_pro_rel_type( $id );
		if ( isset( $proposals[ 'id' ] ) ) {
			$this->session->set_flashdata( 'ntf4', lang( 'proposaldeleted' ) );
			$this->Proposals_Model->delete_proposals( $id );
			redirect( 'proposals/index' );
		} else
			show_error( 'The proposals you are trying to delete does not exist.' );
	}

	function remove_item( $id ) {
		$response = $this->db->delete( 'items', array( 'id' => $id ) );
	}
}