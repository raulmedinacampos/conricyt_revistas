<script type="text/javascript" src="<?php echo base_url('scripts/dictamen.js')?>"></script>
<h3>Dictamen de la revista</h3>
<h5><strong>Nombre de la revista: </strong><?php echo $revista->nombre; ?></h5>
<h5><strong>Institución: </strong><?php echo $revista->institucion; ?></h5>
<h5><strong>Editor de la revista: </strong><?php echo $revista->editor; ?></h5>
<h5><strong>Área: </strong><?php echo $revista->area_conocimiento; ?></h5>
<h5><strong>Disciplina: </strong><?php echo $revista->disciplina; ?></h5>
<h5><strong>Evaluación ponderada: </strong><?php echo number_format($promedio, 2); ?></h5>
<div class="panel panel-primary" style="margin: 20px 0 25px;">
  <div class="panel-heading">
    <h3 class="panel-title">Resumen de las evaluaciones</h3>
  </div>
  	<table class="table table-condensed table-striped">
  	  <tr>
  	  	<th>#</th>
  	  	<th>Evaluador</th>
  	  	<th>Calificación</th>
  	  	<th>Ver evaluación</th>
  	  	<th>Estatus</th>
  	  	</tr>
  	  <?php
  	  $i = 1;
  	  $estatus = "Pendiente";
  	  
  	  foreach($evaluaciones->result() as $evaluacion) {
  	  	if($evaluacion->estatus == 1) {
  	  		$estatus = "En proceso";
  	  	} else if($evaluacion->estatus == 5) {
  	  		$estatus = "Finalizada";
  	  	}
  	  ?>
  	  <tr>
  	  	<th><?php echo $i; ?></th>
  	  	<td><?php echo trim($evaluacion->nombre." ".$evaluacion->ap_paterno." ".$evaluacion->ap_materno); ?></td>
  	  	<td><?php echo number_format($evaluacion->calificacion, 2); ?></td>
  	  	<td><?php echo '<a href="'.base_url('representante-comite/vista-evaluacion/'.$evaluacion->id_evaluacion).'" target="_blank">Ver evaluación</a>'; ?></td>
  	  	<td><?php echo $estatus; ?></td>
  	  	</tr>
  	  <?php
  	  	$i++;
  	  }
  	  ?>
  	</table>
</div>
<?php
$attr = array(
		'id'	=>	'formDictamen',
		'name'	=>	'formDictamen',
		'class'	=>	'form-horizontal'
);

echo form_open('representante-comite/guardarDictamen', $attr);
echo '<div class="form-group">';
echo form_label('Dictamen:', '', array('class' => 'col-sm-1 control-label'));
$opt = array('' => 'Seleccione');
foreach($tipos_dictamen->result() as $val) {
	$opt[$val->id_dictamen] = $val->dictamen;
}
echo '<div class="col-sm-3">';
$extra = 'id="dictamen" class="form-control"';
if($dictamen && $dictamen->estatus == 5) {
	$extra .= ' readonly="readonly"';
}
echo form_dropdown('dictamen', $opt, (isset($dictamen->id_dictamen)) ? $dictamen->id_dictamen : "", $extra);
echo '<br/>';

$attr = array(
		'id'	=>	'hdnDictamen',
		'name'	=>	'hdnDictamen',
		'value'	=>	(isset($dictamen->id)) ? $dictamen->id : "",
		'type'	=>	'hidden'
);
echo form_input($attr);

$attr = array(
		'id'	=>	'hdnFinalizar',
		'name'	=>	'hdnFinalizar',
		'value'	=>	'',
		'type'	=>	'hidden'
);
echo form_input($attr);

$attr = array(
		'id'	=>	'btnGuardar',
		'name'	=>	'btnGuardar',
		'content'=>	'Guardar fallo',
		'class'	=>	'btn btn-primary'
);

if($dictamen && $dictamen->estatus == 5) {
	$attr = array(
			'id'	=>	'btnImprimir',
			'name'	=>	'btnImprimir',
			'content'=>	'Imprimir hoja de dictamen final',
			'class'	=>	'btn btn-primary'
	);
}

echo form_button($attr);

if($dictamen && $dictamen->estatus == 1) {
	$attr = array(
			'id'	=>	'btnFinalizar',
			'name'	=>	'btnFinalizar',
			'content'=>	'Finalizar dictamen',
			'class'	=>	'btn btn-primary'
	);
	
	echo "<br /><br />";
	echo form_button($attr);
}
echo '</div>';

echo form_label('Comentarios:', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
		'id'	=>	'comentarios',
		'name'	=>	'comentarios',
		'class'	=>	'form-control',
		'rows'	=>	3,
		'value'	=>	(isset($dictamen->comentarios)) ? $dictamen->comentarios : ""
);
if($dictamen && $dictamen->estatus == 5) {
	$attr['readonly'] = "readonly";
}
echo '<div class="col-sm-6">';
echo form_textarea($attr);

$attr = array(
		'id'	=>	'hdnSolicitud',
		'name'	=>	'hdnSolicitud',
		'value'	=>	(isset($solicitud)) ? $solicitud : "",
		'type'	=>	'hidden'
);
echo form_input($attr);

$attr = array(
		'id'	=>	'hdnEvaluador',
		'name'	=>	'hdnEvaluador',
		'value'	=>	(isset($evaluador)) ? $evaluador : "",
		'type'	=>	'hidden'
);
echo form_input($attr);
echo '</div>';
echo '</div>';  // form-group

echo form_close();

if($dictamen) {
	$attr = array(
			'id'	=>	'formImprimir',
			'name'	=>	'formImprimir',
			'class'	=>	'form-horizontal'
	);
	
	echo form_open('representante-comite/generarComprobante', $attr);
	$attr = array(
			'id'	=>	'hdnSolicitud2',
			'name'	=>	'hdnSolicitud2',
			'value'	=>	(isset($solicitud)) ? $solicitud : "",
			'type'	=>	'hidden'
	);
	echo form_input($attr);
	echo form_close();
}
?>
<div class="modal fade" id="mensajesError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <ul></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Continuar</button>
      </div>
    </div>
  </div>
</div>