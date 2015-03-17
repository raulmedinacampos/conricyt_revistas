<script type="text/javascript">
$(function() {
	$("#formRevistas #evaluacion a").click(function(e) {
		e.preventDefault();
		var solicitud = $(this).data('id');
		$("#hdnSolicitud2").val(solicitud);
		$("#formRevistas").submit();
	});
});
</script>

<?php
$attr = array(
		'id'	=>	'formRevistas',
		'name'	=>	'formRevistas',
		'class'	=>	'form-horizontal'
);
echo form_open(base_url('representante-comite/generarComprobante'), $attr);

$attr = array(
		'id'	=>	'hdnSolicitud2',
		'name'	=>	'hdnSolicitud2',
		'type'	=>	'hidden'
);
echo form_input($attr);

$attr = array(
		'id'	=>	'hdnRenovacion',
		'name'	=>	'hdnRenovacion',
		'value'	=>	'1',
		'type'	=>	'hidden'
);
echo form_input($attr);
?>
<h3>Revistas de renovación automática</h3>
<div id="evaluacion" class="panel panel-primary">
  <div class="panel-heading">
  	<h3 class="panel-title">Revistas de renovación automática</h3>
  </div>
  <table class="table">
    <tr>
      <th>#</th>
      <th>Nombre de la revista</th>
      <th>Institución</th>
      <th>Área de conocimiento</th>
    </tr>
    <?php
	$i = 1;
	
	if($revistas) {
		foreach($revistas->result() as $revista) {
	?>
    <tr>
      <th><?php echo $i; ?></th>
      <td><a href="<?php echo base_url('representante-comite/generarComprobante')?>" data-id="<?php echo $revista->id_solicitud; ?>"><?php echo $revista->nombre; ?></a></td>
      <td><?php echo $revista->institucion; ?></td>
      <td><?php echo $revista->area_conocimiento; ?></td>
    </tr>
    <?php
    	$i++;
		}
	} else {
	?>
    <tr>
      <th colspan="4">No hay evaluaciones asignadas</th>
    </tr>  
    <?php
	}
	?>
  </table>
</div>
<?php
echo form_close();
?>