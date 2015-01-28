<h3>Reporte por institución</h3>
<table class="table table-condensed table-striped">
	<tbody>
		<tr>
			<th>#</th>
			<th>Institución</th>
			<th>Nombre de la revista</th>
			<th>&nbsp;</th>
		</tr>
	<?php
		if ($revistas) {
			$i = 1;
			foreach ( $revistas->result () as $revista ) {
	?>
        <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $revista->institucion; ?></td>
			<td><?php echo $revista->nombre; ?></td>
			<td>&nbsp;</td>
		</tr>
        <?php
				$i ++;
			}
		} else {
		?>
	  <tr>
			<td colspan="3">No hay revistas registradas</td>
		</tr>
	<?php
		}
	?>
  </tbody>
</table>