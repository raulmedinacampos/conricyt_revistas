<h5>En esta sección deberás anexar la documentación que consideré relevante para la evaluación de la revista.</h5>
<?php
echo form_fieldset('');

$i = 1;

if($anexos && $anexos->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Descripción</th><th>Archivo</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($anexos->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->descripcion.'</td>';
		echo '<td><a href="'.base_url('uploads/'.$usuario->login.'/'.$val->ruta_anexo).'" target="_bank">'.$val->ruta_anexo.'</a></td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_anexo.'" data-seccion="anexos"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Descripción', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
	'id'	=>	'descripcion_anexo_1',
	'name'	=>	'descripcion_anexo[]',
	'class'	=>	'form-control'
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Añadir anexo', '', array('class' => 'col-sm-2 control-label'));

$attr = array(
	'id'	=>	'archivo_anexo_1',
	'name'	=>	'archivo_anexo[]',
	'class'	=>	'filestyle',
	'data-buttonText'	=>	'Buscar archivo'
);	
echo '<div class="col-sm-4">';
echo form_upload($attr);
echo '</div>';
echo '</div>';

$attr = array(
		'id'	=>	'btnMasAnexos',
		'name'	=>	'btnMasAnexos',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar anexo',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();
?>