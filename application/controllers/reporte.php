<?php
class Reporte extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('reporte_model', 'reporte', TRUE);
	}
	
	public function index() {
		$data['totalUsuarios'] = $this->reporte->obtenerTotalUsuarios();
		$data['totalRevistas'] = $this->reporte->obtenerTotalRevistas();
		$data['datos'] = array();
		
		$revistas = $this->reporte->leerRevistas();
		$revistas = $revistas->result();
		
		
		foreach($revistas as $revista) {
			$datos = new stdClass();
			$datos->id_revista = $revista->id_revista;
			$datos->tipo_solicitud = $revista->tipo_solicitud;
			$datos->nombre = $revista->nombre;
			$datos->estatus = $revista->estatus_solicitud;
			
			$rDatos = true;
			$rEjemplares = true;
			$rInstitucion = true;
			$rEditor = true;
			
			if(!$revista->formato || !$revista->acceso || !$revista->inicio_publicacion || !$revista->periodicidad || !$revista->area_conocimiento || !$revista->disciplina || !$revista->subdisciplina || !$revista->articulos_anio || !$revista->porcentaje_rechazados || !$revista->tiempo_recep_aprob || !$revista->factor_impacto || !$revista->issn_impreso) {
				$rDatos = false;
			}
			
			if($revista->tipo_solicitud != 3) {  // No se considera cuando es renovaci髇 autom醫ica
				$ejemplaresElectronicos = $this->reporte->leerEjemplaresElectronicos($revista->id_revista);
				if(!$ejemplaresElectronicos) {
					$rEjemplares = false;
				}
			}
			
			if(!$revista->institucion || !$revista->calle_numero || !$revista->colonia || !$revista->pais || !$revista->entidad || !$revista->ciudad || !$revista->codigo_postal) {
				$rInstitucion = false;
			}
			
			$editor = $this->reporte->leerEditor($revista->editor);
			if(!$editor || !$editor->grado_academico || !$editor->cargo || !$editor->telefono) {
				$rEditor = false;
			}
			
			if(!$rDatos && !$rEjemplares && !$rInstitucion && !$rEditor) {
				$datos->general = '<span class="glyphicon glyphicon-remove text-danger"></span>';
			}
			
			if(!$rDatos || !$rEjemplares || !$rInstitucion || !$rEditor) {
				$datos->general = '<span class="glyphicon glyphicon-exclamation-sign text-warning"></span>';
			}
			
			if($rDatos && $rEjemplares && $rInstitucion && $rEditor) {
				$datos->general = '<span class="glyphicon glyphicon-ok text-success"></span>';
			}
			
			if($revista->ruta_carta_postulacion) {
				$datos->carta_postulacion = '<span class="glyphicon glyphicon-ok text-success"></span>';
			} else {
				$datos->carta_postulacion = '<span class="glyphicon glyphicon-remove text-danger"></span>';
			}
			
			if(!$revista->ruta_comite_editorial && !$revista->ruta_actas_acuerdos && !$revista->url_func_resp_norm) {
				$datos->comite_editorial = '<span class="glyphicon glyphicon-remove text-danger"></span>';
			}
			
			if(!$revista->ruta_comite_editorial || !$revista->ruta_actas_acuerdos || !$revista->url_func_resp_norm) {
				$datos->comite_editorial = '<span class="glyphicon glyphicon-exclamation-sign text-warning"></span>';
			}
			
			if($revista->ruta_comite_editorial && $revista->ruta_actas_acuerdos && $revista->url_func_resp_norm) {
				$datos->comite_editorial = '<span class="glyphicon glyphicon-ok text-success"></span>';
			}
			
			if(!$revista->ruta_cartera_arbitros && !$revista->ruta_bitacora_arbitraje) {
				$datos->arbitraje = '<span class="glyphicon glyphicon-remove text-danger"></span>';
			}
			
			if(!$revista->ruta_cartera_arbitros || !$revista->ruta_bitacora_arbitraje) {
				$datos->arbitraje = '<span class="glyphicon glyphicon-exclamation-sign text-warning"></span>';
			}
			
			if($revista->ruta_cartera_arbitros && $revista->ruta_bitacora_arbitraje) {
				$datos->arbitraje = '<span class="glyphicon glyphicon-ok text-success"></span>';
			}
			
			$indices = $this->reporte->leerIndices($revista->id_solicitud);
			if($indices == 0) {
				$datos->indices = '<span class="glyphicon glyphicon-remove text-danger"></span>';
			} else if($indices == 1) {
				$datos->indices = '<span class="glyphicon glyphicon-exclamation-sign text-warning"></span>';
			} else {
				$datos->indices = '<span class="glyphicon glyphicon-ok text-success"></span>';
			}
			
			$distribuciones = $this->reporte->leerDistribuciones($revista->id_solicitud);
			$volumenes = $this->reporte->leerVolumenes($revista->id_solicitud);
			$volumenes = $volumenes->num_rows();
			$articulos = $this->reporte->leerArticulos($revista->id_solicitud);
			$articulos = $articulos->num_rows();
			$paises = $this->reporte->leerPaises($revista->id_solicitud);
			$paises = $paises->num_rows();
			
			if(!$distribuciones && $volumenes == 0 && $articulos == 0 && $paises == 0) {
				$datos->distribucion = '<span class="glyphicon glyphicon-remove text-danger"></span>';
			}
			
			if(!$distribuciones || $volumenes < 5 || $articulos < 5 || $paises < 5) {
				$datos->distribucion = '<span class="glyphicon glyphicon-exclamation-sign text-warning"></span>';
			}
			
			if($distribuciones && $volumenes >= 5 && $articulos >= 5 && $paises >= 5) {
				$datos->distribucion = '<span class="glyphicon glyphicon-ok text-success"></span>';
			}
			
			if(!$revista->ruta_manuscritos_rechazados && !$revista->ruta_manuscritos_aceptados && !$revista->ruta_formato_dictamen) {
				$datos->manuscritos = '<span class="glyphicon glyphicon-remove text-danger"></span>';
			}
			
			if(!$revista->ruta_manuscritos_rechazados || !$revista->ruta_manuscritos_aceptados || !$revista->ruta_formato_dictamen) {
				$datos->manuscritos = '<span class="glyphicon glyphicon-exclamation-sign text-warning"></span>';
			}
			
			if($revista->ruta_manuscritos_rechazados && $revista->ruta_manuscritos_aceptados && $revista->ruta_formato_dictamen) {
				$datos->manuscritos = '<span class="glyphicon glyphicon-ok text-success"></span>';
			}
			
			$anexos = $this->reporte->leerAnexos($revista->id_solicitud);
			if($anexos) {
				$datos->anexos = $anexos->num_rows();
			} else {
				$datos->anexos = "Sin anexos";
			}
			$data['datos'][] = $datos;
		}
		
		$this->load->view('header');
		$this->load->view('reportes/principal', $data);
		$this->load->view('footer');
	}
	
	public function detalle() {
		$id_revista = $this->uri->segment(3);
		settype($id_revista, "int");
		
		$data['revista'] = $this->reporte->consultarRevistaPorID($id_revista);
		$datos = $data['revista'];
		
		$aux = $this->reporte->consultarInformacionGeneral($id_revista);
		if($aux) {
			switch($aux->formato) {
				case 'i':
					$aux->formato = "Impresi贸n";
					break;
				case 'e':
					$aux->formato = "Electr贸nica";
					break;
				case 'ie':
					$aux->formato = "Impresi贸n y electr贸nica";
					break;
				default: break;
			}
		}
		$data['inf_revista'] = $aux;
		
		$data['editor'] = $this->reporte->leerEditor($datos->editor);
		$data['institucion'] = $this->reporte->consultarInstitucion($id_revista);
		
		$data['ejemplares'] = $this->reporte->leerEjemplaresElectronicos($datos->id_revista);
		
		$indices = $this->reporte->leerIndicesSolicitud($datos->id_solicitud);
		if($indices) {
			$indices = $indices->result();
			foreach($indices as &$val) {
				if($val->tipo == 'i') {
					$val->tipo = '脥ndice nacional o internacional';
				} else {
					$val->tipo = 'Servicio de abstract';
				}
			}
		}
		$data['indices'] = $indices;
		
		$data['distribuciones'] = $this->reporte->leerDistribuciones($datos->id_solicitud);
		$data['volumenes'] = $this->reporte->leerVolumenes($datos->id_solicitud);
		$data['articulos'] = $this->reporte->leerArticulos($datos->id_solicitud);
		$data['paises'] = $this->reporte->leerPaises($datos->id_solicitud);
		
		$mr = array();
		$ma = array();
		
		$manuscritos = $this->reporte->leerManuscritos($datos->id_solicitud);
		if($manuscritos) {
			$manuscritos = $manuscritos->result();
			
			foreach($manuscritos as $val) {
				if($val->tipo == 'r') {
					$manuscritos_rechazados = new stdClass();
					$manuscritos_rechazados->ruta = $val->ruta;
					$mr[] = $manuscritos_rechazados;
				} else if($val->tipo == 'a') {
					$manuscritos_aceptados = new stdClass();
					$manuscritos_aceptados->ruta = $val->ruta;
					$ma = $manuscritos_aceptados;
				}
			}
		}
		
		$data['manuscritos_rechazados'] = $mr;
		$data['manuscritos_aceptados'] = $ma; 
		
		$data['anexos'] = $this->reporte->leerAnexos($datos->id_solicitud);
		
		$this->load->view('header');
		$this->load->view('reportes/detalle', $data);
		$this->load->view('footer');
	}
}
?>