<h5>En esta sección deberás ingresar los documentos correspondientes al comité editorial de acuerdo a lo solicitado en los Criterios Generales de Evaluación.</h5>
<?php
echo '<div class="form-group">';
echo form_label('Comité editorial', '', array('class' => 'col-sm-2 control-label requerido'));

$attr = array(
	'id'	=>	'comite',
	'name'	=>	'comite',
	'class'	=>	'filestyle',
	'data-buttonText'	=>	'Buscar archivo'
);	
echo '<div class="col-sm-10">';

if($solicitud && $solicitud->ruta_comite_editorial) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_comite_editorial;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#comite").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#comite").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_comite_editorial) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Actas y acuerdos', '', array('class' => 'col-sm-2 control-label requerido'));

$attr = array(
		'id'	=>	'actas_acuerdos',
		'name'	=>	'actas_acuerdos',
		'class'	=>	'filestyle',
		'data-buttonText'	=>	'Buscar archivo'
);
echo '<div class="col-sm-10">';

if($solicitud && $solicitud->ruta_actas_acuerdos) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_actas_acuerdos;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#actas_acuerdos").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#actas_acuerdos").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_actas_acuerdos) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Funciones, reponsabilidades y normatividad', '', array('class' => 'col-sm-2 control-label requerido'));

$attr = array(
		'id'	=>	'url_funciones',
		'name'	=>	'url_funciones',
		'class'	=>	'form-control',
		'placeholder' => 'http://www.ejemplo.com',
		'value'	=>	(isset($solicitud->url_func_resp_norm) ? $solicitud->url_func_resp_norm : "")
);
echo '<div class="col-sm-10">';
echo form_input($attr);
echo '</div>';
echo '</div>';
?>