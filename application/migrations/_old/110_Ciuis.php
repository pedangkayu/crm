<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Migration_Ciuis_110 extends CI_Migration {
	function __construct() {
		parent::__construct();
	}

	public

	function up() {

		$this->dbforge->drop_table( 'privileges' );


		$this->dbforge->add_field( array(
			'staff_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'null' => FALSE,
			),
			'permission_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'null' => FALSE,
			),
		) );

		$this->dbforge->create_table( 'privileges' );

		$data = array(
			array( 'staff_id' => 1,
				'permission_id' => 1 ),
			array( 'staff_id' => 1,
				'permission_id' => 2 ),
			array( 'staff_id' => 1,
				'permission_id' => 3 ),
			array( 'staff_id' => 1,
				'permission_id' => 4 ),
			array( 'staff_id' => 1,
				'permission_id' => 5 ),
			array( 'staff_id' => 1,
				'permission_id' => 6 ),
			array( 'staff_id' => 1,
				'permission_id' => 7 ),
			array( 'staff_id' => 1,
				'permission_id' => 8 ),
			array( 'staff_id' => 1,
				'permission_id' => 9 ),
			array( 'staff_id' => 1,
				'permission_id' => 10 ),
			array( 'staff_id' => 1,
				'permission_id' => 11 ),
			array( 'staff_id' => 1,
				'permission_id' => 12 )
		);

		$this->db->insert_batch( 'privileges', $data );



		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'permission' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			),
			'key' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			),
		) );

		$this->dbforge->add_key( 'id', TRUE );
		$this->dbforge->create_table( 'permissions' );

		$data_permissions = array(
			array( 'id' => 1, 'permission' => 'x_menu_invoices', 'key' => 'invoices' ),
			array( 'id' => 2, 'permission' => 'x_menu_proposals', 'key' => 'proposals' ),
			array( 'id' => 3, 'permission' => 'x_menu_expenses', 'key' => 'expenses' ),
			array( 'id' => 4, 'permission' => 'x_menu_accounts', 'key' => 'accounts' ),
			array( 'id' => 5, 'permission' => 'x_menu_customers', 'key' => 'customers' ),
			array( 'id' => 6, 'permission' => 'x_menu_leads', 'key' => 'leads' ),
			array( 'id' => 7, 'permission' => 'x_menu_projects', 'key' => 'projects' ),
			array( 'id' => 8, 'permission' => 'x_menu_tasks', 'key' => 'tasks' ),
			array( 'id' => 9, 'permission' => 'x_menu_tickets', 'key' => 'tickets' ),
			array( 'id' => 10, 'permission' => 'x_menu_products', 'key' => 'products' ),
			array( 'id' => 11, 'permission' => 'x_menu_staff', 'key' => 'staff' ),
			array( 'id' => 12, 'permission' => 'x_menu_reports', 'key' => 'report' ),

		);

		$this->db->insert_batch( 'permissions', $data_permissions );

		$fields = array(
			'two_factor_authentication' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => false,
				'auto_increment' => false
			),
		);
		$this->dbforge->add_column( 'settings', $fields );

		$this->dbforge->drop_table( 'menu' );

		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'order_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'main_menu' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
			),
			'icon' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'show_staff' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
			)
		) );
		$this->dbforge->add_key( 'id', TRUE );
		$this->dbforge->create_table( 'menu' );

		$data = array(
			array(
				'id' => 1, 'order_id' => 1, 'name' => 'x_menu_panel', 'description' => null, 'main_menu' => 0, 'icon' => null, 'url' => 'panel', 'show_staff' => 0 ),
			array(
				'id' => 2, 'order_id' => 2, 'name' => 'x_menu_finance', 'description' => null, 'main_menu' => 0, 'icon' => null, 'url' => null, 'show_staff' => 0 ),
			array(
				'id' => 3, 'order_id' => 3, 'name' => 'x_menu_customers_and_lead', 'description' => null, 'main_menu' => 0, 'icon' => null, 'url' => null, 'show_staff' => 0 ),
			array(
				'id' => 4, 'order_id' => 4, 'name' => 'x_menu_track', 'description' => null, 'main_menu' => 0, 'icon' => null, 'url' => null, 'show_staff' => 0 ),
			array(
				'id' => 5, 'order_id' => 5, 'name' => 'x_menu_others', 'description' => null, 'main_menu' => 0, 'icon' => null, 'url' => null, 'show_staff' => 0 ),
			array(
				'id' => 6, 'order_id' => 6, 'name' => 'x_menu_calendar', 'description' => null, 'main_menu' => 0, 'icon' => null, 'url' => 'calendar', 'show_staff' => 0 ),
			array(
				'id' => 7, 'order_id' => 1, 'name' => 'x_menu_invoices', 'description' => 'manage_invoices', 'main_menu' => 2, 'icon' => 'ico-ciuis-invoices', 'url' => 'invoices', 'show_staff' => 0 ),
			array(
				'id' => 8, 'order_id' => 2, 'name' => 'x_menu_proposals', 'description' => 'manage_proposals', 'main_menu' => 2, 'icon' => 'ico-ciuis-proposals', 'url' => 'proposals', 'show_staff' => 0 ),
			array(
				'id' => 9, 'order_id' => 3, 'name' => 'x_menu_expenses', 'description' => 'manage_expenses', 'main_menu' => 2, 'icon' => 'ico-ciuis-expenses', 'url' => 'expenses', 'show_staff' => 0 ),
			array(
				'id' => 10, 'order_id' => 4, 'name' => 'x_menu_accounts', 'description' => 'manage_accounts', 'main_menu' => 2, 'icon' => 'ico-ciuis-accounts', 'url' => 'accounts', 'show_staff' => 1 ),
			array(
				'id' => 11, 'order_id' => 1, 'name' => 'x_menu_customers', 'description' => 'manage_customers', 'main_menu' => 3, 'icon' => 'ico-ciuis-customers', 'url' => 'customers', 'show_staff' => 0 ),
			array(
				'id' => 12, 'order_id' => 2, 'name' => 'x_menu_leads', 'description' => 'manage_leads', 'main_menu' => 3, 'icon' => 'ico-ciuis-leads', 'url' => 'leads', 'show_staff' => 0 ),
			array(
				'id' => 13, 'order_id' => 1, 'name' => 'x_menu_projects', 'description' => 'manage_projects', 'main_menu' => 4, 'icon' => 'ico-ciuis-projects', 'url' => 'projects', 'show_staff' => 0 ),
			array(
				'id' => 14, 'order_id' => 2, 'name' => 'x_menu_tasks', 'description' => 'manage_tasks', 'main_menu' => 4, 'icon' => 'ico-ciuis-tasks', 'url' => 'tasks', 'show_staff' => 0 ),
			array(
				'id' => 15, 'order_id' => 3, 'name' => 'x_menu_tickets', 'description' => 'manage_tickets', 'main_menu' => 4, 'icon' => 'ico-ciuis-supports', 'url' => 'tickets', 'show_staff' => 0 ),
			array(
				'id' => 16, 'order_id' => 4, 'name' => 'x_menu_products', 'description' => 'manage_products', 'main_menu' => 4, 'icon' => 'ico-ciuis-products', 'url' => 'products', 'show_staff' => 0 ),
			array(
				'id' => 17, 'order_id' => 1, 'name' => 'x_menu_staff', 'description' => 'manage_staff', 'main_menu' => 5, 'icon' => 'ico-ciuis-staff', 'url' => 'staff', 'show_staff' => 1 ),
			array(
				'id' => 18, 'order_id' => 2, 'name' => 'x_menu_reports', 'description' => 'manage_reports', 'main_menu' => 5, 'icon' => 'ico-ciuis-reports', 'url' => 'report', 'show_staff' => 1 ),
		);

		$this->db->insert_batch( 'menu', $data );

	}

}