<?php
class Invoices_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_invoices( $id ) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as email,invoicestatus.name as statusname,invoices.status_id as status_id,invoices.created as created, invoices.id as id,
			recurring.id as recurring_id, recurring.status as recurring_status, recurring.relation_type as recurring_relation_type, recurring.period as recurring_period, recurring.type as recurring_type, recurring.end_date as recurring_endDate
		 ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'recurring', 'invoices.id = recurring.relation AND recurring.relation_type = "invoice"', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'invoices', array( 'invoices.id' => $id ) )->row_array();
	}

	function get_invoices_by_token( $token ) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as email,,invoicestatus.name as statusname,invoices.status_id as status_id, invoices.created as created, invoices.id as id,
			recurring.id as recurring_id, recurring.status as recurring_status, recurring.relation_type as recurring_relation_type, recurring.period as recurring_period, recurring.type as recurring_type, recurring.end_date as recurring_endDate
		 ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'recurring', 'invoices.id = recurring.relation AND recurring.relation_type = "invoice"', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'invoices', array( 'invoices.token' => $token ) )->row_array();
	}

	function get_all_invoices() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as email,invoicestatus.name as statusname,invoices.status_id as status_id, invoices.created as created, invoices.id as id ,
			recurring.id as recurring_id, recurring.status as recurring_status, recurring.relation_type as recurring_relation_type, recurring.period as recurring_period, recurring.type as recurring_type, recurring.end_date as recurring_endDate
		 ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'recurring', 'invoices.id = recurring.relation AND recurring.relation_type = "invoice"', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->order_by( 'invoices.id', 'desc' );
		return $this->db->get_where( 'invoices', array( '' ) )->result_array();
	}

	function get_all_invoices_by_customer( $id ) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as email,invoicestatus.name as statusname,invoices.status_id as status_id, invoices.created as created, invoices.id as id ,
			recurring.id as recurring_id, recurring.status as recurring_status, recurring.relation_type as recurring_relation_type, recurring.period as recurring_period, recurring.type as recurring_type, recurring.end_date as recurring_endDate
		 ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'recurring', 'invoices.id = recurring.relation AND recurring.relation_type = "invoice"', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->order_by( 'invoices.id', 'desc' );
		return $this->db->get_where( 'invoices', array( 'customer_id' => $id ) )->result_array();
	}

	function dueinvoices() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as email,customers.type as type,invoicestatus.name as statusname, invoices.created as created, invoices.id as id,
			recurring.id as recurring_id, recurring.status as recurring_status, recurring.relation_type as recurring_relation_type, recurring.period as recurring_period, recurring.type as recurring_type, recurring.end_date as recurring_endDate
		 ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'recurring', 'invoices.id = recurring.relation AND recurring.relation_type = "invoice"', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->order_by( 'invoices.id', 'desc' );
		return $this->db->get_where( 'invoices', array( 'DATE(duedate)' => date( 'Y-m-d' ) ) )->result_array();
	}

	function overdueinvoices() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as email,customers.type as type,invoicestatus.name as statusname, invoices.created as created, invoices.id as id ,
			recurring.id as recurring_id, recurring.status as recurring_status, recurring.relation_type as recurring_relation_type, recurring.period as recurring_period, recurring.type as recurring_type, recurring.end_date as recurring_endDate
		 ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'recurring', 'invoices.id = recurring.relation AND recurring.relation_type = "invoice"', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->where( 'CURDATE() > invoices.duedate AND invoices.duedate != "0000.00.00" AND invoices.status_id != "4" AND invoices.status_id != "2"' );
		$this->db->order_by( 'invoices.id', 'desc' );
		return $this->db->get( 'invoices' )->result_array();
	}

	function get_invoice_detail( $id ) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individualindividual,customers.address as customeraddress,customers.email as email,invoicestatus.name as statusname,invoices.status_id as status_id, invoices.created as created, invoices.id as id ,
			recurring.id as recurring_id, recurring.status as recurring_status, recurring.relation_type as recurring_relation_type, recurring.period as recurring_period, recurring.type as recurring_type, recurring.end_date as recurring_endDate
		 ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'recurring', 'invoices.id = recurring.relation AND recurring.relation_type = "invoice"', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'invoices', array( 'invoices.id' => $id ) )->row_array();
	}

	function get_items_invoices( $id ) {
		$this->db->select_sum( 'total' );
		$this->db->from( 'items' );
		$this->db->where( '(relation_type = "invoice" AND relation = ' . $id . ')' );
		return $this->db->get();
	}

	function get_paid_invoices( $id ) {
		$this->db->select_sum( 'amount' );
		$this->db->from( 'payments' );
		$this->db->where( '(invoice_id = ' . $id . ') ' );
		return $this->db->get();
	}
	// ADD RECURRING

	function recurring_add( $params ) {
		$this->db->insert( 'recurring', $params );
		$sharax = $this->db->insert_id();
		return $sharax;
	}

	// END ADD RECURRING
	// UPDATE RECURRING

	function recurring_update( $id, $params ) {
		$this->db->where( 'relation', $id )->where('relation_type','invoice');
		$sharax = $this->db->update( 'recurring', $params );
		return $sharax;
	}

	// END UPDATE RECURRING

	// GET ALL RECURRING
	function get_all_recurring() {
		$this->db->select( '*' );
		return $this->db->get_where( 'recurring', array( 'status' => 0 ) )->result_array();
	}
	// END GET ALL RECURRING
	// Copy Invoice
	function recurring_invoice( $invoices, $items) {
		$this->db->insert( 'invoices', $invoices );
		$invoice = $this->db->insert_id();
			$loggedinuserid = 0;
		$i = 0;
		foreach ( $items as $item ) {
			$this->db->insert( 'items', array(
				'relation_type' => 'invoice',
				'relation' => $invoice,
				'product_id' => $item[ 'product_id' ],
				'code' => $item[ 'code' ],
				'name' => $item[ 'name' ],
				'description' => $item[ 'description' ],
				'quantity' => $item[ 'quantity' ],
				'unit' => $item[ 'unit' ],
				'price' => $item[ 'price' ],
				'tax' => $item[ 'tax' ],
				'discount' => $item[ 'discount' ],
				'total' => $item[ 'total' ],
			) );
			$i++;
		};
		//LOG
		$staffname = 'Ciuis CRM Recurring';
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="#"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="invoices/invoice/' . $invoice . '">' . lang( 'invoiceprefix' ) . '-' . $invoice . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $invoices['customer_id']
		) );
		//NOTIFICATION
		$staffavatar = 'defualt-avatar.jpg';
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewinvoice' ) . '' ),
			'customer_id' => $invoices['customer_id'],
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
		) );
		//--------------------------------------------------------------------------------------
			$status = 3;
		$this->db->insert( $this->db->dbprefix . 'sales', array(
			'invoice_id' => '' . $invoice . '',
			'status_id' => $status,
			'staff_id' => $loggedinuserid,
			'customer_id' => $invoices['customer_id'],
			'total' => $invoices['total'],
			'date' => date( 'Y-m-d H:i:s' )
		) );
		//----------------------------------------------------------------------------------------
		return $invoice;
	}
	// END Copy Invoice
	// ADD INVOICE
	function invoice_add( $params ) {
		$this->db->insert( 'invoices', $params );
		$invoice = $this->db->insert_id();
		if ( $this->input->post( 'status' ) == 'true' ) {
			$loggedinuserid = $this->session->usr_id;
			$this->db->insert( 'payments', array(
				'transactiontype' => 0,
				'invoice_id' => $invoice,
				'staff_id' => $loggedinuserid,
				'amount' => $this->input->post( 'total' ),
				'customer_id' => $this->input->post( 'customer' ),
				'account_id' => $this->input->post( 'account' ),
				'not' => '' . $message = sprintf( lang( 'paymentfor' ), $invoice ) . '',
				'date' => $this->input->post( 'datepayment' )
			) );
		}
		$items = $this->input->post( 'items' );
		$i = 0;
		foreach ( $items as $item ) {
			$this->db->insert( 'items', array(
				'relation_type' => 'invoice',
				'relation' => $invoice,
				'product_id' => $item[ 'product_id' ],
				'code' => $item[ 'code' ],
				'name' => $item[ 'name' ],
				'description' => $item[ 'description' ],
				'quantity' => $item[ 'quantity' ],
				'unit' => $item[ 'unit' ],
				'price' => $item[ 'price' ],
				'tax' => $item[ 'tax' ],
				'discount' => $item[ 'discount' ],
				'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
			) );
			$i++;
		};
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="invoices/invoice/' . $invoice . '">' . lang( 'invoiceprefix' ) . '-' . $invoice . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' )
		) );
		//NOTIFICATION
		$staffname = $this->session->staffname;
		$staffavatar = $this->session->staffavatar;
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewinvoice' ) . '' ),
			'customer_id' => $this->input->post( 'customer' ),
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
		) );
		//--------------------------------------------------------------------------------------
		$status_value = $this->input->post( 'status' );
		if ( $status_value == 'true' ) {
			$status = 2;
		} else {
			$status = 3;
		}
		$this->db->insert( $this->db->dbprefix . 'sales', array(
			'invoice_id' => '' . $invoice . '',
			'status_id' => $status,
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' ),
			'total' => $this->input->post( 'total' ),
			'date' => date( 'Y-m-d H:i:s' )
		) );
		//----------------------------------------------------------------------------------------
		return $invoice;
	}

	// UPDATE INVOCE
	function update_invoices( $id, $params ) {
		$this->db->where( 'id', $id );
		$invoice = $id;
		$response = $this->db->update( 'invoices', $params );
		$items = $this->input->post( 'items' );
		$i = 0;
		foreach ( $items as $item ) {
			if ( isset( $item[ 'id' ] ) ) {
				$params = array(
					'relation_type' => 'invoice',
					'relation' => $invoice,
					'product_id' => $item[ 'product_id' ],
					'code' => $item[ 'code' ],
					'name' => $item[ 'name' ],
					'description' => $item[ 'description' ],
					'quantity' => $item[ 'quantity' ],
					'unit' => $item[ 'unit' ],
					'price' => $item[ 'price' ],
					'tax' => $item[ 'tax' ],
					'discount' => $item[ 'discount' ],
					'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
				);
				$this->db->where( 'id', $item[ 'id' ] );
				$response = $this->db->update( 'items', $params );
			}
			if ( empty( $item[ 'id' ] ) ) {
				$this->db->insert( 'items', array(
					'relation_type' => 'invoice',
					'relation' => $invoice,
					'product_id' => $item[ 'product_id' ],
					'code' => $item[ 'code' ],
					'name' => $item[ 'name' ],
					'description' => $item[ 'description' ],
					'quantity' => $item[ 'quantity' ],
					'unit' => $item[ 'unit' ],
					'price' => $item[ 'price' ],
					'tax' => $item[ 'tax' ],
					'discount' => $item[ 'discount' ],
					'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
				) );
			}
			$i++;
		};
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$response = $this->db->where( 'invoice_id', $id )->update( 'sales', array(
			'status_id' => $invoices[ 'status_id' ],
			'staff_id' => $this->session->usr_id,
			'customer_id' => $this->input->post( 'customer' ),
			'total' => $this->input->post( 'total' ),
		) );
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="invoices/invoice/' . $id . '">' . lang( 'invoiceprefix' ) . '-' . $id . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' )
		) );
		//NOTIFICATION
		$staffname = $this->session->staffname;
		$staffavatar = $this->session->staffavatar;
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'uptdatedinvoice' ) . '' ),
			'customer_id' => $this->input->post( 'customer' ),
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
		) );
	}

	//INVOICE DELETE
	function delete_invoices( $id ) {
		$response = $this->db->delete( 'invoices', array( 'id' => $id ) );
		$response = $this->db->delete( 'items', array( 'relation_type' => 'invoice', 'relation' => $id ) );
		$response = $this->db->delete( 'payments', array( 'invoice_id' => $id ) );
		$response = $this->db->delete( 'sales', array( 'invoice_id' => $id ) );
		$response = $this->db->where( 'invoice_id', $id )->update( 'expenses', array( 'invoice_id' => null ) );
		// LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'invoiceprefix' ) . '-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}

	function get_invoice_year() {
		return $this->db->query( 'SELECT DISTINCT(YEAR(date)) as year FROM invoices ORDER BY year DESC' )->result_array();
	}
}