<?php
$contSeccion = 1;

echo form_open('');
echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

foreach($secciones->result() as $seccion) {
	$contPregunta = 1;
	$claseIn = "";
	$claseCollapse = "";
	echo '<div class="panel panel-primary">';
	
	$claseCollapse = ($seccion->id_seccion != 1) ? 'class="collapsed"' : '';
	echo '<div class="panel-heading" role="tab" id="heading'.$seccion->id_seccion.'">';
	echo '<h4 class="panel-title">';
	echo '<a '.$claseCollapse.' data-toggle="collapse" data-parent="#accordion" href="#collapse'.$seccion->id_seccion.'" aria-expanded="true" aria-controls="collapse'.$seccion->id_seccion.'">';
	echo 'Sección '.$contSeccion.': '.$seccion->seccion.'. Ponderación '.$seccion->ponderacion.'%';
	echo '</a>';
	echo '</h4>';
	echo '</div>';
	
	$claseIn = ($seccion->id_seccion == 1) ? "in" : "";
	echo '<div id="collapse'.$seccion->id_seccion.'" class="panel-collapse collapse '.$claseIn.'" role="tabpanel" aria-labelledby="heading'.$seccion->id_seccion.'">';
	echo '<div class="panel-body">';
	
	foreach($subsecciones->result() as $sub) {
		$contPregunta = 1;
		if($sub->seccion == $seccion->id_seccion) {
			echo '<h5>'.$sub->subseccion.'</h5>';
			
			foreach($preguntas->result() as $pregunta) {
				if($pregunta->subseccion == $sub->id_subseccion) {
					echo '<p>Pregunta '.str_pad($contPregunta, 2, "0", STR_PAD_LEFT) .'</p>';
					echo '<p>'.$pregunta->pregunta.'</p>';
					$contPregunta++;
					
					switch($pregunta->tipo_pregunta) {
						case 1:
							$attr = array(
								'id'	=>	'rdb_'.$pregunta->id_pregunta.'_s',
								'name'	=>	'rdb_'.$pregunta->id_pregunta,
								'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 1
							);
							echo form_label(form_radio($attr)." Sí", '', array('class' => 'radio-inline'));
							
							$attr = array(
								'id'	=>	'rdb_'.$pregunta->id_pregunta.'_n',
								'name'	=>	'rdb_'.$pregunta->id_pregunta,
								'value'	=>	0
							);
							echo form_label(form_radio($attr)." No", '', array('class' => 'radio-inline'));
							echo '<div class="form-group">';
							$attr = array(
								'id'	=>	'txt_'.$pregunta->id_pregunta,
								'name'	=>	'txt_'.$pregunta->id_pregunta,
								'class'	=>	'form-control',
								'rows'	=>	'3'
							);
							echo form_label("Argumento:");
							echo form_textarea($attr);
							echo '</div>';
							break;
						case 2:
							foreach($opciones->result() as $opcion) {
								if($pregunta->id_pregunta == $opcion->pregunta) {
									echo '<div class="checkbox">';
									echo form_label(form_checkbox()." ".$opcion->opcion);
									echo '</div>';
								}
							}
							break;
						case 3:
							$contPreguntaHija = 1;
							foreach($preguntas_hijas->result() as $ph) {
								if($pregunta->id_pregunta == $ph->padre) {
									echo '<p>'.$contPreguntaHija.". ".$ph->pregunta.'</p>';
									
									switch($ph->tipo_pregunta) {
										case 1:
											$attr = array(
												'id'	=>	'rdb_'.$ph->id_pregunta.'_s',
												'name'	=>	'rdb_'.$ph->id_pregunta,
												'value'	=>	(isset($ph->puntos_asignados)) ? $ph->puntos_asignados : 1
											);
											echo form_label(form_radio($attr)." Sí", '', array('class' => 'radio-inline'));
											
											$attr = array(
												'id'	=>	'rdb_'.$ph->id_pregunta.'_n',
												'name'	=>	'rdb_'.$ph->id_pregunta,
												'value'	=>	0
											);
											echo form_label(form_radio($attr)." No", '', array('class' => 'radio-inline'));
											echo '<div class="form-group">';
											$attr = array(
												'id'	=>	'txt_'.$ph->id_pregunta,
												'name'	=>	'txt_'.$ph->id_pregunta,
												'class'	=>	'form-control',
												'rows'	=>	'3'
											);
											echo form_label("Argumento:");
											echo form_textarea($attr);
											echo '</div>';
											break;
										case 2:
											foreach($opciones->result() as $opcion) {
												if($ph->id_pregunta == $opcion->pregunta) {
													echo '<div class="checkbox">';
													echo form_label(form_checkbox()." ".$opcion->opcion);
													echo '</div>';
												}
											}
											break;
										case 5:
											$attr = array(
												'id'	=>	'rdb_'.$ph->id_pregunta.'_completo',
												'name'	=>	'rdb_'.$ph->id_pregunta,
												'value'	=>	(isset($ph->puntos_asignados)) ? $ph->puntos_asignados : 2
											);
											echo form_label(form_radio($attr)." Completo", '', array('class' => 'radio-inline'));
											
											$attr = array(
												'id'	=>	'rdb_'.$ph->id_pregunta.'_parcial',
												'name'	=>	'rdb_'.$ph->id_pregunta,
												'value'	=>	(isset($ph->puntos_asignados)) ? $ph->puntos_asignados : 1
											);
											echo form_label(form_radio($attr)." Parcial", '', array('class' => 'radio-inline'));
											
											$attr = array(
												'id'	=>	'rdb_'.$ph->id_pregunta.'_pobre',
												'name'	=>	'rdb_'.$ph->id_pregunta,
												'value'	=>	0
											);
											echo form_label(form_radio($attr)." Pobre", '', array('class' => 'radio-inline'));
											break;
										case 6:
											foreach($opciones->result() as $opcion) {
												if($ph->id_pregunta == $opcion->pregunta) {
													$attr = array(
														'id'	=>	'rdb_'.$ph->id_pregunta.'_s',
														'name'	=>	'rdb_'.$ph->id_pregunta,
														'value'	=>	(isset($ph->puntos_asignados)) ? $ph->puntos_asignados : 1
													);
													echo form_label(form_radio($attr)." ".$opcion->opcion, '', array('class' => 'radio-inline'));
												}
											}
											break;
										default:
											break;
									}
									$contPreguntaHija++;
								}
							}
							break;
						default:
							break;
					}
				}
			}
		}
	}
	
	$contSeccion++;
	
	foreach($preguntas->result() as $pregunta) {
		if($pregunta->seccion == $seccion->id_seccion && !$pregunta->subseccion) {
			echo '<p>Pregunta '.str_pad($contPregunta, 2, "0", STR_PAD_LEFT) .'</p>';
			echo '<p>'.$pregunta->pregunta.'</p>';
			$contPregunta++;
			
			switch($pregunta->tipo_pregunta) {
				case 1:
					$attr = array(
						'id'	=>	'rdb_'.$pregunta->id_pregunta.'_s',
						'name'	=>	'rdb_'.$pregunta->id_pregunta,
						'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 1
					);
					echo form_label(form_radio($attr)." Sí", '', array('class' => 'radio-inline'));
					
					$attr = array(
						'id'	=>	'rdb_'.$pregunta->id_pregunta.'_n',
						'name'	=>	'rdb_'.$pregunta->id_pregunta,
						'value'	=>	0
					);
					echo form_label(form_radio($attr)." No", '', array('class' => 'radio-inline'));
					echo '<div class="form-group">';
					$attr = array(
						'id'	=>	'txt_'.$pregunta->id_pregunta,
						'name'	=>	'txt_'.$pregunta->id_pregunta,
						'class'	=>	'form-control',
						'rows'	=>	'3'
					);
					echo form_label("Argumento:");
					echo form_textarea($attr);
					echo '</div>';
					break;
				case 2:
					foreach($opciones->result() as $opcion) {
						if($pregunta->id_pregunta == $opcion->pregunta) {
							echo '<div class="checkbox">';
							echo form_label(form_checkbox()." ".$opcion->opcion);
							echo '</div>';
						}
					}
					break;
				case 3:
					foreach($preguntas_hijas->result() as $ph) {
						if($pregunta->id_pregunta == $ph->padre) {
							echo '<p>- '.$ph->pregunta.'</p>';
							
							switch($ph->tipo_pregunta) {
								case 4:
									$attr = array(
									'id'	=>	'rdb_'.$ph->id_pregunta.'_s',
									'name'	=>	'rdb_'.$ph->id_pregunta,
									'value'	=>	(isset($ph->puntos_asignados)) ? $ph->puntos_asignados : 1
									);
									echo form_label(form_radio($attr)." Sí", '', array('class' => 'radio-inline'));
							
									$attr = array(
											'id'	=>	'rdb_'.$ph->id_pregunta.'_n',
											'name'	=>	'rdb_'.$ph->id_pregunta,
											'value'	=>	0
									);
									echo form_label(form_radio($attr)." No", '', array('class' => 'radio-inline'));
									break;
								case 5:
									$attr = array(
									'id'	=>	'rdb_'.$ph->id_pregunta.'_completo',
									'name'	=>	'rdb_'.$ph->id_pregunta,
									'value'	=>	(isset($ph->puntos_asignados)) ? $ph->puntos_asignados : 2
									);
									echo form_label(form_radio($attr)." Completo", '', array('class' => 'radio-inline'));
							
									$attr = array(
											'id'	=>	'rdb_'.$ph->id_pregunta.'_parcial',
											'name'	=>	'rdb_'.$ph->id_pregunta,
											'value'	=>	(isset($ph->puntos_asignados)) ? $ph->puntos_asignados : 1
									);
									echo form_label(form_radio($attr)." Parcial", '', array('class' => 'radio-inline'));
							
									$attr = array(
											'id'	=>	'rdb_'.$ph->id_pregunta.'_pobre',
											'name'	=>	'rdb_'.$ph->id_pregunta,
											'value'	=>	0
									);
									echo form_label(form_radio($attr)." Pobre", '', array('class' => 'radio-inline'));
									break;
								default:
									break;
							}
						}
					}
					break;
				case 5:
					$attr = array(
						'id'	=>	'rdb_'.$pregunta->id_pregunta.'_completo',
						'name'	=>	'rdb_'.$pregunta->id_pregunta,
						'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 2
					);
					echo form_label(form_radio($attr)." Completo", '', array('class' => 'radio-inline'));
			
					$attr = array(
							'id'	=>	'rdb_'.$pregunta->id_pregunta.'_parcial',
							'name'	=>	'rdb_'.$pregunta->id_pregunta,
							'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 1
					);
					echo form_label(form_radio($attr)." Parcial", '', array('class' => 'radio-inline'));
			
					$attr = array(
							'id'	=>	'rdb_'.$pregunta->id_pregunta.'_pobre',
							'name'	=>	'rdb_'.$pregunta->id_pregunta,
							'value'	=>	0
					);
					echo form_label(form_radio($attr)." Pobre", '', array('class' => 'radio-inline'));
					break;
				default:
					break;
			}
		}
	}
	
	echo '</div>';  // Contenedor panel body
	echo '</div>';  // Panel colapsable
	echo '</div>';  // Contenedor principal
}

echo '</div>';
echo form_close();
?>