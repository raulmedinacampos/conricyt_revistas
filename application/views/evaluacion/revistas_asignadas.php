<script type="text/javascript">
$(function() {
	$("#formRevistas a").click(function(e) {
		e.preventDefault();
		var solicitud = $(this).data('id');
		var evaluacion = $(this).data('ev');
		$("#hdnSolicitud").val(solicitud);
		$("#hdnEvaluacion").val(evaluacion);
		$("#formRevistas").submit();
	});
});
</script>

<h3>Bienvenido(a) <?php echo $usuario->nombre." ".$usuario->ap_paterno." ".$usuario->ap_materno; ?></h3>
<h3>Revistas asignadas para su evaluación</h3>
<?php
$attr = array(
		'id'	=>	'formRevistas',
		'name'	=>	'formRevistas',
		'class'	=>	'form-horizontal'
);
echo form_open(base_url('evaluador/evaluacion'), $attr);

$attr = array(
		'id'	=>	'hdnSolicitud',
		'name'	=>	'hdnSolicitud',
		'type'	=>	'hidden'
);
echo form_input($attr);

$attr = array(
		'id'	=>	'hdnEvaluacion',
		'name'	=>	'hdnEvaluacion',
		'type'	=>	'hidden'
);
echo form_input($attr);
?>
<table class="table table-bordered table-condensed table-striped">
  <tbody>
    <tr>
      <th>#</th>
      <th>Nombre de la revista</th>
      <th>Institución</th>
      <th>Estatus</th>
    </tr>
    <?php
	$i = 1;
	$estatus = "";
	
	foreach($revistas as $revista) {
		switch($revista->estatus) {
			case 0:
				$estatus = "Pendiente";
				break;
			case 1:
				$estatus = "En proceso";
				break;
			case 5:
				$estatus = "Finalizada";
				break;
			default:
				break;
		}
	?>
    <tr>
      <th><?php echo $i; ?></th>
      <td><a href="<?php echo base_url('evaluador/evaluacion')?>" data-id="<?php echo $revista->id_solicitud; ?>" data-ev="<?php echo $revista->id_evaluacion; ?>"><?php echo $revista->nombre; ?></a></td>
      <td><?php echo $revista->institucion; ?></td>
      <td><?php echo $estatus; ?></td>
    </tr>
    <?php
    	$i++;
	}
	?>
  </tbody>
</table>
<?php
echo form_close();
?>