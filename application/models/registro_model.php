<?php
class Registro_model extends CI_Model {
	public function verificarNombreUsuario($usuario) {
		$this->db->select('id_usuario');
		$this->db->from('usuario');
		$this->db->where('login', $usuario);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function verificarUsuarioExistente($correo) {
		$this->db->select('id_usuario');
		$this->db->from('usuario');
		$this->db->like('correo', $correo, 'none');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return true;
		}
	}
	
	public function insertarSolicitante($data) {
		if($this->db->insert('usuario', $data)) {
			return $this->db->insert_id();
		}
	}
}
?>