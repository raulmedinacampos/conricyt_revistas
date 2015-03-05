<?php
class Evaluador_model extends CI_Model {
	public function leerSecciones() {
		$this->db->select('id_seccion, seccion, ponderacion');
		$this->db->from('ev_seccion');
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerSubsecciones() {
		$this->db->select('id_subseccion, subseccion, seccion');
		$this->db->from('ev_subseccion');
		$this->db->where('estatus', 1);
		$this->db->order_by('orden');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerPreguntas() {
		$this->db->select('id_pregunta, pregunta, tipo_pregunta, seccion, subseccion, puntos_asignados');
		$this->db->from('ev_pregunta');
		$this->db->where('estatus', 1);
		$this->db->where('padre IS NULL');
		$this->db->order_by('orden');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerPreguntasHijas() {
		$this->db->select('id_pregunta, pregunta, tipo_pregunta, seccion, subseccion, padre, puntos_asignados');
		$this->db->from('ev_pregunta');
		$this->db->where('estatus', 1);
		$this->db->where('padre IS NOT NULL');
		$this->db->order_by('orden');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function leerOpciones() {
		$this->db->select('id_opcion, opcion, pregunta, puntos_asignados');
		$this->db->from('ev_opcion');
		$this->db->where('estatus', 1);
		$this->db->order_by('orden');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarRevistasPorEvaluador($evaluador) {
		$this->db->select('s.id_solicitud, r.nombre, r.institucion, ev.estatus');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->join('evaluador_revista er', 'r.id_revista = er.revista');
		$this->db->join('evaluacion ev', 's.id_solicitud = ev.solicitud', "left");
		$this->db->where('er.usuario', $evaluador);
		$this->db->group_by('r.nombre');
		$this->db->order_by('r.nombre');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarEditorPorRevista($revista) {
		$this->db->select('e.id_editor, e.nombre, e.ap_paterno, e.ap_materno');
		$this->db->from('editor e');
		$this->db->join('revista r', 'e.id_editor = r.editor');
		$this->db->where('r.id_revista', $revista);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function leerDatosSolicitudPorID($id) {
		$this->db->select('s.id_solicitud, s.folio, s.revista, r.nombre, r.institucion');
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->where('s.id_solicitud', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarDatosEvaluacionPorSolicitud($solicitud) {
		$this->db->select('ev.id_evaluacion, ev.fecha_evaluacion, ev.usuario, ev.solicitud, ev.comentarios, ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.solicitud', $solicitud);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarDatosEvaluacionPorID($id) {
		$this->db->select('ev.id_evaluacion, ev.fecha_evaluacion, ev.usuario, ev.solicitud, ev.comentarios, ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.id_evaluacion', $id);
		$this->db->where('ev.estatus >', 0);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarEvaluacionPorSolicitudUsuario($solicitud, $usuario) {
		$this->db->select('ev.id_evaluacion, ev.solicitud, ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.solicitud', $solicitud);
		$this->db->where('ev.usuario', $usuario);
		$this->db->where('ev.estatus >', 0);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarRespuestasPorEvaluacion($evaluacion) {
		$this->db->select('ep.evaluacion, ep.pregunta, ep.opcion, ep.justificacion');
		$this->db->from('evaluacion_pregunta ep');
		$this->db->where('ep.evaluacion', $evaluacion);
		$this->db->where('ep.estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarRespuestaPorEvaluacionPregunta($evaluacion, $pregunta) {
		$this->db->select('ep.evaluacion, ep.pregunta, ep.opcion, ep.justificacion');
		$this->db->from('evaluacion_pregunta ep');
		$this->db->where('ep.evaluacion', $evaluacion);
		$this->db->where('ep.pregunta', $pregunta);
		$this->db->where('ep.estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}  
	
	public function insertarEvaluacion($data) {
		$this->db->insert('evaluacion', $data);
		$id_evaluacion = $this->db->insert_id();
		
		if($id_evaluacion) {
			return $id_evaluacion;
		} 
	}
	
	public function actualizarEvaluacion($evaluacion, $data) {
		$this->db->where('id_evaluacion', $evaluacion);
	
		if($this->db->update('evaluacion', $data)) {
			return true;
		}
	}
	
	public function insertarRespuesta($data) {
		if($this->db->insert('evaluacion_pregunta', $data)) {
			return true;
		}
	}
	
	public function actualizarRespuesta($evaluacion, $pregunta, $data) {
		$this->db->where('evaluacion', $evaluacion);
		$this->db->where('pregunta', $pregunta);
		
		if($this->db->update('evaluacion_pregunta', $data)) {
			return true;
		}
	}
	
	public function actualizarEstatus($evaluacion, $data) {
		$this->db->where('id_evaluacion', $evaluacion);
		
		if($this->db->update('evaluacion', $data)) {
			return true;
		}
	}
	
	public function consultarAreaPorUsuario($usr) {
		$this->db->select('c.area_conocimiento');
		$this->db->from('comision c');
		$this->db->join('comision_usuario cu', 'c.id_comision = cu.comision');
		$this->db->where('cu.usuario', $usr);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$area = $query->row();
			return $area->area_conocimiento;
		}
	}
}
?>