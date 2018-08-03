<?php
class Projects_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	/*
	 * Get projects by id
	 */
	function get_projects( $id ) {
		$this->db->select( '*,customers.id as customer_id, customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,projects.status_id as status, projects.id as id ' );
		$this->db->join( 'customers', 'projects.customer_id = customers.id', 'left' );
		return $this->db->get_where( 'projects', array( 'projects.id' => $id ) )->row_array();
	}
	function get_members( $id ) {
		$this->db->select( '*,staff.staffname as member,staff.staffavatar as memberavatar,staff.email as memberemail,projectmembers.id as id' );
		$this->db->join( 'staff', 'projectmembers.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'projectmembers', array( 'projectmembers.project_id' => $id ) )->result_array();
	}
	function get_members_index( $id ) {
		$this->db->select( '*,staff.staffname as member,staff.staffavatar as memberavatar,staff.email as memberemail,projectmembers.id as id' );
		$this->db->join( 'staff', 'projectmembers.staff_id = staff.id', 'left' );
		$this->db->limit(3);
		return $this->db->get_where( 'projectmembers', array( 'projectmembers.project_id' => $id ) )->result_array();
	}

	/*
	 * Get all projects
	 */
	function get_all_projects() {
		$this->db->select( '*,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,projects.status_id as status, projects.id as id ' );
		$this->db->join( 'customers', 'projects.customer_id = customers.id', 'left' );
		$this->db->order_by( 'projects.id', 'desc' );
		return $this->db->get( 'projects' )->result_array();
	}
	
	function get_all_projects_by_customer($id) {
		$this->db->select( '*,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,projects.status_id as status, projects.id as id ' );
		$this->db->join( 'customers', 'projects.customer_id = customers.id', 'left' );
		$this->db->order_by( 'projects.id', 'desc' );
		return $this->db->get_where( 'projects', array( 'customer_id' => $id ) )->result_array();
	}
	
	function get_all_milestones() {
		$this->db->order_by( 'id', 'asc' );
		return $this->db->get_where( 'milestones', array() )->result_array();
	}
	
	function get_all_project_milestones($id) {
		$this->db->order_by( 'order', 'asc' );
		return $this->db->get_where( 'milestones', array( 'project_id' => $id ) )->result_array();
	}
	
	function get_all_project_milestones_task($id) {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'tasks', array( 'milestone' => $id ) )->result_array();
	}
	
	function get_project_time_log($id) {
		$this->db->select('*,staff.staffname as staffmember,tasktimer.id as id');
		$this->db->join( 'staff', 'tasktimer.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tasktimer', array( 'tasktimer.project_id' => $id ) )->result_array();
	}
	
	function get_project_files( $id ) {
		$this->db->select( '*' );
		return $this->db->get_where( 'files', array( 'files.relation_type' => 'project', 'files.relation' => $id ) )->result_array();

	}

	/*
	 * function to add new projects
	 */
	function add_projects( $params ) {
		$this->db->insert( 'projects', $params );
		return $this->db->insert_id();
	}

	/*
	 * function to update projects
	 */
	
	function update( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'projects', $params );
		$loggedinuserid = $this->session->usr_id;
		$staffname = $this->session->staffname;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( ''.$staffname.' updated project.' ),
			'staff_id' => $loggedinuserid,
			'project_id' => $id,
		) );
	}
	
	function markas() {
		$response = $this->db->where( 'id', $_POST[ 'project_id' ] )->update( 'projects', array( 'status_id' => $_POST[ 'status_id' ] ) );
	}
	
	function add_milestone( $id, $params ) {
		$this->db->insert( 'milestones', $params );
		$milestone = $this->db->insert_id();
		$loggedinuserid = $this->session->usr_id;
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( ''.$staffname.' added new milestone' ),
			'staff_id' => $loggedinuserid,
			'project_id' => $id,
		) );
		return $this->db->insert_id();
	}
	
	function update_milestone( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'milestones', $params );
	}

	/*
	 * function to delete projects
	 */
	function delete_projects( $id ) {
		return $this->db->delete( 'projects', array( 'id' => $id ) );
	}
}