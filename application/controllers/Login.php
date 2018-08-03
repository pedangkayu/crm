<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Login extends CI_Controller {


	public $inactive;
	public $roles;

	function __construct() {
		parent::__construct();
		$this->load->model( 'Settings_Model' );
		define( 'LANG', $this->Settings_Model->get_crm_lang() );
		$this->lang->load( LANG, LANG );
		$settings = $this->Settings_Model->get_settings( 'ciuis' );
		$timezone = $settings[ 'default_timezone' ];
		date_default_timezone_set( $timezone );
		$this->load->model( 'Staff_Model' );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_error_delimiters( '<div class="error">', '</div>' );
		$this->inactive = $this->config->item( 'inactive' );
		$this->roles = $this->config->item( 'roles' );
		$timezone = $settings[ 'default_timezone' ];
		date_default_timezone_set( $timezone );
	}

	function index() {
		$settings = $this->Settings_Model->get_settings( 'ciuis' );
		if ( $settings[ 'two_factor_authentication' ] == 1 ) {
			if ( $this->session->userdata( 'LoginOK' ) && $this->session->userdata( '2FAVerify' ) ) {
				redirect( base_url() . 'panel' );
			} else {
				$this->show_login( false );
			}
		} else {
			if ( $this->session->userdata( 'LoginOK' ) ) {
				redirect( base_url() . 'panel' );
			} else {
				$this->show_login( false );
			}
		}
	}

	function auth() {
		$settings = $this->Settings_Model->get_settings( 'ciuis' );
		$this->load->model( 'Login_Model' );
		$email = $this->input->post( 'email' );
		$password = $this->input->post( 'password' );
		$clean = $this->security->xss_clean( $email );

		if ( $userInfo = $this->Staff_Model->getUserInfoByEmail( $clean ) ) {
			if ( $userInfo->inactive != $this->inactive[ 1 ] ) { //if inactive is not approved
				$this->session->set_flashdata( 'ntf4', lang( 'customerinactiveaccount' ) );
				redirect( site_url() . 'login' );
			}
		} else {
			$this->session->set_flashdata( 'ntf4', lang( 'customercanffindmail' ) );
		}
		if ( $email && $password && $this->Login_Model->validate_user( $email, $password ) ) {
			if ( $settings[ 'two_factor_authentication' ] == 1 ) {
				redirect( base_url( 'login/verify_login' ) );
			} else {
				$this->session->set_flashdata( 'login_notification', '' . lang( 'welcomemessagetwo' ) . '' );
				if ( $this->session->userdata( 'admin' ) ) {
					$this->session->set_flashdata( 'admin_notification', '' . lang( 'adminwelcome' ) . '' );
				}
				$staffname = $this->session->staffname;
				$loggedinuserid = $this->session->usr_id;
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'loggedinthesystem' ) . '' ),
					'staff_id' => $loggedinuserid
				) );
				redirect( base_url( 'panel' ) );
			}
		} else {
			$this->show_login( true );
		}
	}

	function verify_login() {
		$this->load->library( 'GoogleAuthenticator' );
		$this->load->model( 'Login_Model' );
		$data[ 'secret' ] = $this->googleauthenticator->createSecret();
		$website = "http://localhost:8888/googleautenticador/";
		$data[ 'url_qr_code' ] = $this->googleauthenticator->getQRCodeGoogleUrl( $this->session->userdata[ 'email' ], $data[ 'secret' ], $website );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$secret = $this->input->post( 'secret_code' );
			$code_verificador = $this->input->post( 'code' );
			$resultado = $this->googleauthenticator->verifyCode( $secret, $code_verificador, 0 );
			if ( $resultado ) {
				$this->Login_Model->two_factor_authentication();
				$this->session->set_flashdata( 'login_notification', '' . lang( 'welcomemessagetwo' ) . '' );
				if ( $this->session->userdata( 'admin' ) ) {
					$this->session->set_flashdata( 'admin_notification', '' . lang( 'adminwelcome' ) . '' );
				}
				$staffname = $this->session->staffname;
				$loggedinuserid = $this->session->usr_id;
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'loggedinthesystem' ) . '' ),
					'staff_id' => $loggedinuserid
				) );
				redirect( base_url( 'panel' ) );

			} else {

				$this->session->sess_destroy();
				redirect( base_url( 'login' ) );

			}
		} else {
			$this->load->view( 'login/verify', $data );
		}

	}

	function show_login( $show_error = false ) {
		$data[ 'error' ] = $show_error;
		$this->load->helper( 'form' );
		$this->load->view( 'login/login', $data );
	}

	function logout() {
		$this->session->sess_destroy();
		$this->index();
	}

	function showphpinfo() {
		echo phpinfo();
	}

	public

	function forgot() {

		$this->form_validation->set_rules( 'email', 'Email', 'required|valid_email' );

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view( 'login/forgot' );
		} else {
			$email = $this->input->post( 'email' );
			$clean = $this->security->xss_clean( $email );
			$userInfo = $this->Staff_Model->getUserInfoByEmail( $clean );

			if ( !$userInfo ) {
				$this->session->set_flashdata( 'ntf4', lang( 'customercanffindmail' ) );
				redirect( site_url() . 'login' );
			}

			if ( $userInfo->inactive != $this->inactive[ 1 ] ) { //if inactive is not approved
				$this->session->set_flashdata( 'ntf4', lang( 'customerinactiveaccount' ) );
				redirect( site_url() . 'login' );
			}

			//build token 

			$token = $this->Staff_Model->insertToken( $userInfo->id );
			$nameis = $userInfo->staffname;
			$qstring = $this->base64url_encode( $token );
			$url = site_url() . 'login/reset_password/token/' . $qstring;
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
				'name' => $nameis,
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
			redirect( 'login' );
		}

	}

	public

	function reset_password() {
		$token = $this->base64url_decode( $this->uri->segment( 4 ) );
		$cleanToken = $this->security->xss_clean( $token );

		$user_info = $this->Staff_Model->isTokenValid( $cleanToken ); //either false or array();               

		if ( !$user_info ) {
			$this->session->set_flashdata( 'ntf1', lang( 'tokenexpired' ) );
			redirect( site_url() . 'login' );
		}
		$data = array(
			'firstName' => $user_info->staffname,
			'email' => $user_info->email,
			//'user_id'=>$user_info->id, 
			'token' => $this->base64url_encode( $token )
		);

		$this->form_validation->set_rules( 'password', 'Password', 'required|min_length[5]' );
		$this->form_validation->set_rules( 'passconf', 'Password Confirmation', 'required|matches[password]' );

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view( 'login/reset_password', $data );
		} else {

			$post = $this->input->post( NULL, TRUE );
			$cleanPost = $this->security->xss_clean( $post );
			$hashed = md5( $cleanPost[ 'password' ] );
			$cleanPost[ 'password' ] = $hashed;
			$cleanPost[ 'user_id' ] = $user_info->id;
			unset( $cleanPost[ 'passconf' ] );
			if ( !$this->Staff_Model->updatePassword( $cleanPost ) ) {
				$this->session->set_flashdata( 'ntf1', lang( 'problemupdatepassword' ) );
			} else {
				$this->session->set_flashdata( 'ntf1', lang( 'passwordupdated' ) );
			}
			redirect( site_url() . 'login' );
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
}