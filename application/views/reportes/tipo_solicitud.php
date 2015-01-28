<h3>Reporte por tipo de solicitud</h3>
<?php
foreach($tipos_solicitudes->result() as $tipo_solicitud) {
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $tipo_solicitud->tipo_solicitud; ?></h3>
  </div>
  <table class="table table-condensed table-striped">
    <tbody>
      <tr>
        <th>#</th>
        <th>Nombre de la revista</th>
        <th>&nbsp;</th>
      </tr>
  <?php
  if($revistas) {
	  $i = 1;
	  foreach($revistas->result() as $revista) {
	  	
	  	if($tipo_solicitud->id_tipo_solicitud == $revista->tipo_solicitud) {
	  ?>
	      <tr>
	        <td><?php echo $i; ?></td>
	        <td><?php echo $revista->nombre; ?></td>
	        <td>&nbsp;</td>
	      </tr>
	      <?php
	  	$i++;
	  	}
	  }
  } else {
  ?>
  		<tr>
  			<td colspan="3">No hay revistas en este rubro</td>
  		</tr>
  <?php
  }
  ?>
    </tbody>
  </table>
</div>
<?php
}
?>