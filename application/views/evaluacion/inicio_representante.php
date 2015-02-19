<script type="text/javascript">
$(function() {
	$("#formRevistas a").click(function(e) {
		e.preventDefault();
		var solicitud = $(this).data('id');
		$("#hdnSolicitud").val(solicitud);
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
echo form_open(base_url('evaluador/evaluacion'), $attr);

$attr = array(
		'id'	=>	'hdnSolicitud',
		'name'	=>	'hdnSolicitud',
		'type'	=>	'hidden'
);
echo form_input($attr);
?>
<h3>Bienvenido(a) <?php echo $usuario->nombre." ".$usuario->ap_paterno." ".$usuario->ap_materno; ?></h3>
<div class="panel panel-primary">
  <div class="panel-heading">
  	<h3 class="panel-title">Evaluaciones propias</h3>
  </div>
  <table class="table">
    <tr>
      <th>#</th>
      <th>Nombre de la revista</th>
      <th>Institución</th>
      <th>Estatus</th>
    </tr>
    <?php
	$i = 1;
	$estatus = "Pendiente";
	
	if($revistas) {
		foreach($revistas->result() as $revista) {
			switch($revista->estatus) {
				case 1: $estatus = "En proceso";
					break;
				case 5: $estatus = "Finalizada";
					break;
				default:
					break;
			}
	?>
    <tr>
      <th><?php echo $i; ?></th>
      <td><a href="<?php echo base_url('evaluador/evaluacion')?>" data-id="<?php echo $revista->id_solicitud; ?>"><?php echo $revista->nombre; ?></a></td>
      <td><?php echo $revista->institucion; ?></td>
      <td><?php echo $estatus; ?></td>
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

<div class="panel panel-primary">
  <div class="panel-heading">
  	<h3 class="panel-title">Evaluaciones del grupo</h3>
  </div>
  <table class="table">
    <tr>
      <th>#</th>
      <th>Nombre de la revista</th>
      <?php
      foreach($evaluadores->result() as $evaluador) {
      	echo "<th>$evaluador->nombre $evaluador->ap_paterno $evaluador->ap_materno</th>";
      }
      ?>
      <th>Porcentaje parcial</th>
    </tr>
    <?php
	$i = 1;
	
	if($evaluaciones) {
		foreach($evaluaciones as $evaluacion) {
	?>
    <tr>
      <th><?php echo $i; ?></th>
      <td><?php echo $evaluacion->revista; ?></td>
      <?php
      foreach($evaluadores->result() as $evaluador) {
      	echo "<td>".$evaluacion->{'calif_estatus_'.$evaluador->id_usuario}."</td>";
      }
      ?>
      <td><?php echo $evaluacion->promedio; ?></td>
    </tr>
    <?php
    	$i++;
		}
	} else {
	?>
    <tr>
      <th colspan="<?php echo 3 + $evaluadores->num_rows(); ?>">No hay evaluaciones asignadas</th>
    </tr>  
    <?php
	}
	?>
  </table>
</div>
<?php
echo form_close();
?>