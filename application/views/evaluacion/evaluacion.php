<?php
//print_r($evaluaciones->result());
?>
<h4>Resultados de las evaluaciones</h4>
<?php
foreach($areas->result() as $area) {
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo (($area->num_area) ? "Área $area->num_area. " : "").$area->area_conocimiento; ?></h3>
	</div>
	<table class="table table-condensed table-striped">
	<?php
	foreach($revistas->result() as $revista) {
		if($revista->area_conocimiento == $area->id_area_conocimiento) {
	?>
		<tr>
			<td style="text-align: left;">
				<h5><strong>Revista: </strong><a href="<?php echo base_url('representante-comite/dictamen/'.$revista->id_solicitud); ?>"><?php echo $revista->nombre; ?></a></h5>
				<?php
				$calificacion = "";
				$contador = 0;
				
				foreach($evaluaciones->result() as $evaluacion) {
					if($evaluacion->solicitud == $revista->id_solicitud) {
						$calificacion += $evaluacion->calificacion;
						$contador++;
					}
				}
				
				$calificacion = $calificacion / $contador;
				?>
				<strong>Calificación final: </strong><?php echo number_format($calificacion, 2); ?><br />
				<strong>Calificaciones parciales:</strong><br />
				<ul>
				<?php
				foreach($evaluaciones->result() as $evaluacion) {
					if($evaluacion->solicitud == $revista->id_solicitud) {
				?>
					<li><?php echo trim($evaluacion->nombre." ".$evaluacion->ap_paterno." ".$evaluacion->ap_materno)." - ".number_format($evaluacion->calificacion, 2); ?></li>
				<?php
					}
				}
				?>
				</ul>
			</td>
		</tr>
	<?php
		}
	}
	?>
	</table>
</div>
<?php
}
?>