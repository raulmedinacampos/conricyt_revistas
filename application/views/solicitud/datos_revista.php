<h5>En esta sección deberás ingresar los datos de la revista, del editor y la institución.</h5>
<div id="aviso-renovacion" class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Renovación automática</h3>
	</div>
	<div class="panel-body">En esta modalidad solo podrán aplicar aquellas revistas que cumplan en su totalidad
	con lo señalado en la Convocatoria y puedan comprobarlo;
	en caso contrario, quedarán fuera del Índice de Revistas</div>
</div>
<?php
if($solicitud) {
	$estatus = ($solicitud->estatus == 1) ? "En proceso" : "Finalizado";
	
	echo form_fieldset('Datos generales de la revista');
	echo '<h5>Solicitud: '.$solicitud->folio.'</h5>';
	echo '<h5>Convocatoria: '.$solicitud->convocatoria.'</h5>';
	echo '<h5>Estatus del documento: '.$estatus.'</h5>';
	echo form_fieldset_close();
}

echo form_fieldset('Datos de la revista');
echo '<div class="form-group">';
echo form_label('Tipo de solicitud', '', array('class' => 'col-sm-2 control-label requerido'));
$opc = array('' => 'Selecciona');
foreach ($tipo_solicitud->result() as $val) {
	$opc[$val->id_tipo_solicitud] = $val->tipo_solicitud;
}

echo '<div class="col-sm-4">';
echo form_dropdown('tipo_solicitud', $opc, (isset($solicitud->tipo_solicitud) ? $solicitud->tipo_solicitud : ''), 'id="tipo_solicitud" class="form-control"');
echo '</div>';

echo form_label('Formato de la revista', '', array('class' => 'col-sm-2 control-label requerido'));
echo '<div class="col-sm-4">';
$attr = array(
		'id'	=>	'formato_revista_1',
		'name'	=>	'formato_revista',
		'value'	=>	'i'
);

if($revista && $revista->formato == $attr['value']) {
	$attr['checked'] = 'checked';
}
echo form_label(form_radio($attr)." Impresión", '', array('class' => 'radio-inline'));

$attr = array(
		'id'	=>	'formato_revista_2',
		'name'	=>	'formato_revista',
		'value'	=>	'e'
);

if($revista && $revista->formato == $attr['value']) {
	$attr['checked'] = 'checked';
}
echo form_label(form_radio($attr)." Electrónica", '', array('class' => 'radio-inline'));

$attr = array(
		'id'	=>	'formato_revista_3',
		'name'	=>	'formato_revista',
		'value'	=>	'ie'
);

if($revista && $revista->formato == $attr['value']) {
	$attr['checked'] = 'checked';
}
echo form_label(form_radio($attr)." Impresión/Electrónica", '', array('class' => 'radio-inline'));
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Nombre de la revista', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'nombre_revista',
		'name'	=>	'nombre_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->nombre) ? $revista->nombre : "")
);	
echo '<div class="col-sm-10">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Año de inicio de la publicación', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'inicio_publicacion',
		'name'	=>	'inicio_publicacion',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->inicio_publicacion) ? $revista->inicio_publicacion : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo form_label('Periodicidad', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'periodicidad',
		'name'	=>	'periodicidad',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->periodicidad) ? $revista->periodicidad : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Área', '', array('class' => 'col-sm-2 control-label requerido'));

$opc = array('' => 'Selecciona');
foreach ($area_conocimiento->result() as $val) {
	$opc[$val->id_area_conocimiento] = $val->area_conocimiento;
}

echo '<div class="col-sm-4">';
echo form_dropdown('area_conocimiento', $opc, (isset($revista->area_conocimiento) ? $revista->area_conocimiento : ''), 'id="area_conocimiento" class="form-control"');
echo '</div>';

echo form_label('Disciplina', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'disciplina_revista',
		'name'	=>	'disciplina_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->disciplina) ? $revista->disciplina : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Subdisciplina', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'subdisciplina_revista',
		'name'	=>	'subdisciplina_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->subdisciplina) ? $revista->subdisciplina : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo form_label('Otra subdisciplina o tema', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'otro_tema',
		'name'	=>	'otro_tema',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->otro_tema) ? $revista->otro_tema : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Número promedio de artículos publicados por año', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'promedio_articulos',
		'name'	=>	'promedio_articulos',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->articulos_anio) ? $revista->articulos_anio : "")
);
echo '<div class="col-sm-4">';
echo '<div class="input-group">';
echo form_input($attr);
echo '<span class="input-group-addon">artículos</span>';
echo '</div>';
echo '</div>';

