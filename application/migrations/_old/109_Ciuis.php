<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Migration_Ciuis_109 extends CI_Migration {
	function __construct() {
		parent::__construct();
	}

	public

	function up() {

		$fields = array(
			'converted_lead_status_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => false,
				'auto_increment' => false
			),
		);
		$this->dbforge->add_column( 'settings', $fields );

		$contacts_fields = array(
			'intercom' => array(
				'name' => 'extension',
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
		);
		$this->dbforge->modify_column( 'contacts', $contacts_fields );

		$this->dbforge->add_field( array(
			'staff_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'null' => FALSE,
			),
			'menu_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'null' => FALSE,
			),
		) );
		
		$this->dbforge->create_table( 'privileges' );

		$data = array(
			array( 'staff_id' => 1,
				'menu_id' => 7 ),
			array( 'staff_id' => 1,
				'menu_id' => 8 ),
			array( 'staff_id' => 1,
				'menu_id' => 9 ),
			array( 'staff_id' => 1,
				'menu_id' => 10 ),
			array( 'staff_id' => 1,
				'menu_id' => 11 ),
			array( 'staff_id' => 1,
				'menu_id' => 12 ),
			array( 'staff_id' => 1,
				'menu_id' => 13 ),
			array( 'staff_id' => 1,
				'menu_id' => 14 ),
			array( 'staff_id' => 1,
				'menu_id' => 15 ),
			array( 'staff_id' => 1,
				'menu_id' => 16 ),
			array( 'staff_id' => 1,
				'menu_id' => 17 ),
			array( 'staff_id' => 1,
				'menu_id' => 18 )
		);

		$this->db->insert_batch( 'privileges', $data );

	}

}