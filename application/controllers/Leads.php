<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Leads extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function kanban() {
		$data[ 'title' ] = lang( 'leads' );
		$data[ 'tlh' ] = $this->db->count_all( 'leads' );
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		$data[ 'tcl' ] = $this->Report_Model->tcl();
		$data[ 'tll' ] = $this->Report_Model->tll();
		$data[ 'tjl' ] = $this->Report_Model->tjl();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		if ( !if_admin ) {
			$data[ 'leads' ] = $this->Leads_Model->get_all_leads_for_admin();
		} else {
			$data[ 'leads' ] = $this->Leads_Model->get_all_leads();
		};
		$data[ 'leadssources' ] = $this->Leads_Model->get_leads_sources();
		$data[ 'leadsstatuses' ] = $this->Leads_Model->get_leads_status();
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$this->load->view( 'leads/kanban', $data );
	}

	function index() {
		$data[ 'title' ] = lang( 'leads' );
		$data[ 'tlh' ] = $this->db->count_all( 'leads' );
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		$data[ 'tcl' ] = $this->Report_Model->tcl();
		$data[ 'tll' ] = $this->Report_Model->tll();
		$data[ 'tjl' ] = $this->Report_Model->tjl();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		if ( !if_admin ) {
			$data[ 'leads' ] = $this->Leads_Model->get_all_leads_for_admin();
		} else {
			$data[ 'leads' ] = $this->Leads_Model->get_all_leads();
		};
		$data[ 'leadssources' ] = $this->Leads_Model->get_leads_sources();
		$data[ 'leadsstatuses' ] = $this->Leads_Model->get_leads_status();
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$this->load->view( 'leads/index', $data );
	}

	function create() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'created' => date( 'Y-m-d H:i:s' ),
				'type' => $this->input->post( 'type' ),
				'name' => $this->input->post( 'name' ),
				'title' => $this->input->post( 'title' ),
				'company' => $this->input->post( 'company' ),
				'description' => $this->input->post( 'description' ),
				'country_id' => $this->input->post( 'country_id' ),
				'zip' => $this->input->post( 'zip' ),
				'city' => $this->input->post( 'city' ),
				'state' => $this->input->post( 'state' ),
				'address' => $this->input->post( 'address' ),
				'email' => $this->input->post( 'email' ),
				'website' => $this->input->post( 'website' ),
				'phone' => $this->input->post( 'phone' ),
				'assigned_id' => $this->input->post( 'assigned' ),
				'source' => $this->input->post( 'source' ),
				'public' => $this->input->post( 'public' ),
				'dateassigned' => date( 'Y-m-d H:i:s' ),
				'staff_id' => $this->session->userdata( 'usr_id' ),
				'status' => $this->input->post( 'status' ),
			);
			$lead_id = $this->Leads_Model->add_lead( $params );
			echo $lead_id;
		}
	}

	function update( $id ) {
		$data[ 'lead' ] = $this->Leads_Model->get_lead( $id );
		if ( isset( $data[ 'lead' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'created' => date( 'Y-m-d H:i:s' ),
					'type' => $this->input->post( 'type' ),
					'name' => $this->input->post( 'name' ),
					'title' => $this->input->post( 'title' ),
					'company' => $this->input->post( 'company' ),
					'description' => $this->input->post( 'description' ),
					'country_id' => $this->input->post( 'country_id' ),
					'zip' => $this->input->post( 'zip' ),
					'city' => $this->input->post( 'city' ),
					'state' => $this->input->post( 'state' ),
					'address' => $this->input->post( 'address' ),
					'email' => $this->input->post( 'email' ),
					'website' => $this->input->post( 'website' ),
					'phone' => $this->input->post( 'phone' ),
					'assigned_id' => $this->input->post( 'assigned_id' ),
					'junk' => $this->input->post( 'junk' ),
					'lost' => $this->input->post( 'lost' ),
					'source' => $this->input->post( 'source' ),
					'public' => $this->input->post( 'public' ),
					'dateassigned' => date( 'Y-m-d H:i:s' ),
					'staff_id' => $this->session->userdata( 'usr_id' ),
					'status' => $this->input->post( 'status' ),
				);
				$this->Leads_Model->update_lead( $id, $params );
				echo lang( 'updated' );
			} else {
				redirect( 'leads/index' );
			}
		} else
			show_error( 'The expensecategory you are trying to edit does not exist.' );
	}

	function lead( $id ) {
		$lead = $this->Leads_Model->get_lead( $id );
		$data[ 'tcl' ] = $this->Report_Model->tcl();
		$data[ 'tll' ] = $this->Report_Model->tll();
		$data[ 'tjl' ] = $this->Report_Model->tjl();
		$data[ 'title' ] = $lead[ 'leadname' ];
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		if ( !if_admin ) {
			$data[ 'leads_table' ] = $this->Leads_Model->get_all_leads_for_admin();
		} else {
			$data[ 'leads_table' ] = $this->Leads_Model->get_all_leads();
		};
		$data[ 'leadssources' ] = $this->Leads_Model->get_leads_sources();
		$data[ 'leadsstatuses' ] = $this->Leads_Model->get_leads_status();
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$data[ 'proposals' ] = $this->db->get_where( 'proposals', array( 'relation' => $id, 'relation_type' => 'lead' ) )->result_array();
		$data[ 'notes' ] = $this->db->select( '*,staff.staffname as notestaff,notes.id as id ' )->join( 'staff', 'notes.addedfrom = staff.id', 'left' )->get_where( 'notes', array( 'relation' => $lead[ 'id' ], 'relation_type' => 'lead' ) )->result_array();
		$data[ 'reminders' ] = $this->db->select( '*,staff.staffname as reminderstaff,staff.staffavatar as staffpicture,reminders.id as id ' )->join( 'staff', 'reminders.staff_id = staff.id', 'left' )->get_where( 'reminders', array( 'relation' => $lead[ 'id' ], 'relation_type' => 'lead' ) )->result_array();
		$data[ 'lead' ] = $this->Leads_Model->get_lead( $id );
		$this->load->view( 'leads/lead', $data );
	}

	function convert( $id ) {
		$lead = $this->Leads_Model->get_lead( $id );
		$settings = $this->Settings_Model->get_settings_ciuis();
		if ( $lead[ 'dateconverted' ] != null ) {
			echo 'false';
		} else {
			$params = array(
				'staff_id' => $lead[ 'staff_id' ],
				'company' => $lead[ 'company' ],
				'type' => $lead[ 'type' ],
				'namesurname' => $lead[ 'company' ],
				'created' => date( 'Y-m-d H:i:s' ),
				'address' => $lead[ 'address' ],
				'zipcode' => $lead[ 'zip' ],
				'country_id' => $lead[ 'country_id' ],
				'state' => $lead[ 'state' ],
				'city' => $lead[ 'city' ],
				'phone' => $lead[ 'phone' ],
				'email' => $lead[ 'leadmail' ],
				'web' => $lead[ 'website' ],
			);
			$this->db->insert( 'customers', $params );
			$customer = $this->db->insert_id();
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' ),
				'detail' => ( '' . $message = sprintf( lang( 'leadconvert' ), $this->session->staffname, $lead[ 'company' ] ) . '' ),
				'staff_id' => $this->session->usr_id,
				'customer_id' => $customer,
			) );
			$response = $this->db->where( 'id', $id )->update( 'leads', array( 'status' => $settings[ 'converted_lead_status_id' ], 'dateconverted' => date( 'Y-m-d H:i:s' ) ) );
			$response = $this->db->where( 'relation', $id, 'relation_type', 'lead' )->update( 'proposals', array( 'relation' => $customer, 'relation_type' => 'customer' ) );
			echo $customer;
		}
	}

	function add_status() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
			);
			$status = $this->Leads_Model->add_status( $params );
			echo $status;
		} else {
			redirect( 'leads/index' );
		}
	}

	function update_status( $id ) {
		$data[ 'statuses' ] = $this->Leads_Model->get_status( $id );
		if ( isset( $data[ 'statuses' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'color' => $this->input->post( 'color' ),
				);
				$this->Leads_Model->update_status( $id, $params );
			}
		}
	}

	function remove_status( $id ) {
		$lead = $this->Leads_Model->get_status( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $lead[ 'id' ] ) ) {
			$this->Leads_Model->delete_status( $id );
		}
	}

	function add_source() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
			);
			$source = $this->Leads_Model->add_source( $params );
			echo $source;
		} else {
			redirect( 'leads/index' );
		}
	}

	function update_source( $id ) {
		$data[ 'sources' ] = $this->Leads_Model->get_source( $id );
		if ( isset( $data[ 'sources' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
				);
				$this->Leads_Model->update_source( $id, $params );
			}
		}
	}

	function remove_source( $id ) {
		$lead = $this->Leads_Model->get_source( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $lead[ 'id' ] ) ) {
			$this->Leads_Model->delete_source( $id );
		}
	}

	function move_lead() {
		$this->Leads_Model->move_lead();
	}

	function mark_as_lead( $id ) {
		if ( isset( $id ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				if ( $this->input->post( 'value' ) == 1 ) {
					$response = $this->db->where( 'id', $id )->update( 'leads', array( 'lost' => 1 ) );
				}
				if ( $this->input->post( 'value' ) == 2 ) {
					$response = $this->db->where( 'id', $id )->update( 'leads', array( 'lost' => 0 ) );
				}
				if ( $this->input->post( 'value' ) == 3 ) {
					$response = $this->db->where( 'id', $id )->update( 'leads', array( 'junk' => 1 ) );
				}
				if ( $this->input->post( 'value' ) == 4 ) {
					$response = $this->db->where( 'id', $id )->update( 'leads', array( 'junk' => 0 ) );
				}
				echo lang( 'updated' );
			} else {
				redirect( 'leads/index' );
			}
		} else
			show_error( 'The expensecategory you are trying to edit does not exist.' );
	}

	function
	import () {
		$this->load->library( 'csvimport' );
		$data[ 'leads' ] = $this->Leads_Model->get_leads_for_import();
		$data[ 'error' ] = ''; //initialize image upload error array to empty
		$config[ 'upload_path' ] = './uploads/imports/';
		$config[ 'allowed_types' ] = 'csv';
		$config[ 'max_size' ] = '1000';
		$this->load->library( 'upload', $config );
		// If upload failed, display error
		if ( !$this->upload->do_upload() ) {
			$data[ 'error' ] = $this->upload->display_errors();
			$this->session->set_flashdata( 'ntf1', 'Csv Data not Imported' );
			redirect( 'leads/index' );
		} else {
			$file_data = $this->upload->data();
			$file_path = './uploads/imports/' . $file_data[ 'file_name' ];
			if ( $this->csvimport->get_array( $file_path ) ) {
				$csv_array = $this->csvimport->get_array( $file_path );
				foreach ( $csv_array as $row ) {
					$insert_data = array(
						'created' => date( 'Y-m-d H:i:s' ),
						'type' => $row[ 'type' ],
						'name' => $row[ 'name' ],
						'title' => $row[ 'title' ],
						'company' => $row[ 'company' ],
						'description' => $row[ 'description' ],
						'zip' => $row[ 'zip' ],
						'city' => $row[ 'city' ],
						'state' => $row[ 'state' ],
						'address' => $row[ 'address' ],
						'email' => $row[ 'email' ],
						'website' => $row[ 'website' ],
						'phone' => $row[ 'phone' ],
						'assigned_id' => $this->input->post( 'importassigned' ),
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'source' => $this->input->post( 'importsource' ),
						'dateassigned' => date( 'Y-m-d H:i:s' ),
						'status' => $this->input->post( 'importstatus' ),
					);
					$this->Leads_Model->insert_csv( $insert_data );
				}
				$this->session->set_flashdata( 'ntf3', 'Csv Data Imported Succesfully' );
				redirect( 'leads/index' );
				//echo "<pre>"; print_r($insert_data);
			} else
				redirect( 'leads/index' );
			$this->session->set_flashdata( 'ntf3', 'Error' );
		}
	}

	function remove_converted( $id ) {
		$response = $this->db->delete( 'leads', array( 'status' => $id ) );
	}

	function make_converted_status( $id ) {
		$response = $this->db->where( 'settingname', 'ciuis' )->update( 'settings', array( 'converted_lead_status_id' => $id ) );
	}

	function remove( $id ) {
		$lead = $this->Leads_Model->get_lead( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $lead[ 'id' ] ) ) {
			$this->Leads_Model->delete_lead( $id );
			redirect( 'leads/index' );
		} else
			show_error( 'The expenses you are trying to delete does not exist.' );
	}
}