echo form_label('Porcentaje promedio de artículos rechazados por año', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'porcentaje_rechazados',
		'name'	=>	'porcentaje_rechazados',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->porcentaje_rechazados) ? $revista->porcentaje_rechazados : "")
);
echo '<div class="col-sm-4">';
echo '<div class="input-group">';
echo form_input($attr);
echo '<span class="input-group-addon">%</span>';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Tiempo promedio entre recepción y aprobación de un artículo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'tiempo_promedio',
		'name'	=>	'tiempo_promedio',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->tiempo_recep_aprob) ? $revista->tiempo_recep_aprob : "")
);
echo '<div class="col-sm-4">';
echo '<div class="input-group">';
echo form_input($attr);
echo '<span class="input-group-addon">meses</span>';
echo '</div>';
echo '</div>';

echo form_label('Factor de impacto', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'factor_impacto',
		'name'	=>	'factor_impacto',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->factor_impacto) ? $revista->factor_impacto : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('ISSN impreso', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'issn_impreso',
		'name'	=>	'issn_impreso',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->issn_impreso) ? $revista->issn_impreso : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('ISSN electrónico', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'issn_electronico',
		'name'	=>	'issn_electronico',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->issn_electronico) ? $revista->issn_electronico : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);

$attr = array(
		'id'	=>	'hdn_revista',
		'name'	=>	'hdn_revista',
		'type'	=>	'hidden',
		'value'	=>	(isset($revista->id_revista) ? $revista->id_revista : "")
);
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group div-carta-exencion">';
echo form_label('Carta de<br />renovación automática', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'carta_exencion',
		'name'	=>	'carta_exencion',
		'class'	=>	'filestyle',
		'data-buttonText'	=>	'Buscar archivo'
);
echo '<div class="col-sm-4">';

if($solicitud && $solicitud->ruta_carta_exencion) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_carta_exencion;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#carta_exencion").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#carta_exencion").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_carta_exencion) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';
echo '</div>';

$i = 1;

