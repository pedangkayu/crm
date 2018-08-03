<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class CIUIS_Controller extends CI_Controller {

	public $loggedinuserid;

	protected

	function only_admin_access() {
		if ( $this->session->userdata( 'admin' ) );
		else {
			redirect( "panel" );
		};
	}

	public

	function __construct() {
		parent::__construct();
		$this->load->helper( 'security' );
		$this->load->model( 'Settings_Model' );
		define( 'TWFAUTH', $this->Settings_Model->two_factor_authentication() );
		if ( $this->session->userdata( 'LoginOK' ) ) {
			$this->lang->load( '' . $this->session->userdata( 'language' ) . '', '' . $this->session->userdata( 'language' ) . '' );
		} else {
			define( 'LANG', $this->Settings_Model->get_crm_lang() );
			$this->lang->load( LANG, LANG );
		}
		if ( TWFAUTH == 1 ) {
			if ( !$this->session->userdata( '2FAVerify' ) ) {
				$this->session->sess_destroy();
				redirect( base_url( 'login' ) );
			}
		}
		$this->load->model( 'Privileges_Model' );
		$this->load->model( 'Login_Model' );
		$this->load->model( 'Customers_Model' );
		$this->load->model( 'Staff_Model' );
		$this->load->model( 'Products_Model' );
		$this->load->model( 'Tickets_Model' );
		$this->load->model( 'Settings_Model' );
		$this->load->model( 'Invoices_Model' );
		$this->load->model( 'Proposals_Model' );
		$this->load->model( 'Tickets_Model' );
		$this->load->model( 'Report_Model' );
		$this->load->model( 'Logs_Model' );
		$this->load->model( 'Sales_Model' );
		$this->load->model( 'Projects_Model' );
		$this->load->model( 'Notifications_Model' );
		$this->load->model( 'Contacts_Model' );
		$this->load->model( 'Events_Model' );
		$this->load->model( 'Tasks_Model' );
		$this->load->model( 'Accounts_Model' );
		$this->load->model( 'Payments_Model' );
		$this->load->model( 'Expenses_Model' );
		$this->load->model( 'Trivia_Model' );
		$this->load->model( 'Leads_Model' );
		$loggedinuserid = $this->Login_Model->usr_id();
		if ( !$loggedinuserid ) {
			redirect( base_url() . '' );
		}
		$this->logged_in_staff = $this->Login_Model->get_logged_in_staff_info( $loggedinuserid );
		define( 'currency', $this->Settings_Model->get_currency() );
		define( 'if_admin', $this->Login_Model->if_admin() );
		define( 'current_user_id', $this->session->userdata( 'usr_id' ) );
		define( 'timezone', $this->Settings_Model->default_timezone() );
		date_default_timezone_set( timezone );
	}

}

class CIUISCUSTOMER_Controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'Customers_Model' );
		$this->load->model( 'Staff_Model' );
		$this->load->model( 'Products_Model' );
		$this->load->model( 'Tickets_Model' );
		$this->load->model( 'Settings_Model' );
		$this->load->model( 'Invoices_Model' );
		$this->load->model( 'Report_Model' );
		$this->load->model( 'Logs_Model' );
		$this->load->model( 'Sales_Model' );
		$this->load->model( 'Notifications_Model' );
		$this->load->model( 'Contacts_Model' );
		$this->load->model( 'Events_Model' );
		$this->load->model( 'Projects_Model' );
		$this->load->model( 'Accounts_Model' );
		$this->load->model( 'Payments_Model' );
		$this->load->model( 'Expenses_Model' );
		$this->load->model( 'Proposals_Model' );
		$data[ 'contacts' ] = $this->Contacts_Model->get_all_contacts();
		define( 'currency', $this->Settings_Model->get_currency() );
		define( 'timezone', $this->Settings_Model->default_timezone() );
		date_default_timezone_set( timezone );
	}

}

function tes_ciuis( $datetime, $full = false ) {
	$today = time();
	$createdday = strtotime( $datetime );
	$datediff = abs( $today - $createdday );
	$difftext = "";
	$years = floor( $datediff / ( 365 * 60 * 60 * 24 ) );
	$months = floor( ( $datediff - $years * 365 * 60 * 60 * 24 ) / ( 30 * 60 * 60 * 24 ) );
	$days = floor( ( $datediff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 ) / ( 60 * 60 * 24 ) );
	$hours = floor( $datediff / 3600 );
	$minutes = floor( $datediff / 60 );
	$seconds = floor( $datediff );
	// Years
	if ( $difftext == "" ) {
		if ( $years > 1 )
			$difftext = $years . lang( 'yearsago' );
		elseif ( $years == 1 )
			$difftext = $years . lang( 'yearago' );
	}
	// Mounth
	if ( $difftext == "" ) {
		if ( $months > 1 )
			$difftext = $months . lang( 'monthsago' );
		elseif ( $months == 1 )
			$difftext = $months . lang( 'monthago' );
	}
	// Days
	if ( $difftext == "" ) {
		if ( $days > 1 )
			$difftext = $days . lang( 'daysago' );
		elseif ( $days == 1 )
			$difftext = $days . lang( 'dayago' );
	}
	// Hours
	if ( $difftext == "" ) {
		if ( $hours > 1 )
			$difftext = $hours . lang( 'hoursago' );
		elseif ( $hours == 1 )
			$difftext = $hours . lang( 'hourago' );
	}
	// Minutes
	if ( $difftext == "" ) {
		if ( $minutes > 1 )
			$difftext = $minutes . lang( 'minutesago' );
		elseif ( $minutes == 1 )
			$difftext = $minutes . lang( 'minuteago' );
	}
	// Seconds
	if ( $difftext == "" ) {
		if ( $seconds > 1 )
			$difftext = $seconds . lang( 'secondsago' );
		elseif ( $seconds == 1 )
			$difftext = $seconds . lang( 'secondago' );
	}
	return $difftext;
}