<h5>En esta sección deberás ingresar su presencia en bases de datos.</h5>
<?php
echo form_fieldset('');
echo '<div class="form-group">';
echo form_label('Presencia en bases de datos (URL)', '', array('class' => 'col-sm-2 control-label requerido'));

$attr = array(
		'id'	=>	'url_presencia_bd',
		'name'	=>	'url_presencia_bd',
		'class'	=>	'form-control',
		'placeholder' => 'http://www.ejemplo.com',
		'value'	=>	(isset($solicitud->url_presencia_bd) ? $solicitud->url_presencia_bd : "")
);
echo '<div class="col-sm-10">';
echo form_input($attr);
echo '</div>';
echo '</div>';
echo form_fieldset_close();

echo form_fieldset('Índices nacionales e internacionales');

$i = 1;

if($indices && $indices->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Nombre</th><th>Antigüedad</th><th>Estatus</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($indices->result() as $val) {
		$estatus = ($val->estatus == 1) ? "Finalizado":"En trámite";
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->nombre.'</td>';
		echo '<td>'.$val->antiguedad.'</td>';
		echo '<td>'.$estatus.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_indice_resumen.'" data-seccion="indices"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Nombre', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'nombre_indice_'.$i,
	'name'	=>	'nombre_indice[]',
	'class'	=>	'form-control'
);	
echo '<div class="col-sm-2">';
echo form_input($attr);
echo '</div>';

echo form_label('Antigüedad', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'antiguedad_indice_'.$i,
	'name'	=>	'antiguedad_indice[]',
	'class'	=>	'form-control'
);	
echo '<div class="col-sm-2">';
echo form_input($attr);
echo '</div>';

echo form_label('Estatus', '', array('class' => 'col-sm-2 control-label requerido'));
$opc = array(
	''	=>	'Selecciona',
	'2'	=>	'En trámite',
	'1'	=>	'Finalizado'
);
echo '<div class="col-sm-2">';
echo form_dropdown('estatus_indice[]', $opc, '', 'id="estatus_indice_'.$i.'" class="form-control"');

$attr = array(
		'id'	=>	'num_indices',
		'name'	=>	'num_indices',
		'type'	=>	'hidden',
		'value'	=>	$i
);
echo form_input($attr);
echo '</div>';
echo '</div>';

$attr = array(
	'id'	=>	'btnMasIndices',
	'name'	=>	'btnMasIndices',
	'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar índice',
	'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();

echo form_fieldset('Servicios de resúmenes (abstracts) nacionales e internacionales');

$i = 1;

if($resumenes && $resumenes->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Nombre</th><th>Antigüedad</th><th>Estatus</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($resumenes->result() as $val) {
		$estatus = ($val->estatus == 1) ? "Finalizado":"En trámite";
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->nombre.'</td>';
		echo '<td>'.$val->antiguedad.'</td>';
		echo '<td>'.$estatus.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_indice_resumen.'" data-seccion="indices"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Nombre', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'nombre_abstract_'.$i,
	'name'	=>	'nombre_abstract[]',
	'class'	=>	'form-control'
);	
echo '<div class="col-sm-2">';
echo form_input($attr);
echo '</div>';

echo form_label('Antigüedad', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'antiguedad_abstract_'.$i,
	'name'	=>	'antiguedad_abstract[]',
	'class'	=>	'form-control'
);	
echo '<div class="col-sm-2">';
echo form_input($attr);
echo '</div>';

echo form_label('Estatus', '', array('class' => 'col-sm-2 control-label requerido'));
$opc = array(
	''	=>	'Selecciona',
	'2'	=>	'En trámite',
	'1'	=>	'Finalizado'
);
echo '<div class="col-sm-2">';
echo form_dropdown('estatus_abstract[]', $opc, '', 'id="estatus_abstract_'.$i.'" class="form-control"');

$attr = array(
		'id'	=>	'num_abstracts',
		'name'	=>	'num_abstracts',
		'type'	=>	'hidden',
		'value'	=>	$i
);
echo form_input($attr);
echo '</div>';
echo '</div>';

$attr = array(
		'id'	=>	'btnMasAbstracts',
		'name'	=>	'btnMasAbstracts',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar servicio de resúmenes',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();
?>