<?php
class Solicitud_model extends CI_Model {
	public function leerTipoSolicitud() {
		$this->db->select('id_tipo_solicitud, tipo_solicitud');
		$this->db->from('cat_tipo_solicitud');
		$this->db->where('estatus', 1);
		$this->db->order_by('tipo_solicitud');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerAreaConocimiento() {
		$this->db->select('id_area_conocimiento, area_conocimiento');
		$this->db->from('cat_area_conocimiento');
		$this->db->where('estatus', 1);
		$this->db->order_by('area_conocimiento');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerPaises() {
		$this->db->select('id_pais, pais');
		$this->db->from('cat_pais');
		$this->db->where('estatus', 1);
		$this->db->order_by('pais');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerGradoAcademico() {
		$this->db->select('id_grado_academico, grado_academico');
		$this->db->from('cat_grado_academico');
		$this->db->where('estatus', 1);
		$this->db->order_by('grado_academico');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function validarRevista($nombre, $issn) {
		$sql = "SELECT r.id_revista, r.nombre, r.issn_impreso, r.issn_electronico, s.id_solicitud ";
		$sql .= "FROM revista r JOIN solicitud s ON r.id_revista = s.revista ";
		$sql .= "WHERE SOUNDEX(r.nombre) = SOUNDEX('$nombre') ";
		$sql .= "AND (r.issn_impreso LIKE '$issn' OR r.issn_electronico LIKE '$issn') ";
		$sql .= "AND r.estatus = 1";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarUsuario($id) {
		$this->db->select('login, nombre, ap_paterno, ap_materno, correo, tipo_usuario');
		$this->db->from('usuario');
		$this->db->where('id_usuario', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarEditorPorCorreo($correo) {
		$this->db->select('id_editor, nombre, ap_paterno, ap_materno, correo');
		$this->db->from('editor');
		$this->db->where('correo', $correo);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarUltimoFolio() {
		$this->db->select('folio');
		$this->db->from('solicitud');
		$this->db->order_by('id_solicitud', "DESC");
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$folio = $query->row();
			return $folio->folio;
		}
	}
	
	public function consultarSolicitudPorUsuario($usr) {
		$this->db->from('solicitud s');
		$this->db->where('s.usuario', $usr);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarRegistrosPorUsuario($usr) {
		$this->db->select('s.id_solicitud, r.nombre, s.estatus');
		$this->db->from('solicitud s');
		$this->db->join('revista r', 's.revista = r.id_revista');
		$this->db->where('s.usuario', $usr);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarSolicitudPorID($id) {
		$this->db->from('solicitud s');
		$this->db->where('s.id_solicitud', $id);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarEjemplaresPorRevista($revista) {
		$this->db->from('ejemplar_electronico e');
		$this->db->where('e.revista', $revista);
		$this->db->where('e.estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarRevistaPorSolicitud($solicitud) {
		$this->db->from('revista r');
		$this->db->where('r.id_revista', $solicitud);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarEditorPorID($id) {
		$this->db->from('editor e');
		$this->db->where('e.id_editor', $id);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarIndicesResumenesPorSolicitudTipo($tipo, $solicitud) {
		$this->db->from('indice_resumen ir');
		$this->db->where('ir.solicitud', $solicitud);
		$this->db->where('ir.tipo', $tipo);
		$this->db->where('ir.estatus >=', 1);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarDistribucionPorSolicitud($solicitud) {
		$this->db->from('distribucion_electronica de');
		$this->db->where('de.solicitud', $solicitud);
		$this->db->where('de.estatus', 1);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarVolumenesPorSolicitud($solicitud) {
		$this->db->from('volumen_consultado v');
		$this->db->where('v.solicitud', $solicitud);
		$this->db->where('v.estatus', 1);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarArticulosPorSolicitud($solicitud) {
		$this->db->from('articulo_descargado a');
		$this->db->where('a.solicitud', $solicitud);
		$this->db->where('a.estatus', 1);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarPaisesPorSolicitud($solicitud) {
		$this->db->from('pais_consulta p');
		$this->db->where('p.solicitud', $solicitud);
		$this->db->where('p.estatus', 1);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarManuscritosRechazadosPorSolicitud($solicitud) {
		$this->db->from('manuscrito m');
		$this->db->where('m.solicitud', $solicitud);
		$this->db->where('m.estatus', 1);
		$this->db->where('m.tipo', 'r');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarManuscritosAceptadosPorSolicitud($solicitud) {
		$this->db->from('manuscrito m');
		$this->db->where('m.solicitud', $solicitud);
		$this->db->where('m.estatus', 1);
		$this->db->where('m.tipo', 'a');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarAnexosPorSolicitud($solicitud) {
		$this->db->from('anexo a');
		$this->db->where('a.solicitud', $solicitud);
		$this->db->where('a.estatus', 1);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarManuscritoPorID($id) {
		$this->db->select('m.ruta');
		$this->db->from('manuscrito m');
		$this->db->where('m.id_manuscrito', $id);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarAnexoPorID($id) {
		$this->db->select('a.descripcion, a.ruta_anexo');
		$this->db->from('anexo a');
		$this->db->where('a.id_anexo', $id);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function crearRegistro($tabla, $data) {
		if($this->db->insert($tabla, $data)) {
			return $this->db->insert_id();
		}
	}
	
	public function insertarEjemplarElectronico($data) {
		if($this->db->insert('ejemplar_electronico', $data)) {
			return true;
		}
	}
	
	public function insertarIndiceResumen($data) {
		if($this->db->insert('indice_resumen', $data)) {
			return true;
		}
	}
	
	public function insertarDistribucionElectronica($data) {
		if($this->db->insert('distribucion_electronica', $data)) {
			return true;
		}
	}
	
	public function insertarVolumenConsultado($data) {
		if($this->db->insert('volumen_consultado', $data)) {
			return true;
		}
	}
	
	public function insertarArticuloDescargado($data) {
		if($this->db->insert('articulo_descargado', $data)) {
			return true;
		}
	}
	
	public function insertarPaisConsulta($data) {
		if($this->db->insert('pais_consulta', $data)) {
			return true;
		}
	}
	
	public function insertarManuscrito($data) {
		if($this->db->insert('manuscrito', $data)) {
			return true;
		}
	}

	public function insertarAnexo($data) {
		if($this->db->insert('anexo', $data)) {
			return true;
		}
	}
	
	public function actualizarSolicitud($id, $data) {
		$this->db->where('id_solicitud', $id);
		if($this->db->update('solicitud', $data)) {
			return true;
		}
	}
	
	public function actualizarRevista($id, $data) {
		$this->db->where('id_revista', $id);
		if($this->db->update('revista', $data)) {
			return true;
		}
	}
	
	public function actualizarEditor($id, $data) {
		$this->db->where('id_editor', $id);
		if($this->db->update('editor', $data)) {
			return true;
		}
	}
	
	public function eliminarRegistro($tabla, $columna, $id) {
		$this->db->set('estatus', 0);
		$this->db->where($columna, $id);
		
		if($this->db->update($tabla)) {
			return true;
		}
	}
	
	public function cambiarFechaFinalizacion($solicitud, $fecha) {
		$this->db->set('fecha_finalizacion', $fecha);
		$this->db->where('id_solicitud', $solicitud);
	
		if($this->db->update('solicitud')) {
			return true;
		}
	}
	
	public function cambiarEstatus($solicitud, $estatus) {
		$this->db->set('estatus', $estatus);
		$this->db->where('id_solicitud', $solicitud);
		
		if($this->db->update('solicitud')) {
			return true;
		}
	}
}