<script type="text/javascript">
$(function() {
	$("#btnEntrar").click(function() {
		$("#formLogin").submit();
	});
});
</script>

<div class="text-center">
  <h3>Convocatoria 2014-2015</h3>
  <h4>Integración de revistas al Índice de Revistas Mexicanas de Investigación Científica y Tecnológica</h4>
</div>
<div class="col-md-8 col-md-offset-2" style="margin-top:20px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Indicaciones</strong></div>
    <div class="panel-body">
      <ol>
        <li>Para capturar una solicitud debe registrarse el director o editor de la revista en <a href="<?php echo base_url('registro'); ?>">esta liga</a>.</li>
        <li>Una vez registrado, ingresa tu usuario y contraseña en los campos correspondientes.</li>
      </ol>
    </div>
  </div>
</div>
<div id="loginbox" style="margin-top:20px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
  <div class="panel panel-info" >
    <div class="panel-heading">
      <div class="panel-title">Entrar al sistema</div>
    </div>
    <div style="padding-top:30px" class="panel-body" >
      <?php
		if($this->session->userdata('error')) {
	?>
      <div class="alert alert-danger col-sm-12">El usuario o contraseña son incorrectos</div>
      <div style="clear:both;"></div>
      <?php
		}
	$attr = array(
		'id'	=>	'formLogin',
		'name'	=>	'formLogin',
		'class'	=>	'form-horizontal'
	);
	echo form_open(base_url('login/validarAcceso'), $attr);
?>
      <div style="margin-bottom: 25px" class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <?php
		$attr = array(
			'id'	=>	'usuario',
			'name'	=>	'usuario',
			'class'	=>	'form-control',
			'placeholder' => 'Usuario'
		);
		echo form_input($attr);
		?>
      </div>
      <div style="margin-bottom: 25px" class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <?php
		$attr = array(
			'id'	=>	'password',
			'name'	=>	'password',
			'class'	=>	'form-control',
			'placeholder' => 'Contraseña'
		);
		echo form_password($attr);
		?>
      </div>
      <div style="margin-top:10px" class="form-group">
        <!-- Button -->
        <div class="col-sm-12 controls">
          <?php
		$attr = array(
			'id'	=>	'btnEntrar',
			'name'	=>	'btnEntrar',
			'class'	=>	'btn btn-primary',
			'content' => 'Entrar'
		);
		echo form_button($attr);
		?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12 control">
          <div style="border-top: 1px solid#888; padding-top:15px; font-weight:bold;"> <a href="<?php echo base_url('registro'); ?>"> Registrarse por primera vez </a> </div>
        </div>
      </div>
<?php
	echo form_close();
?>
    </div>
  </div>
</div>
