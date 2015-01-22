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
}
?>