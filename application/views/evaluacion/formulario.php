<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap-datetimepicker.min.css')?>" />
<script type="text/javascript" src="<?php echo base_url('scripts/moment.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('scripts/bootstrap-datetimepicker.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('scripts/evaluacion.js')?>"></script>
<script type="text/javascript">
<?php
if($datos->estatus == 5) {
?>
function desactivarCampos() {
	$("input, textarea").prop("disabled", "disabled");
}

$(function() {
	desactivarCampos();
});
<?php
}
?>
</script>

<h3>Formato de evaluación</h3>
<?php
$attr = array(
		'id'	=>	'formDatos',
		'name'	=>	'formDatos',
		'class'	=>	'form-horizontal'
);
echo form_open(base_url(), $attr);
?>
<div class="panel panel-primary">
	<div class="panel-body">
	<?php
	echo '<div class="form-group">';
	echo form_label('Fecha:', '', array('class' => 'col-sm-4 control-label'));
	
	$attr = array(
			'id'	=>	'fecha_evaluacion',
			'name'	=>	'fecha_evaluacion',
			'value'	=>	(isset($datos->fecha_evaluacion)) ? $datos->fecha_evaluacion : date('d/m/Y'),
			'class'	=>	'form-control'
	);
	
	if(isset($datos->fecha_evaluacion)) {
		$attr['readonly'] = 'readonly';
	}
	
	echo '<div class="col-sm-5">';
	echo '<div class="input-group date" id="datetimepicker1">';
	echo form_input($attr);
	echo '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Fondo:', '', array('class' => 'col-sm-4 control-label'));
	
	$attr = array(
			'id'	=>	'fondo',
			'name'	=>	'fondo',
			'value'	=>	'R0001',
			'readonly'=>'readonly',
			'class'	=>	'form-control'
	);
	echo '<div class="col-sm-5">';
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Convocatoria:', '', array('class' => 'col-sm-4 control-label'));
	
	$attr = array(
			'id'	=>	'convocatoria',
			'name'	=>	'convocatoria',
			'value'	=>	'2014-2015',
			'readonly'=>'readonly',
			'class'	=>	'form-control'
	);
	echo '<div class="col-sm-5">';
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Solicitud:', '', array('class' => 'col-sm-4 control-label'));
	
	$attr = array(
			'id'	=>	'solicitud',
			'name'	=>	'solicitud',
			'value'	=>	(isset($datos->folio)) ? $datos->folio : "",
			'readonly'=>'readonly',
			'class'	=>	'form-control'
	);
	echo '<div class="col-sm-5">';
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Nombre de la Revista:', '', array('class' => 'col-sm-4 control-label'));
	
	$attr = array(
			'id'	=>	'revista',
			'name'	=>	'revista',
			'value'	=>	(isset($datos->revista)) ? $datos->revista : "",
			'readonly'=>'readonly',
			'class'	=>	'form-control'
	);
	echo '<div class="col-sm-5">';
	echo form_input($attr);
	
	$attr = array(
			'id'	=>	'id_solicitud',
			'name'	=>	'id_solicitud',
			'value'	=>	(isset($datos->id_solicitud)) ? $datos->id_solicitud : "",
			'type'	=>	'hidden'
	);
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Editor y/o Director:', '', array('class' => 'col-sm-4 control-label'));
	
	$attr = array(
			'id'	=>	'editor',
			'name'	=>	'editor',
			'value'	=>	(isset($datos->editor)) ? $datos->editor : "",
			'readonly'=>'readonly',
			'class'	=>	'form-control'
	);
	echo '<div class="col-sm-5">';
	echo form_input($attr);
	
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	echo form_label('Evaluador:', '', array('class' => 'col-sm-4 control-label'));
	
	$attr = array(
			'id'	=>	'evaluador',
			'name'	=>	'evaluador',
			'value'	=>	(isset($datos->evaluador)) ? $datos->evaluador : "",
			'readonly'=>'readonly',
			'class'	=>	'form-control'
	);
	echo '<div class="col-sm-5">';
	echo form_input($attr);
	echo '</div>';
	echo '</div>';
	?>
	</div>
