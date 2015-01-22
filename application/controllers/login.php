<?php
class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('login_model', 'login', TRUE);
	}
	
	public function index() {
		$this->load->helper('form');
		
		$this->load->view('header');
		if(date('Y-m-d') >= "2014-11-08") {
			$this->load->view('inicio');
		} else {
			$this->load->view('solicitud/error');
		}
		$this->load->view('footer');
	}
	
	public function validarAcceso() {
		$usuario = addslashes($this->input->post('usuario'));
		$password = addslashes($this->input->post('password'));
		
		$usr = $this->login->buscarUsuario($usuario, $password);
		
		if($usr) {
			$this->session->unset_userdata('error');
			$this->session->set_userdata('perfil', $usr->tipo_usuario);
			$this->session->set_userdata('id_usr', $usr->id_usuario);
			
			switch($usr->tipo_usuario) {
				case 1:
					redirect(base_url('administracion'));
					break;
				case 2:
					redirect(base_url('evaluador'));
					break;
				case 3:
					redirect(base_url('solicitud'));
					break;
				default:
					break;
			}
		} else {
			$this->session->set_userdata('error', true);
			redirect(base_url());
		}
	}
	
	public function cerrarSesion() {
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
?>