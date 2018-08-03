<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Area extends CIUISCUSTOMER_Controller {

	public $inactive;
	public $roles;

	function __construct() {
		parent::__construct();
		$this->load->model( 'Settings_Model' );
		define( 'LANG', $this->Settings_Model->get_crm_lang() );
		$this->lang->load( LANG, LANG );
		$this->load->library( array( 'session' ) );
		$this->load->helper( array( 'url' ) );
		$this->load->model( 'Area_Model' );
		$this->load->model( 'Contacts_Model' );
		$this->load->model( 'Settings_Model' );
		$this->load->model( 'Tasks_Model' );
		$this->load->model( 'Projects_Model' );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_error_delimiters( '<div class="error">', '</div>' );
		$this->inactive = $this->config->item( 'inactive' );
		$this->roles = $this->config->item( 'roles' );
	}

	function login() {
		$data = new stdClass();
		$this->load->helper( 'form' );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'email', 'Email', 'required' );
		$this->form_validation->set_rules( 'password', 'Password', 'required' );
		if ( $this->form_validation->run() == false ) {
			$this->load->view( 'area/login/login' );
		} else {
			$email = $this->input->post( 'email' );
			$password = $this->input->post( 'password' );
			if ( $this->Area_Model->resolve_user_login( $email, $password ) ) {
				$contact_id = $this->Area_Model->get_contact_id_from_email( $email );
				$user = $this->Area_Model->get_user( $contact_id );
				$_SESSION[ 'contact_id' ] = ( int )$user->id;
				$_SESSION[ 'customer' ] = ( int )$user->customer_id;
				$_SESSION[ 'name' ] = ( string )$user->name;
				$_SESSION[ 'surname' ] = ( string )$user->surname;
				$_SESSION[ 'email' ] = ( string )$user->email;
				$_SESSION[ 'logged_in' ] = ( bool )true;
				redirect( 'area/index' );
			} else {
				$data->error = lang( 'wrongmessage' );
				$this->load->view( 'area/login/login', $data );

			}
		}
	}

	function logout() {
		$data = new stdClass();
		if ( isset( $_SESSION[ 'logged_in' ] ) && $_SESSION[ 'logged_in' ] === true ) {
			foreach ( $_SESSION as $key => $value ) {
				unset( $_SESSION[ $key ] );
			}
			redirect( '/area' );
		} else {
			redirect( '/area' );
		}
	}
	public

	function forgot() {

		$this->form_validation->set_rules( 'email', 'Email', 'required|valid_email' );

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view( 'area/login/forgot' );
		} else {
			$email = $this->input->post( 'email' );
			$clean = $this->security->xss_clean( $email );
			$userInfo = $this->Contacts_Model->getUserInfoByEmail( $clean );

			if ( !$userInfo ) {
				$this->session->set_flashdata( 'ntf4', lang( 'customercanffindmail' ) );
				redirect( site_url() . 'area/login' );
			}

			if ( $userInfo->inactive != $this->inactive[ 1 ] ) { //if inactive is not approved
				$this->session->set_flashdata( 'ntf4', lang( 'customerinactiveaccount' ) );
				redirect( site_url() . 'area/login' );
			}

			//build token 

			$token = $this->Contacts_Model->insertToken( $userInfo->id );
			$qstring = $this->base64url_encode( $token );
			$url = site_url() . 'area/reset_password/token/' . $qstring;
			$link = '<a href="' . $url . '">' . $url . '</a>';
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
			$data = array(
				'name' => $userInfo->name,
				'email' => $userInfo->email,
				'link' => $url,
			);
			$body = $this->load->view( 'email/reset_password.php', $data, TRUE );
			$this->email->initialize( $config );
			$this->email->set_newline( "\r\n" );
			$this->email->set_mailtype( "html" );
			$this->email->from( $sender ); // change it to yours
			$this->email->to( $userInfo->email ); // change it to yours
			$this->email->subject( lang( 'resetyourpassword' ) );
			$this->email->message( $body );
			$this->email->send();
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'customerpasswordsend' ) . '</b>' );
			redirect( 'area/login' );

		}

	}

	public

	function reset_password() {
		$token = $this->base64url_decode( $this->uri->segment( 4 ) );
		$cleanToken = $this->security->xss_clean( $token );

		$user_info = $this->Contacts_Model->isTokenValid( $cleanToken ); //either false or array();               

		if ( !$user_info ) {
			$this->session->set_flashdata( 'ntf1', lang( 'tokenexpired' ) );
			redirect( site_url() . 'area/login' );
		}
		$data = array(
			'firstName' => $user_info->name,
			'email' => $user_info->email,
			//                'contact_id'=>$user_info->id, 
			'token' => $this->base64url_encode( $token )
		);

		$this->form_validation->set_rules( 'password', 'Password', 'required|min_length[5]' );
		$this->form_validation->set_rules( 'passconf', 'Password Confirmation', 'required|matches[password]' );

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view( 'area/login/reset_password', $data );
		} else {

			$post = $this->input->post( NULL, TRUE );
			$cleanPost = $this->security->xss_clean( $post );
			$hashed = password_hash( $cleanPost[ 'password' ], PASSWORD_BCRYPT );
			$cleanPost[ 'password' ] = $hashed;
			$cleanPost[ 'contact_id' ] = $user_info->id;
			unset( $cleanPost[ 'passconf' ] );
			if ( !$this->Contacts_Model->updatePassword( $cleanPost ) ) {
				$this->session->set_flashdata( 'ntf1', lang( 'problemupdatepassword' ) );
			} else {
				$this->session->set_flashdata( 'ntf1', lang( 'passwordupdated' ) );
			}
			redirect( site_url() . 'area/login' );
		}
	}

	public

	function base64url_encode( $data ) {
		return rtrim( strtr( base64_encode( $data ), '+/', '-_' ), '=' );
	}

	public

	function base64url_decode( $data ) {
		return base64_decode( str_pad( strtr( $data, '-_', '+/' ), strlen( $data ) % 4, '=', STR_PAD_RIGHT ) );
	}

	function index() {
		if ( isset( $_SESSION[ 'logged_in' ] ) && $_SESSION[ 'logged_in' ] === true ) {
			$data[ 'title' ] = lang( 'areatitleindex' );
			$data[ 'ycr' ] = $this->Report_Model->ycr();
			$data[ 'customerdebt' ] = $this->Area_Model->customerdebt();
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data[ 'customer_annual_sales_chart' ] = $this->Area_Model->customer_annual_sales_chart();
			$data[ 'totalticket' ] = $this->db->from( 'tickets' )->where( 'customer_id = ' . $_SESSION[ 'customer' ] . '' )->get()->num_rows();
			$data[ 'totalinvoices' ] = $this->db->from( 'invoices' )->where( 'customer_id = ' . $_SESSION[ 'customer' ] . '' )->get()->num_rows();
			$data[ 'totalproposals' ] = $this->db->from( 'proposals' )->where( 'relation = ' . $_SESSION[ 'customer' ] . ' AND relation_type = "customer"' )->get()->num_rows();
			$data[ 'totalcontact' ] = $this->db->from( 'contacts' )->where( 'customer_id = ' . $_SESSION[ 'customer' ] . '' )->get()->num_rows();
			$data[ 'totalpayment' ] = $this->db->from( 'payments' )->where( 'customer_id = ' . $_SESSION[ 'customer' ] . '' )->get()->num_rows();
			$this->load->view( 'area/inc/header', $data );
			$this->load->view( 'area/index/area', $data );

		} else {
			redirect( 'area/login' );
		}
	}

	function mark_read_notification( $id ) {
		if ( isset( $id ) ) {
			$response = $this->db->where( 'id', $id )->update( 'notifications', array( 'customerread' => ( 1 ) ) );
		}
	}

	function new_appointment() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'note' => $_POST[ 'note' ],
				'start' => $_POST[ 'date' ],
				'staff_id' => $_POST[ 'staff_id' ],
				'contact_id' => $_SESSION[ 'contact_id' ],
			);
			$appointment = $this->Events_Model->new_appointment( $params );
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => '' . $message = sprintf( lang( 'x_wants_an_appointment' ), $_SESSION[ 'name' ] ) . '',
				'perres' => 'n-img.png',
				'staff_id' => $_POST[ 'staff_id' ],
				'target' => '' . base_url( 'calendar' ) . ''
			) );
			echo lang( 'appointment_request_sent' );
		}
	}

	function invoices() {

		$data[ 'title' ] = lang( 'areatitleinvoices' );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'area/invoices/index', $data );

	}

	function invoice( $token ) {
		$invoice = $this->Invoices_Model->get_invoices_by_token( $token );
		$data[ 'invoice' ] = $this->Invoices_Model->get_invoices_by_token( $token );
		$invoice = $this->Invoices_Model->get_invoices_by_token( $token );
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $invoice[ 'id' ] ) )->result_array();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'title' ] = 'INV-' . $invoice[ 'id' ] . ' Detail';
		$this->load->view( 'area/invoices/invoice', $data );
	}

	function projects() {
		$data[ 'title' ] = lang( 'areatitleprojects' );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'area/projects/index', $data );
	}

	function project( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		$data[ 'title' ] = $project[ 'name' ];
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Proposals', 'proposals' );
		$this->breadcrumb->add_crumb( 'Proposal Detayı' );
		$data[ 'projects' ] = $this->Projects_Model->get_projects( $id );
		$this->load->view( 'area/projects/project', $data );
	}

	function proposals() {
		$data[ 'title' ] = lang( 'areatitleproposals' );
		$data[ 'proposals' ] = $this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,customers.company as customer,customers.email as toemail,customers.namesurname as individual,customers.address as toaddress, proposals.id as id ' )->join( 'customers', 'proposals.relation = customers.id', 'left' )->join( 'staff', 'proposals.assigned = staff.id', 'left' )->get_where( 'proposals', array( 'relation' => $_SESSION[ 'customer' ], 'relation_type' => 'customer' ) )->result_array();
		//Detaylar
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'area/proposals/index', $data );

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


	function tickets() {
		$data[ 'title' ] = lang( 'areatitletickets' );
		$data[ 'ttc' ] = $this->Area_Model->ttc();
		$data[ 'otc' ] = $this->Area_Model->otc();
		$data[ 'ipc' ] = $this->Area_Model->ipc();
		$data[ 'atc' ] = $this->Area_Model->atc();
		$data[ 'ctc' ] = $this->Area_Model->ctc();
		$data[ 'ysy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'otc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'bsy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ipc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'twy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'atc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'iey' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ctc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'tickets' ] = $this->db->select( '*,customers.type as type,customers.company as company,customers.namesurname as namesurname,departments.name as department,staff.staffname as staffmembername,contacts.name as contactname,contacts.surname as contactsurname,tickets.staff_id as stid, tickets.id as id ' )->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' )->join( 'customers', 'contacts.customer_id = customers.id', 'left' )->join( 'departments', 'tickets.department_id = departments.id', 'left' )->join( 'staff', 'tickets.staff_id = staff.id', 'left' )->get_where( 'tickets', array( 'contact_id' => $_SESSION[ 'contact_id' ] ) )->result_array();
		$data[ 'departments' ] = $this->db->get_where( 'departments', array( '' ) )->result_array();
		//Detaylar
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'area/inc/header', $data );
		$this->load->view( 'area/tickets/index', $data );
		$this->load->view( 'area/inc/footer', $data );

	}

	function create_ticket() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$config[ 'upload_path' ] = './uploads/attachments/';
			$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
			$this->load->library( 'upload', $config );
			$this->upload->do_upload( 'attachment' );
			$data_upload_files = $this->upload->data();
			$image_data = $this->upload->data();
			$params = array(
				'contact_id' => $_SESSION[ 'contact_id' ],
				'customer_id' => $_SESSION[ 'customer' ],
				'email' => $_SESSION[ 'email' ],
				'department_id' => $this->input->post( 'department' ),
				'priority' => $this->input->post( 'priority' ),
				'status_id' => 1,
				'subject' => $this->input->post( 'subject' ),
				'message' => $this->input->post( 'message' ),
				'attachment' => $image_data[ 'file_name' ],
				'date' => date( " Y.m.d H:i:s " ),
			);
			$this->session->set_flashdata( 'ntf1', 'Ticket added' );
			$tickets_id = $this->Area_Model->add_tickets( $params );
			redirect( 'area/tickets' );
		}
	}

	function ticket( $id ) {
		$data[ 'title' ] = lang( 'areatitletickets' );
		$data[ 'ticketstatustitle' ] = 'All Tickets';
		$data[ 'ttc' ] = $this->Area_Model->ttc();
		$data[ 'otc' ] = $this->Area_Model->otc();
		$data[ 'ipc' ] = $this->Area_Model->ipc();
		$data[ 'atc' ] = $this->Area_Model->atc();
		$data[ 'ctc' ] = $this->Area_Model->ctc();
		$data[ 'ysy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'otc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'bsy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ipc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'twy' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'atc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'iey' ] = ( $data[ 'ttc' ] > 0 ? number_format( ( $data[ 'ctc' ] * 100 ) / $data[ 'ttc' ] ) : 0 );
		$data[ 'ticket' ] = $this->Tickets_Model->get_tickets( $id );
		$data[ 'dtickets' ] = $this->db->select( '*,customers.type as type,customers.company as company,customers.namesurname as namesurname,departments.name as department,staff.staffname as staffmembername,contacts.name as contactname,contacts.surname as contactsurname,tickets.staff_id as stid, tickets.id as id ' )->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' )->join( 'customers', 'contacts.customer_id = customers.id', 'left' )->join( 'departments', 'tickets.department_id = departments.id', 'left' )->join( 'staff', 'tickets.staff_id = staff.id', 'left' )->get_where( 'tickets', array( 'contact_id' => $_SESSION[ 'contact_id' ] ) )->result_array();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'area/inc/header', $data );
		$this->load->view( 'area/tickets/ticket', $data );
		$this->load->view( 'area/inc/footer', $data );
	}

	function reply( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$ticket = $this->Tickets_Model->get_tickets( $id );
			$config[ 'upload_path' ] = './uploads/attachments/';
			$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
			$this->load->library( 'upload', $config );
			$this->upload->do_upload( 'attachment' );
			$data_upload_files = $this->upload->data();
			$image_data = $this->upload->data();
			$params = array(
				'ticket_id' => $id,
				'staff_id' => $ticket[ 'staff_id' ],
				'contact_id' => $_SESSION[ 'contact_id' ],
				'date' => date( " Y.m.d H:i:s " ),
				'name' => $_SESSION[ 'name' ],
				'message' => $this->input->post( 'message' ),
				'attachment' => $image_data[ 'file_name' ],
			);
			$contact = $_SESSION[ 'name' ];
			$contactavatar = 'n-img.png';
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $contact . ' replied ' . lang( 'ticket' ) . '-' . $id . '' ),
				'perres' => $contactavatar,
				'staff_id' => $ticket[ 'staff_id' ],
				'target' => '' . base_url( 'tickets/ticket/' . $id . '' ) . ''
			) );
			$response = $this->db->where( 'id', $id )->update( 'tickets', array(
				'status_id' => 1,
				'lastreply' => date( "Y.m.d H:i:s " ),
			) );
			// SEND EMAIL SETTINGS
			$staffinfo = $this->Staff_Model->getUserInfo( $ticket[ 'staff_id' ] );
			$setconfig = $this->Settings_Model->get_settings_ciuis();
			$this->load->library( 'email' );
			$config = array();
			$config[ 'protocol' ] = 'smtp';
			$config[ 'smtp_host' ] = $setconfig[ 'smtphost' ];
			$config[ 'smtp_user' ] = $setconfig[ 'smtpusername' ];
			$config[ 'smtp_pass' ] = $setconfig[ 'smtppassoword' ];
			$config[ 'smtp_port' ] = $setconfig[ 'smtpport' ];
			$sender = $setconfig[ 'sendermail' ];
			$data = array(
				'name' => $_SESSION[ 'name' ],
				'ticketlink' => '' . base_url( 'tickets/ticket/' . $id . '' ) . ''
			);
			$body = $this->load->view( 'email/ticket.php', $data, TRUE );
			$this->email->initialize( $config );
			$this->email->set_newline( "\r\n" );
			$this->email->set_mailtype( "html" );
			$this->email->from( $sender ); // change it to yours
			$this->email->to( $staffinfo->email ); // change it to yours
			$this->email->subject( lang( 'customerrepliedticket' ) );
			$this->email->message( $body );
			$this->email->send();
			/////////////
			$replyid = $this->Tickets_Model->add_reply_contact( $params );
			redirect( 'area/ticket/' . $id . '' );
		}
	}

	// API SERVICES

	function get_settings() {
		$settings = $this->Settings_Model->get_settings_ciuis();
		echo json_encode( $settings );
	}

	function get_projects() {
		$projects = $this->Projects_Model->get_all_projects_by_customer( $_SESSION[ 'customer' ] );
		$data_projects = array();
		foreach ( $projects as $project ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			$totaltasks = $this->Report_Model->totalprojecttasks( $project[ 'id' ] );
			$opentasks = $this->Report_Model->openprojecttasks( $project[ 'id' ] );
			$completetasks = $this->Report_Model->completeprojecttasks( $project[ 'id' ] );
			$progress = ( $totaltasks > 0 ? number_format( ( $completetasks * 100 ) / $totaltasks ) : 0 );
			$project_id = $project[ 'id' ];
			switch ( $project[ 'status' ] ) {
				case '1':
					$projectstatus = 'notstarted';
					$icon = 'notstarted.png';
					$status = lang( 'notstarted' );
					break;
				case '2':
					$projectstatus = 'started';
					$icon = 'started.png';
					$status = lang( 'started' );
					break;
				case '3':
					$projectstatus = 'percentage';
					$icon = 'percentage.png';
					$status = lang( 'percentage' );
					break;
				case '4':
					$projectstatus = 'cancelled';
					$icon = 'cancelled.png';
					$status = lang( 'cancelled' );
					break;
				case '5':
					$projectstatus = 'complete';
					$icon = 'complete.png';
					$status = lang( 'complete' );
					break;
			}
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $project[ 'start_date' ] );
					break;
				case 'dd.mm.yy':
					$startdate = _udate( $project[ 'start_date' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $project[ 'start_date' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $project[ 'start_date' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $project[ 'start_date' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $project[ 'start_date' ] );
					break;
			};
			if ( $project[ 'customercompany' ] === NULL ) {
				$customer = $project[ 'namesurname' ];
			} else $customer = $project[ 'customercompany' ];
			$enddate = $project[ 'deadline' ];
			$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( 'Asia/Dhaka' ) );
			$end_date = new DateTime( "$enddate", new DateTimeZone( 'Asia/Dhaka' ) );
			$interval = $current_date->diff( $end_date );
			$leftdays = $interval->format( '%a day(s)' );
			$members = $this->Projects_Model->get_members_index( $project_id );
			$milestones = $this->Projects_Model->get_all_project_milestones( $project_id );
			$data_projects[] = array(
				'id' => $project[ 'id' ],
				'project_id' => $project[ 'id' ],
				'name' => $project[ 'name' ],
				'pinned' => $project[ 'pinned' ],
				'progress' => $progress,
				'startdate' => $startdate,
				'leftdays' => $leftdays,
				'customer' => $customer,
				'status_icon' => $icon,
				'status' => $status,
				'status_class' => $projectstatus,
				'customer_id' => $project[ 'customer_id' ],
				'members' => $members,
				'milestones' => $milestones,
			);
		};
		echo json_encode( $data_projects );
	}

	function get_projectdetail( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		$settings = $this->Settings_Model->get_settings_ciuis();
		$milestones = $this->Projects_Model->get_all_project_milestones( $id );
		$projectmembers = $this->Projects_Model->get_members( $id );
		$project_logs = $this->Logs_Model->project_logs( $id );
		$totaltasks = $this->Report_Model->totalprojecttasks( $id );
		$opentasks = $this->Report_Model->openprojecttasks( $id );
		$completetasks = $this->Report_Model->completeprojecttasks( $id );
		$progress = ( $totaltasks > 0 ? number_format( ( $completetasks * 100 ) / $totaltasks ) : 0 );
		if ( $project[ 'customercompany' ] === NULL ) {
			$customer = $project[ 'namesurname' ];
		} else $customer = $project[ 'customercompany' ];
		$enddate = $project[ 'deadline' ];
		$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( $settings[ 'default_timezone' ] ) );
		$end_date = new DateTime( "$enddate", new DateTimeZone( $settings[ 'default_timezone' ] ) );
		$interval = $current_date->diff( $end_date );
		$project_left_date = $interval->format( '%a day(s)' );
		if ( date( "Y-m-d" ) > $project[ 'deadline' ] ) {
			$ldt = 'Time\'s up!';
		} else $ldt = $project_left_date;
		switch ( $project[ 'status' ] ) {
			case '1':
				$status = lang( 'notstarted' );
				break;
			case '2':
				$status = lang( 'started' );
				break;
			case '3':
				$status = lang( 'percentage' );
				break;
			case '4':
				$status = lang( 'cancelled' );
				break;
			case '5':
				$status = lang( 'complete' );
				break;
		};
		switch ( $settings[ 'dateformat' ] ) {
			case 'yy.mm.dd':
				$start = _rdate( $project[ 'start_date' ] );
				$deadline = _rdate( $project[ 'deadline' ] );
				$created = _rdate( $project[ 'created' ] );
				$finished = _rdate( $project[ 'finished' ] );

				break;
			case 'dd.mm.yy':
				$start = _udate( $project[ 'start_date' ] );
				$deadline = _udate( $project[ 'deadline' ] );
				$created = _udate( $project[ 'created' ] );
				$finished = _udate( $project[ 'finished' ] );
				break;
			case 'yy-mm-dd':
				$start = _mdate( $project[ 'start_date' ] );
				$deadline = _mdate( $project[ 'deadline' ] );
				$created = _mdate( $project[ 'created' ] );
				$finished = _mdate( $project[ 'finished' ] );
				break;
			case 'dd-mm-yy':
				$start = _cdate( $project[ 'start_date' ] );
				$deadline = _cdate( $project[ 'deadline' ] );
				$created = _cdate( $project[ 'created' ] );
				$finished = _cdate( $project[ 'finished' ] );
				break;
			case 'yy/mm/dd':
				$start = _zdate( $project[ 'start_date' ] );
				$deadline = _zdate( $project[ 'deadline' ] );
				$created = _zdate( $project[ 'created' ] );
				$finished = _zdate( $project[ 'finished' ] );
				break;
			case 'dd/mm/yy':
				$start = _kdate( $project[ 'start_date' ] );
				$deadline = _kdate( $project[ 'deadline' ] );
				$created = _kdate( $project[ 'created' ] );
				$finished = _kdate( $project[ 'finished' ] );
				break;
		};
		if ( $project[ 'invoice_id' ] > 0 ) {
			$billed = lang( 'yes' );
		} else {
			$billed = lang( 'no' );
		}
		$data_projectdetail = array(
			'id' => $project[ 'id' ],
			'name' => $project[ 'name' ],
			'description' => $project[ 'description' ],
			'start' => $start,
			'deadline' => $deadline,
			'created' => $created,
			'finished' => $finished,
			'status' => $status,
			'progress' => $progress,
			'totaltasks' => $totaltasks,
			'opentasks' => $opentasks,
			'completetasks' => $completetasks,
			'customer' => $customer,
			'ldt' => $ldt,
			'billed' => $billed,
			'milestones' => $milestones,
			'members' => $projectmembers,
			'project_logs' => $project_logs
		);
		echo json_encode( $data_projectdetail );
	}

	function get_projecttasks( $id ) {
		$tasks = $this->Tasks_Model->get_project_tasks( $id );
		$data_projecttasks = array();
		foreach ( $tasks as $task ) {

			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $task[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					$taskdone = '';
					break;
				case '2':
					$status = lang( 'inprogress' );
					$taskdone = '';
					break;
				case '3':
					$status = lang( 'waiting' );
					$taskdone = '';
					break;
				case '4':
					$status = lang( 'complete' );
					$taskdone = 'done';
					break;
				case '5':
					$status = lang( 'cancelled' );
					$taskdone = '';
					break;
			};
			switch ( $task[ 'relation_type' ] ) {
				case 'project':
					$relationtype = 'Project';
					break;
				case 'ticket':
					$relationtype = 'Tıcket';
					break;
				case 'proposal':
					$relationtype = 'Proposal';
					break;
			};
			switch ( $task[ 'priority' ] ) {
				case '0':
					$priority = lang( 'low' );
					break;
				case '1':
					$priority = lang( 'medium' );
					break;
				case '2':
					$priority = lang( 'high' );
					break;
			};
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $task[ 'startdate' ] );
					$duedate = _rdate( $task[ 'duedate' ] );
					$created = _rdate( $task[ 'created' ] );
					$datefinished = _rdate( $task[ 'datefinished' ] );

					break;
				case 'dd.mm.yy':
					$startdate = _udate( $task[ 'startdate' ] );
					$duedate = _udate( $task[ 'duedate' ] );
					$created = _udate( $task[ 'created' ] );
					$datefinished = _udate( $task[ 'datefinished' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $task[ 'startdate' ] );
					$duedate = _mdate( $task[ 'duedate' ] );
					$created = _mdate( $task[ 'created' ] );
					$datefinished = _mdate( $task[ 'datefinished' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $task[ 'startdate' ] );
					$duedate = _cdate( $task[ 'duedate' ] );
					$created = _cdate( $task[ 'created' ] );
					$datefinished = _cdate( $task[ 'datefinished' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $task[ 'startdate' ] );
					$duedate = _zdate( $task[ 'duedate' ] );
					$created = _zdate( $task[ 'created' ] );
					$datefinished = _zdate( $task[ 'datefinished' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $task[ 'startdate' ] );
					$duedate = _kdate( $task[ 'duedate' ] );
					$created = _kdate( $task[ 'created' ] );
					$datefinished = _kdate( $task[ 'datefinished' ] );
					break;
			};
			$data_projecttasks[] = array(
				'id' => $task[ 'id' ],
				'name' => $task[ 'name' ],
				'relationtype' => $relationtype,
				'status' => $status,
				'status_id' => $task[ 'status_id' ],
				'duedate' => $duedate,
				'startdate' => $startdate,
				'done' => $taskdone,
			);
		};
		echo json_encode( $data_projecttasks );
	}

	function get_projectmilestones( $id ) {
		$milestones = $this->Projects_Model->get_all_project_milestones( $id );
		$data_milestones = array();
		foreach ( $milestones as $milestone ) {
			if ( date( "Y-m-d" ) > $milestone[ 'duedate' ] ) {
				$status = 'is-completed';
			}
			if ( date( "Y-m-d" ) < $milestone[ 'duedate' ] ) {
				$status = 'is-future';
			};
			$tasks = $this->Projects_Model->get_all_project_milestones_task( $milestone[ 'id' ] );
			$data_milestones[] = array(
				'id' => $milestone[ 'id' ],
				'name' => $milestone[ 'name' ],
				'duedate' => $milestone[ 'duedate' ],
				'description' => $milestone[ 'description' ],
				'order' => $milestone[ 'order' ],
				'due' => $milestone[ 'duedate' ],
				'status' => $status,
				'tasks' => $tasks,
			);
		};
		echo json_encode( $data_milestones );
	}

	function get_projectfiles( $id ) {
		$files = $this->Projects_Model->get_project_files( $id );
		$data_files = array();
		foreach ( $files as $file ) {
			$data_files[] = array(
				'id' => $file[ 'id' ],
				'name' => $file[ 'file_name' ],
			);
		};
		echo json_encode( $data_files );
	}

	function get_projecttimelogs( $id ) {
		$timelogs = $this->Projects_Model->get_project_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $timelog[ 'task_id' ] );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'timed' => $timed_minute,
					'amount' => $amount,
				);
			}
		};
		echo json_encode( $data_timelogs );
	}

	function get_tasktimelogs( $id ) {
		$timelogs = $this->Tasks_Model->get_task_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $id );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'timed' => $timed_minute,
					'amount' => $amount,
				);
			};
		};
		echo json_encode( $data_timelogs );
	}

	function get_milestones() {
		$milestones = $this->Projects_Model->get_all_milestones();
		$data_milestones = array();
		foreach ( $milestones as $milestone ) {
			$data_milestones[] = array(
				'id' => $milestone[ 'id' ],
				'milestone_id' => $milestone[ 'id' ],
				'name' => $milestone[ 'name' ],
				'project_id' => $milestone[ 'project_id' ],
			);
		};
		echo json_encode( $data_milestones );
	}




	function get_stats() {
		$customer_debt = $this->Area_Model->customerdebt();
		if ( isset( $customer_debt ) ) {
			$customer_debit = $customer_debt;
		} else {
			$customer_debit = 0;
		}
		$data_stats = array(
			'newnotification' => $this->Area_Model->newnotification(),
			'customer_debt' => $customer_debit,
			'chart_data' => $this->Report_Model->customer_annual_sales_chart( $_SESSION[ 'customer' ] ),
		);
		echo json_encode( $data_stats );
	}

	function get_staff() {
		$staffs = $this->Staff_Model->get_all_staff();
		$data_staffs = array();
		foreach ( $staffs as $staff ) {
			$data_staffs[] = array(
				'id' => $staff[ 'id' ],
				'name' => $staff[ 'staffname' ],
				'avatar' => $staff[ 'staffavatar' ],
				'department' => $staff[ 'department' ],
				'phone' => $staff[ 'phone' ],
				'address' => $staff[ 'address' ],
				'email' => $staff[ 'email' ],
				'birthday' => $staff[ 'birthday' ],
				'last_login' => $staff[ 'last_login' ],
				'appointment_availability' => $staff[ 'appointment_availability' ],
			);
		};
		echo json_encode( $data_staffs );
	}

	function get_departments() {
		$departments = $this->Settings_Model->get_departments();
		$data_departments = array();
		foreach ( $departments as $department ) {
			$data_departments[] = array(
				'id' => $department[ 'id' ],
				'name' => $department[ 'name' ],
			);
		};
		echo json_encode( $data_departments );
	}

	function get_proposals() {
		$proposals = $this->Proposals_Model->get_all_proposals_by_customer( $_SESSION[ 'customer' ] );
		$data_proposals = array();
		foreach ( $proposals as $proposal ) {
			$pro = $this->Proposals_Model->get_proposals( $proposal[ 'id' ], $proposal[ 'relation_type' ] );
			if ( $pro[ 'relation_type' ] == 'customer' ) {
				if ( $pro[ 'customercompany' ] === NULL ) {
					$customer = $pro[ 'namesurname' ];
				} else $customer = $pro[ 'customercompany' ];
			}
			if ( $pro[ 'relation_type' ] == 'lead' ) {
				$customer = $pro[ 'leadname' ];
			}
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$date = _rdate( $proposal[ 'date' ] );
					$opentill = _rdate( $proposal[ 'opentill' ] );
					break;
				case 'dd.mm.yy':
					$date = _udate( $proposal[ 'date' ] );
					$opentill = _udate( $proposal[ 'opentill' ] );
					break;
				case 'yy-mm-dd':
					$date = _mdate( $proposal[ 'date' ] );
					$opentill = _mdate( $proposal[ 'opentill' ] );
					break;
				case 'dd-mm-yy':
					$date = _cdate( $proposal[ 'date' ] );
					$opentill = _cdate( $proposal[ 'opentill' ] );
					break;
				case 'yy/mm/dd':
					$date = _zdate( $proposal[ 'date' ] );
					$opentill = _zdate( $proposal[ 'opentill' ] );
					break;
				case 'dd/mm/yy':
					$date = _kdate( $proposal[ 'date' ] );
					$opentill = _kdate( $proposal[ 'opentill' ] );
					break;
			};
			switch ( $proposal[ 'status_id' ] ) {
				case '1':
					$status = lang( 'draft' );
					$class = 'proposal-status-accepted';
					break;
				case '2':
					$status = lang( 'sent' );
					$class = 'proposal-status-sent';
					break;
				case '3':
					$status = lang( 'open' );
					$class = 'proposal-status-open';
					break;
				case '4':
					$status = lang( 'revised' );
					$class = 'proposal-status-revised';
					break;
				case '5':
					$status = lang( 'declined' );
					$class = 'proposal-status-declined';
					break;
				case '6':
					$status = lang( 'accepted' );
					$class = 'proposal-status-accepted';
					break;

			};
			$data_proposals[] = array(
				'id' => $proposal[ 'id' ],
				'token' => $proposal[ 'token' ],
				'assigned' => $proposal[ 'assigned' ],
				'subject' => $proposal[ 'subject' ],
				'customer' => $customer,
				'relation_type' => $proposal[ 'relation_type' ],
				'relation' => $proposal[ 'relation' ],
				'date' => $date,
				'opentill' => $opentill,
				'status' => $status,
				'status_id' => $proposal[ 'status_id' ],
				'staff' => $proposal[ 'staffmembername' ],
				'staffavatar' => $proposal[ 'staffavatar' ],
				'total' => $proposal[ 'total' ],
				'class' => $class,
				'' . lang( 'filterbystatus' ) . '' => $status,
				'' . lang( 'filterbycustomer' ) . '' => $customer,
				'' . lang( 'filterbyassigned' ) . '' => $proposal[ 'staffmembername' ],
			);
		};
		echo json_encode( $data_proposals );
	}

	function get_invoices() {
		$invoices = $this->Invoices_Model->get_all_invoices_by_customer( $_SESSION[ 'customer' ] );
		$data_invoices = array();
		foreach ( $invoices as $invoice ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$created = _rdate( $invoice[ 'created' ] );
					$duedate = _rdate( $invoice[ 'duedate' ] );
					break;
				case 'dd.mm.yy':
					$created = _udate( $invoice[ 'created' ] );
					$duedate = _udate( $invoice[ 'duedate' ] );
					break;
				case 'yy-mm-dd':
					$created = _mdate( $invoice[ 'created' ] );
					$duedate = _mdate( $invoice[ 'duedate' ] );
					break;
				case 'dd-mm-yy':
					$created = _cdate( $invoice[ 'created' ] );
					$duedate = _cdate( $invoice[ 'duedate' ] );
					break;
				case 'yy/mm/dd':
					$created = _zdate( $invoice[ 'created' ] );
					$duedate = _zdate( $invoice[ 'duedate' ] );
					break;
				case 'dd/mm/yy':
					$created = _kdate( $invoice[ 'created' ] );
					$duedate = _kdate( $invoice[ 'duedate' ] );
					break;
			};
			if ( $invoice[ 'duedate' ] == 0000 - 00 - 00 ) {
				$realduedate = 'No Due Date';
			} else $realduedate = $duedate;
			$totalx = $invoice[ 'total' ];
			$this->db->select_sum( 'amount' )->from( 'payments' )->where( '(invoice_id =' . $invoice[ 'id' ] . ') ' );
			$paytotal = $this->db->get();
			$balance = $totalx - $paytotal->row()->amount;
			if ( $balance > 0 ) {
				$invoicestatus = '';
			} else $invoicestatus = lang( 'paidinv' );
			$color = 'success';;
			if ( $paytotal->row()->amount < $invoice[ 'total' ] && $paytotal->row()->amount > 0 && $invoice[ 'status_id' ] == 3 ) {
				$invoicestatus = lang( 'partial' );
				$color = 'warning';
			} else {
				if ( $paytotal->row()->amount < $invoice[ 'total' ] && $paytotal->row()->amount > 0 ) {
					$invoicestatus = lang( 'partial' );
					$color = 'warning';
				}
				if ( $invoice[ 'status_id' ] == 3 ) {
					$invoicestatus = lang( 'unpaid' );
					$color = 'danger';
				}
			}
			if ( $invoice[ 'status_id' ] == 1 ) {
				$invoicestatus = lang( 'draft' );
				$color = 'muted';
			}
			if ( $invoice[ 'status_id' ] == 4 ) {
				$invoicestatus = lang( 'cancelled' );
				$color = 'danger';
			}
			if ( $invoice[ 'customercompany' ] === NULL ) {
				$customer = $invoice[ 'individual' ];
			} else $customer = $invoice[ 'customercompany' ];
			$data_invoices[] = array(
				'id' => $invoice[ 'id' ],
				'token' => $invoice[ 'token' ],
				'prefix' => lang( 'invoiceprefix' ),
				'longid' => str_pad( $invoice[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'created' => $created,
				'duedate' => $realduedate,
				'customer' => $customer,
				'customer_id' => $invoice[ 'customer_id' ],
				'total' => $invoice[ 'total' ],
				'status' => $invoicestatus,
				'color' => $color,
				'' . lang( 'filterbystatus' ) . '' => $invoicestatus,
				'' . lang( 'filterbycustomer' ) . '' => $customer,
			);
		};
		echo json_encode( $data_invoices );
	}

	function get_invoicedetails( $id ) {
		$invoice = $this->Invoices_Model->get_invoices( $id );
		$payments = $this->db->select( '*,accounts.name as accountname,payments.id as id ' )->join( 'accounts', 'payments.account_id = accounts.id', 'left' )->get_where( 'payments', array( 'invoice_id' => $id ) )->result_array();
		$items = $this->db->select( '*,products.productname as name,invoiceitems.id as id ' )->join( 'products', 'invoiceitems.in[product_id] = products.id', 'left' )->get_where( 'invoiceitems', array( 'invoice_id' => $id ) )->result_array();
		$fatop = $this->Invoices_Model->get_items_invoices( $id );
		$tadtu = $this->Invoices_Model->get_paid_invoices( $id );
		$total = $invoice[ 'total' ];
		$today = time();
		$duedate = strtotime( $invoice[ 'duedate' ] ); // or your date as well
		$created = strtotime( $invoice[ 'created' ] );
		$paymentday = $duedate - $created; // Bunun sonucu 14 gün olcak
		$paymentx = $today - $created;
		$datepaymentnet = $paymentday - $paymentx;
		if ( $invoice[ 'duedate' ] == 0000 - 00 - 00 ) {
			$duedate_text = 'No Due Date';
		} else {
			if ( $datepaymentnet < 0 ) {
				$duedate_text = '<span class="text-danger mdi mdi-timer-off"></span> <span class="text-danger"><b>' . lang( 'overdue' ) . '</b> </span>';
				echo '<b>', floor( $datepaymentnet / ( 60 * 60 * 24 ) ), '</b> days';;

			} else {
				$duedate_text = lang( 'payableafter' ) . floor( $datepaymentnet / ( 60 * 60 * 24 ) ) . ' ' . lang( 'day' ) . '';

			}
		}
		if ( $invoice[ 'datesend' ] == '0000-00-00 00:00:00' ) {
			$mail_status = lang( 'notyetbeensent' );
		} else $mail_status = _adate( $invoice[ 'datesend' ] );
		$kalan = $total - $tadtu->row()->amount;
		$net_balance = $kalan;
		if ( $tadtu->row()->amount < $total && $tadtu->row()->amount > 0 ) {
			$partial_is = 'true';
		} else $partial_is = 'false';
		$invoice_details = array(
			'id' => $invoice[ 'id' ],
			'items' => $items,
			'payments' => $payments,
			'duedate_text' => $duedate_text,
			'mail_status' => $mail_status,
			'balance' => $net_balance,
			'partial_is' => $partial_is

		);
		echo json_encode( $invoice_details );
	}

	function get_notifications() {
		$notifications = $this->Area_Model->get_all_notifications();
		$data_notifications = array();
		foreach ( $notifications as $notification ) {
			switch ( $notification[ 'customerread' ] ) {
				case 0:
					$read = true;
					break;
				case 1:
					$read = false;
					break;
			};
			$data_notifications[] = array(
				'id' => $notification[ 'notifyid' ],
				'target' => $notification[ 'target' ],
				'date' => tes_ciuis( $notification[ 'date' ] ),
				'detail' => $notification[ 'detail' ],
				'perres' => $notification[ 'perres' ],
				'read' => $read,
			);
		};
		echo json_encode( $data_notifications );
	}

	function get_tickets() {
		$tickets = $this->Tickets_Model->get_all_tickets_by_customer( $_SESSION[ 'contact_id' ] );
		$data_tickets = array();
		foreach ( $tickets as $ticket ) {
			switch ( $ticket[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			$data_tickets[] = array(
				'id' => $ticket[ 'id' ],
				'subject' => $ticket[ 'subject' ],
				'message' => $ticket[ 'message' ],
				'staff_id' => $ticket[ 'staff_id' ],
				'contactname' => '' . $ticket[ 'contactname' ] . ' ' . $ticket[ 'contactsurname' ] . '',
				'priority' => $priority,
				'priority_id' => $ticket[ 'priority' ],
				'lastreply' => $ticket[ 'lastreply' ],
				'status_id' => $ticket[ 'status_id' ],
				'customer_id' => $ticket[ 'customer_id' ],
			);
		};
		echo json_encode( $data_tickets );
	}

	function get_ticket( $id ) {
		$ticket = $this->Tickets_Model->get_tickets( $id );
		switch ( $ticket[ 'priority' ] ) {
			case '1':
				$priority = lang( 'low' );
				break;
			case '2':
				$priority = lang( 'medium' );
				break;
			case '3':
				$priority = lang( 'high' );
				break;
		};
		switch ( $ticket[ 'status_id' ] ) {
			case '1':
				$status = lang( 'open' );
				break;
			case '2':
				$status = lang( 'inprogress' );
				break;
			case '3':
				$status = lang( 'answered' );
				break;
			case '4':
				$status = lang( 'closed' );
				break;
		};
		if ( $ticket[ 'type' ] == 0 ) {
			$customer = $ticket[ 'company' ];
		} else $customer = $ticket[ 'namesurname' ];
		$data_ticketdetails = array(
			'id' => $ticket[ 'id' ],
			'subject' => $ticket[ 'subject' ],
			'message' => $ticket[ 'message' ],
			'staff_id' => $ticket[ 'staff_id' ],
			'contact_id' => $ticket[ 'contact_id' ],
			'contactname' => '' . $ticket[ 'contactname' ] . ' ' . $ticket[ 'contactsurname' ] . '',
			'priority' => $priority,
			'priority_id' => $ticket[ 'priority' ],
			'lastreply' => $ticket[ 'lastreply' ],
			'status' => $status,
			'status_id' => $ticket[ 'status_id' ],
			'customer_id' => $ticket[ 'customer_id' ],
			'department' => $ticket[ 'department' ],
			'opened_date' => _adate( $ticket[ 'date' ] ),
			'last_reply_date' => _adate( $ticket[ 'lastreply' ] ),
			'attachment' => $ticket[ 'attachment' ],
			'customer' => $customer,
			'assigned_staff_name' => $ticket[ 'staffmembername' ],
			'replies' => $this->db->get_where( 'ticketreplies', array( 'ticket_id' => $id ) )->result_array(),
		);
		echo json_encode( $data_ticketdetails );
	}

	function get_logs() {
		$logs = $this->Logs_Model->panel_last_logs( $_SESSION[ 'customer' ] );
		$data_logs = array();
		foreach ( $logs as $log ) {
			$data_logs[] = array(
				'logdate' => _adate( $log[ 'date' ] ),
				'date' => tes_ciuis( $log[ 'date' ] ),
				'detail' => $log[ 'detail' ],
				'customer_id' => $log[ 'customer_id' ],
				'project_id' => $log[ 'project_id' ],
				'staff_id' => $log[ 'staff_id' ],
			);
		};
		echo json_encode( $data_logs );
	}

	function get_contacts() {
		$contacts = $this->Contacts_Model->get_all_contacts();
		$data_contacts = array();
		foreach ( $contacts as $contact ) {
			$data_contacts[] = array(
				'id' => $contact[ 'id' ],
				'customer_id' => $contact[ 'customer_id' ],
				'name' => '' . $contact[ 'name' ] . ' ' . $contact[ 'surname' ] . '',
				'email' => $contact[ 'email' ],
				'phone' => $contact[ 'phone' ],
				'username' => $contact[ 'username' ],
				'address' => $contact[ 'address' ],
			);
		};
		echo json_encode( $data_contacts );
	}

	function get_leftmenu() {
		$data_leftmenu = array(
			'1' => array(
				'title' => lang( 'x_menu_panel' ),
				'url' => base_url( 'area' ),
				'icon' => 'ion-ios-analytics-outline',
			),
			'2' => array(
				'title' => lang( 'x_menu_projects' ),
				'url' => base_url( 'area/projects' ),
				'icon' => 'ico-ciuis-projects',
			),
			'3' => array(
				'title' => lang( 'x_menu_invoices' ),
				'url' => base_url( 'area/invoices' ),
				'icon' => 'ico-ciuis-invoices',
			),
			'4' => array(
				'title' => lang( 'x_menu_proposals' ),
				'url' => base_url( 'area/proposals' ),
				'icon' => 'ico-ciuis-proposals',
			),
			'5' => array(
				'title' => lang( 'x_menu_tickets' ),
				'url' => base_url( 'area/tickets' ),
				'icon' => 'ico-ciuis-supports',
			),

		);
		echo json_encode( $data_leftmenu );
	}

	function get_notes() {
		$relation_type = $this->uri->segment( 3 );
		$relation_id = $this->uri->segment( 4 );
		$notes = $this->db->select( '*,staff.staffname as notestaff,notes.id as id ' )->join( 'staff', 'notes.addedfrom = staff.id', 'left' )->get_where( 'notes', array( 'relation' => $relation_id, 'relation_type' => $relation_type ) )->result_array();
		$data_projectnotes = array();
		foreach ( $notes as $note ) {
			$data_projectnotes[] = array(
				'id' => $note[ 'id' ],
				'description' => $note[ 'description' ],
				'staffid' => $note[ 'addedfrom' ],
				'staff' => $note[ 'notestaff' ],
				'date' => _adate( $note[ 'created' ] ),
			);
		};
		echo json_encode( $data_projectnotes );


	}

	function get_expenses_by_relation() {
		$relation_type = $this->uri->segment( 3 );
		$relation_id = $this->uri->segment( 4 );
		$expenses = $this->Expenses_Model->get_all_expenses_by_relation( $relation_type, $relation_id );
		$data_expenses = array();
		foreach ( $expenses as $expense ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$expensedate = _rdate( $expense[ 'date' ] );
					break;
				case 'dd.mm.yy':
					$expensedate = _udate( $expense[ 'date' ] );
					break;
				case 'yy-mm-dd':
					$expensedate = _mdate( $expense[ 'date' ] );
					break;
				case 'dd-mm-yy':
					$expensedate = _cdate( $expense[ 'date' ] );
					break;
				case 'yy/mm/dd':
					$expensedate = _zdate( $expense[ 'date' ] );
					break;
				case 'dd/mm/yy':
					$expensedate = _kdate( $expense[ 'date' ] );
					break;
			};
			if ( $expense[ 'invoice_id' ] == NULL ) {
				$billstatus = lang( 'notbilled' )and $color = 'warning'
				and $billstatus_code = 'false';
			} else $billstatus = lang( 'billed' )and $color = 'success'
			and $billstatus_code = 'true';
			if ( $expense[ 'customer_id' ] != 0 ) {
				$billable = 'true';
			} else {
				$billable = 'false';
			}
			$data_expenses[] = array(
				'id' => $expense[ 'id' ],
				'title' => $expense[ 'title' ],
				'prefix' => lang( 'expenseprefix' ),
				'longid' => str_pad( $expense[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'amount' => $expense[ 'amount' ],
				'staff' => $expense[ 'staff' ],
				'category' => $expense[ 'category' ],
				'billstatus' => $billstatus,
				'billstatus_code' => $billstatus_code,
				'color' => $color,
				'billable' => $billable,
				'date' => $expensedate,
			);
		};
		echo json_encode( $data_expenses );
	}
}