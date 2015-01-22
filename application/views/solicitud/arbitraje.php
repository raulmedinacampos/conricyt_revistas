<h5>En esta sección deberás ingresar los documentos correspondientes a los árbitros de acuerdo a los Criterios Geberales de Evaluación de los últimos 2 años de publicación de la revista.</h5>
<?php
echo '<div class="form-group">';
echo form_label('Cartera de árbitros', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'arbitros',
	'name'	=>	'arbitros',
	'class'	=>	'filestyle',
	'data-buttonText'	=>	'Buscar archivo'
);	
echo '<div class="col-sm-10">';

if($solicitud && $solicitud->ruta_cartera_arbitros) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_cartera_arbitros;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#arbitros").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#arbitros").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_cartera_arbitros) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Bitácora de arbitraje', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'bitacora',
	'name'	=>	'bitacora',
	'class'	=>	'filestyle',
	'data-buttonText'	=>	'Buscar archivo'
);	
echo '<div class="col-sm-10">';

if($solicitud && $solicitud->ruta_bitacora_arbitraje) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_bitacora_arbitraje;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#bitacora").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#bitacora").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_bitacora_arbitraje) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';
?>