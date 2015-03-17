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
	foreach($revistas as $revista) {
		if($revista->area_conocimiento == $area->id_area_conocimiento) {
	?>
		<tr>
			<td style="text-align: left;">
			<?php
			$btnDictamen = ($area_evaluador == $area->id_area_conocimiento) ? '<a href="'.base_url('representante-comite/dictamen/'.$revista->id_solicitud).'" class="btn btn-xs btn-warning">Emitir fallo</a>' : '';
			?>
				<h5><strong>Revista: </strong><?php echo $revista->nombre." ".$btnDictamen; ?></h5>
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
				<strong>Dictamen: </strong><?php echo $revista->dictamen; ?><br />
				<strong>Comentarios del comité: </strong><?php echo $revista->comentarios; ?><br />
				<strong>Evaluación ponderada: </strong><?php echo number_format($calificacion, 2); ?><br />
				<strong>Calificaciones parciales:</strong><br />
				<ul>
				<?php
				foreach($evaluaciones->result() as $evaluacion) {
					if($evaluacion->solicitud == $revista->id_solicitud) {
				?>
					<li><?php echo trim($evaluacion->nombre." ".$evaluacion->ap_paterno." ".$evaluacion->ap_materno)." - ".number_format($evaluacion->calificacion, 2).' <a href="'.base_url('representante-comite/vista-evaluacion/'.$evaluacion->id_evaluacion).'" target="_blank"><strong>(Ver evaluación)</strong></a>'; ?></li>
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