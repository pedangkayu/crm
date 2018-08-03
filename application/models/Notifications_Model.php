<?php
class Notifications_Model extends CI_Model {
	function get_notifications( $id ) {
		return $this->db->get_where( 'notifications', array( 'id' => $id ) )->row_array();
	}

	function get_all_notifications() {
		$this->db->select( '*,staff.staffname as staffmembername, staff.staffavatar as staffimage,notifications.public as public,notifications.staff_id as staff_id,notifications.contact_id as contact_id,notifications.customer_id as customer_id, notifications.id as notifyid ' );
		$this->db->join( 'staff', 'notifications.staff_id = staff.id', 'left' );
		$this->db->from( 'notifications' );
		$this->db->order_by( "notifyid", "desc" );
		$this->db->where( 'public = "1" OR staff_id = ' . $this->session->userdata( 'usr_id' ) . '' );
		$query = $this->db->get();
		$ybs = $query->result_array();
		return $ybs;
	}

	function readnotification() {
		$new = $this->db->get_where( 'notifications', array( 'markread' => 1,'staff_id' => $this->session->userdata('usr_id')))->result();
		if ( $new ) {
			return '-unread';
		}
	}

	function newnotification() {
		$new = $this->db->get_where( 'notifications', array( 'markread' => 0,'staff_id' => $this->session->userdata('usr_id')))->result();
		if ( $new) {
			return true;
		}else{
			return false;
		}
	}
}