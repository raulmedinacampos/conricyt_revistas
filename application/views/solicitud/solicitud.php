<?php
echo '<div class="form-group">';
echo form_label('Título de la solicitud', '', array('class' => 'col-sm-2 control-label'));
$attr = array(
	'id'	=>	'titulo_solicitud',
	'name'	=>	'titulo_solicitud',
	'class'	=>	'form-control'
);
echo '<div class="col-sm-10">';
echo form_input($attr);
echo '</div>';
echo '</div>';
?>