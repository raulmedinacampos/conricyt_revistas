<?php
class Representante_comite extends CI_Controller {
	function __construct() {
		parent::__construct();
		error_reporting(0);
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
		//$data['revistas'] = $this->evaluador->consultarRevistasPorEvaluador($evaluador);
		
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
				
				/*if($revista->estatus == 1) {
					$dato->estatus = "En proceso";
				} else if($revista->estatus == 5) {
					$dato->estatus = "Finalizada";
				}*/
				
				foreach($evaluadores->result() as $ev) {
					$asignacion = $this->representante->verificarEvaluacionAsignada($ev->id_usuario, $revista->id_revista);
					$calificacion = $this->representante->consultarCalificacionPorUsuarioSolicitud($ev->id_usuario, $revista->id_solicitud);
					$estatus = $this->representante->consultarEstatusPorUsuarioSolicitud($ev->id_usuario, $revista->id_solicitud);
					$evaluacion = $this->representante->consultarEvaluacionPorSolicitudUsuario($revista->id_solicitud, $ev->id_usuario);
					
					$dato->estatus = "Pendiente";
					
					if($estatus == 1) {
					$dato->estatus = "En proceso";
					} else if($estatus == 5) {
					$dato->estatus = "Finalizada";
					}
					
					//print_r($evaluacion);
					//print_r($evaluacion);
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
	
	public function evaluacion() {
		$this->load->model('evaluador_model', 'evaluador', TRUE);
		
		$areas = "";
		$evaluador = $this->session->userdata['id_usr'];
		$area = $this->evaluador->consultarAreaPorUsuario($evaluador);
		$grupo1 = array(1,2,3,6,7,8);
		$grupo2 = array(4,5,8);
		
		if(in_array($area, $grupo1)) {
			$areas = "1,2,3,6,7,8";
		} else if(in_array($area, $grupo2)) {
			$areas = "4,5,8";
		} else {
			$areas = "1,2,3,4,5,6,7,8";
		}
		
		$data['areas'] = $this->representante->consultarAreasPorGrupo($areas);
		$data['revistas'] = $this->representante->consultarRevistasPorGrupo($areas);
		$data['evaluaciones'] = $this->representante->consultarEvaluacionesPorGrupo($areas);
		
		$header['area'] = $area;
		
		$this->load->view('header', $header);
		$this->load->view('evaluacion/evaluacion', $data);
		$this->load->view('footer');
	}
	
	public function dictamen() {
		$this->load->helper('form');
		$this->load->model('evaluador_model', 'evaluador', TRUE);
		
		$id_solicitud = $this->uri->segment(3);
		settype($id_solicitud, "int");
		
		$evaluador = $this->session->userdata['id_usr'];
		$promedio = 0;
		$evaluaciones = $this->representante->consultarEvaluacionPorSolicitud($id_solicitud);
		
		foreach($evaluaciones->result() as $val) {
			$promedio += $val->calificacion;
		}
		
		$promedio = $promedio / $evaluaciones->num_rows();
		
		$header['area'] = $this->evaluador->consultarAreaPorUsuario($evaluador);
		
		$data['evaluador'] = $evaluador;
		$data['solicitud'] = $id_solicitud;
		$data['revista'] = $this->representante->consultarRevistaPorSolicitud($id_solicitud);
		$data['tipos_dictamen'] = $this->representante->leerOpcionesDictamen();
		$data['evaluaciones'] = $evaluaciones;
		$data['promedio'] = $promedio;
		$data['dictamen'] = $this->representante->consultarDictamenPorSolicitudUsuario($id_solicitud, $evaluador);
		
		$this->load->view('header', $header);
		$this->load->view('evaluacion/dictamen', $data);
		$this->load->view('footer');
	}
	
	public function guardarDictamen() {
		$data['solicitud'] = $this->input->post('hdnSolicitud');
		$data['dictamen'] = $this->input->post('dictamen');
		$data['comentarios'] = $this->input->post('comentarios');
		$data['usuario'] = $this->input->post('hdnEvaluador');
		
		if($this->representante->guardarDictamen($data)) {
			redirect(base_url('representante-comite/dictamen/'.$data['solicitud']));
		}
	}
	
	public function generarComprobante() {
		$this->load->library('pdf');
		$this->load->library('Fecha');
		$pdf = $this->pdf->load("c", "Letter", "", "", 20, 20, 45, 30, 10, 10);
		
		$id_solicitud = $this->input->post('hdnSolicitud2');
		
		if(!$id_solicitud) {
			redirect(base_url('representante-comite/evaluacion'));
		}
		
		$areas = "";
		$calificacion = 0;
		$evaluaciones = $this->representante->consultarEvaluacionPorSolicitud($id_solicitud);
		$revista = $this->representante->consultarRevistaPorSolicitud($id_solicitud);
		$dictamen = $this->representante->consultarDictamenPorSolicitudUsuario($id_solicitud, $this->session->userdata['id_usr']);
		$grupo1 = array(1,2,3,6,7,8);
		$grupo2 = array(4,5,8);
		
		if(in_array($revista->area, $grupo1)) {
			echo "Es del grupo 1";
			$areas = "1,2,3,6,7,8";
		} else if (in_array($revista->area, $grupo2)) {
			echo "Es del grupo 2";
			$areas = "4,5,8";
		} else {
			$areas = "1,2,3,4,5,6,7,8";
		}
		
		foreach($evaluaciones->result() as $evaluacion) {
			$calificacion += $evaluacion->calificacion;
		}
		
		$calificacion = $calificacion / $evaluaciones->num_rows();
		
		$evaluadores = $this->representante->consultarRepresentantesPorArea($areas);
		
		$header = '<p class="header"><img id="logo-mexico" src="'.base_url('images/mexico_comprobante.png').'" /><img id="logo-conacyt" src="'.base_url('images/conacyt_comprobante.gif').'" /><div style="clear:both;"></div></p>';
		$footer = '<p class="paginacion">Página {PAGENO} de {nb}</p>';
		$footer .= '<p class="footer">Av. Insurgentes Sur 1582, Col. Crédito Constructor, Del. Benito Juárez, C.P. 03940, México Distrito Federal<br/>Tel: (55) 5322-7700 &nbsp; <strong>www.conacyt.gob.mx</strong></p>';
				
		$html = '';
		
		$html .= '<div class="contenido">';
		$html .= '<p class="titulo1">DIRECCIÓN ADJUNTA DE DESARROLLO CIENTÍFICO</p>';
		$html .= '<p class="titulo2">Dirección de Planeación de Ciencia</p>';
		$html .= '<p class="fecha">'.Fecha::MostrarFormatoLargo(date('Y-m-d')).'</p>';
		
		$html .= '<p class="titulo3">Índices de Revistas Mexicanas de Investigación Científica y Tecnológica<br/>';
		$html .= 'Convocatoria 2014 - 2015</p>';
		
		$html .= '<p class="titulo4">ACTA DE DICTAMEN</p>';
		
		$html .= '<table id="datos">';
		$html .= '<tr>';
		$html .= '<td>Número de solicitud:</td>';
		$html .= '<td><strong>'.$revista->folio.'</strong></td>';
		$html .= '<td>Nombre de la revista:</td>';
		$html .= '<td><strong>'.utf8_decode($revista->nombre).'</strong></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Institución editora:</td>';
		$html .= '<td><strong>'.utf8_decode($revista->institucion).'</strong></td>';
		$html .= '<td>Área:</td>';
		$html .= '<td><strong>'.utf8_decode($revista->area_conocimiento).'</strong></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Tipo de solicitud:</td>';
		$html .= '<td><strong>'.utf8_decode($revista->tipo_solicitud).'</strong></td>';
		$html .= '<td>Puntaje total obtenido de la evaluación:</td>';
		$html .= '<td><strong>'.number_format($calificacion, 2).'</strong></td>';
		$html .= '</tr>';
		$html .= '</table>';
		
		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td>Dictamen:</td>';
		$html .= '<td>Aprobada (5 años) <input type="radio" '.(($dictamen->id_dictamen == 1) ? 'checked="checked"' : '').' /></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td></td>';
		$html .= '<td>Aprobada condicionada (2 años) <input type="radio" '.(($dictamen->id_dictamen == 2) ? 'checked="checked"' : '').' /></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td></td>';
		$html .= '<td>No aprobada <input type="radio" '.(($dictamen->id_dictamen == 3) ? 'checked="checked"' : '').' /></td>';
		$html .= '</tr>';
		$html .= '</table>';
		
		$html .= 'Comentarios, observaciones y sugerencias para ser considerados por el Editor de la revista.';
		$html .= '<div class="comentarios">'.utf8_decode($dictamen->comentarios).'</div>';
		
		$i = 1;
		foreach($evaluadores->result() as $evaluador) {
			$clase = "firma";
			($i%2 == 1) ? $clase.="1" : $clase.="2";
			
			if($i%2 == 1 && $i == $evaluadores->num_rows()) {
				$clase ="firma-ultimo";
			}
			
			$html .= '<div class="'.$clase.'">';
			$html .= '________________________________________';
			$html .= '<br />';
			$html .= trim(utf8_decode($evaluador->nombre." ".$evaluador->ap_paterno." ".$evaluador->ap_materno));
			$html .= '</div>';
			$i++;
		}
		
		$html .= '</div>';  // Div contenido
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, base_url('css/comprobante.css'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$stylesheet = curl_exec($ch);
		curl_close($ch);
		
		$pdf->SetHTMLHeader(utf8_encode($header));
		$pdf->SetHTMLFooter(utf8_encode($footer));
		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML(utf8_encode($html));
		$pdf->Output('comprobante.pdf', 'D');
	}
}
?>