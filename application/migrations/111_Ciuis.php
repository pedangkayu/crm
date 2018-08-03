<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Migration_Ciuis extends CI_Migration {
	function __construct() {
		parent::__construct();
	}

	public

	function up() {
		$fields = array(
			'appointment_availability' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => false,
				'auto_increment' => false
			),
		);
		$this->dbforge->add_column( 'staff', $fields );


		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'contact_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
			),
			'staff_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
			),
			'note' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			),
			'start' => array(
				'type' => 'TIMESTAMP',
				'null' => TRUE,
			),
			'end' => array(
				'type' => 'TIMESTAMP',
				'null' => TRUE,
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
			)
		) );
		$this->dbforge->add_key( 'id', TRUE );
		$this->dbforge->create_table( 'appointments' );


		$fields_inv = array(
			'recurring' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0,
			),
		);
		$this->dbforge->add_column( 'invoices', $fields_inv );


		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
			),
			'relation_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			),
			'relation' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => 0,
			),
			'period' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => 0,
			),
			'type' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => 0,
			),
			'created_at' => array(
				'type' => 'TIMESTAMP',
				'null' => TRUE,
			),
			'end_date' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
				'default' => 'Invalid date',
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => 0,
			)
		) );
		$this->dbforge->add_key( 'id', TRUE );
		$this->dbforge->create_table( 'recurring' );
	}

}