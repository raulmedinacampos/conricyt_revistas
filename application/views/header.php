<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Solicitud al Índice de Revistas Mexicanas de Investigación Científica y Tecnológica</title>

<!-- Estilos -->
<link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url("css/estilos.css"); ?>" rel="stylesheet" type="text/css" />

<!-- html5shiv para IE -->
<!--[if lt IE 9]>
  <script type="text/javascript" src="<?php echo base_url('scripts/html5shiv.min.js'); ?>"></script>
<![endif]-->

<!-- Scripts -->
<script type="text/javascript" src="<?php echo base_url("scripts/jquery-1.11.0.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("scripts/bootstrap.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("scripts/jquery.validate.min.js"); ?>"></script>
</head>

<body>

<div id="franja-azul"></div>
<div id="contenedor" class="container">
  <header>
  	<div id="logotipos" class="row">
      <img class="img-responsive" src="<?php echo base_url('images/logos.png'); ?>" alt="CONACYT" />
    </div>
    <div id="divisor">
      <div class="container">
    <?php
        if($this->session->userdata('perfil')) {
            echo '<a href="'.base_url('login/cerrarSesion').'"><span class="btn btn-warning btn-sm">Cerrar sesión</span></a>';
        }
    ?>
      </div>
    </div>
  </header>
  <div class="container">