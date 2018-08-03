<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Projects extends CIUIS_Controller {

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
		$data[ 'title' ] = lang( 'projects' );
		$data[ 'projects' ] = $this->Projects_Model->get_all_projects();
		$this->load->view( 'projects/index', $data );
	}

	function project( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		$data[ 'title' ] = $project[ 'name' ];
		$data[ 'projects' ] = $this->Projects_Model->get_projects( $id );
		$this->load->view( 'projects/project', $data );
	}

	function create() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $_POST[ 'name' ],
				'description' => $_POST[ 'description' ],
				'customer_id' => $_POST[ 'customer' ],
				'start_date' => $_POST[ 'start' ],
				'deadline' => $_POST[ 'deadline' ],
				'staff_id' => $this->session->userdata( 'usr_id' ),
				'status_id' => 1,
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$this->db->insert( 'projects', $params );
			$project = $this->db->insert_id();;
			$loggedinuserid = $this->session->usr_id;
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . ' created new project' ),
				'staff_id' => $loggedinuserid,
				'project_id' => $project,
			) );
			$project_detail = $this->Projects_Model->get_projects( $project );
			echo json_encode( $project_detail );
		}
	}

	function update( $id ) {
		$data[ 'project' ] = $this->Projects_Model->get_projects( $id );
		if ( isset( $data[ 'project' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'description' => $this->input->post( 'description' ),
					'customer_id' => $this->input->post( 'customer' ),
					'start_date' => $this->input->post( 'start' ),
					'deadline' => $this->input->post( 'deadline' ),
				);
				$this->Projects_Model->update( $id, $params );
				echo lang('projectupdated');
			} else {
				$this->load->view( 'projects/index', $data );
			}
		} else
			show_error( 'The task you are trying to edit does not exist.' );
	}

	function markas() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'project_id' => $_POST[ 'project_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Projects_Model->markas();
		}
	}

	function addmilestone( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'project_id' => $id,
				'name' => $this->input->post( 'name' ),
				'order' => $this->input->post( 'order' ),
				'duedate' => _phdate( $this->input->post( 'duedate' ) ),
				'description' => $this->input->post( 'description' ),
				'created' => date( 'Y-m-d' ),
				'color' => 'green',
			);
			$response = $this->Projects_Model->add_milestone( $id, $params );
		}
	}

	function updatemilestone( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'order' => $this->input->post( 'order' ),
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
				'duedate' => $this->input->post( 'duedate' ),
			);
			$this->Projects_Model->update_milestone( $id, $params );
		}
	}

	function removemilestone() {
		if ( isset( $_POST[ 'milestone' ] ) ) {
			$milestone = $_POST[ 'milestone' ];
			$response = $this->db->delete( 'milestones', array( 'id' => $milestone ) );
		}
	}

	function addtask( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
				'priority' => $this->input->post( 'priority' ),
				'assigned' => $this->input->post( 'assigned' ),
				'relation_type' => 'project',
				'relation' => $id,
				'milestone' => $this->input->post( 'milestone' ),
				'public' => $this->input->post( 'public' ),
				'billable' => $this->input->post( 'billable' ),
				'visible' => $this->input->post( 'visible' ),
				'hourly_rate' => $this->input->post( 'hourlyrate' ),
				'startdate' => $this->input->post( 'startdate' ),
				'duedate' => $this->input->post( 'duedate' ),
				'addedfrom' => $this->session->userdata( 'usr_id' ),
				'status_id' => 1,
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$this->session->set_flashdata( 'ntf1', '<b>Task Added</b>' );
			$this->db->insert( 'tasks', $params );
			$loggedinuserid = $this->session->usr_id;
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . ' added new task' ),
				'staff_id' => $loggedinuserid,
				'project_id' => $id,
			) );
			echo lang('added');
		}
	}

	function addmember() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'staff_id' => $_POST[ 'staff' ],
				'project_id' => $_POST[ 'project' ],
			);
			$this->db->insert( 'projectmembers', $params );
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( lang('assignednewproject') ),
				'perres' => $this->session->staffavatar,
				'staff_id' => $_POST[ 'staff' ],
				'target' => '' . base_url( 'projects/project/' . $_POST[ 'project' ] . '' ) . ''
			) );
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $this->session->staffname . ' added new member to project' ),
				'staff_id' => $this->session->usr_id,
				'project_id' => $_POST[ 'project' ],
			) );
			$member_detail = $this->Staff_Model->get_staff( $_POST[ 'staff' ] );
			echo json_encode( $member_detail );
		}
	}

	function unlinkmember( $id ) {
		if ( isset( $_POST[ 'linkid' ] ) ) {
			$linkid = $_POST[ 'linkid' ];
			$response = $this->db->where( 'id', $linkid )->delete( 'projectmembers', array( 'id' => $linkid ) );
		}
	}

	function deletefile() {
		if ( isset( $_POST[ 'fileid' ] ) ) {
			$file = $_POST[ 'fileid' ];
			$response = $this->db->where( 'id', $file )->delete( 'files', array( 'id' => $file ) );
		}
	}

	function add_file($id) {
		if ( isset( $id ) ) {
			if ( isset( $_POST )) {
				$config[ 'upload_path' ] = './uploads/files/';
				$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
				$this->load->library( 'upload', $config );
				$this->upload->do_upload( 'file_name' );
				$data_upload_files = $this->upload->data();
				$image_data = $this->upload->data();
				$params = array(
					'relation_type' => 'project',
					'relation' => $id,
					'file_name' => $image_data[ 'file_name' ],
					'created' => date( " Y.m.d H:i:s " ),
				);
				$this->db->insert( 'files', $params );
				redirect( 'projects/project/' . $id . '' );
			}
		}
	}

	function checkpinned() {
		if ( isset( $_POST[ 'project' ] ) ) {
			$project = $_POST[ 'project' ];
			$response = $this->db->where( 'id', $project )->update( 'projects', array( 'pinned' => 1 ) );
		}
	}

	function unpinned() {
		if ( isset( $_POST[ 'pinnedproject' ] ) ) {
			$pinnedproject = $_POST[ 'pinnedproject' ];
			$response = $this->db->where( 'id', $pinnedproject )->update( 'projects', array( 'pinned' => 0 ) );
		}
	}

	function addexpense($id) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'category_id' => $this->input->post( 'category' ),
				'staff_id' => $this->session->usr_id,
				'customer_id' => $this->input->post( 'customer' ),
				'relation_type' => 'project',
				'relation' => $id,
				'account_id' => $this->input->post( 'account' ),
				'title' => $this->input->post( 'title' ),
				'date' => $this->input->post( 'date' ),
				'created' => date( 'Y-m-d H:i:s' ),
				'amount' => $this->input->post( 'amount' ),
				'description' => $this->input->post( 'description' ),
			);
			$expenses_id = $this->Expenses_Model->create( $params );
			echo $expenses_id;
		}
	}

	function convert( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'token' => md5( uniqid() ),
				'staff_id' => $project[ 'staff_id' ],
				'customer_id' => $project[ 'customer_id' ],
				'created' => date( 'Y-m-d H:i:s' ),
				'status_id' => 3,
				'total_discount' => 0,
				'total_tax' => 0,
				'total' => $this->input->post( 'total' ),
				'project_id' => $id,
				'sub_total' => $this->input->post( 'total' ),
			);
			$this->db->insert( 'invoices', $params );
			$invoice = $this->db->insert_id();
			$this->db->insert( 'items', array(
				'relation_type' => 'invoice',
				'relation' => $invoice,				
				'name' => $project[ 'name' ],				
				'description' => $project[ 'description' ],				
				'quantity' => 1,				
				'unit' => 'Unit',				
				'tax' => 0,				
				'discount' => 0,				
				'price' => $this->input->post( 'total' ),				
				'total' => $this->input->post( 'total' ),				
			) );
			$this->db->insert( $this->db->dbprefix . 'sales', array(
				'invoice_id' => '' . $invoice . '',
				'status_id' => 3,
				'staff_id' => $this->session->usr_id,
				'customer_id' => $project[ 'customer_id' ],
				'total' => $this->input->post( 'total' ),
				'date' => date( 'Y-m-d H:i:s' )
			) );
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $message = sprintf( lang( 'projecttoinvoicelog' ), $staffname, $project[ 'id' ] ) . '' ),
				'staff_id' => $this->session->usr_id,
				'customer_id' => $project[ 'customer_id' ],
			) );
			$response = $this->db->where( 'id', $id )->update( 'projects', array( 'invoice_id' => $invoice ) );
			echo $invoice;
		}
	}

	/* Remove Project */
	function remove( $id ) {
		$projects = $this->Projects_Model->get_projects( $id );
		if ( isset( $projects[ 'id' ] ) ) {
			$this->Projects_Model->delete_projects( $id );
			redirect( 'projects/index' );
		} else
			show_error( 'The projects you are trying to delete does not exist.' );
	}

}