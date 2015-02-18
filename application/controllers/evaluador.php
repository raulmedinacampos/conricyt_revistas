<?php
class Evaluador extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('evaluador_model', 'evaluador', TRUE);
		
		if(!$this->session->userdata('perfil')) {
			redirect(base_url());
		}
	}
	
	public function index() {
		$this->load->helper('form');
		$this->load->model('login_model', 'usuario', TRUE);
		
		$evaluador = $this->session->userdata['id_usr'];
		$data['revistas'] = $this->evaluador->consultarRevistasPorEvaluador($evaluador);
		$data['usuario'] = $this->usuario->consultarUsuarioPorID($evaluador);
		
		$this->load->view('header');
		$this->load->view('evaluacion/revistas_asignadas', $data);
		$this->load->view('footer');
	}
	
	public function evaluacion() {
		$this->load->helper('form');
		$this->load->model('login_model', 'usuario', TRUE);
		$this->load->library("Fecha");
		
		$id_solicitud = ($this->input->post('hdnSolicitud')) ? addslashes($this->input->post('hdnSolicitud')) : $this->session->flashdata('sess_solicitud');
		
		if(!$id_solicitud) {
			redirect(base_url('evaluador'));
		}
		
		$id_usuario = $this->session->userdata['id_usr'];
		
		$data['secciones'] = $this->evaluador->leerSecciones();
		$data['subsecciones'] = $this->evaluador->leerSubsecciones();
		$data['preguntas_hijas'] = $this->evaluador->leerPreguntasHijas();
		$data['opciones'] = $this->evaluador->leerOpciones();
		
		$solicitud = $this->evaluador->leerDatosSolicitudPorID($id_solicitud);
		$editor = $this->evaluador->consultarEditorPorRevista($solicitud->revista);
		$evaluador = $this->usuario->consultarUsuarioPorID($id_usuario);
		$evaluacion = $this->evaluador->consultarDatosEvaluacionPorSolicitud($solicitud->id_solicitud);
		
		if($evaluacion) {
			$respuestas = $this->evaluador->consultarRespuestasPorEvaluacion($evaluacion->id_evaluacion);
		}
		
		$preguntas = $this->evaluador->leerPreguntas();
		$preguntas_arr = array();
		foreach($preguntas->result() as $pregunta) {
			$preguntas_aux = new stdClass();
			$preguntas_aux->id_pregunta = $pregunta->id_pregunta;
			$preguntas_aux->pregunta = $pregunta->pregunta;
			$preguntas_aux->tipo_pregunta = $pregunta->tipo_pregunta;
			$preguntas_aux->seccion = $pregunta->seccion;
			$preguntas_aux->subseccion = $pregunta->subseccion;
			$preguntas_aux->puntos_asignados = $pregunta->puntos_asignados;
			
			if(isset($respuestas)) {
				foreach($respuestas->result() as $respuesta) {
					if($respuesta->pregunta == $pregunta->id_pregunta) {
						$preguntas_aux->justificacion = $respuesta->justificacion;
						$preguntas_aux->opcion = $respuesta->opcion;
					}
				}
			}
			$preguntas_arr[] = $preguntas_aux;
		}
		
		$data['preguntas'] = $preguntas_arr;
		
		$datos = new stdClass();
		
		$datos->estatus = 1;
		if($evaluacion) {
			$datos->fecha_evaluacion = Fecha::ConvertirNormal($evaluacion->fecha_evaluacion);
			$datos->estatus = $evaluacion->estatus;
		}
		
		$datos->folio = $solicitud->folio;
		$datos->revista = $solicitud->nombre;
		$datos->id_solicitud = $solicitud->id_solicitud;
		$datos->editor = trim($editor->nombre." ".$editor->ap_paterno." ".$editor->ap_materno);
		$datos->evaluador = trim($evaluador->nombre." ".$evaluador->ap_paterno." ".$evaluador->ap_materno);

		$data['datos'] = $datos;
		
		$this->load->view('header');
		$this->load->view('evaluacion/formulario', $data);
		$this->load->view('footer');
	}
	
	public function guardar() {
		$this->load->library("Fecha");
		
		$data['fecha_evaluacion'] = addslashes($this->input->post('fecha_evaluacion'));
		$data['fecha_evaluacion'] = Fecha::ConvertirMySQL($data['fecha_evaluacion']);
		$data['solicitud'] = $this->input->post('id_solicitud');
		$data['usuario'] = $this->session->userdata['id_usr'];
		$evaluacion = $this->evaluador->consultarDatosEvaluacionPorSolicitud($data['solicitud']);
		if($evaluacion) {
			$data['fecha_modificacion'] = date('Y-m-d H:i:s');
			$this->evaluador->actualizarEvaluacion($evaluacion->id_evaluacion, $data);
			$id_evaluacion = $evaluacion->id_evaluacion;
		} else {
			$data['fecha_creacion'] = date('Y-m-d H:i:s');
			$id_evaluacion = $this->evaluador->insertarEvaluacion($data);
		}
		
		$preguntas = $this->evaluador->leerPreguntas();
		
		foreach($preguntas->result() as $pregunta) {
			$respuesta['evaluacion'] = $id_evaluacion;
			$respuesta['pregunta'] = $pregunta->id_pregunta;
			$respuesta['opcion'] = $this->input->post('rdb_'.$pregunta->id_pregunta);
			$respuesta['justificacion'] = addslashes(trim($this->input->post('txt_'.$pregunta->id_pregunta)));
			
			if($respuesta['opcion'] != "" || $respuesta['justificacion'] != "") {
				if($this->evaluador->consultarRespuestaPorEvaluacionPregunta($id_evaluacion, $respuesta['pregunta'])) {
					$actualizacion['opcion'] = ($respuesta['opcion'] != "") ? $respuesta['opcion'] : NULL;
					$actualizacion['justificacion'] = $respuesta['justificacion'];
					
					$this->evaluador->actualizarRespuesta($id_evaluacion, $respuesta['pregunta'], $actualizacion);
				} else {
					$respuesta['opcion'] = ($respuesta['opcion'] != "") ? $respuesta['opcion'] : NULL;
					$this->evaluador->insertarRespuesta($respuesta);
				}
			}
		}
		
		$this->session->set_flashdata('sess_solicitud', $data['solicitud']);
	}
	
	public function guardarCambios() {
		$id_solicitud = $this->input->post('id_solicitud');
		$this->guardar();
		$this->session->set_flashdata('sess_solicitud', $id_solicitud);
		redirect(base_url('evaluador/evaluacion'));
	}
	
	public function finalizarEvaluacion() {
		$id_solicitud = $this->input->post('id_solicitud');
		$this->guardar();
		
		$evaluacion = $this->evaluador->consultarDatosEvaluacionPorSolicitud($id_solicitud);
		if($evaluacion) {
			$data['fecha_modificacion'] = date('Y-m-d H:i:s');
			$this->evaluador->actualizarEvaluacion($evaluacion->id_evaluacion, $data);
			$id_evaluacion = $evaluacion->id_evaluacion;
		}
		
		$data['fecha_finalizacion'] = date('Y-m-d H:i:s');
		$data['estatus'] = 5;
		$this->evaluador->actualizarEstatus($id_evaluacion, $data);
		
		redirect(base_url('evaluador'));
	}
}
?>