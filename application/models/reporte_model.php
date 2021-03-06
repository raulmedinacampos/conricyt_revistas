<?php
class Reporte_model extends CI_Model {
	public function obtenerTotalUsuarios() {
		$this->db->select('id_usuario');
		$this->db->from('usuario');
		$this->db->where('estatus', 1);
		$this->db->where('tipo_usuario', 3);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function obtenerTotalRevistas() {
		$this->db->select('r.id_revista');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->where('r.estatus', 1);
		$this->db->where('s.estatus >', 0);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function obtenerTotalFinalizados() {
		$this->db->select('s.id_solicitud');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->where('s.estatus', 5);
		$this->db->where('r.estatus', 1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function obtenerTotalPendientes() {
		$this->db->select('s.id_solicitud');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->where('s.estatus', 1);
		$this->db->where('r.estatus', 1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function leerRevistas($estatus = false) {
		$this->db->select("*, s.estatus AS estatus_solicitud");
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->where('r.estatus', 1);
		
		if($estatus === false) {
			$this->db->where('s.estatus >', 0);
		} else {
			$this->db->where('s.estatus', $estatus);
		}
		
		$this->db->order_by('r.nombre');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerTipoSolicitud() {
		$this->db->select('id_tipo_solicitud, tipo_solicitud');
		$this->db->from('cat_tipo_solicitud');
		$this->db->where('estatus', 1);
		$this->db->order_by('tipo_solicitud', 'DESC');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerRevistasInstitucion() {
		$this->db->select('r.nombre, r.institucion');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->where('r.estatus', 1);
		$this->db->where('s.estatus', 5);
		$this->db->order_by('r.institucion, r.nombre');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerAreas() {
		$sql = "SELECT id_area_conocimiento, num_area, area_conocimiento 
				FROM cat_area_conocimiento 
				WHERE estatus = 1 
				ORDER BY FIELD (num_area, NULL)";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerEjemplaresElectronicos($revista) {
		$this->db->select('id_ejemplar_electronico, numero, anio_distribucion, url');
		$this->db->from('ejemplar_electronico');
		$this->db->where('revista', $revista);
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerEditor($editor) {
		$this->db->select('cga.grado_academico, cargo, nombre, ap_paterno, ap_materno, correo, telefono');
		$this->db->from('editor e');
		$this->db->join('cat_grado_academico cga', 'e.grado_academico = cga.id_grado_academico');
		$this->db->where('id_editor', $editor);
		$this->db->where('e.estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function leerIndices($solicitud) {
		$this->db->select('id_indice_resumen');
		$this->db->from('indice_resumen');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus >', 0);
		$this->db->group_by('tipo');
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function leerIndicesSolicitud($solicitud) {
		$this->db->select('id_indice_resumen, tipo, nombre, antiguedad');
		$this->db->from('indice_resumen');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus >', 0);
		$this->db->order_by('tipo, nombre');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerDistribuciones($solicitud) {
		$this->db->select('id_distribucion, anio, consecutivo, abstracts, html, pdf');
		$this->db->from('distribucion_electronica');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerVolumenes($solicitud) {
		$this->db->select('id_volumen, anio, volumen, abstracts, texto_completo');
		$this->db->from('volumen_consultado');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		return $query;
	}
	
	public function leerArticulos($solicitud) {
		$this->db->select('id_articulo, anio, volumen, titulo, autor');
		$this->db->from('articulo_descargado');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		return $query;
	}
	
	public function leerPaises($solicitud) {
		$this->db->select('id_pais, anio, pais, consultas, texto_completo');
		$this->db->from('pais_consulta');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		return $query;
	}
	
	public function leerManuscritos($solicitud) {
		$this->db->select('id_manuscrito');
		$this->db->from('manuscrito');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus', 1);
		$this->db->group_by('tipo');
		$query = $this->db->get();
	
		return $query->num_rows();
	}
	
	public function leerManuscritosSolicitud($solicitud) {
		$this->db->select('id_manuscrito, tipo, ruta');
		$this->db->from('manuscrito');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus', 1);
		$this->db->order_by('tipo, ruta');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerAnexos($solicitud) {
		$this->db->select('id_anexo, descripcion, ruta_anexo');
		$this->db->from('anexo');
		$this->db->where('solicitud', $solicitud);
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarRevistaPorID($id) {
		$this->db->select('r.*, s.*, u.login, e.nombre AS enombre, e.ap_paterno, e.ap_materno');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->join('usuario u', 's.usuario = u.id_usuario');
		$this->db->join('editor e', 'r.editor = e.id_editor');
		$this->db->where('id_revista', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarInformacionGeneral($id) {
		$this->db->select('cts.tipo_solicitud, formato, nombre, inicio_publicacion, periodicidad, cac.area_conocimiento, disciplina, subdisciplina, otro_tema, articulos_anio, porcentaje_rechazados, tiempo_recep_aprob, factor_impacto, issn_impreso, issn_electronico');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->join('cat_tipo_solicitud cts', 's.tipo_solicitud = cts.id_tipo_solicitud');
		$this->db->join('cat_area_conocimiento cac', 'r.area_conocimiento = cac.id_area_conocimiento');
		$this->db->where('id_revista', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarInstitucion($id) {
		$this->db->select('institucion, calle_numero, numero_interior, colonia, cp.pais, entidad, municipio, ciudad, codigo_postal');
		$this->db->from('revista r');
		$this->db->join('cat_pais cp', 'r.pais = cp.id_pais');
		$this->db->where('id_revista', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarDictamenes() {
		$this->db->select('r.nombre, r.institucion, cts.tipo_solicitud, cac.area_conocimiento, cd.dictamen, d.comentarios');
		$this->db->from('dictamen d');
		$this->db->join('solicitud s', 'd.solicitud = s.id_solicitud');
		$this->db->join('revista r', 's.revista = r.id_revista');
		$this->db->join('cat_dictamen cd', 'd.dictamen = cd.id_dictamen');
		$this->db->join('cat_area_conocimiento cac', 'r.area_conocimiento = cac.id_area_conocimiento');
		$this->db->join('cat_tipo_solicitud cts', 's.tipo_solicitud = cts.id_tipo_solicitud');
		$this->db->where('d.estatus', 5);
		$this->db->order_by('r.area_conocimiento, r.nombre');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
}