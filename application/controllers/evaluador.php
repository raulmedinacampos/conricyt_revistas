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
		$data['usuario'] = $this->usuario->consultarUsuarioPorID($evaluador);
		
		$header['area'] = $this->evaluador->consultarAreaPorUsuario($evaluador);
		
		$revistas = $this->evaluador->consultarRevistasPorEvaluador($evaluador);
		$revista_arr = array();
		
		foreach($revistas->result() as $revista) {
			$evaluacion = $this->evaluador->consultarEvaluacionPorSolicitudUsuario($revista->id_solicitud, $evaluador);
			
			$revista_aux = new stdClass();
			$revista_aux->id_solicitud = $revista->id_solicitud;
			$revista_aux->id_evaluacion = (isset($evaluacion->id_evaluacion)) ? $evaluacion->id_evaluacion : "";
			$revista_aux->nombre = $revista->nombre;
			$revista_aux->institucion = $revista->institucion;
			$revista_aux->estatus = (isset($evaluacion->estatus)) ? $evaluacion->estatus : 0;
			$revista_arr[] = $revista_aux;
		}
		
		$data['revistas'] = $revista_arr;
		
		$this->load->view('header', $header);
		$this->load->view('evaluacion/revistas_asignadas', $data);
		$this->load->view('footer');
	}
	
	public function evaluacion() {
		$this->load->helper('form');
		$this->load->model('login_model', 'usuario', TRUE);
		$this->load->library("Fecha");
		
		$id_solicitud = ($this->input->post('hdnSolicitud')) ? addslashes($this->input->post('hdnSolicitud')) : $this->session->flashdata('sess_solicitud');
		$id_evaluacion = ($this->input->post('hdnEvaluacion')) ? addslashes($this->input->post('hdnEvaluacion')) : $this->session->flashdata('sess_evaluacion');
		
		if(!$id_solicitud) {
			redirect(base_url('evaluador'));
		}
		
		$id_usuario = $this->session->userdata['id_usr'];
		
		$header['area'] = $this->evaluador->consultarAreaPorUsuario($id_usuario);
		
		$data['secciones'] = $this->evaluador->leerSecciones();
		$data['subsecciones'] = $this->evaluador->leerSubsecciones();
		$data['preguntas_hijas'] = $this->evaluador->leerPreguntasHijas();
		$data['opciones'] = $this->evaluador->leerOpciones();
		
		$solicitud = $this->evaluador->leerDatosSolicitudPorID($id_solicitud);
		$editor = $this->evaluador->consultarEditorPorRevista($solicitud->revista);
		$evaluador = $this->usuario->consultarUsuarioPorID($id_usuario);
		$evaluacion = $this->evaluador->consultarDatosEvaluacionPorID($id_evaluacion);
		
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
			$datos->comentarios = $evaluacion->comentarios;
			$datos->id_evaluacion = $evaluacion->id_evaluacion;
		}
		
		$datos->folio = $solicitud->folio;
		$datos->id_revista = $solicitud->revista;
		$datos->revista = $solicitud->nombre;
		$datos->id_solicitud = $solicitud->id_solicitud;
		$datos->editor = trim($editor->nombre." ".$editor->ap_paterno." ".$editor->ap_materno);
		$datos->evaluador = trim($evaluador->nombre." ".$evaluador->ap_paterno." ".$evaluador->ap_materno);

		$data['datos'] = $datos;
		
		$this->load->view('header', $header);
		$this->load->view('evaluacion/formulario', $data);
		$this->load->view('footer');
	}
	
	public function guardar() {
		$this->load->library("Fecha");
		
		$id_ev = $this->input->post('id_evaluacion');
		
		$data['fecha_evaluacion'] = addslashes($this->input->post('fecha_evaluacion'));
		$data['fecha_evaluacion'] = Fecha::ConvertirMySQL($data['fecha_evaluacion']);
		$data['solicitud'] = $this->input->post('id_solicitud');
		$data['usuario'] = $this->session->userdata['id_usr'];
		$data['comentarios'] = addslashes($this->input->post('comentarios'));
		//$evaluacion = $this->evaluador->consultarDatosEvaluacionPorSolicitud($data['solicitud']);
		$evaluacion = $this->evaluador->consultarDatosEvaluacionPorID($id_ev);
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
		
		$this->session->set_flashdata('sess_solicitud', $id_ev);
		$this->session->set_flashdata('sess_evaluacion', $data['solicitud']);
	}
	
	public function guardarCambios() {
		$id_solicitud = $this->input->post('id_solicitud');
		$id_evaluacion = $this->input->post('id_evaluacion');
		$this->guardar();
		$this->session->set_flashdata('sess_solicitud', $id_solicitud);
		$this->session->set_flashdata('sess_evaluacion', $id_evaluacion);
		redirect(base_url('evaluador/evaluacion'));
	}
	
	public function finalizarEvaluacion() {
		$id_solicitud = $this->input->post('id_solicitud');
		$id_ev = $this->input->post('id_evaluacion');
		$this->guardar();
		
		//$evaluacion = $this->evaluador->consultarDatosEvaluacionPorSolicitud($id_solicitud);
		$evaluacion = $this->evaluador->consultarDatosEvaluacionPorID($id_ev);
		if($evaluacion) {
			$data['fecha_modificacion'] = date('Y-m-d H:i:s');
			$data['calificacion'] =  $this->input->post('calificacion_final');
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