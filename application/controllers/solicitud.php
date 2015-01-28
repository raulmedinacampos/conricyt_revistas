<?php
class Solicitud extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('solicitud_model', 'solicitud', TRUE);
		
		if(!$this->session->userdata('perfil')) {
			redirect(base_url());
		}
	}
	
	public function index() {
		$this->load->helper('form');
		
		$id_solicitud = ($this->input->post('hdnListaSol')) ?  $this->input->post('hdnListaSol') : "";
		$nueva = ($this->input->post('hdn_nueva')) ?  $this->input->post('hdn_nueva') : "";
		
		$data['tipo_solicitud'] = $this->solicitud->leerTipoSolicitud();
		$data['area_conocimiento'] = $this->solicitud->leerAreaConocimiento();
		$data['paises'] = $this->solicitud->leerPaises();
		$data['grado_academico'] = $this->solicitud->leerGradoAcademico();
		$data['usuario'] = $this->solicitud->consultarUsuario($this->session->userdata('id_usr'));
		
		$solicitudes = $this->solicitud->consultarSolicitudPorUsuario($this->session->userdata('id_usr'));
		
		if(!$solicitudes || $nueva) {
			$data['solicitud'] = "";
			$data['revista'] = "";
			$data['editor'] = "";
			$data['ejemplares'] = "";
			$data['indices'] = "";
			$data['resumenes'] = "";
			$data['distribuciones'] = "";
			$data['volumenes'] = "";
			$data['articulos'] = "";
			$data['paises_dist'] = "";
			$data['mAceptados'] = "";
			$data['mRechazados'] = "";
			$data['anexos'] = "";
			
			$this->load->view('header');
			$this->load->view('solicitud/formulario', $data);
			$this->load->view('footer');
		} else if($solicitudes->num_rows() == 1 || $id_solicitud) {
			if($id_solicitud) {
				$datosSolicitud = $this->solicitud->consultarSolicitudPorID($id_solicitud);
				$data['solicitud'] = $datosSolicitud;
			} else {
				$datosSolicitud = $solicitudes->row();
				$data['solicitud'] = $this->solicitud->consultarSolicitudPorID($datosSolicitud->id_solicitud);
			}
			$revista = $this->solicitud->consultarRevistaPorSolicitud($datosSolicitud->revista);
			$data['revista'] = $revista;
			
			if($revista) {
				$data['editor'] = $this->solicitud->consultarEditorPorID($revista->editor);
				$data['ejemplares'] = $this->solicitud->consultarEjemplaresPorRevista($revista->id_revista);
			}
			
			$data['indices'] = $this->solicitud->consultarIndicesResumenesPorSolicitudTipo('i', $datosSolicitud->id_solicitud);
			$data['resumenes'] = $this->solicitud->consultarIndicesResumenesPorSolicitudTipo('r', $datosSolicitud->id_solicitud);
			$data['distribuciones'] = $this->solicitud->consultarDistribucionPorSolicitud($datosSolicitud->id_solicitud);
			$data['volumenes'] = $this->solicitud->consultarVolumenesPorSolicitud($datosSolicitud->id_solicitud);
			$data['articulos'] = $this->solicitud->consultarArticulosPorSolicitud($datosSolicitud->id_solicitud);
			$data['paises_dist'] = $this->solicitud->consultarPaisesPorSolicitud($datosSolicitud->id_solicitud);
			$data['mRechazados'] = $this->solicitud->consultarManuscritosRechazadosPorSolicitud($datosSolicitud->id_solicitud);
			$data['mAceptados'] = $this->solicitud->consultarManuscritosAceptadosPorSolicitud($datosSolicitud->id_solicitud);
			$data['anexos'] = $this->solicitud->consultarAnexosPorSolicitud($datosSolicitud->id_solicitud);
			
			$this->load->view('header');
			$this->load->view('solicitud/formulario', $data);
			$this->load->view('footer');
		} else {
			$data['registros'] = $this->solicitud->consultarRegistrosPorUsuario($this->session->userdata('id_usr'));
			
			$this->load->view('header');
			$this->load->view('solicitud/listadoSolicitudes', $data);
			$this->load->view('footer');
		}
	}
	
	public function mostrarError() {
		$this->load->view('header');
		$this->load->view('solicitud/error');
		$this->load->view('footer');
	}
	
	public function mostrarConfirmacion() {
		$this->load->view('header');
		$this->load->view('solicitud/confirmacion');
		$this->load->view('footer');
	}
	
	public function convocatoriaFinalizada() {
		$this->load->view('header');
		$this->load->view('solicitud/finalizada');
		$this->load->view('footer');
	}
	
	private function calcularFolio() {
		$ultimo = $this->solicitud->consultarUltimoFolio();
		$nuevo = "140001";
		
		if($ultimo) {
			$nuevo = substr($ultimo, 2);
			settype($nuevo, "integer");
			$nuevo++;
			
			$nuevo = str_pad($nuevo, 4, "0", STR_PAD_LEFT);
			$nuevo = "14".$nuevo;
		}
		
		return $nuevo;
	}
	
	public function revisarISSNRepetido() {
		$solicitud = addslashes(trim($this->input->post('solicitud')));
		$nombre = addslashes(trim($this->input->post('nombre')));
		$issn = addslashes(trim($this->input->post('issn')));
		$existe = "true";  // TRUE para aprobar la validación
		
		if($registros = $this->solicitud->validarRevista($nombre, $issn)) {		
			foreach($registros->result() as $val) {
				if($val->id_solicitud != $solicitud) {
					$existe = "false";
				}
			}
		}
		
		echo $existe;
	}
	
	private function cargarArchivo($usuario, $config, $archivo) {
		$this->load->library('upload');
		
		$config['overwrite'] = TRUE;
		$config['allowed_types'] = '*';
		$ruta_principal = './uploads/';
		$dir = $ruta_principal.$usuario;
		$config['upload_path'] = $dir;
		$nombre_archivo = "";
		$existe = false;
		
		if(!file_exists($dir)) {
			if(mkdir($dir, 0775)) {
				chmod($dir, 0775);
				$existe = true;
			}
		} else {
			$existe = true;
		}
		
		if($existe) {
			$this->upload->initialize($config);
			
			if($this->upload->do_upload($archivo)) {
				$archivo_cargado = $this->upload->data();
				$nombre_archivo = $config['file_name'];
				echo "Archivo cargado ";
			} else {
				echo "Ocurrió un error al cargar el archivo<br/>";
				print_r($this->upload->display_errors());
			}
		}
		
		return $nombre_archivo;
	}
	
	private function enviarCorreo($correo, $remitente, $asunto, $body) {
		$this->load->library('phpmailer');
			
		$this->phpmailer->IsSMTP();
		$this->phpmailer->SMTPDebug  = 0;
		$this->phpmailer->SMTPAuth   = true;					// activa autenticación
		$this->phpmailer->Host       = "smtp.gmail.com";		// servidor de correo
		//$this->phpmailer->Host       = "74.125.136.108";		// servidor de correo
		$this->phpmailer->Port       = 465;                    // puerto de salida que usa Gmail
		$this->phpmailer->SMTPSecure = 'ssl';					// protocolo de autenticación
		$this->phpmailer->Username   = "conricyt@gmail.com";
		$this->phpmailer->Password   = 'C0nR1c17p1x3l8lu3';
			
		$this->phpmailer->SetFrom('conricyt@gmail.com', 'CONRICyT');
		$this->phpmailer->AddBCC('montiveross@conacyt.mx', "Margarita Ontiveros");
		$this->phpmailer->AddReplyTo('no-replay@conacyt.mx', 'CONRICyT');
		$this->phpmailer->Subject    = utf8_encode($asunto);
		$this->phpmailer->AltBody    = utf8_encode($asunto);
			
		$this->phpmailer->MsgHTML($body);
			
		$this->phpmailer->AddAddress($correo, $remitente);
			
		$this->phpmailer->CharSet = 'UTF-8';
			
		if(!$this->phpmailer->Send()) {
			echo "Error al enviar correo: " . $this->phpmailer->ErrorInfo;
		} else {
			echo "Correo enviado";
		}
	}
	
	public function eliminarRegistro() {
		$id = $this->input->post('id');
		$seccion = $this->input->post('seccion');
		$columna = "";
		$tabla = "";
		
		$usuario = $this->solicitud->consultarUsuario($this->session->userdata('id_usr'));
		
		switch($seccion) {
			case "ejemplares":
				$columna = "id_ejemplar_electronico";
				$tabla = "ejemplar_electronico";
				break;
			case "indices":
				$columna = "id_indice_resumen";
				$tabla = "indice_resumen";
				break;
			case "distribuciones":
				$columna = "id_distribucion";
				$tabla = "distribucion_electronica";
				break;
			case "volumenes":
				$columna = "id_volumen";
				$tabla = "volumen_consultado";
				break;
			case "articulos":
				$columna = "id_articulo";
				$tabla = "articulo_descargado";
				break;
			case "paises":
				$columna = "id_pais";
				$tabla = "pais_consulta";
				break;
			case "manuscritos":
				$columna = "id_manuscrito";
				$tabla = "manuscrito";
				break;
			case "anexos":
				$columna = "id_anexo";
				$tabla = "anexo";
				break;
			default:
				break;
		}
		
		if($id && $tabla && $this->solicitud->eliminarRegistro($tabla, $columna, $id)) {
			if($tabla == 'manuscrito') {
				$manuscrito = $this->solicitud->consultarManuscritoPorID($id);
				
				@unlink('./uploads/'.$usuario->login.'/'.$manuscrito->ruta);
			}
			
			if($tabla == 'anexo') {
				$anexo = $this->solicitud->consultarAnexoPorID($id);
				
				@unlink('./uploads/'.$usuario->login.'/'.$anexo->ruta_anexo);
			}
			
			echo "Eliminando";
		} else {
			echo "No se pudo eliminar el registro";
		}
	}
	
	public function guardar() {
		if(date('Y-m-d') <= "2015-01-26") {
		
		$config['upload_path'] = './uploads/';
		$config['max_size']	= '10240';
		
		$this->load->library('cadena');
		$this->load->library('upload', $config);
		
		$id_solicitud = $this->input->post('hdn_solicitud');
		$id_revista = $this->input->post('hdn_revista');
		$id_editor = $this->input->post('hdn_editor');
		
		$solicitud['fecha_modificacion'] = date('Y-m-d H:i:s');
		
		$usuario = $this->solicitud->consultarUsuario($this->session->userdata('id_usr'));
		
		if($this->input->post('tipo_solicitud')) {
			$solicitud['tipo_solicitud'] = $this->input->post('tipo_solicitud');
		} else {
			$solicitud['tipo_solicitud'] = NULL;
		}
		
		// Datos de la revista
		$revista['formato'] = $this->input->post('formato_revista');
		$revista['nombre'] = addslashes(trim($this->input->post('nombre_revista')));
		$revista['inicio_publicacion'] = addslashes(trim($this->input->post('inicio_publicacion')));
		$revista['periodicidad'] = addslashes(trim($this->input->post('periodicidad')));
		
		if($this->input->post('area_conocimiento')) {
			$revista['area_conocimiento'] = $this->input->post('area_conocimiento');
		} else {
			$revista['area_conocimiento'] = NULL;
		}
		
		$revista['disciplina'] = addslashes(trim($this->input->post('disciplina_revista')));
		$revista['subdisciplina'] = addslashes(trim($this->input->post('subdisciplina_revista')));
		$revista['otro_tema'] = addslashes(trim($this->input->post('otro_tema')));
		$revista['articulos_anio'] = addslashes(trim($this->input->post('promedio_articulos')));
		$revista['porcentaje_rechazados'] = addslashes(trim($this->input->post('porcentaje_rechazados')));
		$revista['tiempo_recep_aprob'] = addslashes(trim($this->input->post('tiempo_promedio')));
		$revista['factor_impacto'] = addslashes(trim($this->input->post('factor_impacto')));
		$revista['issn_impreso'] = addslashes(trim($this->input->post('issn_impreso')));
		$revista['issn_electronico'] = addslashes(trim($this->input->post('issn_electronico')));
		
		if(isset($_FILES['carta_exencion']) && $_FILES['carta_exencion']['name']) {
			$solicitud['ruta_carta_exencion'] = Cadena::nombrarArchivos($_FILES['carta_exencion']['name']);
				
			$config['file_name'] = $solicitud['ruta_carta_exencion'];
			$config['allowed_types'] = 'pdf';
				
			$solicitud['ruta_carta_exencion'] = $this->cargarArchivo($usuario->login, $config, "carta_exencion");
		}
		
		$revista['institucion'] = addslashes(trim($this->input->post('institucion_revista')));
		$revista['calle_numero'] = addslashes(trim($this->input->post('calle_revista')));
		$revista['numero_interior'] = addslashes(trim($this->input->post('numero_int_revista')));
		$revista['colonia'] = addslashes(trim($this->input->post('colonia_revista')));
		
		if($this->input->post('pais_revista')) {
			$revista['pais'] = $this->input->post('pais_revista');
		} else {
			$revista['pais'] = NULL;
		}
		
		$revista['entidad'] = addslashes(trim($this->input->post('entidad_revista')));
		$revista['municipio'] = addslashes(trim($this->input->post('municipio_revista')));
		$revista['ciudad'] = addslashes(trim($this->input->post('ciudad_revista')));
		$revista['codigo_postal'] = addslashes(trim($this->input->post('cp_revista')));
		
		// Se crean los registros de revista y editor
		if(!$id_solicitud && !$id_revista && !$id_editor && $revista['nombre'] && $revista['issn_impreso']) {
			$editorExistente = $this->solicitud->consultarEditorPorCorreo($usuario->correo);
			
			if($editorExistente) {
				$id_editor = $editorExistente->id_editor;
			} else {
				$nuevo_editor['estatus'] = 1;
				$id_editor = $this->solicitud->crearRegistro("editor", $nuevo_editor);
			}
			
			$nueva_revista['editor'] = $id_editor;
			$id_revista = $this->solicitud->crearRegistro("revista", $nueva_revista);
			
			$nueva_solicitud['folio'] = $this->calcularFolio();
			$nueva_solicitud['convocatoria'] = 'R0001-2014-2015';
			$nueva_solicitud['fecha_solicitud'] = date('Y-m-d H:i:s');
			$nueva_solicitud['revista'] = $id_revista;
			$nueva_solicitud['usuario'] = $this->session->userdata('id_usr');
			
			$id_solicitud = $this->solicitud->crearRegistro("solicitud", $nueva_solicitud);
		}
		
		if($this->input->post('grado_editor')) {
			$editor['grado_academico'] = $this->input->post('grado_editor');
		} else {
			$editor['grado_academico'] = NULL;
		}
		
		$editor['cargo'] = addslashes(trim($this->input->post('cargo_editor')));
		$editor['nombre'] = addslashes(trim($this->input->post('nombre_editor')));
		$editor['ap_paterno'] = addslashes(trim($this->input->post('ap_paterno_editor')));
		$editor['ap_materno'] = addslashes(trim($this->input->post('ap_materno_editor')));
		$editor['correo'] = addslashes(trim($this->input->post('correo_editor')));
		$editor['telefono'] = addslashes(trim($this->input->post('telefono_editor')));
		
		if(isset($_FILES['carta_postulacion']) && $_FILES['carta_postulacion']['name']) {
			$solicitud['ruta_carta_postulacion'] = Cadena::nombrarArchivos($_FILES['carta_postulacion']['name']);
			
			$config['file_name'] = $solicitud['ruta_carta_postulacion'];
			$config['allowed_types'] = 'pdf';
			
			$solicitud['ruta_carta_postulacion'] = $this->cargarArchivo($usuario->login, $config, "carta_postulacion");
		}
		
		$solicitud['url_sistema_gestion'] = addslashes(trim($this->input->post('url_sistema_gestion')));
		$solicitud['usr_temporal'] = addslashes(trim($this->input->post('usr_temporal')));
		$solicitud['psw_temporal'] = addslashes(trim($this->input->post('psw_temporal')));
		
		$ejemplares['num'] = $this->input->post('num_dist_elect');
		$ejemplares['anio'] = $this->input->post('anio_dist_elect');
		$ejemplares['url'] = $this->input->post('url_dist_elect');
		
		$ej_electronico['revista'] = $id_revista;
		
		for($i=0; $i < sizeof($ejemplares['num']); $i++) {
			$aux_num = $ejemplares['num'];
			$aux_anio = $ejemplares['anio'];
			$aux_url = $ejemplares['url'];
			
			$ej_electronico['numero'] = addslashes(trim($aux_num[$i]));
			$ej_electronico['anio_distribucion'] = addslashes(trim($aux_anio[$i]));
			$ej_electronico['url'] = addslashes(trim($aux_url[$i]));
			
			if($ej_electronico['numero'] && $ej_electronico['anio_distribucion'] && $ej_electronico['url']) {
				$this->solicitud->insertarEjemplarElectronico($ej_electronico);
			} 
		}
		
		// Comite editorial
		if(isset($_FILES['comite']) && $_FILES['comite']['name']) {
			$solicitud['ruta_comite_editorial'] = Cadena::nombrarArchivos($_FILES['comite']['name']);
			
			$config['file_name'] = $solicitud['ruta_comite_editorial'];
			$config['allowed_types'] = 'xls|xlsx';
				
			$solicitud['ruta_comite_editorial'] = $this->cargarArchivo($usuario->login, $config, "comite");
		}
		
		if(isset($_FILES['actas_acuerdos']) && $_FILES['actas_acuerdos']['name']) {
			$solicitud['ruta_actas_acuerdos'] = Cadena::nombrarArchivos($_FILES['actas_acuerdos']['name']);
			
			$config['file_name'] = $solicitud['ruta_actas_acuerdos'];
			$config['allowed_types'] = 'xls|xlsx';
			
			$solicitud['ruta_actas_acuerdos'] = $this->cargarArchivo($usuario->login, $config, "actas_acuerdos");
		}
		
		$solicitud['url_func_resp_norm'] = addslashes(trim($this->input->post('url_funciones')));
		
		// Arbitraje
		if(isset($_FILES['arbitros']) && $_FILES['arbitros']['name']) {
			$solicitud['ruta_cartera_arbitros'] = Cadena::nombrarArchivos($_FILES['arbitros']['name']);
			
			$config['file_name'] = $solicitud['ruta_cartera_arbitros'];
			$config['allowed_types'] = 'xls|xlsx';
			
			$solicitud['ruta_cartera_arbitros'] = $this->cargarArchivo($usuario->login, $config, "arbitros");
		}
		
		if(isset($_FILES['bitacora']) && $_FILES['bitacora']['name']) {
			$solicitud['ruta_bitacora_arbitraje'] = Cadena::nombrarArchivos($_FILES['bitacora']['name']);
			
			$config['file_name'] = $solicitud['ruta_bitacora_arbitraje'];
			$config['allowed_types'] = 'xls|xlsx';
				
			$solicitud['ruta_bitacora_arbitraje'] = $this->cargarArchivo($usuario->login, $config, "bitacora");
		}
		
		// Indices y resumenes
		$indices['solicitud'] = $id_solicitud;
		
		$solicitud['url_presencia_bd'] = addslashes(trim($this->input->post('url_presencia_bd')));
		
		$indiceResumen['nombre'] = $this->input->post('nombre_indice');
		$indiceResumen['antiguedad'] = $this->input->post('antiguedad_indice');
		$indiceResumen['estatus'] = $this->input->post('estatus_indice');
		
		$indices['tipo'] = 'i';
		
		for($i=0; $i < sizeof($indiceResumen['nombre']); $i++) {
			$aux_nombre = $indiceResumen['nombre'];
			$aux_antiguedad = $indiceResumen['antiguedad'];
			$aux_estatus = $indiceResumen['estatus'];
				
			$indices['nombre'] = addslashes(trim($aux_nombre[$i]));
			$indices['antiguedad'] = addslashes(trim($aux_antiguedad[$i]));
			$indices['estatus'] = $aux_estatus[$i];
				
			if($indices['nombre'] && $indices['antiguedad'] && $indices['estatus']) {
				$this->solicitud->insertarIndiceResumen($indices);
			}
		}
		
		$indiceResumen['nombre'] = $this->input->post('nombre_abstract');
		$indiceResumen['antiguedad'] = $this->input->post('antiguedad_abstract');
		$indiceResumen['estatus'] = $this->input->post('estatus_abstract');
		
		$indices['tipo'] = 'r';
		
		for($i=0; $i < sizeof($indiceResumen['nombre']); $i++) {
			$aux_nombre = $indiceResumen['nombre'];
			$aux_antiguedad = $indiceResumen['antiguedad'];
			$aux_estatus = $indiceResumen['estatus'];
		
			$indices['nombre'] = addslashes(trim($aux_nombre[$i]));
			$indices['antiguedad'] = addslashes(trim($aux_antiguedad[$i]));
			$indices['estatus'] = $aux_estatus[$i];
		
			if($indices['nombre'] && $indices['antiguedad'] && $indices['estatus']) {
				$this->solicitud->insertarIndiceResumen($indices);
			}
		}
		
		// Distribucion electronica
		$revista['acceso'] = $this->input->post('acceso_revista');
		
		$dis_electronica['anio'] = $this->input->post('anio_distribucion');
		$dis_electronica['consecutivo'] = $this->input->post('numero_consecutivo');
		$dis_electronica['consultas_abstracts'] = $this->input->post('consultas_abs_distribucion');
		$dis_electronica['html'] = $this->input->post('html_distribucion');
		$dis_electronica['pdf'] = $this->input->post('pdf_distribucion');
		
		$distribuciones['solicitud'] = $id_solicitud;
		
		for($i=0; $i < sizeof($dis_electronica['anio']); $i++) {
			$aux_anio = $dis_electronica['anio'];
			$aux_consecutivo = $dis_electronica['consecutivo'];
			$aux_abstracts = $dis_electronica['consultas_abstracts'];
			$aux_html = $dis_electronica['html'];
			$aux_pdf = $dis_electronica['pdf'];
		
			$distribuciones['anio'] = addslashes(trim($aux_anio[$i]));
			$distribuciones['consecutivo'] = addslashes(trim($aux_consecutivo[$i]));
			$distribuciones['abstracts'] = addslashes(trim($aux_abstracts[$i]));
			$distribuciones['html'] = addslashes(trim($aux_html[$i]));
			$distribuciones['pdf'] = addslashes(trim($aux_pdf[$i]));
		
			if($distribuciones['anio'] && $distribuciones['consecutivo']) {
				$this->solicitud->insertarDistribucionElectronica($distribuciones);
			}
		}
		
		$vol_cons['anio'] = $this->input->post('anio_volumen');
		$vol_cons['vol_articulo'] = $this->input->post('articulo_volumen');
		$vol_cons['consultas_abstracts'] = $this->input->post('consultas_volumen');
		$vol_cons['texto_completo'] = $this->input->post('texto_volumen');
		
		$volumenes['solicitud'] = $id_solicitud;
		
		for($i=0; $i < sizeof($vol_cons['anio']); $i++) {
			$aux_anio = $vol_cons['anio'];
			$aux_vol_articulo = $vol_cons['vol_articulo'];
			$aux_abstracts = $vol_cons['consultas_abstracts'];
			$aux_texto_completo = $vol_cons['texto_completo'];
		
			$volumenes['anio'] = addslashes(trim($aux_anio[$i]));
			$volumenes['volumen'] = addslashes(trim($aux_vol_articulo[$i]));
			$volumenes['abstracts'] = addslashes(trim($aux_abstracts[$i]));
			$volumenes['texto_completo'] = addslashes(trim($aux_texto_completo[$i]));
		
			if($volumenes['anio'] && $volumenes['volumen']) {
				$this->solicitud->insertarVolumenConsultado($volumenes);
			}
		}
		
		$art_desc['anio'] = $this->input->post('anio_articulo');
		$art_desc['vol_articulo'] = $this->input->post('articulo_articulo');
		$art_desc['titulo'] = $this->input->post('titulo_articulo');
		$art_desc['autor'] = $this->input->post('autor_articulo');
		
		$articulos['solicitud'] = $id_solicitud;
		
		for($i=0; $i < sizeof($art_desc['anio']); $i++) {
			$aux_anio = $art_desc['anio'];
			$aux_vol_articulo = $art_desc['vol_articulo'];
			$aux_titulo = $art_desc['titulo'];
			$aux_autor = $art_desc['autor'];
		
			$articulos['anio'] = addslashes(trim($aux_anio[$i]));
			$articulos['volumen'] = addslashes(trim($aux_vol_articulo[$i]));
			$articulos['titulo'] = addslashes(trim($aux_titulo[$i]));
			$articulos['autor'] = addslashes(trim($aux_autor[$i]));
		
			if($articulos['anio'] && $articulos['volumen']) {
				$this->solicitud->insertarArticuloDescargado($articulos);
			}
		}
		
		$pais_cons['anio'] = $this->input->post('anio_pais');
		$pais_cons['nombre'] = $this->input->post('nombre_pais');
		$pais_cons['consultas'] = $this->input->post('consultas_pais');
		$pais_cons['texto_completo'] = $this->input->post('texto_pais');
		
		$paises['solicitud'] = $id_solicitud;
		
		for($i=0; $i < sizeof($pais_cons['anio']); $i++) {
			$aux_anio = $pais_cons['anio'];
			$aux_nombre = $pais_cons['nombre'];
			$aux_consultas = $pais_cons['consultas'];
			$aux_texto_completo = $pais_cons['texto_completo'];
		
			$paises['anio'] = addslashes(trim($aux_anio[$i]));
			$paises['pais'] = addslashes(trim($aux_nombre[$i]));
			$paises['consultas'] = addslashes(trim($aux_consultas[$i]));
			$paises['texto_completo'] = addslashes(trim($aux_texto_completo[$i]));
		
			if($paises['anio'] && $paises['pais']) {
				$this->solicitud->insertarPaisConsulta($paises);
			}
		}
		
		// Manuscritos recibidos
		if(isset($_FILES['manuscritos_condicionados']) && $_FILES['manuscritos_condicionados']['name']) {
			$solicitud['ruta_manuscritos_rechazados'] = Cadena::nombrarArchivos($_FILES['manuscritos_condicionados']['name']);
			
			$config['file_name'] = $solicitud['ruta_manuscritos_rechazados'];
			$config['allowed_types'] = 'pdf';
			
			$solicitud['ruta_manuscritos_rechazados'] = $this->cargarArchivo($usuario->login, $config, "manuscritos_condicionados");
		}
		
		if(isset($_FILES['manuscritos_aceptados']) && $_FILES['manuscritos_aceptados']['name']) {
			$solicitud['ruta_manuscritos_aceptados'] = Cadena::nombrarArchivos($_FILES['manuscritos_aceptados']['name']);
			
			$config['file_name'] = $solicitud['ruta_manuscritos_aceptados'];
			$config['allowed_types'] = 'xls|xlsx';
				
			$solicitud['ruta_manuscritos_aceptados'] = $this->cargarArchivo($usuario->login, $config, "manuscritos_aceptados");
		}
		
		if(isset($_FILES['dictamen']) && $_FILES['dictamen']['name']) {
			$solicitud['ruta_formato_dictamen'] = Cadena::nombrarArchivos($_FILES['dictamen']['name']);
			
			$config['file_name'] = $solicitud['ruta_formato_dictamen'];
			$config['allowed_types'] = 'pdf';
				
			$solicitud['ruta_formato_dictamen'] = $this->cargarArchivo($usuario->login, $config, "dictamen");
		}
		
		// Archivos múltiples de manuscritos rechazados
		$archivo_manuscrito['archivo'] = $_FILES['mRechazado'];
		
		$manuscritos['solicitud'] = $id_solicitud;
		
		for($i=0; $i < sizeof($archivo_manuscrito['archivo']['name']); $i++) {
			$aux_archivo = $archivo_manuscrito['archivo']['name'];
				
			$manuscritos['ruta'] = Cadena::nombrarArchivos($aux_archivo[$i]);
			$manuscritos['tipo'] = 'r';
				
			if($manuscritos['ruta']) {
				$_FILES['manuscrito_aux']['name'] = $archivo_manuscrito['archivo']['name'][$i];
				$_FILES['manuscrito_aux']['type'] = $archivo_manuscrito['archivo']['type'][$i];
				$_FILES['manuscrito_aux']['tmp_name'] = $archivo_manuscrito['archivo']['tmp_name'][$i];
				$_FILES['manuscrito_aux']['error'] = $archivo_manuscrito['archivo']['error'][$i];
				$_FILES['manuscrito_aux']['size'] = $archivo_manuscrito['archivo']['size'][$i];
		
				$config['file_name'] = $_FILES['manuscrito_aux']['name'];
				$config['allowed_types'] = 'xls|xlsx';
		
				$manuscritos['ruta'] = $this->cargarArchivo($usuario->login, $config, "manuscrito_aux");
		
				$this->solicitud->insertarManuscrito($manuscritos);
			}
		}
		
		// Archivos múltiples de manuscritos aceptados
		$archivo_manuscrito['archivo'] = $_FILES['mAceptado'];
		
		$manuscritos['solicitud'] = $id_solicitud;
		
		for($i=0; $i < sizeof($archivo_manuscrito['archivo']['name']); $i++) {
			$aux_archivo = $archivo_manuscrito['archivo']['name'];
		
			$manuscritos['ruta'] = Cadena::nombrarArchivos($aux_archivo[$i]);
			$manuscritos['tipo'] = 'a';
		
			if($manuscritos['ruta']) {
				$_FILES['manuscrito_aux']['name'] = $archivo_manuscrito['archivo']['name'][$i];
				$_FILES['manuscrito_aux']['type'] = $archivo_manuscrito['archivo']['type'][$i];
				$_FILES['manuscrito_aux']['tmp_name'] = $archivo_manuscrito['archivo']['tmp_name'][$i];
				$_FILES['manuscrito_aux']['error'] = $archivo_manuscrito['archivo']['error'][$i];
				$_FILES['manuscrito_aux']['size'] = $archivo_manuscrito['archivo']['size'][$i];
		
				$config['file_name'] = $_FILES['manuscrito_aux']['name'];
				$config['allowed_types'] = 'xls|xlsx|pdf';
		
				$manuscritos['ruta'] = $this->cargarArchivo($usuario->login, $config, "manuscrito_aux");
		
				$this->solicitud->insertarManuscrito($manuscritos);
			}
		}
		
		// Anexos de revistas
		$archivo_anexo['descripcion'] = $this->input->post('descripcion_anexo');
		$archivo_anexo['archivo'] = $_FILES['archivo_anexo'];
		
		$anexos['solicitud'] = $id_solicitud;
		
		for($i=0; $i < sizeof($archivo_anexo['descripcion']); $i++) {
			$aux_descripcion = $archivo_anexo['descripcion'];
			$aux_archivo = $archivo_anexo['archivo']['name'];
			
			$anexos['descripcion'] = addslashes(trim($aux_descripcion[$i]));
			$anexos['ruta_anexo'] = Cadena::nombrarArchivos($aux_archivo[$i]);
			
			//print_r($archivo_anexo['archivo']).'<br />';
		
			if($anexos['descripcion'] && $anexos['ruta_anexo']) {
				$_FILES['anexo_aux']['name'] = $archivo_anexo['archivo']['name'][$i];
				$_FILES['anexo_aux']['type'] = $archivo_anexo['archivo']['type'][$i];
				$_FILES['anexo_aux']['tmp_name'] = $archivo_anexo['archivo']['tmp_name'][$i];
				$_FILES['anexo_aux']['error'] = $archivo_anexo['archivo']['error'][$i];
				$_FILES['anexo_aux']['size'] = $archivo_anexo['archivo']['size'][$i];
				
				$config['file_name'] = $_FILES['anexo_aux']['name'];
				$config['allowed_types'] = 'xls|xlsx|pdf';
				
				$anexos['ruta_anexo'] = $this->cargarArchivo($usuario->login, $config, "anexo_aux");
				
				$this->solicitud->insertarAnexo($anexos);
			}
		}
		
		// Disposición para reunirse con el comité
		$solicitud['disposicion'] = ($this->input->post('rdb_reunion')) ? $this->input->post('rdb_reunion') : 0;
		
		// Se ejecutan las actualizaciones en la base
		$this->solicitud->actualizarSolicitud($id_solicitud, $solicitud);
		
		$this->solicitud->actualizarRevista($id_revista, $revista);
		
		$this->solicitud->actualizarEditor($id_editor, $editor);
		} else {
			redirect(base_url('solicitud/convocatoriaFinalizada'));
		}
	}
	
	public function guardarCambios() {
		$this->guardar();
		
		$this->session->set_flashdata('tab', $this->input->post('hdn_tab'));
		redirect(base_url('solicitud'));
	}
	
	public function finalizarSolicitud() {
		if(date('Y-m-d') <= "2015-01-26") {
			$id_solicitud = $this->input->post('hdn_solicitud');
			
			$this->guardar();
			
			if($this->solicitud->cambiarEstatus($id_solicitud, 5)) {
				$sol = $this->solicitud->consultarSolicitudPorID($id_solicitud);
				$fecha_fin = date('Y-m-d H:i:s');
				$mes = array('', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
				$fecha = date('j').' de '.$mes[date('n')] . ' de '.date('Y');
				$nombre = trim($this->input->post('nombre_editor'));
				$ap_paterno = trim($this->input->post('ap_paterno_editor'));
				$ap_materno = trim($this->input->post('ap_materno_editor'));
				$correo = trim($this->input->post('correo_editor'));
				$editor = trim($nombre." ".$ap_paterno." ".$ap_materno);
				$asunto = utf8_decode("Solicitud al Índice de Revistas finalizada");
				$body = '<table width="100%" border="1" cellspacing="0" cellpadding="10" border="0" bordercolor="#FFFFFF">';
				$body .= '<tr><td bgcolor="#005199" align="center"><font size="4" face="Arial" color="#e0e0e0">';
				$body .= '<strong>Solicitud al &Iacute;ndice de Revistas finalizada</strong>';
				$body .= '</font></td></tr></table>';
				$body .= '<p><font size="3" face="Arial" color="#006699"><strong>Apreciable '.$editor.':</strong></font></p>';
				$body .= '<p><font size="3" face="Arial" color="#006699">Su solicitud número <strong>'.$sol->folio.'</strong> que ingreso bajo la Convocatoria del ';
				$body .= '&Iacute;ndice de Revistas Mexicanas de Investigaci&oacute;n Cient&iacute;fica y Tecnol&oacute;gica 2014-2015, ha sido finalizada exitosamente ';
				$body .= 'el d&iacute;a '.$fecha.' a las '.date('H:i').' horas, le recuerdo que la publicaci&oacute;n de resultados ser&aacute; ';
				$body .= 'hasta el 13 de marzo del 2015.</font></p>';
				$body .= '<p><font size="3" face="Arial" color="#FF0000">En caso de alguna duda, por favor comun&iacute;cate con al tel&eacute;fono (55) 5322 7700 ext. 4022 o escribe a la cuenta montiveross@conacyt.mx</font></p>';
				$body .= '<table width="100%" border="1" cellspacing="0" cellpadding="10" border="0" bordercolor="#FFFFFF"><tr><td bgcolor="#e0e0e0" align="center"><font size="3" face="Arial" color="#005199"><strong>Consejo Nacional de Ciencia y Tecnolog&iacute;a (CONACYT)</strong></font></td></tr></table>';
				$this->solicitud->cambiarFechaFinalizacion($id_solicitud, $fecha_fin);
				$this->session->set_flashdata('nombre', $editor);
				$this->session->set_flashdata('folio', $sol->folio);
				$this->session->set_flashdata('fecha', $fecha);
				$this->session->set_flashdata('hora', date('H:i'));
				$this->enviarCorreo($correo, $editor, $asunto, $body);
				redirect(base_url('solicitud/mostrarConfirmacion'));
			} else {
				redirect(base_url('solicitud/mostrarError'));
			}
		} else {
			redirect(base_url('solicitud/convocatoriaFinalizada'));
		}
	}
}
?>