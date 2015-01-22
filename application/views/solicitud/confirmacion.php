<div class="col-sm-8 col-sm-offset-2">
  <div class="panel panel-info" style="padding:20px 25px 30px;">
    <h4>Apreciable <?php echo $this->session->flashdata('nombre') ?></h4>
    <p>Su solicitud número <strong><?php echo $this->session->flashdata('folio') ?></strong> que ingreso bajo la Convocatoria del Índice de Revistas Mexicanas de Investigación Científica y Tecnológica 2014-2015, ha sido finalizada exitosamente el día <?php echo $this->session->flashdata('fecha') ?> a las <?php echo $this->session->flashdata('hora') ?> horas, le recuerdo que la publicación de resultados será hasta el 13 de marzo del 2015.</p>
    <p>Atentamente,<br>
      Mtra. Margarita Ontiveros y Sánchez de la Barquera<br>
    Coordinadora General del CONRICyT </p>
    <span class="btn btn-primary"><a href="<?php echo base_url('solicitud'); ?>" style="color:#FFFFFF; text-decoration:none;">Aceptar</a></span>
  </div>
</div>
