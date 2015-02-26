<?php
class Representante_comite extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('representante_model', 'representante', TRUE);
		
		if(!$this->session->userdata('perfil')) {
			redirect(base_url());
		}
	}
	
	public function index() {
		$this->load->helper('form');
		$this->load->model('evaluador_model', 'evaluador', TRUE);
		$this->load->model('login_model', 'usuario', TRUE);
		
		$evaluador = $this->session->userdata['id_usr'];
		$comision = $this->representante->consultarComisionPorUsuario($evaluador);
		
		$header['area'] = $this->evaluador->consultarAreaPorUsuario($evaluador);
		
		$data['usuario'] = $this->usuario->consultarUsuarioPorID($evaluador);
		$data['revistas'] = $this->evaluador->consultarRevistasPorEvaluador($evaluador);
		$revistas = $this->representante->consultarRevistasPorComision($comision);
		$evaluadores = $this->representante->consultarEvaluadoresPorComision($comision);
		
		$datos_arr = array();
		
		if(isset($revistas)) {
			foreach($revistas->result() as $revista) {
				$involucrados = 0;
				$promedio = 0;
				$dato = new stdClass();
				$dato->revista = $revista->nombre;
				$dato->estatus = "Pendiente";
				
				if($revista->estatus == 1) {
					$dato->estatus = "En proceso";
				} else if($revista->estatus == 5) {
					$dato->estatus = "Finalizada";
				}
				
				foreach($evaluadores->result() as $ev) {
					$asignacion = $this->representante->verificarEvaluacionAsignada($ev->id_usuario, $revista->id_revista);
					$calificacion = $this->representante->consultarCalificacionPorUsuarioSolicitud($ev->id_usuario, $revista->id_solicitud);
					$evaluacion = $this->representante->consultarEvaluacionPorSolicitudUsuario($revista->id_solicitud, $ev->id_usuario);
					$dato->{'ev_'.$ev->id_usuario} = (float)$calificacion;
					$id_evaluacion = (isset($evaluacion->id_evaluacion)) ? $evaluacion->id_evaluacion : "";
						
					if(!$asignacion) {
						$dato->{'ev_'.$ev->id_usuario} = "NA";
						$dato->{'calif_estatus_'.$ev->id_usuario} = $dato->{'ev_'.$ev->id_usuario};
					} else {
						$involucrados++;
						$promedio += $calificacion;
						if($id_evaluacion) {
							$dato->{'calif_estatus_'.$ev->id_usuario} = '<a href="'.base_url('representante-comite/vista-evaluacion/'.$id_evaluacion).'">'.number_format($dato->{'ev_'.$ev->id_usuario}, 2)." ($dato->estatus)</a>";
						} else {
							$dato->{'calif_estatus_'.$ev->id_usuario} = $dato->{'ev_'.$ev->id_usuario}." (Pendiente)";
						}
					}
					
					
				}
				
				$promedio = $promedio / $involucrados;
				
				$dato->promedio = $promedio;
				$datos_arr[] = $dato;
			}
		}
		
		$data['evaluadores'] = $evaluadores;
		$data['evaluaciones'] = $datos_arr;
		
		$this->load->view('header', $header);
		$this->load->view('evaluacion/inicio_representante', $data);
		$this->load->view('footer');
	}
	
	public function vista_evaluacion() {
		$this->load->library('Fecha');
		$this->load->model('evaluador_model', 'evaluador', TRUE);
		
		$evaluador = $this->session->userdata['id_usr'];
		
		$header['area'] = $this->evaluador->consultarAreaPorUsuario($evaluador);
		
		$data['secciones'] = $this->evaluador->leerSecciones();
		$data['subsecciones'] = $this->evaluador->leerSubsecciones();
		
		$id_evaluacion = ($this->uri->segment(3));
		settype($id_evaluacion, "int");
		
		if($id_evaluacion == 0) {
			redirect(base_url('representante-comite'));
		}
		
		$evaluacion = $this->representante->consultarEvaluacionPorID($id_evaluacion);
		
		if($evaluacion) {
			$solicitud = $this->evaluador->leerDatosSolicitudPorID($evaluacion->solicitud);
			$evaluacion->fecha_evaluacion = Fecha::ConvertirNormal($evaluacion->fecha_evaluacion);
			$data['evaluacion'] = $evaluacion;
			$respuestas = $this->evaluador->consultarRespuestasPorEvaluacion($evaluacion->id_evaluacion);
		}
		
		if($solicitud) {
			$solicitud->revista = $this->representante->consultarNombreRevistaPorID($solicitud->revista);
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
		
		$data['solicitud'] = $solicitud;
		$data['preguntas'] = $preguntas_arr;
		
		$this->load->view('header', $header);
		$this->load->view('evaluacion/evaluacion_detalle', $data);
		$this->load->view('footer');
	}
	
	public function dictamen() {
		$this->load->helper('form');
		$this->load->model('evaluador_model', 'evaluador', TRUE);
		
		$evaluador = $this->session->userdata['id_usr'];
		
		$header['area'] = $this->evaluador->consultarAreaPorUsuario($evaluador);
		
		$data = array();
		$this->load->view('header', $header);
		$this->load->view('evaluacion/dictamen', $data);
		$this->load->view('footer');
	}
}
?>