<?php
class CronJob extends CI_Controller {

	public function __construct(){
        parent::__construct();

         //load the model  
         $this->load->model('Invoices_Model');  

    }

	function index(){
		header('Location: /');
	}

	function run() {
		foreach ($this->Invoices_Model->get_all_recurring() as $key => $value) {
			// Check END Date 
			if($value['end_date'] != 'Invalid date' && strtotime($value['end_date']) <= strtotime(date('Y-m-d 23:59:59'))) continue;
			// Today Conflict
			$id = $value['relation'];
			$invv = $this->db->get_where( 'invoices', array( 'recurring' => $value['id']));
			if($invv->num_rows() == 0){
				$invv = $this->db->get_where( 'invoices', array( 'id' => $value['relation'] ) );
			}
			$invv = $invv->result_array();
			$invv = end($invv);
			// Years
			if($value['type'] == 3 && date('Y-m-d',strtotime($invv['created'].' +'.$value['period'].'Years')) != date('Y-m-d')){
				continue;
			}
			// Month
			if($value['type'] == 2 && date('Y-m-d',strtotime($invv['created'].' +'.$value['period'].'month')) != date('Y-m-d')){
				continue;
			}
			// Week
			if($value['type'] == 1 && date('Y-m-d',strtotime($invv['created'].' +'.$value['period'].'week')) != date('Y-m-d')){
				continue;
			}
			// Day
			if($value['type'] == 0 && date('Y-m-d',strtotime($invv['created'].' +'.$value['period'].'day')) != date('Y-m-d')){
				continue;
			}
				$invoice = $this->Invoices_Model->get_invoices($id);
			$created = date('Y-m-d');
			$invoices = array(
				'token' => md5( uniqid() ),
				'no' => $invoice['no'],
				'serie' => $invoice['serie'],
				'customer_id' => $invoice['customer_id'],
				'staff_id' => $invoice['staff_id'],
				'status_id' => 3,
				'created' => $created,
				'duedate' => date('Y-m-d' ,strtotime($created . '+30 days')), // +30 day
				'duenote' => $invoice['duenote'],
				'sub_total' => $invoice['sub_total'],
				'total_discount' => $invoice['total_discount'],
				'total_tax' => $invoice['total_tax'],
				'total' => $invoice['total'],
				'recurring' => $value['id'],
			);
				$items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'invoice', 'relation' => $id ) )->result_array();
				$this->Invoices_Model->recurring_invoice($invoices,$items);
				echo $id;
				echo '<br>';
		}
	}

}