<style type="text/css">
table td {
	text-align: left !important;
}
.panel table td:first-of-type {
	width: 35%;
}

.panel:first-of-type table td {
	width: 50%;
}

.panel:first-of-type table:nth-of-type(2) td {
    width: auto;
}
</style>
<h4><?php echo $revista->nombre; ?></h4>
<h5><strong><?php echo $revista->institucion; ?></strong></h5>
<h5><?php echo trim($revista->enombre." ".$revista->ap_paterno." ".$revista->ap_materno); ?></h5>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Datos de la revista</h3>
  </div>
  <div class="panel-body">
  	<h5><strong>Datos generales</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <td>Tipo de solicitud: <strong><?php echo (isset($inf_revista->tipo_solicitud)) ? $inf_revista->tipo_solicitud : ""; ?></strong></td>
        <td>Formato de la revista: <strong><?php echo (isset($inf_revista->formato)) ? $inf_revista->formato : ""; ?></strong></td>
      </tr>
      <tr>
        <td>Nombre de la revisa: <strong><?php echo $revista->nombre; ?></strong></td>
        <td>Año de inicio de la publicación: <strong><?php echo $revista->inicio_publicacion; ?></strong></td>
      </tr>
      <tr>
        <td>Periodicidad: <strong><?php echo $revista->periodicidad; ?></strong></td>
        <td>Área: <strong><?php echo (isset($inf_revista->area_conocimiento)) ? $inf_revista->area_conocimiento : ""; ?></strong></td>
      </tr>
      <tr>
        <td>Disciplina: <strong><?php echo $revista->disciplina; ?></strong></td>
        <td>Subdisciplina: <strong><?php echo $revista->subdisciplina; ?></strong></td>
      </tr>
      <tr>
        <td>Otra subdisciplina o tema: <strong><?php echo $revista->otro_tema; ?></strong></td>
        <td>Número promedio de artículos publicados por año: <strong><?php echo $revista->articulos_anio; ?></strong></td>
      </tr>
      <tr>
        <td>Porcentaje promedio de artículos rechazados por año: <strong><?php echo $revista->porcentaje_rechazados; ?></strong></td>
        <td>Tiempo promedio entre recepción y aprobación de un artículo: <strong><?php echo $revista->tiempo_recep_aprob; ?></strong></td>
      </tr>
      <tr>
        <td>Factor de impacto: <strong><?php echo $revista->factor_impacto; ?></strong></td>
        <td>ISSN impreso: <strong><?php echo $revista->issn_impreso; ?></strong></td>
      </tr>
      <tr>
        <td>ISSN electrónico: <strong><?php echo $revista->issn_electronico; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    
    <h5><strong>Ejemplares electrónicos</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <th>Número</th>
        <th>Año de distribución</th>
        <th>URL</th>
      </tr>
      <?php
  if($ejemplares) {
	foreach($ejemplares->result() as $ejemplar) {
	?>
      <tr>
        <td><?php echo $ejemplar->numero; ?></td>
        <td><?php echo $ejemplar->anio_distribucion; ?></td>
        <td><strong><a href="<?php echo $ejemplar->url; ?>" target="_blank"><?php echo $ejemplar->url; ?></a></strong></td>
      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay distribuciones electrónicas cargadas</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
    
  	<h5><strong>Datos de la institución</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <td>Institución: <strong><?php echo $institucion->institucion; ?></strong></td>
        <td>Calle y número: <strong><?php echo $institucion->calle_numero; ?></strong></td>
      </tr>
      <tr>
        <td>Número interior: <strong><?php echo $institucion->numero_interior; ?></strong></td>
        <td>Colonia: <strong><?php echo $institucion->colonia; ?></strong></td>
      </tr>
      <tr>
        <td>País: <strong><?php echo $institucion->pais; ?></strong></td>
        <td>Estado: <strong><?php echo $institucion->entidad; ?></strong></td>
      </tr>
      <tr>
        <td>Delegación o municipio: <strong><?php echo $institucion->municipio; ?></strong></td>
        <td>Ciudad: <strong><?php echo $institucion->ciudad; ?></strong></td>
      </tr>
      <tr>
        <td>Código postal: <strong><?php echo $institucion->codigo_postal; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    
  	<h5><strong>Datos del editor</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <td>Grado: <strong><?php echo $editor->grado_academico; ?></strong></td>
        <td>Cargo: <strong><?php echo $editor->cargo; ?></strong></td>
      </tr>
      <tr>
        <td>Nombre: <strong><?php echo $editor->nombre; ?></strong></td>
        <td>Apellido paterno: <strong><?php echo $editor->ap_paterno; ?></strong></td>
      </tr>
      <tr>
        <td>Apellido materno: <strong><?php echo $editor->ap_materno; ?></strong></td>
        <td>Correo: <strong><?php echo $editor->correo; ?></strong></td>
      </tr>
      <tr>
        <td>Telefono: <strong><?php echo $editor->telefono; ?></strong></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    
  	<p>
    	Carta de postulación: <strong>
        <?php
			if($revista->ruta_carta_postulacion) {
				echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_carta_postulacion).'">'.$revista->ruta_carta_postulacion."</a>";
			} else {
				echo "No se ha cargado la carta de postulación";
			}
		?>
      </strong>
    </p>
  	<p>
    	Carta de renovación automática: <strong>
        <?php
			if($revista->ruta_carta_exencion) {
				echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_carta_exencion).'">'.$revista->ruta_carta_exencion."</a>";
			} else {
				echo "No se ha cargado la carta de renovación automática";
			}
		?>
      </strong>
    </p>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Comité editorial</h3>
  </div>
  <div class="panel-body">
    <table class="table table-condensed table-striped">
      <tr>
        <td>Comité editorial</td>
        <td><strong>
          <?php
    	if($revista->ruta_comite_editorial) {
			echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_comite_editorial).'">'.$revista->ruta_comite_editorial."</a>";
		} else {
			echo "No se ha cargado archivo";
		}
    ?>
          </strong></td>
      </tr>
      <tr>
        <td>Actas y acuerdos</td>
        <td><strong>
          <?php
    	if($revista->ruta_actas_acuerdos) {
			echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_actas_acuerdos).'">'.$revista->ruta_actas_acuerdos."</a>";
		} else {
			echo "No se ha cargado archivo";
		}
    ?>
          </strong></td>
      </tr>
      <tr>
        <td>Funciones, reponsabilidades y normatividad</td>
        <td><strong>
          <?php
    	if($revista->url_func_resp_norm) {
			echo 'URL: <a href="'.$revista->url_func_resp_norm.'" target="_blank">'.$revista->url_func_resp_norm."</a>";
		} else {
			echo "No se ha cargado URL";
		}
    ?>
          </strong></td>
      </tr>
    </table>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Arbitraje</h3>
  </div>
  <div class="panel-body">
    <table class="table table-condensed table-striped">
      <tr>
        <td>Cartera de árbitros</td>
        <td><strong>
          <?php
    	if($revista->ruta_cartera_arbitros) {
			echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_cartera_arbitros).'">'.$revista->ruta_cartera_arbitros."</a>";
		} else {
			echo "No se ha cargado archivo";
		}
    ?>
          </strong></td>
      </tr>
      <tr>
        <td>Bitácora de arbitraje</td>
        <td><strong>
          <?php
    	if($revista->ruta_bitacora_arbitraje) {
			echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_bitacora_arbitraje).'">'.$revista->ruta_bitacora_arbitraje."</a>";
		} else {
			echo "No se ha cargado archivo";
		}
    ?>
          </strong></td>
      </tr>
    </table>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Índices y resúmenes</h3>
  </div>
  <div class="panel-body">
  	<p>
    	Presencia en bases de datos: <strong>
        <?php
			if($revista->url_presencia_bd) {
				echo 'URL: <a href="'.$revista->url_presencia_bd.'" target="_blank">'.$revista->url_presencia_bd."</a>";
			} else {
				echo "No se ha cargado URL";
			}
		?>
      </strong>
    </p>
    <table class="table table-condensed table-striped">
      <tr>
        <th>Nombre del índice</th>
        <th>Antigüedad</th>
        <th>Tipo de índice</th>
      </tr>
      <?php
  if($indices) {
	foreach($indices as $indice) {
	?>
      <tr>
        <td><?php echo $indice->nombre; ?></td>
        <td><?php echo $indice->antiguedad; ?></td>
        <td><?php echo $indice->tipo; ?></td>
      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay anexos cargados</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Distribución electrónica</h3>
  </div>
  <div class="panel-body">
  	<h5><strong>Distribución electrónica</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <th>Año</th>
        <th>Consecutivo</th>
        <th>Consultas abstracts</th>
        <th>HTML</th>
        <th>PDF</th>
      </tr>
      <?php
  if($distribuciones) {
	foreach($distribuciones->result() as $distribucion) {
	?>
      <tr>
        <td><?php echo $distribucion->anio; ?></td>
        <td><?php echo $distribucion->consecutivo; ?></td>
        <td><?php echo $distribucion->abstracts; ?></td>
        <td><?php echo $distribucion->html; ?></td>
        <td><?php echo $distribucion->pdf; ?></td>
      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay distribuciones electrónicas cargadas</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
    
  	<h5><strong>Volúmenes más consultados</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <th>Año</th>
        <th>Volumen</th>
        <th>Consultas abstracts</th>
        <th>Texto completo</th>
      </tr>
      <?php
  if($volumenes) {
	foreach($volumenes->result() as $volumen) {
	?>
      <tr>
        <td><?php echo $volumen->anio; ?></td>
        <td><?php echo $volumen->volumen; ?></td>
        <td><?php echo $volumen->abstracts; ?></td>
        <td><?php echo $volumen->texto_completo; ?></td>
      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay volúmenes cargados</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
    
  	<h5><strong>Artículos más descargados</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <th>Año</th>
        <th>Volumen</th>
        <th>Título del artículo</th>
        <th>Autor(es)</th>
      </tr>
      <?php
  if($articulos) {
	foreach($articulos->result() as $articulo) {
	?>
      <tr>
        <td><?php echo $articulo->anio; ?></td>
        <td><?php echo $articulo->volumen; ?></td>
        <td><?php echo $articulo->titulo; ?></td>
        <td><?php echo $articulo->autor; ?></td>
      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay artículos cargados</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
    
  	<h5><strong>Países que más consultan los artículos</strong></h5>
    <table class="table table-condensed table-striped">
      <tr>
        <th>Año</th>
        <th>País</th>
        <th>Consultas realizadas</th>
        <th>Texto completo</th>
      </tr>
      <?php
  if($paises) {
	foreach($paises->result() as $pais) {
	?>
      <tr>
        <td><?php echo $pais->anio; ?></td>
        <td><?php echo $pais->pais; ?></td>
        <td><?php echo $pais->consultas; ?></td>
        <td><?php echo $pais->texto_completo; ?></td>
      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay países cargados</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Manuscritos recibidos</h3>
  </div>
  <div class="panel-body">
    <table class="table table-condensed table-striped">
      <tr>
        <td>Manuscritos rechazados o condicionados</td>
        <td><strong>
          <?php
    	if($revista->ruta_manuscritos_rechazados) {
			echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_manuscritos_rechazados).'">'.$revista->ruta_manuscritos_rechazados."</a>";
		} else {
			echo "No se ha cargado archivo";
		}
    ?>
          </strong></td>
      </tr>
      <tr>
        <td>Manuscritos aceptados</td>
        <td><strong>
          <?php
    	if($revista->ruta_manuscritos_aceptados) {
			echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_manuscritos_aceptados).'">'.$revista->ruta_manuscritos_aceptados."</a>";
		} else {
			echo "No se ha cargado archivo";
		}
    ?>
          </strong></td>
      </tr>
      <tr>
        <td>Formato de dictamen o formato libre</td>
        <td><strong>
          <?php
    	if($revista->ruta_formato_dictamen) {
			echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.$revista->ruta_formato_dictamen).'">'.$revista->ruta_formato_dictamen."</a>";
		} else {
			echo "No se ha cargado archivo";
		}
    ?>
          </strong></td>
      </tr>
    </table>
    
    <h5><strong>Manuscritos rechazados</strong></h5>
    <table class="table table-condensed table-striped">
      <?php
  if($manuscritos_rechazados) {
	foreach($manuscritos_rechazados as $mr) {
	?>
      <tr>
        <td><strong><?php echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.str_replace(" ", "_", $mr->ruta)).'">'.$mr->ruta."</a>"; ?></strong></td>
-      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay más manuscritos rechazados</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
    
    <h5><strong>Manuscritos aceptados</strong></h5>
    <table class="table table-condensed table-striped">
      <?php
  if($manuscritos_aceptados) {
	foreach($manuscritos_aceptados as $ma) {
	?>
      <tr>
        <td><strong><?php echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.str_replace(" ", "_", $ma->ruta)).'">'.$ma->ruta."</a>"; ?></strong></td>
-      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay más manuscritos aceptados</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Anexos de revistas</h3>
  </div>
  <div class="panel-body">
    <table class="table table-condensed table-striped">
      <?php
  if($anexos) {
	foreach($anexos->result() as $anexo) {
	?>
      <tr>
        <td><?php echo $anexo->descripcion; ?></td>
        <td><strong><?php echo 'Archivo cargado: <a href="'.base_url('uploads/'.$revista->login.'/'.str_replace(" ", "_", $anexo->ruta_anexo)).'">'.$anexo->ruta_anexo."</a>"; ?></strong></td>
      </tr>
      <?php
	}
  } else {
  ?>
      <tr>
        <td colspan="2"><strong>No hay anexos cargados</strong></td>
      </tr>
      <?php
  }
  ?>
    </table>
  </div>
</div>
