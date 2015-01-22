<script type="text/javascript" src="<?php echo base_url("scripts/additional-methods.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("scripts/bootstrap-filestyle.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("scripts/registro.js"); ?>"></script>
<script type="text/javascript">
function cancelarRegistro() {
	$("#btn_cancelar").click(function() {
		window.location = "<?php echo base_url(); ?>";
	});
}

function obtenerImagen() {
	$.post("<?php echo base_url('captcha'); ?>", '', function(data) {
		$("#img-captcha").attr("src", "<?php echo base_url('captcha/getImage').'/'; ?>"+data+"/"+Math.random());
		$("#oculto").val(data);
	});
}
</script>

<div style="margin-top:20px;" class="panel panel-info col-sm-8 col-sm-offset-2">
  <?php
  	$attr = array(
		'id'	=>	'formRegistro',
		'name'	=>	'formRegistro',
		'class'	=>	'form-horizontal'
	);
  	echo form_open_multipart(base_url('registro/alta'), $attr);
	
	echo form_fieldset('Datos de registro');
	
	echo '<div class="form-group">';
	echo form_label('Nombre', '', array('class' => 'col-sm-3 control-label requerido'));
	
	$attr = array(
		'id'	=>	'nombre',
		'name'	=>	'nombre',
		'class'	=>	'form-control'
	);	
	echo '<div class="col-sm-9">';
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Apellido paterno', '', array('class' => 'col-sm-3 control-label requerido'));
	
	$attr = array(
		'id'	=>	'ap_paterno',
		'name'	=>	'ap_paterno',
		'class'	=>	'form-control'
	);	
	echo '<div class="col-sm-9">';
	echo form_input($attr);
	
	$attr = array(
		'id'	=>	'chkApPaterno',
		'name'	=>	'chkApPaterno',
		'value'	=>	'1'
	);
	echo '<span class="help-block">';
	echo form_checkbox($attr);
	echo ' Sin apellido paterno</span>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Apellido materno', '', array('class' => 'col-sm-3 control-label requerido'));
	
	$attr = array(
		'id'	=>	'ap_materno',
		'name'	=>	'ap_materno',
		'class'	=>	'form-control'
	);	
	echo '<div class="col-sm-9">';
	echo form_input($attr);
	
	$attr = array(
		'id'	=>	'chkApMaterno',
		'name'	=>	'chkApMaterno',
		'value'	=>	'1'
	);
	echo '<span class="help-block">';
	echo form_checkbox($attr);
	echo ' Sin apellido materno</span>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Correo', '', array('class' => 'col-sm-3 control-label requerido'));
	
	$attr = array(
		'id'	=>	'correo',
		'name'	=>	'correo',
		'class'	=>	'form-control'
	);	
	echo '<div class="col-sm-9">';
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Confirmar correo', '', array('class' => 'col-sm-3 control-label requerido'));
	
	$attr = array(
		'id'	=>	'correo_conf',
		'name'	=>	'correo_conf',
		'class'	=>	'form-control'
	);	
	echo '<div class="col-sm-9">';
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Adjuntar CVU', '', array('class' => 'col-sm-3 control-label requerido'));
	
	$attr = array(
		'id'	=>	'archivo_cvu',
		'name'	=>	'archivo_cvu',
		'class'	=>	'filestyle',
		'data-buttonText'	=>	'Buscar archivo',
		'data-toggle'		=>	'tooltip',
		'title'	=>	'El CVU debe estar en formato PDF. Tamaño máximo del archivo: 10 MB'
	);	
	echo '<div class="col-sm-9">';
	echo form_upload($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Escribe el texto de la imagen', '', array('class' => 'col-sm-3 control-label requerido'));
	
	$attr = array(
			'id'	=>	'captcha',
			'name'	=>	'captcha',
			'class'	=>	'form-control'
	);
	echo '<div class="col-sm-4">';
	echo form_input($attr);
	
	$attr = array(
			'id'	=>	'oculto',
			'name'	=>	'oculto',
			'type'	=>	'hidden'
	);
	echo form_input($attr);
	echo '</div>';

	echo '<div class="col-sm-3">';
	echo '<img id="img-captcha" src="'.base_url("captcha").'" />';
	echo '</div>';

	echo '<div class="col-sm-2 text-right">';
	$attr = array(
		'id'	=>	'btn_captcha',
		'name'	=>	'btn_captcha',
		'class'	=>	'btn btn-primary',
		'content' => '<span class="glyphicon glyphicon-refresh"></span>'
	);	
	echo form_button($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo '<div class="col-sm-offset-2 col-sm-10">';
	echo '<div class="pull-right">';
	
	$attr = array(
		'id'	=>	'btn_cancelar',
		'name'	=>	'btn_cancelar',
		'class'	=>	'btn btn-default',
		'content' => 'Cancelar'
	);	
	echo form_button($attr);
	echo " ";
	
	$attr = array(
		'id'	=>	'btn_guardar',
		'name'	=>	'btn_guardar',
		'class'	=>	'btn btn-primary',
		'content' => 'Guardar'
	);	
	echo form_button($attr);
	echo '</div>';
	echo '</div>';
	echo '</div>';
  ?>
	<p>Con fundamento en el artículo 14, fracción VI, artículo 18, fracciones I y II, y artículo 21 de la Ley Federal de Transparencia y Acceso a la Información Pública Gubernamental, el tiempo de reserva de la presente información, que es de carácter confidencial, es de 10 años.</p>
  <?php
	
  	echo form_fieldset_close();
	echo form_close();
  ?>
  <div class="modal fade" id="mensajesError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Hay errores con el llenado del formulario</h4>
      </div>
      <div class="modal-body">
        <ul></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</div>
