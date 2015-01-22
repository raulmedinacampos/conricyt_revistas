<?php
class Login_model extends CI_Model {
	public function buscarUsuario($usuario, $password) {
		$this->db->select('id_usuario, login, tipo_usuario');
		$this->db->from('usuario');
		$this->db->where('login', $usuario);
		$this->db->where('password', $password);
		$this->db->where('estatus', 1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
}
?>