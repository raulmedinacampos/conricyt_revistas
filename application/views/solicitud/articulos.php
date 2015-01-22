<h5>En esta sección deberás ingresar la documentación correspondiente a los manuscritos, de acuerdo a lo solicitado en los Criterios Generales de Evaluación de los últimos 2 años.</h5>
<?php
echo form_fieldset('');
echo '<div class="form-group">';
echo form_label('Manuscritos rechazados o condicionados', '', array('class' => 'col-sm-2 control-label requerido'));

$attr = array(
	'id'	=>	'manuscritos_condicionados',
	'name'	=>	'manuscritos_condicionados',
	'class'	=>	'filestyle',
	'data-buttonText'	=>	'Buscar archivo'
);	
echo '<div class="col-sm-10">';

if($solicitud && $solicitud->ruta_manuscritos_rechazados) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_manuscritos_rechazados;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#manuscritos_condicionados").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#manuscritos_condicionados").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_manuscritos_rechazados) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';

$i = 1;

if($mRechazados && $mRechazados->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Archivo</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($mRechazados->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->ruta.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_manuscrito.'" data-seccion="manuscritos"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

$attr = array(
		'id'	=>	'btnMasMRechazados',
		'name'	=>	'btnMasMRechazados',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar manuscrito rechazado',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();

echo form_fieldset('');
echo '<div class="form-group">';
echo form_label('Manuscritos aceptados', '', array('class' => 'col-sm-2 control-label requerido'));

$attr = array(
	'id'	=>	'manuscritos_aceptados',
	'name'	=>	'manuscritos_aceptados',
	'class'	=>	'filestyle',
	'data-buttonText'	=>	'Buscar archivo'
);	
echo '<div class="col-sm-10">';

if($solicitud && $solicitud->ruta_manuscritos_aceptados) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_manuscritos_aceptados;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#manuscritos_aceptados").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#manuscritos_aceptados").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_manuscritos_aceptados) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';

$i = 1;

if($mAceptados && $mAceptados->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Archivo</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($mAceptados->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->ruta.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_manuscrito.'" data-seccion="manuscritos"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

$attr = array(
		'id'	=>	'btnMasMAceptados',
		'name'	=>	'btnMasMAceptados',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar manuscrito aceptado',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();

echo '<div class="form-group">';
echo form_label('Formato de dictamen o formato libre', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'dictamen',
		'name'	=>	'dictamen',
		'class'	=>	'filestyle',
		'data-buttonText'	=>	'Buscar archivo'
);
echo '<div class="col-sm-10">';

if($solicitud && $solicitud->ruta_formato_dictamen) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_formato_dictamen;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#dictamen").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#dictamen").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_formato_dictamen) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';
?>