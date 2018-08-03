<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Invoices extends CIUIS_Controller {

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
		$data[ 'title' ] = lang( 'invoices' );
		$data[ 'off' ] = $this->Report_Model->pff();
		$data[ 'ofv' ] = $this->Report_Model->ofv();
		$data[ 'oft' ] = $this->Report_Model->oft();
		$data[ 'vgf' ] = $this->Report_Model->vgf();
		$data[ 'tfa' ] = $this->Report_Model->tfa();
		$data[ 'pfs' ] = $this->Report_Model->pfs();
		$data[ 'otf' ] = $this->Report_Model->otf();
		$data[ 'tef' ] = $this->Report_Model->tef();
		$data[ 'vdf' ] = $this->Report_Model->vdf();
		$data[ 'fam' ] = $this->Report_Model->fam();
		$data[ 'ofy' ] = ( $data[ 'tfa' ] > 0 ? number_format( ( $data[ 'tef' ] * 100 ) / $data[ 'tfa' ] ) : 0 );
		$data[ 'ofx' ] = ( $data[ 'tfa' ] > 0 ? number_format( ( $data[ 'otf' ] * 100 ) / $data[ 'tfa' ] ) : 0 );
		$data[ 'vgy' ] = ( $data[ 'tfa' ] > 0 ? number_format( ( $data[ 'vdf' ] * 100 ) / $data[ 'tfa' ] ) : 0 );
		$data[ 'invoices' ] = $this->Invoices_Model->get_all_invoices();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'invoices/index', $data );
	}

	function create() {
		$data[ 'title' ] = lang( 'newinvoice' );
		$products = $this->Products_Model->get_all_products();
		$settings = $this->Settings_Model->get_settings_ciuis();
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$status_value = $this->input->post( 'status' );
			if ( $status_value == 'true' ) {
				$datepayment = $this->input->post( 'datepayment' );
				$duenote = null;
				$duedate = null;
				$status = 2;
			} else {
				$duedate = $this->input->post( 'duedate' );
				$duenote = $this->input->post( 'duenote' );
				$datepayment = null;
				$status = 3;
			}

			$params = array(
				'token' => md5( uniqid() ),
				'no' => $this->input->post( 'no' ),
				'serie' => $this->input->post( 'serie' ),
				'customer_id' => $this->input->post( 'customer' ),
				'staff_id' => $this->session->usr_id,
				'status_id' => $status,
				'created' => $this->input->post( 'created' ),
				'duedate' => $duedate,
				'datepayment' => $datepayment,
				'duenote' => $duenote,
				'sub_total' => $this->input->post( 'sub_total' ),
				'total_discount' => $this->input->post( 'total_discount' ),
				'total_tax' => $this->input->post( 'total_tax' ),
				'total' => $this->input->post( 'total' ),
			);
			$invoices_id = $this->Invoices_Model->invoice_add( $params );
			echo $invoices_id;

			// START Recurring Invoice
			if($this->input->post( 'recurring' ) == 'true'){
				$SHXparams = array(
					'relation_type' => 'invoice',
					'relation' => $invoices_id,
					'period' => $this->input->post( 'recurring_period' ),
					'end_date' => $this->input->post( 'end_recurring' ),
					'type' => $this->input->post( 'recurring_type' ),
				);
				$recurring_invoices_id = $this->Invoices_Model->recurring_add( $SHXparams );
			}
			// END Recurring Invoice
		} else {
			$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
			$data[ 'all_accounts' ] = $this->Accounts_Model->get_all_accounts();
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$this->load->view( 'invoices/create', $data );
		}
	}

	function update( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$data[ 'title' ] = '' . lang( 'updateinvoicetitle' ) . ' ' . lang( 'invoiceprefix' ) . '-' . str_pad( $invoices[ 'id' ], 6, '0', STR_PAD_LEFT ) . '';
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				if ( $invoices[ 'status_id' ] == 2 ) {
					$datepayment = $this->input->post( 'datepayment' );
					$duenote = null;
					$duedate = null;
				} else {
					$duedate = $this->input->post( 'duedate' );
					$duenote = $this->input->post( 'duenote' );
					$datepayment = null;
				}
				$params = array(
					'no' => $this->input->post( 'no' ),
					'serie' => $this->input->post( 'serie' ),
					'customer_id' => $this->input->post( 'customer' ),
					'created' => $this->input->post( 'created' ),
					'duedate' => $duedate,
					'duenote' => $duenote,
					'sub_total' => $this->input->post( 'sub_total' ),
					'total_discount' => $this->input->post( 'total_discount' ),
					'total_tax' => $this->input->post( 'total_tax' ),
					'total' => $this->input->post( 'total' ),
				);
				$this->Invoices_Model->update_invoices( $id, $params );
				echo $id;

				// START Recurring Invoice
				if($this->input->post( 'recurring_status' ) === true){
					$SHXparams = array(
						'period' => $this->input->post( 'recurring_period' ),
						'end_date' => $this->input->post( 'end_recurring' ),
						'type' => $this->input->post( 'recurring_type' ),
						'status' => 0,
					);
					$recurring_invoices_id = $this->Invoices_Model->recurring_update( $id ,$SHXparams );
				}else{
					$SHXparams = array(
						'period' => $this->input->post( 'recurring_period' ),
						'end_date' => $this->input->post( 'end_recurring' ),
						'type' => $this->input->post( 'recurring_type' ),
						'status' => 1,
					);
					$recurring_invoices_id = $this->Invoices_Model->recurring_update( $id ,$SHXparams );
				}
				if(!is_numeric($this->input->post( 'recurring_id' ))){ // NEW Recurring From Update
					$SHXparams = array(
						'relation_type' => 'invoice',
						'relation' => $id,
						'period' => $this->input->post( 'recurring_period' ),
						'end_date' => $this->input->post( 'end_recurring' ),
						'type' => $this->input->post( 'recurring_type' ),
					);
					$recurring_invoices_id = $this->Invoices_Model->recurring_add( $SHXparams );
				}
				// END Recurring Invoice
			} else {
				$this->load->view( 'invoices/update', $data );
			}
		} else
			$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'error' ) );
	}

	function invoice( $id ) {
		$invoices = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $invoices[ 'id' ], 6, '0', STR_PAD_LEFT ) . ' ' . lang( 'detail' ) . '';
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$this->load->view( 'invoices/invoice', $data );
	}

	function record_payment() {
		$amount = $this->input->post( 'amount' );
		$invoicetotal = $this->input->post( 'invoicetotal' );
		if ( $amount > $invoicetotal ) {
			echo lang( 'paymentamounthigh' );
		} else {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'invoice_id' => $this->input->post( 'invoice' ),
					'amount' => $amount,
					'account_id' => $this->input->post( 'account' ),
					'date' => $this->input->post( 'date' ),
					'not' => $this->input->post( 'not' ),
					'attachment' => $this->input->post( 'attachment' ),
					'customer_id' => $this->input->post( 'customer' ),
					'staff_id' => $this->input->post( 'staff' ),
				);
				$payments = $this->Payments_Model->addpayment( $params );
				echo lang( 'paymentaddedsuccessfully' );

			}
		}
	}

	function pdf( $id ) {
		$ind = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $id ) )->result_array();
		$data[ 'opt_data' ] = 'I';
		$data[ 'opt_js' ] = '';
		$this->load->view( 'invoices/pdf', $data );
	}

	function print_( $id ) {
		$ind = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $id ) )->result_array();
		$data[ 'opt_data' ] = 'I';
		$data[ 'opt_js' ] = 'print(true)';
		$this->load->view( 'invoices/pdf', $data );
	}

	function download( $id ) {
		$ind = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $id ) )->result_array();
		$data[ 'opt_data' ] = 'D';
		$data[ 'opt_js' ] = '';
		$this->load->view( 'invoices/pdf', $data );
	}

	function share( $id ) {
		$inv = $this->Invoices_Model->get_invoice_detail( $id );
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
		switch ( $inv[ 'type' ] ) {
			case '0':
				$invcustomer = $inv[ 'customercompany' ];
				break;
			case '1':
				$invcustomer = $inv[ 'namesurname' ];
				break;
		}
		$data = array(
			'customer' => $invcustomer,
			'customermail' => $inv[ 'email' ],
			'invoicelink' => '' . base_url( 'share/invoice/' . $inv[ 'token' ] . '' ) . ''
		);
		$body = $this->load->view( 'email/invoices/sendinvoice.php', $data, TRUE );
		$this->email->initialize( $config );
		$this->email->set_newline( "\r\n" );
		$this->email->set_mailtype( "html" );
		$this->email->from( $sender ); // change it to yours
		$this->email->to( $inv[ 'email' ] ); // change it to yours
		$this->email->subject( lang( 'yourinvoicedetails' ) );
		$this->email->message( $body );
		if ( $this->email->send() ) {
			$response = $this->db->where( 'id', $id )->update( 'invoices', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' .$inv[ 'email' ], lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'invoices/invoice/' . $id . '' );

		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'invoices/invoice/' . $id . '' );
		}


	}

	function mark_as_draft( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'invoices', array( 'status_id' => 1 ) );
		$response = $this->db->update( 'sales', array( 'invoice_id' => $id, 'status_id' => 1 ) );
		echo lang( 'markedasdraft' );
	}

	function mark_as_cancelled( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'invoices', array( 'status_id' => 4 ) );
		$response = $this->db->delete( 'sales', array( 'invoice_id' => $id ) );
		$response = $this->db->delete( 'payments', array( 'invoice_id' => $id ) );
		echo lang( 'markedascancelled' );
	}

	function remove( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->session->set_flashdata( 'ntf4', lang( 'invoicedeleted' ) );
			$this->Invoices_Model->delete_invoices( $id );
			redirect( 'invoices/index' );
		} else
			show_error( 'The invoices you are trying to delete does not exist.' );
	}

	function remove_item( $id ) {
		$response = $this->db->delete( 'items', array( 'id' => $id ) );
	}

}