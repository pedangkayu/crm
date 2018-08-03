<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Logs extends CIUIS_Controller {

	public

	function index() {
		$data[ 'title' ] = 'Logs';
		$this->load->library( 'breadcrumb' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Logs', 'logs' );
		$this->breadcrumb->add_crumb( 'Tüm Logs' );
		$data[ 'logs' ] = $this->Logs_Model->get_all_logs();
		// Notification Data //
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
		$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
		$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'logs', $data );
	}

	public

	function remove( $id ) {
		$this->session->set_flashdata( 'logs_silindi', lang( 'logsdeleted' ) );
		$logs = $this->Logs_Model->get_logs( $id );
		if ( isset( $logs[ 'id' ] ) ) {
			$this->Logs_Model->delete_logs( $id );
			redirect( 'logs/index' );

		} else
			show_error( 'Logs Silindi.' );
	}

	public

	function last_logs() {
		$data[ 'logs' ] = $this->Logs_Model->panel_last_logs();
		$data = array();
		echo json_encode( $data );

	}

	function getlog_json() {
		$data = $this->Logs_Model->getlog_json();
		echo json_encode( $data );

	}
}