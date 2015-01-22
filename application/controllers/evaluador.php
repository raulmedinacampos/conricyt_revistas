<?php
class Evaluador extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('evaluador_model', 'evaluador', TRUE);
	}
	
	public function index() {
		$this->load->helper('form');
		
		$data['secciones'] = $this->evaluador->leerSecciones();
		$data['subsecciones'] = $this->evaluador->leerSubsecciones();
		$data['preguntas'] = $this->evaluador->leerPreguntas();
		$data['preguntas_hijas'] = $this->evaluador->leerPreguntasHijas();
		$data['opciones'] = $this->evaluador->leerOpciones();
		 
		$this->load->view('header');
		$this->load->view('evaluacion/formulario', $data);
		$this->load->view('footer');
	}
}
?>