<script type="text/javascript" src="<?php echo base_url("scripts/additional-methods.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("scripts/bootstrap-filestyle.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("scripts/solicitud.js"); ?>"></script>

<?php
// Mensaje al darse de alta
if($this->session->flashdata('registrado') == '1') {
	echo '<script>$(function() {mostrarConfirmacion();});</script>';
}

// Preselección de la última pestaña
if($this->session->flashdata('tab')) {
	echo '<script>$(function() {$(".nav-tabs a[href=\"'.$this->session->flashdata('tab').'\"]").tab("show");});</script>';
}

// En caso de que la solicitud ya haya sido finalizada
if($solicitud && $solicitud->estatus == 5) {
	echo '<script>$(function() {$("input, select").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#hdn_nueva").prop("disabled", false);});</script>';
	echo '<script>$(function() {$(".quitar-elemento").css("display", "none");});</script>';
	echo '<script>$(function() {$(".table th:last-of-type, .table td:last-of-type").css("display", "none");});</script>';
}

$attr = array(
		'id'	=>	'formNueva',
		'name'	=>	'formNueva',
		'class'	=>	'form-horizontal'
);

echo form_open(base_url('solicitud'), $attr);

$attr = array(
		'id'	=>	'hdn_nueva',
		'name'	=>	'hdn_nueva',
		'type'	=>	'hidden'
);
echo form_input($attr);

echo form_close();


$attr = array(
	'id'	=>	'formSolicitud',
	'name'	=>	'formSolicitud',
	'class'	=>	'form-horizontal'
);

echo form_open_multipart(base_url('solicitud/guardarCambios'), $attr);

$attr = array(
	'id'	=>	'hdn_solicitud',
	'name'	=>	'hdn_solicitud',
	'type'	=>	'hidden',
	'value'	=>	(isset($solicitud->id_solicitud) ? $solicitud->id_solicitud : '')
);
echo form_input($attr);

$attr = array(
		'id'	=>	'hdn_tab',
		'name'	=>	'hdn_tab',
		'type'	=>	'hidden'
);

if($this->session->flashdata('tab')) {
	$attr['value'] = $this->session->flashdata('tab');
}

echo form_input($attr);
?>
<div class="panel panel-info" style="padding:20px 0 10px; font-size:14px;">
  <ul class="instrucciones">
    <li>El tamaño de cada archivo debe ser hasta un máximo de 10MB y solo se permiten en formato Excel y PDF</li>
    <li>El nombre del archivo no debe contener acentos ni caracteres especiales tales como \ / ; * &quot; &lt; &gt; |</li>
    <li>No olvides guardar los cambios al terminar de capturar la información solicitada en cada sección</li>
    <li>Es importante que consideres que al finalizar tu solicitud no podrás realizar ningún cambio, se te sugiere verificar que tu solicitud cumpla con toda la información requerida tanto en la Convocatoria como en los Criterios Generales de Evaluación</li>
    <li>No se dará trámite a las solicitudes que no cumplan con los requisitos o presenten documentación incompleta</li>
  </ul>
</div>
<div class="text-right">
  <a href="#" id="a_nueva"><span class="btn btn-default btn-sm">Nueva solicitud</span></a>
</div>

<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#tab-datos-revista" role="tab" data-toggle="tab">Datos de la revista</a></li>
  <li><a href="#tab-comite-editorial" role="tab" data-toggle="tab">Comité editorial</a></li>
  <li><a href="#tab-cartera-arbitros" role="tab" data-toggle="tab">Arbitraje</a></li>
  <li><a href="#tab-indices" role="tab" data-toggle="tab">Índices y resúmenes</a></li>
  <li><a href="#tab-dist-electronica" role="tab" data-toggle="tab">Distribución electrónica</a></li>
  <li><a href="#tab-articulos" role="tab" data-toggle="tab">Manuscritos recibidos</a></li>
  <li><a href="#tab-anexos" role="tab" data-toggle="tab">Anexos de revistas</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="tab-datos-revista">
    <?php include("datos_revista.php"); ?>
  </div>
  <div class="tab-pane" id="tab-comite-editorial">
    <?php include("comite_editorial.php"); ?>
  </div>
  <div class="tab-pane" id="tab-cartera-arbitros">
    <?php include("arbitraje.php"); ?>
  </div>
  <div class="tab-pane" id="tab-indices">
    <?php include("indices.php"); ?>
  </div>
  <div class="tab-pane" id="tab-dist-electronica">
    <?php include("distribucion_electronica.php"); ?>
  </div>
  <div class="tab-pane" id="tab-articulos">
    <?php include("articulos.php"); ?>
  </div>
  <div class="tab-pane" id="tab-anexos">
    <?php include("anexos.php"); ?>
  </div>
</div>
<?php
$attr = array(
		'id'	=>	'rdb_reunion_1',
		'name'	=>	'rdb_reunion',
		'value'	=>	'1'
);

if($solicitud && $solicitud->disposicion == 1) {
	$attr['checked'] = 'checked';
}

echo '<div class="form-group">';
echo '<div class="col-sm-12">¿Manifiesta su disposición para reunirse con el comité de expertos, el día y hora que este lo solicite?<br />';
echo form_label(form_radio($attr).' Sí', '', array('class' => 'radio-inline'))." ";

$attr = array(
		'id'	=>	'rdb_reunion_2',
		'name'	=>	'rdb_reunion',
		'value'	=>	'2'
);

if($solicitud && $solicitud->disposicion == 2) {
	$attr['checked'] = 'checked';
}
echo form_label(form_radio($attr).' No', '', array('class' => 'radio-inline'));
echo '</div>';
echo '</div>';

// En caso de que la solicitud ya haya sido finalizada o la convocatoria se haya cerrado
if((!$solicitud || $solicitud->estatus != 5) && date('Y-m-d') <= "2015-01-26") {
	$attr = array(
		'id'		=>	'btnGuardar',
		'name'		=>	'btnGuardar',
		'class'		=>	'btn btn-primary',
		'content'	=>	'Guardar avances'
	);
	
	echo form_button($attr);
	echo " ";
	
	$attr = array(
			'id'		=>	'btnFinalizar',
			'name'		=>	'btnFinalizar',
			'class'		=>	'btn btn-primary',
			'content'	=>	'Finalizar solicitud'
	);
	echo form_button($attr);
}

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

<div class="modal fade" id="mensajeEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Se eliminará el registro</h4>
      </div>
      <div class="modal-body">
        <p>Estás a punto de eliminar el registro seleccionado, ¿deseas continuar?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Continuar</button>
      </div>
    </div>
  </div>
</div>