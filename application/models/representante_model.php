<?php
class Representante_model extends CI_Model {
	public function leerOpcionesDictamen() {
		$this->db->select('id_dictamen, dictamen');
		$this->db->from('cat_dictamen');
		$this->db->where('estatus', 1);
		$this->db->order_by('dictamen');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
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
		$this->db->where('ev.estatus >', 0);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$calificacion = $query->row();
			return $calificacion->calificacion; 
		}
	}
	
	public function consultarEstatusPorUsuarioSolicitud($usuario, $solicitud) {
		$this->db->select('ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.usuario', $usuario);
		$this->db->where('ev.solicitud', $solicitud);
		$this->db->where('ev.estatus >', 0);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			$calificacion = $query->row();
			return $calificacion->estatus;
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
	
	public function consultarRevistaPorSolicitud($solicitud) {
		$this->db->select('r.nombre, r.institucion, s.folio, cts.tipo_solicitud, r.area_conocimiento AS area, a.area_conocimiento, r.disciplina, CONCAT_WS(" ", e.nombre, e.ap_paterno, e.ap_materno) AS editor', FALSE);
		$this->db->from('revista r');
		$this->db->join('solicitud s', 'r.id_revista = s.revista');
		$this->db->join('cat_area_conocimiento a', 'r.area_conocimiento = a.id_area_conocimiento');
		$this->db->join('editor e', 'r.editor = e.id_editor');
		$this->db->join('cat_tipo_solicitud cts', 's.tipo_solicitud = cts.id_tipo_solicitud');
		$this->db->where('s.id_solicitud', $solicitud);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarEvaluacionPorID($evaluacion) {
		$this->db->select('ev.id_evaluacion, ev.fecha_evaluacion, ev.usuario, ev.solicitud, ev.calificacion, ev.comentarios, ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.id_evaluacion', $evaluacion);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarEvaluacionPorSolicitud($solicitud) {
		$this->db->select('ev.id_evaluacion, ev.calificacion, ev.estatus, u.nombre, u.ap_paterno, u.ap_materno');
		$this->db->from('evaluacion ev');
		$this->db->join('usuario u', 'ev.usuario = u.id_usuario');
		$this->db->where('ev.solicitud', $solicitud);
		$this->db->where('ev.estatus >', 0);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarEvaluacionPorSolicitudUsuario($solicitud, $usuario) {
		$this->db->select('ev.id_evaluacion, ev.fecha_evaluacion, ev.usuario, ev.solicitud, ev.comentarios, ev.estatus');
		$this->db->from('evaluacion ev');
		$this->db->where('ev.solicitud', $solicitud);
		$this->db->where('ev.usuario', $usuario);
		$this->db->where('ev.estatus >', 0);
		$query = $this->db->get();
	
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarRepresentantesPorArea($areas) {
		$this->db->select('u.id_usuario, u.nombre, u.ap_paterno, u.ap_materno');
		$this->db->from('usuario u');
		$this->db->join('evaluacion ev', 'u.id_usuario = ev.usuario');
		$this->db->join('solicitud s', 'ev.solicitud = s.id_solicitud');
		$this->db->join('revista r', 's.revista = r.id_revista');
		$this->db->where('r.area_conocimiento IN', '('.$areas.')', FALSE);
		$this->db->where('u.tipo_usuario', 4);
		$this->db->where('u.estatus', 1);
		$this->db->group_by('u.id_usuario');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarDictamenPorSolicitudUsuario($solicitud, $usuario) {
		$this->db->select('cd.id_dictamen, cd.dictamen, d.comentarios');
		$this->db->from('dictamen d');
		$this->db->join('cat_dictamen cd', 'd.dictamen = cd.id_dictamen');
		$this->db->where('d.solicitud', $solicitud);
		$this->db->where('d.usuario', $usuario);
		$this->db->where('d.estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	
	public function consultarAreasPorGrupo($areas) {
		$this->db->select('cac.id_area_conocimiento, cac.num_area, cac.area_conocimiento');
		$this->db->from('cat_area_conocimiento cac');
		$this->db->where('cac.id_area_conocimiento IN', "($areas)", FALSE);
		$this->db->where('cac.estatus', 1);
		$this->db->order_by('cac.id_area_conocimiento');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	} 
	
	public function consultarRevistasPorGrupo($areas) {
		$this->db->select('ev.id_evaluacion, s.id_solicitud, r.id_revista, r.area_conocimiento, r.nombre');
		$this->db->from('evaluacion ev');
		$this->db->join('solicitud s', 'ev.solicitud = s.id_solicitud');
		$this->db->join('revista r', 's.revista = r.id_revista');
		$this->db->where('r.area_conocimiento IN', "($areas)", FALSE);
		//$this->db->where('ev.estatus', 5);
		$this->db->group_by('r.id_revista');
		$this->db->order_by('r.nombre');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
		}
	}
	
	public function consultarEvaluacionesPorGrupo($areas) {
		$this->db->select('ev.id_evaluacion, ev.solicitud, ev.calificacion, u.id_usuario, u.nombre, u.ap_paterno, u.ap_materno');
		$this->db->from('evaluacion ev');
		$this->db->join('usuario u', 'ev.usuario = u.id_usuario');
		$this->db->join('solicitud s', 'ev.solicitud = s.id_solicitud');
		$this->db->join('revista r', 's.revista = r.id_revista');
		$this->db->where('r.area_conocimiento IN', "($areas)", FALSE);
		//$this->db->where('ev.estatus', 5);
		$this->db->where('ev.estatus >', 0);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query;
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
	
	public function guardarDictamen($data) {
		if($this->db->insert('dictamen', $data)) {
			return true;
		}
	}
}
?>