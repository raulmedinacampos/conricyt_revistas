<h5>En esta sección deberás ingresar los datos de su distribución electrónica de los últimos dos años.</h5>
<?php
$maximo = 5;

echo '<div class="form-group">';
echo form_label('El acceso a la revista es', '', array('class' => 'col-sm-2 control-label requerido'));
echo '<div class="col-sm-4">';
$attr = array(
	'id'	=>	'acceso_revista_1',
	'name'	=>	'acceso_revista',
	'value'	=>	'a'
);

if($revista && $revista->acceso == $attr['value']) {
	$attr['checked'] = 'checked';
}
echo form_label(form_radio($attr)." Abierta", '', array('class' => 'radio-inline'));

$attr = array(
		'id'	=>	'acceso_revista_2',
		'name'	=>	'acceso_revista',
		'value'	=>	's'
);

if($revista && $revista->acceso == $attr['value']) {
	$attr['checked'] = 'checked';
}
echo form_label(form_radio($attr)." Suscripción", '', array('class' => 'radio-inline'));

$attr = array(
		'id'	=>	'acceso_revista_3',
		'name'	=>	'acceso_revista',
		'value'	=>	'as'
);

if($revista && $revista->acceso == $attr['value']) {
	$attr['checked'] = 'checked';
}
echo form_label(form_radio($attr)." Abierta/Suscripción", '', array('class' => 'radio-inline'));
echo '</div>';
echo '</div>';

echo form_fieldset('');

$i = 1;

if($distribuciones && $distribuciones->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Año</th><th>Consecutivo</th><th>Consultas abstracts</th><th>HTML</th><th>PDF</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($distribuciones->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->anio.'</td>';
		echo '<td>'.$val->consecutivo.'</td>';
		echo '<td>'.$val->abstracts.'</td>';
		echo '<td>'.$val->html.'</td>';
		echo '<td>'.$val->pdf.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_distribucion.'" data-seccion="distribuciones"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Año', '', array('class' => 'col-sm-1 control-label requerido'));
$attr = array(
	'id'	=>	'anio_distribucion_'.$i,
	'name'	=>	'anio_distribucion[]',
	'class'	=>	'form-control'
);	

if($i > ($maximo*2)) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('Consecutivo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'numero_consecutivo_'.$i,
	'name'	=>	'numero_consecutivo[]',
	'class'	=>	'form-control'
);	

if($i > ($maximo*2)) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('Número consultas abstracts', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'consultas_abs_distribucion_'.$i,
	'name'	=>	'consultas_abs_distribucion[]',
	'class'	=>	'form-control'
);	

if($i > ($maximo*2)) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('HTML', '', array('class' => 'col-sm-1 control-label requerido'));
$attr = array(
	'id'	=>	'html_distribucion_'.$i,
	'name'	=>	'html_distribucion[]',
	'class'	=>	'form-control'
);	

if($i > ($maximo*2)) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('PDF', '', array('class' => 'col-sm-1 control-label requerido'));
$attr = array(
	'id'	=>	'pdf_distribucion_'.$i,
	'name'	=>	'pdf_distribucion[]',
	'class'	=>	'form-control'
);	

if($i > ($maximo*2)) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);

$attr = array(
		'id'	=>	'num_distribuciones',
		'name'	=>	'num_distribuciones',
		'type'	=>	'hidden',
		'value'	=>	$i
);
echo form_input($attr);
echo '</div>';
echo '</div>';

$attr = array(
		'id'	=>	'btnMasAccesos',
		'name'	=>	'btnMasAccesos',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar registro',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);

echo form_fieldset_close();

echo form_fieldset('Los 5 volúmenes más consultados de los últimos 2 años');

$i = 1;

if($volumenes && $volumenes->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Año</th><th>Volumen</th><th>Consultas abstracts</th><th>Texto completo</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($volumenes->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->anio.'</td>';
		echo '<td>'.$val->volumen.'</td>';
		echo '<td>'.$val->abstracts.'</td>';
		echo '<td>'.$val->texto_completo.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_volumen.'" data-seccion="volumenes"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Año', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'anio_volumen_'.$i,
	'name'	=>	'anio_volumen[]',
	'class'	=>	'form-control'
);

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('Vol. artículo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'articulo_volumen_'.$i,
	'name'	=>	'articulo_volumen[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('Número de consultas abstracts', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'consultas_volumen_'.$i,
	'name'	=>	'consultas_volumen[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('Texto completo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'texto_volumen_'.$i,
	'name'	=>	'texto_volumen[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-1">';
echo form_input($attr);

$attr = array(
		'id'	=>	'num_volumen',
		'name'	=>	'num_volumen',
		'type'	=>	'hidden',
		'value'	=>	$i
);
echo form_input($attr);
echo '</div>';
echo '</div>';

$attr = array(
		'id'	=>	'btnMasVolumenes',
		'name'	=>	'btnMasVolumenes',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar volumen',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();

echo form_fieldset('Enliste los 5 artículos más bajados en texto completo en los últimos 2 años');

$i = 1;

if($articulos && $articulos->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Año</th><th>Volumen</th><th>Título del artículo</th><th>Autor(es)</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($articulos->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->anio.'</td>';
		echo '<td>'.$val->volumen.'</td>';
		echo '<td>'.$val->titulo.'</td>';
		echo '<td>'.$val->autor.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_articulo.'" data-seccion="articulos"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Año', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'anio_articulo_'.$i,
	'name'	=>	'anio_articulo[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Vol. artículo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'articulo_articulo_'.$i,
	'name'	=>	'articulo_articulo[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Título del artículo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'titulo_articulo_'.$i,
	'name'	=>	'titulo_articulo[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Autor o autores', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'autor_articulo_'.$i,
	'name'	=>	'autor_articulo[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);

$attr = array(
		'id'	=>	'num_articulo',
		'name'	=>	'num_articulo',
		'type'	=>	'hidden',
		'value'	=>	$i
);
echo form_input($attr);
echo '</div>';
echo '</div>';

$attr = array(
		'id'	=>	'btnMasArticulos',
		'name'	=>	'btnMasArticulos',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar artículo',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();

echo form_fieldset('Enliste los 5 países que más consultan los artículos de la revista en los últimos 2 años');

$i = 1;

if($paises_dist && $paises_dist->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Año</th><th>País</th><th>Consultas realizadas</th><th>Texto completo</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($paises_dist->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->anio.'</td>';
		echo '<td>'.$val->pais.'</td>';
		echo '<td>'.$val->consultas.'</td>';
		echo '<td>'.$val->texto_completo.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_pais.'" data-seccion="paises"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Año', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'anio_pais_'.$i,
	'name'	=>	'anio_pais[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('País', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'nombre_pais_'.$i,
	'name'	=>	'nombre_pais[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Consultas realizadas', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'consultas_pais_'.$i,
	'name'	=>	'consultas_pais[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Texto completo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'texto_pais_'.$i,
	'name'	=>	'texto_pais[]',
	'class'	=>	'form-control'
);	

if($i > $maximo) {
	$attr['readonly'] = 'readonly';
}

echo '<div class="col-sm-4">';
echo form_input($attr);

$attr = array(
		'id'	=>	'num_paises',
		'name'	=>	'num_paises',
		'type'	=>	'hidden',
		'value'	=>	$i
);
echo form_input($attr);
echo '</div>';
echo '</div>';

$attr = array(
		'id'	=>	'btnMasPaises',
		'name'	=>	'btnMasPaises',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar país',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo form_fieldset_close();
?>