<h3>Resumen de dictámenes<a href="<?php echo base_url('reporte/dictamen/xls'); ?>"><span class="btn btn-xs btn-success" style="float: right;">Exportar a Excel</span></a></h3>

<table class="table table-condensed table-striped">
  <tbody>
    <tr>
      <th>#</th>
      <th>Nombre de la revista</th>
      <th>Área de conocimiento</th>
      <th>Tipo de solicitud</th>
      <th>Institución</th>
      <th>Dictamen</th>
      <th>Comentarios</th>
      <th></th>
      </tr>
    <?php
	$i = 1;
	
	if($dictamenes) {
		foreach($dictamenes->result() as $dictamen) {
	?>
	    <tr>
	      <th><?php echo $i; ?></th>
	      <td><?php echo $dictamen->nombre; ?></td>
	      <td><?php echo $dictamen->area_conocimiento; ?></td>
	      <td><?php echo $dictamen->tipo_solicitud; ?></td>
	      <td><?php echo $dictamen->institucion; ?></td>
	      <td><?php echo $dictamen->dictamen; ?></td>
	      <td><?php echo $dictamen->comentarios; ?></td>
	      <td></td>
	    </tr>
	<?php
	    	$i++;
		}
	}
	?>
  </tbody>
</table>