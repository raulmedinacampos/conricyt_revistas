<?php
	$promedio = 0;
	
	foreach($evaluaciones->result() as $evaluacion) {
		$promedio += $evaluacion->calificacion;
	}
	
	$promedio = $promedio / $evaluaciones->num_rows();
?>
<h3>Resultados de la evaluación</h3>
<h5><strong>Nombre de la revista: </strong><?php echo $revista->nombre; ?></h5>
<h5><strong>Institución: </strong><?php echo $revista->institucion; ?></h5>
<h5><strong>Editor de la revista: </strong><?php echo trim($editor->nombre." ".$editor->ap_paterno." ".$editor->ap_materno); ?></h5>
<h5><strong>Área: </strong><?php echo $area->area_conocimiento; ?></h5>
<h5><strong>Disciplina: </strong><?php echo $revista->disciplina; ?></h5>
<h5><strong>Promedio de la evaluación: </strong><?php echo number_format($promedio, 2); ?></h5>
<h5><strong>Dictamen: </strong><?php echo $dictamen->dictamen; ?></h5>
<h5><strong>Comentarios del comité: </strong><?php echo nl2br($dictamen->comentarios); ?></h5>
<div class="panel panel-primary" style="margin: 20px 0 25px;">
  <div class="panel-heading">
    <h3 class="panel-title">Resumen de las evaluaciones</h3>
  </div>
  	<table class="table table-condensed table-striped">
  	  <tr>
  	  	<th>#</th>
  	  	<th>Evaluador</th>
  	  	<th>Calificación</th>
  	  	<th>Comentarios</th>
  	  	<th></th>
  	  </tr>
  	  <?php
  	  $i = 1;
  	  foreach($evaluaciones->result() as $evaluacion) {
  	  ?>
  	  <tr>
  	  	<td><?php echo $i; ?></td>
  	  	<td style="white-space: nowrap;"><?php echo "Evaluador $i"; ?></td>
  	  	<td><?php echo number_format($evaluacion->calificacion, 2); ?></td>
  	  	<td><?php echo nl2br($evaluacion->comentarios); ?></td>
  	  	<td></td>
  	  </tr>
  	  <?php
  	  	$i++;
  	  }
  	  ?>
  	</table>
</div>