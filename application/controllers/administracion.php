<?php
class Administracion extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		if(!$this->session->userdata('perfil') || $this->session->userdata('perfil') != 1) {
			redirect(base_url('solicitud'));
		}
	}
	
	public function index() {
		$this->load->view('header');
		$this->load->view('footer');
	}
}