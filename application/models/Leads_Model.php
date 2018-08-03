<?php
class Leads_Model extends CI_Model {

	function get_lead( $id ) {
		$this->db->select( '*,leadsstatus.name as statusname,countries.shortname as leadcountry,staff.staffname as leadassigned,staff.staffavatar as assignedavatar,leadssources.name as sourcename,leads.name as leadname,leads.email as leadmail,leads.phone as leadphone,leads.address as address,leads.id as id' );
		$this->db->join( 'leadsstatus', 'leads.status = leadsstatus.id', 'left' );
		$this->db->join( 'countries', 'leads.country_id = countries.id', 'left' );
		$this->db->join( 'leadssources', 'leads.source = leadssources.id', 'left' );
		$this->db->join( 'staff', 'leads.assigned_id = staff.id', 'left' );
		return $this->db->get_where( 'leads', array( 'leads.id' => $id ) )->row_array();
	}
	function get_source( $id ) {
		return $this->db->get_where( 'leadssources', array( 'id' => $id ) )->row_array();
	}
	function get_status( $id ) {
		return $this->db->get_where( 'leadsstatus', array( 'id' => $id ) )->row_array();
	}
	function get_all_leads() {
		$this->db->select( '*,leadsstatus.name as statusname,countries.shortname as leadcountry,staff.staffname as leadassigned,staff.staffavatar as assignedavatar,leadssources.name as sourcename,leads.name as leadname,leads.email as leadmail,leads.phone as leadphone,leads.id as id' );
		$this->db->join( 'leadsstatus', 'leads.status = leadsstatus.id', 'left' );
		$this->db->join( 'countries', 'leads.country_id = countries.id', 'left' );
		$this->db->join( 'leadssources', 'leads.source = leadssources.id', 'left' );
		$this->db->join( 'staff', 'leads.assigned_id = staff.id', 'left' );
		$this->db->where( 'public = 1 OR assigned_id = '.$this->session->userdata( 'usr_id' ) .'' );
		$this->db->order_by( 'leads.id', 'desc' );
		return $this->db->get( 'leads' )->result_array();
	}
	function get_all_leads_for_admin() {
		$this->db->select( '*,leadsstatus.name as statusname,countries.shortname as leadcountry,staff.staffname as leadassigned,staff.staffavatar as assignedavatar,leadssources.name as sourcename,leads.name as leadname,leads.email as leadmail,leads.phone as leadphone,leads.id as id' );
		$this->db->join( 'leadsstatus', 'leads.status = leadsstatus.id', 'left' );
		$this->db->join( 'countries', 'leads.country_id = countries.id', 'left' );
		$this->db->join( 'leadssources', 'leads.source = leadssources.id', 'left' );
		$this->db->join( 'staff', 'leads.assigned_id = staff.id', 'left' );
		$this->db->order_by( 'leads.id', 'desc' );
		return $this->db->get( 'leads' )->result_array();
	}
	function get_leads_sources() {
		return $this->db->get( 'leadssources' )->result_array();
	}
	function get_leads_status() {
		return $this->db->get( 'leadsstatus' )->result_array();
	}

	function add_lead( $params ) {
		$this->db->insert( 'leads', $params );
		return $this->db->insert_id();
	}

	function update_lead( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update('leads', $params );
	}

	function delete_lead( $id ) {
		$response = $this->db->delete( 'leads', array( 'id' => $id ) );
	}
	function delete_source( $id ) {
		$response = $this->db->delete( 'leadssources', array( 'id' => $id ) );
	}
	function delete_status( $id ) {
		$response = $this->db->delete( 'leadsstatus', array( 'id' => $id ) );
	}
	public

	function isDuplicate( $email ) {
		$this->db->get_where( 'leads', array( 'email' => $email ), 1 );
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	/* Add Lead Status and Sources */
	
	function add_status( $params ) {
		$this->db->insert( 'leadsstatus', $params );
		return $this->db->insert_id();
	}
	function add_source( $params ) {
		$this->db->insert( 'leadssources', $params );
		return $this->db->insert_id();
	}

	/* Update Leads Status and Sources  */
	
	function update_status( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'leadsstatus', $params );
	}
	function update_source( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'leadssources', $params );
	}
	function move_lead()
	{
			$leadid = $_POST[ 'leadid' ];
			$status = $_POST[ 'status' ];
			$response = $this->db->where( 'id', $leadid )->update( 'leads', array( 'status' => $status ) );
	}
	function get_leads_for_import() {     
        $query = $this->db->get('leads');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    
    function insert_csv($data) {
        $this->db->insert('leads', $data);
    }

}