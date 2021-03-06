<h5><strong>Total de usuarios: <?php echo $totalUsuarios; ?></strong></h5>
<h5><strong>Total de revistas registradas: <?php echo $totalRevistas; ?></strong></h5>
<h5><strong>Total de solicitudes finalizadas: <?php echo $totalFinalizados; ?></strong></h5>
<h5><strong>Total de solicitudes pendientes: <?php echo $totalPendientes; ?></strong></h5>
<table class="table table-condensed table-striped">
  <tr>
    <th>#</th>
    <th>Nombre de la revista</th>
    <th>Datos generales</th>
    <th>Carta de postulación</th>
    <th>Comité editorial</th>
    <th>Arbitraje</th>
    <th>Índices y resúmenes</th>
    <th>Distribución electrónica</th>
    <th>Manuscritos</th>
    <th>Anexos</th>
    <th>Finalizado</th>
  </tr>
  <?php
  $i = 1;
  foreach($datos as $dato) {
	$claseFondo = "";
	
	if($dato->tipo_solicitud == 3) {
		$claseFondo = "#F0D58C";
	}
  ?>
  <tr>
    <td style="background-color: <?php echo $claseFondo; ?>"><?php echo $i; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>"><a href="<?php echo base_url('reporte/detalle/'.$dato->id_revista); ?>"><?php echo $dato->nombre; ?></a></td>
    <td style="background-color: <?php echo $claseFondo; ?>" class="text-center"><?php echo $dato->general; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>" class="text-center"><?php echo $dato->carta_postulacion; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>" class="text-center"><?php echo $dato->comite_editorial; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>" class="text-center"><?php echo $dato->arbitraje; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>" class="text-center"><?php echo $dato->indices; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>" class="text-center"><?php echo $dato->distribucion; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>" class="text-center"><?php echo $dato->manuscritos; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>"><?php echo $dato->anexos; ?></td>
    <td style="background-color: <?php echo $claseFondo; ?>"><?php echo ($dato->estatus == 5) ? '<span class="glyphicon glyphicon-ok text-success"></span>' : ""; ?></td>
  </tr>
  <?php
    $i++;
  }
  ?>
</table>