</div>
<?php
$contSeccion = 1;

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
			
			foreach($preguntas as $pregunta) {
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
							echo form_label("Por favor justifique su respuesta:");
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
						case 4:
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
							break;
						case 5:
							$attr = array(
							'id'	=>	'rdb_'.$pregunta->id_pregunta.'_1',
							'name'	=>	'rdb_'.$pregunta->id_pregunta,
							'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 1
							);
							echo form_label(form_radio($attr)." Muy buena", '', array('class' => 'radio-inline'));
							
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_2',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 0.67
							);
							echo form_label(form_radio($attr)." Buena", '', array('class' => 'radio-inline'));
							
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_3',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 0.33
							);
							echo form_label(form_radio($attr)." Regular", '', array('class' => 'radio-inline'));
								
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_4',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	0
							);
							echo form_label(form_radio($attr)." Definitivamente debe mejorar", '', array('class' => 'radio-inline'));
							echo '<div class="form-group">';
							$attr = array(
									'id'	=>	'txt_'.$pregunta->id_pregunta,
									'name'	=>	'txt_'.$pregunta->id_pregunta,
									'class'	=>	'form-control',
									'rows'	=>	'3'
							);
							echo form_label("Por favor justifique su respuesta:");
							echo form_textarea($attr);
							echo '</div>';
							break;
						case 7:
							$attr = array(
							'id'	=>	'rdb_'.$pregunta->id_pregunta.'_1',
							'name'	=>	'rdb_'.$pregunta->id_pregunta,
							'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 1
							);
							echo form_label(form_radio($attr)." Muy claramente", '', array('class' => 'radio-inline'));
							
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_2',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 0.67
							);
							echo form_label(form_radio($attr)." Claramente", '', array('class' => 'radio-inline'));
							
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_3',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 0.33
							);
							echo form_label(form_radio($attr)." No es claro", '', array('class' => 'radio-inline'));
								
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_4',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	0
							);
							echo form_label(form_radio($attr)." Definitivamente no", '', array('class' => 'radio-inline'));
							echo '<div class="form-group">';
							$attr = array(
									'id'	=>	'txt_'.$pregunta->id_pregunta,
									'name'	=>	'txt_'.$pregunta->id_pregunta,
									'class'	=>	'form-control',
									'rows'	=>	'3'
							);
							echo form_label("Por favor justifique su respuesta:");
							echo form_textarea($attr);
							echo '</div>';
							break;
						case 8:
							$attr = array(
							'id'	=>	'rdb_'.$pregunta->id_pregunta.'_1',
							'name'	=>	'rdb_'.$pregunta->id_pregunta,
							'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 1
							);
							echo form_label(form_radio($attr)." Muy cuidado y de buena calidad", '', array('class' => 'radio-inline'));
								
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_2',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 0.5
							);
							echo form_label(form_radio($attr)." Cuidado pero faltó calidad", '', array('class' => 'radio-inline'));
						
							$attr = array(
									'id'	=>	'rdb_'.$pregunta->id_pregunta.'_3',
									'name'	=>	'rdb_'.$pregunta->id_pregunta,
									'value'	=>	0
							);
							echo form_label(form_radio($attr)." Descuidado y sin calidad", '', array('class' => 'radio-inline'));
							echo '<div class="form-group">';
							$attr = array(
									'id'	=>	'txt_'.$pregunta->id_pregunta,
									'name'	=>	'txt_'.$pregunta->id_pregunta,
									'class'	=>	'form-control',
									'rows'	=>	'3'
							);
							echo form_label("Por favor justifique su respuesta:");
							echo form_textarea($attr);
							echo '</div>';
							break;
						default:
							break;
					}
				}
			}
		}
	}
	
	$contSeccion++;
	
	foreach($preguntas as $pregunta) {
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
					echo form_label("Por favor justifique su respuesta:");
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
				case 7:
					$attr = array(
						'id'	=>	'rdb_'.$pregunta->id_pregunta.'_1',
						'name'	=>	'rdb_'.$pregunta->id_pregunta,
						'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 1
					);
					if(isset($pregunta->opcion) && $pregunta->opcion == 1) {
						$attr['checked'] = 'checked';
					}
					echo form_label(form_radio($attr)." Muy claramente", '', array('class' => 'radio-inline'));
					
					$attr = array(
						'id'	=>	'rdb_'.$pregunta->id_pregunta.'_2',
						'name'	=>	'rdb_'.$pregunta->id_pregunta,
						'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 0.67
					);
					if(isset($pregunta->opcion) && $pregunta->opcion == 0.67) {
						$attr['checked'] = 'checked';
					}
					echo form_label(form_radio($attr)." Claramente", '', array('class' => 'radio-inline'));
					
					$attr = array(
							'id'	=>	'rdb_'.$pregunta->id_pregunta.'_3',
							'name'	=>	'rdb_'.$pregunta->id_pregunta,
							'value'	=>	(isset($pregunta->puntos_asignados)) ? $pregunta->puntos_asignados : 0.33
					);
					if(isset($pregunta->opcion) && $pregunta->opcion == 0.33) {
						$attr['checked'] = 'checked';
					}
					echo form_label(form_radio($attr)." No es claro", '', array('class' => 'radio-inline'));
					
					$attr = array(
						'id'	=>	'rdb_'.$pregunta->id_pregunta.'_4',
						'name'	=>	'rdb_'.$pregunta->id_pregunta,
						'value'	=>	0
					);
					if(isset($pregunta->opcion) && $pregunta->opcion == 0) {
						$attr['checked'] = 'checked';
					}
					echo form_label(form_radio($attr)." Definitivamente no", '', array('class' => 'radio-inline'));
					echo '<div class="form-group">';
					$attr = array(
						'id'	=>	'txt_'.$pregunta->id_pregunta,
						'name'	=>	'txt_'.$pregunta->id_pregunta,
						'class'	=>	'form-control',
						'rows'	=>	'3',
						'value'	=>	(isset($pregunta->justificacion)) ? $pregunta->justificacion : ""
					);
					echo form_label("Por favor justifique su respuesta:");
					echo form_textarea($attr);
					echo '</div>';
					break;
				default:
					break;
			}
		}
	}
	
	echo '<div id="cp_'.$seccion->id_seccion.'"></div>';
	echo '</div>';  // Contenedor panel body
	echo '</div>';  // Panel colapsable
	echo '</div>';  // Contenedor principal
}

echo '</div>';

if($datos->estatus != 5) {
	echo '<div class="text-center">';
	$attr = array(
		'id'	=>	'btnGuardar',
		'name'	=>	'btnGuardar',
		'content'=>	'Guardar avances',
		'class'	=>	'btn btn-primary',
		'style'	=>	'margin-right: 15px;'
	);
	echo form_button($attr);
	
	$attr = array(
			'id'	=>	'btnFinalizar',
			'name'	=>	'btnFinalizar',
			'content'=>	'Finalizar evaluación',
			'class'	=>	'btn btn-primary',
			'style'	=>	'margin-left: 15px;'
	);
	echo form_button($attr);
	echo '</div>';
}

echo form_close();
?>
<div class="modal fade" id="mensajeAvisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Continuar</button>
      </div>
    </div>
  </div>
</div>