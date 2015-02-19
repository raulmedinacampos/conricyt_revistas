<?php
class Representante_comite extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('representante_model', 'representante', TRUE);
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
		$evaluaciones = $this->representante->consultarRevistasPorRepresentanteComision($evaluador, $comision);
		
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
					$dato->{'ev_'.$ev->id_usuario} = (float)$calificacion;
					
					if(!$asignacion) {
						$dato->{'ev_'.$ev->id_usuario} = "NA";
						$dato->{'calif_estatus_'.$ev->id_usuario} = $dato->{'ev_'.$ev->id_usuario};
					} else {
						$involucrados++;
						$promedio += $calificacion;
						$dato->{'calif_estatus_'.$ev->id_usuario} = $dato->{'ev_'.$ev->id_usuario}." ($dato->estatus)";
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
		$this->load->model('evaluador_model', 'evaluador', TRUE);
		
		$evaluador = $this->session->userdata['id_usr'];
		
		$header['area'] = $this->evaluador->consultarAreaPorUsuario($evaluador);
		
		$this->load->view('header', $header);
		$this->load->view('evaluacion/evaluacion_detalle');
		$this->load->view('footer');
	}
}
?>