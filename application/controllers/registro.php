<?php
class Registro extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('registro_model', 'registro', TRUE);
	}
	
	public function index() {
		$this->session->unset_userdata('error');
		$this->load->helper('form');
		
		$this->load->view('header');
		$this->load->view('registro/formulario');
		$this->load->view('footer');
	}
	
	public function revisarCorreoRepetido() {
		$correo = $this->input->post('correo');
		
		if($this->registro->verificarUsuarioExistente($correo)) {
			// Ya existe el usuario
			echo "false";
		} else {
			echo "true";
		}
	}
	
	private function crearUsuario($data) {
		$this->load->library('cadena');
		
		$usuario = "";
		$extra = "";
		
		$usuario = substr(Cadena::quitarAcentos($data['nombre']), 0, 1);
		
		if($data['ap_paterno']) {
			$usuario .= Cadena::quitarAcentos($data['ap_paterno']);
		} else {
			$usuario .= Cadena::quitarAcentos($data['ap_materno']);
		}
		
		$usrParecido = $this->registro->verificarNombreUsuario($usuario);
		
		if($usrParecido > 0) {
			$extra = str_pad($usrParecido, 2, "0", STR_PAD_LEFT);
			$usuario .= $extra;
		}
		
		return $usuario;
	}
	
	private function crearPassword($longitud = 8) {
		$password = substr(str_shuffle(md5(time())), 0, $longitud);
		return $password;
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
	
	public function alta() {
		$this->load->library('cadena');
		
		$cvu = "archivo_cvu";
		$data['fecha_alta'] = date('Y-m-d H:i:s');
		$data['tipo_usuario'] = 3;
		$data['nombre'] = addslashes(Cadena::formatearNombre($this->input->post('nombre')));
		$data['ap_paterno'] = addslashes(Cadena::formatearNombre($this->input->post('ap_paterno')));
		$data['ap_materno'] = addslashes(Cadena::formatearNombre($this->input->post('ap_materno')));
		$data['correo'] = addslashes(strtolower(trim($this->input->post('correo'))));
		
		$ext = strtolower(end(explode(".", $_FILES[$cvu]['name'])));
		
		$config['upload_path'] = './uploads/';
		$config['file_name'] = Cadena::nombrarArchivos($data['nombre'].'_'.$data['ap_paterno']).'_'.time().'.'.$ext;
		$config['allowed_types'] = 'xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '10240';
		
		$data['ruta_cvu'] = base_url('uploads').'/'.$config['file_name'];
		
		if($data['nombre']) {
			$data['login'] = $this->crearUsuario($data);
			$data['password'] = $this->crearPassword();
		}
		
		if(!$this->registro->verificarUsuarioExistente($data['correo'])) {
			$this->load->library('upload', $config);
	
			if($cvu = $this->upload->do_upload($cvu)) {
				$cvu_cargado = $this->upload->data();
				if($usuario = $this->registro->insertarSolicitante($data)) {
					$remitente = trim($data['nombre']." ".$data['ap_paterno']." ".$data['ap_materno']);
					$asunto = utf8_decode("Registro para solicitud al Índice de Revistas");
					$body = '<table width="100%" border="1" cellspacing="0" cellpadding="10" border="0" bordercolor="#FFFFFF">';
					$body .= '<tr><td bgcolor="#005199" align="center"><font size="4" face="Arial" color="#e0e0e0">';
					$body .= '<strong>Datos de acceso para registrar tu solicitud al &Iacute;ndice de Revistas</strong>';
					$body .= '</font></td></tr></table>';
					$body .= '<p><font size="3" face="Arial" color="#006699">Usuario: '.$data['login'].'<br />';
					$body .= 'Contraseña: '.$data['password'].'</font></p>';
					$body .= '<p><font size="3" face="Arial" color="#FF0000">En caso de alguna duda, por favor comun&iacute;cate con la Lic. Eldaa Flores al tel&eacute;fono (55) 5322 7700 ext. 4023 o escribe a la cuenta efloresga@conacyt.mx</font></p>';
					$body .= '<table width="100%" border="1" cellspacing="0" cellpadding="10" border="0" bordercolor="#FFFFFF"><tr><td bgcolor="#e0e0e0" align="center"><font size="3" face="Arial" color="#005199"><strong>Consejo Nacional de Ciencia y Tecnolog&iacute;a (CONACYT)</strong></font></td></tr></table>';
					$this->enviarCorreo($data['correo'], $remitente, $asunto, $body);
					
					$this->load->model('solicitud_model', 'solicitud', TRUE);
					$usr = $this->solicitud->consultarUsuario($usuario);
					
					$this->session->unset_userdata('error');
					$this->session->set_userdata('perfil', $usr->tipo_usuario);
					$this->session->set_userdata('id_usr', $usuario);
					
					$this->session->set_flashdata('registrado', '1');
					redirect(base_url('solicitud'));
				}
				echo "Subió";
			} else {
				echo "El archivo que intenta subir es incorrecto<br/>";
				print_r($this->upload->display_errors());
			}
		} else {
			echo "Este usuario ya existe";
		}
	}
} 