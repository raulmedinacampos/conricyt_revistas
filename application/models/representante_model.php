<?php
class Representante_model extends CI_Model {
	public function consultarComisionPorUsuario($usr) {
		$this->db->select('c.id_comision');
		$this->db->from('comision c');
		$this->db->join('comision_usuario cu', 'c.id_comision = cu.comision');
		$this->db->where('cu.usuario', $usr);
		$this->db->where('c.estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$comision = $query->row();
			return $comision->id_comision;
		}
	}
	
	public function consultarEvaluadoresPorComision($comision) {
		$this->db->select('u.id_usuario, u.nombre, u.ap_paterno, u.ap_materno');
		$this->db->from('usuario u');
		$this->db->join('comision_usuario cu', 'u.id_usuario = cu.usuario');
		$this->db->join('evaluador_revista er', 'u.id_usuario = er.usuario');
		$this->db->where('cu.comision', $comision);
		$this->db->group_by('u.id_usuario');
		$this->db->order_by('u.nombre, u.ap_paterno, u.ap_materno');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarRevistasPorComision($comision) {
		$this->db->select("s.id_solicitud, r.id_revista, r.nombre, ev.id_evaluacion, ev.calificacion, ev.estatus");
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->join('evaluador_revista er', 'r.id_revista = er.revista');
		$this->db->join('evaluacion ev', 's.id_solicitud = ev.solicitud', "left");
		$this->db->join('usuario u', 'er.usuario = u.id_usuario');
		$this->db->join('comision_usuario cu', 'u.id_usuario = cu.usuario');
		$this->db->where('cu.comision', $comision);
		$this->db->group_by('r.id_revista');
		$this->db->order_by('r.nombre');
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarRevistasPorRepresentanteComision($representante, $comision) {
		$this->db->select("s.id_solicitud, r.nombre, r.institucion, u.id_usuario, CONCAT_WS(' ', u.nombre, u.ap_paterno, u.ap_materno) AS evaluador, ev.calificacion, ev.estatus", FALSE);
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->join('evaluador_revista er', 'r.id_revista = er.revista');
		$this->db->join('evaluacion ev', 's.id_solicitud = ev.solicitud', "left");
		$this->db->join('usuario u', 'er.usuario = u.id_usuario');
		$this->db->join('comision_usuario cu', 'u.id_usuario = cu.usuario');
		$this->db->where('cu.comision', $comision);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarCalificacionPorUsuarioSolicitud($usuario, $solicitud) {
		$this->db->select('ev.calificacion');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.usuario', $usuario);
		$this->db->where('ev.solicitud', $solicitud);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$calificacion = $query->row();
			return $calificacion->calificacion; 
		}
	}
	
	public function consultarNombreRevistaPorID($id) {
		$this->db->select('r.nombre');
		$this->db->from('revista r');
		$this->db->where('r.id_revista', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$revista = $query->row();
			return $revista->nombre;
		}
	}
	
	public function consultarEvaluacionPorID($evaluacion) {
		$this->db->select('ev.id_evaluacion, ev.fecha_evaluacion, ev.usuario, ev.solicitud, ev.comentarios, ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.id_evaluacion', $evaluacion);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarEvaluacionPorSolicitudUsuario($solicitud, $usuario) {
		$this->db->select('ev.id_evaluacion, ev.fecha_evaluacion, ev.usuario, ev.solicitud, ev.comentarios, ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.solicitud', $solicitud);
		$this->db->where('ev.usuario', $usuario);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function verificarEvaluacionAsignada($usuario, $revista) {
		$this->db->from('evaluador_revista');
		$this->db->where('usuario', $usuario);
		$this->db->where('revista', $revista);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return true;
		}
	}
}
?>