<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Expenses extends CIUIS_Controller {

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
		$data[ 'title' ] = lang( 'expenses' );
		$data[ 'expenses' ] = $this->Expenses_Model->get_all_expenses();
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'expenses/index', $data );
		$this->load->view( 'inc/footer', $data );
	}

	function create() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'category_id' => $this->input->post( 'category' ),
				'staff_id' => $this->session->usr_id,
				'customer_id' => $this->input->post( 'customer' ),
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

	function update( $id ) {
		// check if the expenses exists before trying to edit it
		$data[ 'expenses' ] = $this->Expenses_Model->get_expenses( $id );

		if ( isset( $data[ 'expenses' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'category_id' => $this->input->post( 'category' ),
					'customer_id' => $this->input->post( 'customer' ),
					'account_id' => $this->input->post( 'account' ),
					'title' => $this->input->post( 'title' ),
					'date' => _phdate( $this->input->post( 'date' ) ),
					'amount' => $this->input->post( 'amount' ),
					'description' => $this->input->post( 'description' ),
				);
				$this->Expenses_Model->update_expenses( $id, $params );
			} 
		} else
			show_error( 'The expenses you are trying to edit does not exist.' );
	}

	function receipt( $id ) {
		$data[ 'title' ] = lang( 'expense' );
		$data[ 'expenses' ] = $this->Expenses_Model->get_expenses( $id );
		if ( isset( $data[ 'expenses' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'category_id' => $this->input->post( 'category' ),
					'staff_id' => $this->input->post( 'staff' ),
					'customer_id' => $this->input->post( 'customer' ),
					'account_id' => $this->input->post( 'account' ),
					'title' => $this->input->post( 'title' ),
					'date' => _pdate( $this->input->post( 'date' ) ),
					'created' => $this->input->post( 'created' ),
					'amount' => $this->input->post( 'amount' ),
					'description' => $this->input->post( 'description' ),
				);
				$this->Expenses_Model->update_expenses( $id, $params );
				redirect( 'expenses/index' );
			} else {
				$this->load->view( 'inc/header', $data );
				$this->load->view( 'expenses/receipt', $data );
				$this->load->view( 'inc/footer', $data );
			}
		} else
			show_error( 'The expenses you are trying to edit does not exist.' );
	}

	function convert( $id ) {
		$expenses = $this->Expenses_Model->get_expenses( $id );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'staff_id' => $expenses[ 'staff_id' ],
				'customer_id' => $expenses[ 'customer_id' ],
				'created' => date( 'Y-m-d H:i:s' ),
				'status_id' => 3,
				'total' => $expenses[ 'amount' ],
				'expense_id' => $id,
				'sub_total' => $expenses[ 'amount' ],
			);
			$this->db->insert( 'invoices', $params );
			$invoice = $this->db->insert_id();
			$this->db->insert( 'invoiceitems', array(
				'relation' => $invoice,
				'relation_type' => 'invoice',
				'name' => $expenses[ 'title' ],
				'total' => $expenses[ 'amount' ],
				'price' => $expenses[ 'amount' ],
				'quantity' => 1,
				'unit' => 'Unit',
				'description' => $expenses[ 'desc' ],
			) );
			$loggedinuserid = $this->session->usr_id;
			$this->db->insert( $this->db->dbprefix . 'sales', array(
				'invoice_id' => '' . $invoice . '',
				'status_id' => 3,
				'staff_id' => $loggedinuserid,
				'customer_id' => $expenses[ 'customer_id' ],
				'total' => $expenses[ 'amount' ],
				'date' => date( 'Y-m-d H:i:s' )
			) );
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' ),
				'detail' => ( '' . $message = sprintf( lang( 'expensetoinvoicelog' ), $staffname, $expenses[ 'id' ] ) . '' ),
				'staff_id' => $loggedinuserid,
				'customer_id' => $expenses[ 'customer_id' ],
			) );
			$response = $this->db->where( 'id', $id )->update( 'expenses', array( 'invoice_id' => $invoice ) );
			echo $invoice;
		}
	}

	function remove( $id ) {
		$expenses = $this->Expenses_Model->get_expenses( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $expenses[ 'id' ] ) ) {
			$this->Expenses_Model->delete_expenses( $id );
			redirect( 'expenses/index' );
		} else
			show_error( 'The expenses you are trying to delete does not exist.' );
	}

	function add_category() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
			);
			$category = $this->Expenses_Model->add_category( $params );
			echo $category;
		}
	}

	function update_category( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
			);
			$this->Expenses_Model->update_category( $id, $params );
		}
	}

	function remove_category( $id ) {
		$expensecategory = $this->Expenses_Model->get_expensecategory( $id );
		if ( isset( $expensecategory[ 'id' ] ) ) {
			$this->Expenses_Model->delete_category( $id );
		} else
			show_error( 'The expensecategory you are trying to delete does not exist.' );
	}

}