echo '<div class="div-ejemplares">';
if($ejemplares && $ejemplares->num_rows() > 0) {
	echo '<table class="table table-bordered table-condensed table-striped">';
	echo '<tr>';
	echo '<th>#</th><th>Número</th><th>Año de distribución</th><th>URL</th><th>Eliminar</th>';
	echo '</tr>';

	foreach($ejemplares->result() as $val) {
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$val->numero.'</td>';
		echo '<td>'.$val->anio_distribucion.'</td>';
		echo '<td>'.$val->url.'</td>';
		echo '<td><span class="glyphicon glyphicon-trash" data-registro="'.$val->id_ejemplar_electronico.'" data-seccion="ejemplares"></span></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<div class="form-group">';
echo form_label('Número', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'num_dist_elect_'.$i,
		'name'	=>	'num_dist_elect[]',
		'class'	=>	'form-control'
);
echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('Año de distribución', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'anio_dist_elect_'.$i,
		'name'	=>	'anio_dist_elect[]',
		'class'	=>	'form-control'
);
echo '<div class="col-sm-1">';
echo form_input($attr);
echo '</div>';

echo form_label('URL número de la revista', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'url_dist_elect_'.$i,
		'name'	=>	'url_dist_elect[]',
		'class'	=>	'form-control',
		'placeholder' => 'http://www.ejemplo.com'
);
echo '<div class="col-sm-4">';
echo form_input($attr);

$attr = array(
		'id'	=>	'num_ejemplares',
		'name'	=>	'num_ejemplares',
		'type'	=>	'hidden',
		'value'	=>	$i
);
echo form_input($attr);
echo '</div>';
echo '</div>';

$attr = array(
		'id'	=>	'btnMasURL',
		'name'	=>	'btnMasURL',
		'content' =>'<span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar ejemplares',
		'class'	=>	'btn btn-default'
);
echo form_button($attr);
echo '</div>';

echo form_fieldset_close();

echo form_fieldset('Datos de la institución que publica la revista');
echo '<div class="form-group">';
echo form_label('Nombre de la institución', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'institucion_revista',
		'name'	=>	'institucion_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->institucion) ? $revista->institucion : "")
);	
echo '<div class="col-sm-10">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Calle y número', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'calle_revista',
		'name'	=>	'calle_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->calle_numero) ? $revista->calle_numero : "")
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Número interior', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'numero_int_revista',
		'name'	=>	'numero_int_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->numero_interior) ? $revista->numero_interior : "")
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Colonia', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'colonia_revista',
		'name'	=>	'colonia_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->colonia) ? $revista->colonia : "")
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('País', '', array('class' => 'col-sm-2 control-label requerido'));

$opc = array('' => 'Selecciona');
foreach ($paises->result() as $val) {
	$opc[$val->id_pais] = $val->pais;
}

echo '<div class="col-sm-4">';
echo form_dropdown('pais_revista', $opc, (isset($revista->pais) ? $revista->pais : ""), 'id="pais_revista" class="form-control"');
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Estado', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'entidad_revista',
		'name'	=>	'entidad_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->entidad) ? $revista->entidad : "")
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Delegación / municipio', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'municipio_revista',
		'name'	=>	'municipio_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->municipio) ? $revista->municipio : "")
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Ciudad', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'ciudad_revista',
		'name'	=>	'ciudad_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->ciudad) ? $revista->ciudad : "")
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Código postal', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'cp_revista',
		'name'	=>	'cp_revista',
		'class'	=>	'form-control',
		'value'	=>	(isset($revista->codigo_postal) ? $revista->codigo_postal : "")
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo form_fieldset_close();

echo form_fieldset('Datos del editor de la revista');
echo '<div class="form-group">';
echo form_label('Grado', '', array('class' => 'col-sm-2 control-label requerido'));
$opc = array('' => 'Selecciona');
foreach ($grado_academico->result() as $val) {
	$opc[$val->id_grado_academico] = $val->grado_academico;
}

echo '<div class="col-sm-4">';
echo form_dropdown('grado_editor', $opc, (isset($editor->grado_academico) ? $editor->grado_academico : ""), 'id="grado_editor" class="form-control"');
echo '</div>';

echo form_label('Cargo', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'cargo_editor',
		'name'	=>	'cargo_editor',
		'class'	=>	'form-control',
		'value'	=>	(isset($editor->cargo) ? $editor->cargo : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Nombre', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'nombre_editor',
		'name'	=>	'nombre_editor',
		'class'	=>	'form-control',
		'readonly'=>'readonly',
		'value'	=>	(isset($editor->nombre) ? $editor->nombre : $usuario->nombre)
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Apellido paterno', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'ap_paterno_editor',
		'name'	=>	'ap_paterno_editor',
		'class'	=>	'form-control',
		'readonly'=>'readonly',
		'value'	=>	(isset($editor->ap_paterno) ? $editor->ap_paterno : $usuario->ap_paterno)
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Apellido materno', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'ap_materno_editor',
		'name'	=>	'ap_materno_editor',
		'class'	=>	'form-control',
		'readonly'=>'readonly',
		'value'	=>	(isset($editor->ap_materno) ? $editor->ap_materno : $usuario->ap_materno)
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Correo electrónico', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'correo_editor',
		'name'	=>	'correo_editor',
		'class'	=>	'form-control',
		'readonly'=>'readonly',
		'value'	=>	(isset($editor->correo) ? $editor->correo : $usuario->correo)
);	
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Teléfono', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
		'id'	=>	'telefono_editor',
		'name'	=>	'telefono_editor',
		'class'	=>	'form-control',
		'value'	=>	(isset($editor->telefono) ? $editor->telefono : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);

$attr = array(
		'id'	=>	'hdn_editor',
		'name'	=>	'hdn_editor',
		'type'	=>	'hidden',
		'value'	=>	(isset($editor->id_editor) ? $editor->id_editor : "")
);
echo form_input($attr);
echo '</div>';

echo form_label('Carta de postulación', '', array('class' => 'col-sm-2 control-label requerido'));
$attr = array(
	'id'	=>	'carta_postulacion',
	'name'	=>	'carta_postulacion',
	'class'	=>	'filestyle',
	'data-buttonText'	=>	'Buscar archivo'
);
echo '<div class="col-sm-4">';

if($solicitud && $solicitud->ruta_carta_postulacion) {
	echo '<div class="texto-documento">';
	echo $solicitud->ruta_carta_postulacion;
	echo '<span class="glyphicon glyphicon-remove quitar-elemento"></span>';
	echo '</div>';
	echo '<script>$(function() {$("#carta_postulacion").prop("disabled", true);});</script>';
	echo '<script>$(function() {$("#carta_postulacion").next(".bootstrap-filestyle").css("display", "none");});</script>';
}

echo form_upload($attr);

if($solicitud && $solicitud->ruta_carta_postulacion) {
	echo '<div class="conservar-documento">';
	echo 'Conservar archivo guardado';
	echo '<span class="glyphicon glyphicon-ok conservar-elemento"></span>';
	echo '</div>';
}
echo '</div>';

echo '</div>';
echo form_fieldset_close();

echo form_fieldset("Acceso temporal al sistema de gestión editorial", 'class="acceso-temporal"');
echo '<div class="form-group">';
echo form_label('URL del sistema de gestión', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'url_sistema_gestion',
		'name'	=>	'url_sistema_gestion',
		'class'	=>	'form-control',
		'placeholder'=>'http://www.ejemplo.com',
		'value'	=>	(isset($solicitud->url_sistema_gestion) ? $solicitud->url_sistema_gestion : "")
);
echo '<div class="col-sm-10">';
echo form_input($attr);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo form_label('Usuario', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'usr_temporal',
		'name'	=>	'usr_temporal',
		'class'	=>	'form-control',
		'value'	=>	(isset($solicitud->usr_temporal) ? $solicitud->usr_temporal : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';

echo form_label('Contraseña', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'psw_temporal',
		'name'	=>	'psw_temporal',
		'class'	=>	'form-control',
		'value'	=>	(isset($solicitud->usr_temporal) ? $solicitud->usr_temporal : "")
);
echo '<div class="col-sm-4">';
echo form_input($attr);
echo '</div>';
echo '</div>';
echo form_fieldset_close();
?>