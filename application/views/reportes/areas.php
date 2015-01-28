<h3>Reporte por área de conocimiento</h3>
<?php
foreach($areas->result() as $area) {
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $area->area_conocimiento; ?></h3>
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
	  	
	  	if($area->id_area_conocimiento == $revista->area_conocimiento) {
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
  			<td colspan="3">No hay revistas pertenecientes a esta área</td>
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