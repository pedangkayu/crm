<?php
class Expenses_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	/* Get Expense by ID */
	
	function get_expenses( $id ) {
		$this->db->select( '*,customers.company as customer,customers.type as type,customers.namesurname as individual,accounts.name as account,expensecat.name as category,staff.staffname as staff,expenses.description as desc, expenses.id as id' );
		$this->db->join( 'customers', 'expenses.customer_id = customers.id', 'left' );
		$this->db->join( 'accounts', 'expenses.account_id = accounts.id', 'left' );
		$this->db->join( 'expensecat', 'expenses.category_id = expensecat.id', 'left' );
		$this->db->join( 'staff', 'expenses.staff_id = staff.id', 'left' );
		$this->db->order_by( 'expenses.id', 'desc' );
		return $this->db->get_where( 'expenses', array( 'expenses.id' => $id ) )->row_array();
	}

	// All Expenses Count
	
	function get_all_expenses_count() {
		$this->db->from( 'expenses' );
		return $this->db->count_all_results();
	}
	
	/* Get All Expenses */
	
	function get_all_expenses() {
		$this->db->select( '*,customers.company as customer,customers.type as type,customers.namesurname as individual,expensecat.name as category,staff.staffname as staff,expenses.description as desc, expenses.id as id' );
		$this->db->join( 'customers', 'expenses.customer_id = customers.id', 'left' );
		$this->db->join( 'expensecat', 'expenses.category_id = expensecat.id', 'left' );
		$this->db->join( 'staff', 'expenses.staff_id = staff.id', 'left' );
		$this->db->order_by( 'expenses.id', 'desc' );
		return $this->db->get( 'expenses' )->result_array();
	}
	
	function get_all_expenses_by_relation($relation_type,$relation_id) {
		$this->db->select( '*,customers.company as customer,customers.type as type,customers.namesurname as individual,expensecat.name as category,staff.staffname as staff,expenses.description as desc, expenses.id as id' );
		$this->db->join( 'customers', 'expenses.customer_id = customers.id', 'left' );
		$this->db->join( 'expensecat', 'expenses.category_id = expensecat.id', 'left' );
		$this->db->join( 'staff', 'expenses.staff_id = staff.id', 'left' );
		$this->db->order_by( 'expenses.id', 'desc' );
		return $this->db->get_where( 'expenses', array( 'relation' => $relation_id, 'relation_type' => $relation_type ) )->result_array();
	}
	
	// Function to add new expenses
	
	function create( $params ) {
		$this->db->insert( 'expenses', $params );
		$expense = $this->db->insert_id();
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'payments', array(
			'transactiontype' => 1,
			'expense_id' => $expense,
			'staff_id' => $loggedinuserid,
			'amount' => $this->input->post( 'amount' ),
			'account_id' => $this->input->post( 'account' ),
			'customer_id' => $this->input->post( 'customer' ),
			'not' => 'Outgoings for <a href="' . base_url( 'expenses/receipt/' . $expense . '' ) . '">EXP-' . $expense . '</a>',
			'date' => _pdate( $this->input->post( 'date' ) ),
		) );
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'addedanewexpense' ) . ' <a href="expenses/receipt/' . $expense . '">' . lang( 'expenseprefix' ) . '-' . $expense . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' )
		) );
		return $expense;
	}

	// Function to update expenses
	
	function update_expenses( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'expenses', $params );
		$response = $this->db->where( 'expense_id', $id )->update( 'payments', array(
			'transactiontype' => 1,
			'amount' => $this->input->post( 'amount' ),
			'account_id' => $this->input->post( 'account' ),
			'customer_id' => $this->input->post( 'customer' ),
			'not' => 'Payment for <a href="' . base_url( 'expenses/edit/' . $id . '' ) . '">EXP-' . $id . '</a>',
			'date' => _pdate( $this->input->post( 'date' ) ),
		) );
		$loggedinuserid = $this->session->usr_id;
		$staffname = $this->session->staffname;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="expenses/receipt/' . $id . '">' . lang( 'expenseprefix' ) . '-' . $id . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' )
		) );
	}

	// Function to delete expenses
	
	function delete_expenses( $id ) {
		$response = $this->db->delete( 'expenses', array( 'id' => $id ) );
		$response = $this->db->delete( 'payments', array( 'expense_id' => $id ) );
		$response = $this->db->delete( 'sales', array( 'invoice_id' => $id ) );
		// LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'expenseprefix' ) . '-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}

	function get_expensecategory( $id ) {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'expensecat', array( 'id' => $id ) )->row_array();
	}

	/* Get All Expense Categories */

	function get_all_expensecat() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get( 'expensecat' )->result_array();
	}

	/* Add Expense Category */

	function add_category( $params ) {
		$this->db->insert( 'expensecat', $params );
		return $this->db->insert_id();
	}

	/* Update Expense Category */

	function update_category( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'expensecat', $params );
	}

	/* Delete Expense Category */

	function delete_category( $id ) {
		return $this->db->delete( 'expensecat', array( 'id' => $id ) );
	}
}