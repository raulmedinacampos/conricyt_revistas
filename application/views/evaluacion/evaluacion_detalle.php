<h4>Vista previa de la evaluación</h4>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Información general</h3>
  </div>
  <div class="panel-body">
  	<table class="table table-condensed table-striped">
  	  <tr>
  	  	<td>Fecha: <strong><?php echo $evaluacion->fecha_evaluacion; ?></strong></td>
  	  </tr>
  	  <tr>
  	  	<td>Fondo: <strong>R0001</strong></td>
  	  </tr>
  	  <tr>
  	  	<td>Convocatoria: <strong>2014-2015</strong></td>
  	  </tr>
  	  <tr>
  	  	<td>Solicitud: <strong><?php echo $solicitud->folio; ?></strong></td>
  	  </tr>
  	  <tr>
  	  	<td>Nombre de la revista: <strong><?php echo $solicitud->revista; ?></td>
  	  </tr>
  	  <tr>
  	  	<td>Evaluador: <strong><?php echo trim($evaluador->nombre." ".$evaluador->ap_paterno." ".$evaluador->ap_materno); ?></td>
  	  </tr>
  	  <tr>
  	  	<td><a href="<?php echo base_url('revista/detalle/'.$id_revista); ?>"><span class="btn btn-xs btn-warning">Datos y documentos de la revista</span></a></td>
  	  </tr>
  	  </table>
  </div>
</div>
<?php
$i = 1;

foreach($secciones->result() as $seccion) {
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo "Sección $i: $seccion->seccion"; ?></h3>
  </div>
  <div class="panel-body">
  <?php
  foreach($subsecciones->result() as $subseccion) {
  	if($seccion->id_seccion == $subseccion->seccion) {
  		echo "<h5><strong>$subseccion->subseccion</strong></h5>";
  		$p = 1;
  		
  		foreach($preguntas as $pregunta) {
  			if($subseccion->id_subseccion == $pregunta->subseccion) {
		  		$respuesta = "Esta pregunta no ha sido respondida";
		  		switch($pregunta->tipo_pregunta) {
		  			case 1:
		  				if(isset($pregunta->opcion)) {
		  					switch($pregunta->opcion) {
		  						case 0:
		  							$respuesta = "No";
		  							break;
		  						case 1:
		  							$respuesta = "Sí";
		  							break;
		  						default:
		  							break;
		  					}
		  				}
		  				break;
		  			case 4:
		  				if(isset($pregunta->opcion)) {
		  					switch($pregunta->opcion) {
		  						case 0:
		  							$respuesta = "No";
		  							break;
		  						case 1:
		  							$respuesta = "Sí";
		  							break;
		  						default:
		  							break;
		  					}
		  				}
		  				break;
		  			case 5:
		  				if(isset($pregunta->opcion)) {
		  					switch($pregunta->opcion) {
		  						case 0:
		  							$respuesta = "Definitivamente debe mejorar";
		  							break;
		  						case 0.33:
		  							$respuesta = " Regular";
		  							break;
		  						case 0.67:
		  							$respuesta = "Buena";
		  							break;
		  						case 1:
		  							$respuesta = "Muy buena";
		  							break;
		  						default:
		  							break;
		  					}
		  				}
		  				break;
		  			case 7:
		  				if(isset($pregunta->opcion)) {
		  					switch($pregunta->opcion) {
		  						case 0:
		  							$respuesta = "Definitivamente no";
		  							break;
		  						case 0.33:
		  							$respuesta = "No es claro";
		  							break;
		  						case 0.67:
		  							$respuesta = "Claramente";
		  							break;
		  						case 1:
		  							$respuesta = "Muy claramente";
		  							break;
		  						default:
		  							break;
		  					}
		  				}
		  				break;
		  				case 8:
		  					if(isset($pregunta->opcion)) {
		  						switch($pregunta->opcion) {
		  							case 0:
		  								$respuesta = "Descuidado y sin calidad";
		  								break;
		  							case 0.5:
		  								$respuesta = "Cuidado pero faltó calidad";
		  								break;
		  							case 1:
		  								$respuesta = "Muy cuidado y de buena calidad";
		  								break;
		  							default:
		  								break;
		  						}
		  					}
		  				break;
		  			default:
		  				break;
		  		}
  ?>
    <p><?php echo "<em>Pregunta $p.</em> $pregunta->pregunta"; ?></p>
  	<p>Respuesta:<br />
  	<strong><?php echo $respuesta; ?></strong></p>
  	<?php
  	if($pregunta->tipo_pregunta == 1 || $pregunta->tipo_pregunta == 5 || $pregunta->tipo_pregunta == 7 || $pregunta->tipo_pregunta == 8) {
  	?>
    <p>Justificación:<br />
  	<strong><?php echo (isset($pregunta->justificacion)) ? $pregunta->justificacion : "Falta justificar la respuesta"; ?></strong></p>
  	<?php
  	}
  			$p++;
  			}
  		}
  	}
  }
  
  $p = 1;
  foreach($preguntas as $pregunta) {
  	if($pregunta->seccion == $seccion->id_seccion && !$pregunta->subseccion) {
  		$respuesta = "Esta pregunta no ha sido respondida";
  		switch($pregunta->tipo_pregunta) {
  			case 7:
  				if(isset($pregunta->opcion)) {
  					switch($pregunta->opcion) {
  						case 0:
  							$respuesta = "Definitivamente no";
  							break;
		  				case 0.33:
		  					$respuesta = "No es claro";
		  					break;
		  				case 0.67:
		  					$respuesta = "Claramente";
		  					break;
		  				case 1:
		  					$respuesta = "Muy claramente";
		  					break;
		  				default:
		  					break;
		  			}
		  		}
		  		break;
		  	default:
		  		break;
		}
  		?>
  		<p><?php echo "<em>Pregunta $p.</em> $pregunta->pregunta"; ?></p>
	  	<p>Respuesta:<br />
	  	<strong><?php echo $respuesta; ?></strong></p>
	  	<?php
	  	if($pregunta->tipo_pregunta == 1 || $pregunta->tipo_pregunta == 7) {
	  	?>
	    <p>Justificación:<br />
	  	<strong><?php echo (isset($pregunta->justificacion)) ? $pregunta->justificacion : "Falta justificar la respuesta"; ?></strong></p>
  		<?php
	  	}
  		$p++;
  	}
  }
  ?>
  </div>
</div>
<?php
	$i++;
}
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Comentario de la evaluación</h3>
  </div>
  <div class="panel-body">
  	<p><?php echo $evaluacion->comentarios; ?></p>
  </div>
</div>