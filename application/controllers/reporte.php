<?php
class Reporte extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('reporte_model', 'reporte', TRUE);
	}
	
	public function index() {
		$data['totalUsuarios'] = $this->reporte->obtenerTotalUsuarios();
		$data['totalRevistas'] = $this->reporte->obtenerTotalRevistas();
		$data['totalFinalizados'] = $this->reporte->obtenerTotalFinalizados();
		$data['totalPendientes'] = $this->reporte->obtenerTotalPendientes();
		$data['datos'] = array();
		
		$revistas = $this->reporte->leerRevistas();
		$revistas = $revistas->result();
		
		
		foreach($revistas as $revista) {
			$datos = new stdClass();
			$datos->id_revista = $revista->id_revista;
			$datos->tipo_solicitud = $revista->tipo_solicitud;
			$datos->nombre = $revista->nombre;
			$datos->estatus = $revista->estatus_solicitud;
			$datos->carta_postulacion = "N/A";
			$datos->comite_editorial = "N/A";
			$datos->arbitraje = "N/A";
			$datos->indices = "N/A";
			$datos->distribucion = "N/A";
			$datos->manuscritos = "N/A";
			
			$rDatos = true;
			$rEjemplares = true;
			$rInstitucion = true;
			$rEditor = true;
			
			if(!$revista->formato || !$revista->inicio_publicacion || !$revista->periodicidad || !$revista->area_conocimiento || !$revista->disciplina || !$revista->subdisciplina || !$revista->articulos_anio || !$revista->porcentaje_rechazados || !$revista->tiempo_recep_aprob || !$revista->factor_impacto || !$revista->issn_impreso) {
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
			
			if($revista->tipo_solicitud != 3) {
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
				$manuscritos = $this->reporte->leerManuscritos($revista->id_solicitud);
				
				if(!$distribuciones && $volumenes == 0 && $articulos == 0 && $paises == 0) {
					$datos->distribucion = '<span class="glyphicon glyphicon-remove text-danger"></span>';
				}
				
				if(!$distribuciones || $volumenes < 3 || $articulos < 3 || $paises < 3) {
					$datos->distribucion = '<span class="glyphicon glyphicon-exclamation-sign text-warning"></span>';
				}
				
				if($distribuciones && $volumenes >= 3 && $articulos >= 3 && $paises >= 3) {
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
		
		$indices_arr = array();
		
		$indices = $this->reporte->leerIndicesSolicitud($datos->id_solicitud);
		if($indices) {
			$indices = $indices->result();
			
			foreach($indices as $val) {
				$indice_aux = new stdClass();
				$indice_aux->nombre = $val->nombre;
				$indice_aux->antiguedad = $val->antiguedad;
				$indice_aux->tipo = $val->tipo;
				if($val->tipo == 'i') {
					$indice_aux->tipo = '脥ndice nacional o internacional';
				} else {
					$indice_aux->tipo = 'Servicio de abstract';
				}
				$indices_arr[] = $indice_aux;
			}
		}
		$data['indices'] = $indices_arr;
		
		$data['distribuciones'] = $this->reporte->leerDistribuciones($datos->id_solicitud);
		$data['volumenes'] = $this->reporte->leerVolumenes($datos->id_solicitud);
		$data['articulos'] = $this->reporte->leerArticulos($datos->id_solicitud);
		$data['paises'] = $this->reporte->leerPaises($datos->id_solicitud);
		
		$mr = array();
		$ma = array();
		
		$manuscritos = $this->reporte->leerManuscritosSolicitud($datos->id_solicitud);
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
					$ma[] = $manuscritos_aceptados;
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
	
	public function por_tipo_solicitud() {
		$data['tipos_solicitudes'] = $this->reporte->leerTipoSolicitud();
		$data['revistas'] = $this->reporte->leerRevistas(5);
		
		$this->load->view('header');
		$this->load->view('reportes/tipo_solicitud', $data);
		$this->load->view('footer');
	}
	
	public function por_institucion() {
		$data['revistas'] = $this->reporte->leerRevistasInstitucion(5);
	
		$this->load->view('header');
		$this->load->view('reportes/instituciones', $data);
		$this->load->view('footer');
	}
	
	public function por_area() {
		$data['areas'] = $this->reporte->leerAreas();
		$data['revistas'] = $this->reporte->leerRevistas(5);
	
		$this->load->view('header');
		$this->load->view('reportes/areas', $data);
		$this->load->view('footer');
	}
	
	public function dictamen() {
		$dictamenes = $this->reporte->consultarDictamenes();
		$dictamenes = $dictamenes->result();
		
		$xls = addslashes($this->uri->segment(3));
		
		if($xls) {
			$this->load->library('excel');
			$fila = 1;
		
			// Contenido de las celdas
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setSize(18);
			$this->excel->getActiveSheet()->setCellValue('A'.$fila, utf8_encode('Dict醡enes de la revistas'));
			$fila+=2;
		
			// Encabezados
			$this->excel->getActiveSheet()->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.$fila.':F'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
			$this->excel->getActiveSheet()->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('5B9BD5');
			$this->excel->getActiveSheet()->getStyle('A'.$fila.':F'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
			$this->excel->getActiveSheet()
			->setCellValue('A'.$fila, utf8_encode('Nombre de la revista'))
			->setCellValue('B'.$fila, utf8_encode('羠ea de conocimiento'))
			->setCellValue('C'.$fila, utf8_encode('Tipo de solicitud'))
			->setCellValue('D'.$fila, utf8_encode('Instituci髇'))
			->setCellValue('E'.$fila, utf8_encode('Dictamen'))
			->setCellValue('F'.$fila, utf8_encode('Comentarios'));
			$fila++;
				
			// Datos
			for($i=0; $i<sizeof($dictamenes); $i++) {
				$row = $dictamenes[$i];
				$this->excel->getActiveSheet()
				->setCellValue('A'.$fila, $row->nombre)
				->setCellValue('B'.$fila, $row->area_conocimiento)
				->setCellValue('C'.$fila, $row->tipo_solicitud)
				->setCellValue('D'.$fila, $row->institucion)
				->setCellValue('E'.$fila, $row->dictamen)
				->setCellValue('F'.$fila, $row->comentarios);
					
				$setColor = ($fila > 1 && $fila % 2 == 1) ? true : false;
					
				if($setColor) {
					$this->excel->getActiveSheet()->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DEE1E2');
				}
					
				$fila++;
			}
		
			// Ancho de las columnas
			$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		
			// Nombre de la hoja
			$this->excel->getActiveSheet()->setTitle(utf8_encode('Dict醡enes'));
		
			// Headers para salida de archivo xlsx
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Dictamenes.xlsx"');
			header('Cache-Control: max-age=0');
			// Header para IE9
			header('Cache-Control: max-age=1');
		
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
			$objWriter->save("php://output");
			exit();
		}
		
		$data['dictamenes'] = $this->reporte->consultarDictamenes();
		
		$this->load->view('header');
		$this->load->view('reportes/dictamenes', $data);
		$this->load->view('footer');
	}
}
?>