<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Panel extends CIUIS_Controller {
	function index() {
		$data[ 'title' ] = lang('logintitle');
		$this->load->view( 'inc/header', $data );
		$this->load->view( 'panel/index', $data );
		$this->load->view( 'inc/footer', $data );
	}
}