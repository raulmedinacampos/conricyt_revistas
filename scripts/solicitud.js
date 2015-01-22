/**
 * Funciones utilizadas en la solicitud de publicación de revista
 */

function inicializar() {
	// Se restablecen las propiedades iniciales del formulario al cargar
	var formulario = document.getElementById("formSolicitud");
	formulario.reset();
	$("div.tab-content input, div.tab-content select").prop("disabled", false);
	
	// Se ocultan las pestañas en caso de ser renovación automática
	if($("#tipo_solicitud option:selected").val()) {
		mostrarTipoSolicitud();
	}
	
	$("#tipo_solicitud").change(function() {
		mostrarTipoSolicitud();
	});
	
	// Al desplegar el dropdown de pais, si no se ha seleccionado un valor, preselecciona a México 
	var paisSeleccionado = 0;
	$("#pais_revista").click(function() {
		if(paisSeleccionado == 0) {
			$("#pais_revista option").each(function() {
				if($(this).text() == "México") {
					$(this).prop("selected", true);
					paisSeleccionado++;
				}
			});
		}
	});
	
	// Se oculta el nombre del documento y se muestra el campo para adjuntar el archivo
	$(".quitar-elemento").click(function() {
		var elem = $(this);
		elem.parents(".texto-documento").toggle();
		elem.parents("div").children(".bootstrap-filestyle").toggle();
		elem.parents("div").children(".conservar-documento").toggle();
		
		if(elem.parents("div").children(".bootstrap-filestyle").is(":visible")) {
			elem.parents("div").children("input:file").prop("disabled", false);
		} else {
			elem.parents("div").children("input:file").prop("disabled", true);
		}
	});
	
	$(".conservar-documento").click(function() {
		var elem = $(this).children("span.conservar-elemento");
		elem.parents("div").children(".texto-documento").toggle();
		elem.parents("div").children(".quitar-elemento").toggle();
		elem.parents("div").children(".bootstrap-filestyle").toggle();
		elem.parents("div").children(".conservar-documento").toggle();
		
		if(elem.parents("div").children(".bootstrap-filestyle").is(":visible")) {
			elem.parents("div").children("input:file").prop("disabled", false);
		} else {
			elem.parents("div").children("input:file").prop("disabled", true);
		}
	});
	
	//Eliminar registros
	$(".glyphicon-trash").click(function() {
		var id_reg = $(this).data("registro");
		var nom_seccion = $(this).data("seccion");
		
		$("#mensajeEliminar h4.modal-title").html('Se eliminará el registro');
		$("#mensajeEliminar .modal-body").html('<p>Estás a punto de eliminar el registro seleccionado, ¿deseas continuar?</p>');
		$("#mensajeEliminar .modal-footer .btn-primary").css("display", "inline");
		$("#mensajeEliminar .modal-footer .btn-default").html("Cancelar");
		$("#mensajeEliminar").modal();
		
		$("#mensajeEliminar .modal-footer .btn-primary").click(function() {
			$.post('./solicitud/eliminarRegistro',
				{id: id_reg, seccion: nom_seccion},
				function(data) {
					$("#mensajeEliminar h4.modal-title").html('Eliminado');
					$("#mensajeEliminar .modal-body").html('<p>'+data+'</p>');
					$("#mensajeEliminar .modal-footer .btn-default").html("Aceptar");
					$("#mensajeEliminar .modal-footer .btn-primary").toggle();
					$("#mensajeEliminar").modal();
					
					$("#mensajeEliminar .modal-footer .btn-default").click(function() {
						location.reload();
					});
				}
			);
		});
	});
	
	// Se hace el post para generar una nueva solicitud
	$("#a_nueva").click(function(e) {
		e.preventDefault();
		
		$("#hdn_nueva").val("1");
		$("#formNueva").submit();
	});
	
	// Obtenemos la pestaña que fue selccionada antes de guardar
	$(".nav-tabs li a").click(function() {
		var seleccionado = $(this).attr("href")
		$("#hdn_tab").val(seleccionado);
	});
}

function mostrarConfirmacion() {
	$("#mensajeEliminar h4.modal-title").html('Bienvenido');
	$("#mensajeEliminar .modal-body").html('<p>Has recibido un correo electrónico con tu usuario y contraseña. En caso de no encontrarlo en tu bandeja de entrada, se te sugiere revisar en la bandeja de no deseados (SPAM)</p>');
	$("#mensajeEliminar .modal-footer .btn-primary").css("display", "none");
	$("#mensajeEliminar .modal-footer .btn-default").html("Aceptar");
	$("#mensajeEliminar").modal();
}

function mostrarTipoSolicitud() {	
	if($("#tipo_solicitud option:selected").text() == "Renovación automática") {
		$("ul.nav li").not(".active").css("display", "none");
		$("ul.nav-tabs li").last().css("display", "block");
		$("div.tab-content input").not("#tab-datos-revista input").prop("disabled", true);
		$("div.tab-content select").not("#tab-datos-revista select").prop("disabled", true);
		$("#tab-anexos input").prop("disabled", false);
		$(".instrucciones").prepend('<li class="renovacion">Para la renovación automática los archivos anexos son opcionales</li>');
		$(".acceso-temporal").css("display", "block");
		$("#aviso-renovacion").css("display", "block");
		$(".div-carta-exencion").css("display", "block");
		$(".div-ejemplares").css("display", "none");
	} else {
		$("ul.nav li").not(".active").css("display", "block");
		$("div.tab-content input").prop("disabled", false);
		$("div.tab-content select").prop("disabled", false);
		$(".instrucciones li.renovacion").remove();
		$(".acceso-temporal").css("display", "none");
		$("#aviso-renovacion").css("display", "none");
		$(".div-carta-exencion").css("display", "none");
		$(".div-ejemplares").css("display", "block");
	}
}

function agregarURL() {
	$("#btnMasURL").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoIndice = '';
		var contador = fs.children(".form-group").length;
		contador++;
		
		nuevoIndice = $('<div class="form-group"></div>');
		
		campo = '<input id="num_dist_elect_' + contador + '" class="form-control" type="text" name="num_dist_elect[]">';		
		nuevoIndice.append('<label class="col-sm-2 control-label">Número</label>');
		nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
		
		campo = '<input id="anio_dist_elect_' + contador + '" class="form-control" type="text" name="anio_dist_elect[]">';
		nuevoIndice.append('<label class="col-sm-2 control-label">Año de distribución</label>');
		nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
		
		campo = '<input id="url_dist_elect_' + contador + '" class="form-control" type="text" name="url_dist_elect[]">';		
		nuevoIndice.append('<label class="col-sm-2 control-label">URL número de la revista</label>');
		nuevoIndice.append('<div class="col-sm-4">' + campo + '</div>');
		
		fs.children(".form-group").last().after(nuevoIndice);
	});
}

function agregarIndices() {
	$("#btnMasIndices").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var comboLista = '';
		var nuevoIndice = '';
		var contador = fs.children(".form-group").length;
		contador++;
		
		nuevoIndice = $('<div class="form-group"></div>');
		
		campo = '<input id="nombre_indice_' + contador + '" class="form-control" type="text" name="nombre_indice[]">';		
		nuevoIndice.append('<label class="col-sm-2 control-label">Nombre</label>');
		nuevoIndice.append('<div class="col-sm-2">' + campo + '</div>');
		
		campo = '<input id="antiguedad_indice_' + contador + '" class="form-control" type="text" name="antiguedad_indice[]">';
		nuevoIndice.append('<label class="col-sm-2 control-label">Antigüedad</label>');
		nuevoIndice.append('<div class="col-sm-2">' + campo + '</div>');
		
		comboLista = '<select class="form-control" id="estatus_indice_' + contador + '" name="estatus_indice[]">';
		comboLista += '<option selected="selected" value="">Selecciona</option>';
		comboLista += '<option value="2">En trámite</option>';
		comboLista += '<option value="1">Finalizado</option>';
		comboLista += '</select>';
		nuevoIndice.append('<label class="col-sm-2 control-label">Estatus</label>');
		nuevoIndice.append('<div class="col-sm-2">' + comboLista + '</div>');
		
		fs.children(".form-group").last().after(nuevoIndice);
	});
	
	$("#btnMasAbstracts").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var comboLista = '';
		var nuevoIndice = '';
		var contador = fs.children(".form-group").length;
		contador++;
		
		nuevoIndice = $('<div class="form-group"></div>');
		
		campo = '<input id="nombre_abstract_' + contador + '" class="form-control" type="text" name="nombre_abstract[]">';		
		nuevoIndice.append('<label class="col-sm-2 control-label">Nombre</label>');
		nuevoIndice.append('<div class="col-sm-2">' + campo + '</div>');
		
		campo = '<input id="antiguedad_abstract_' + contador + '" class="form-control" type="text" name="antiguedad_abstract[]">';
		nuevoIndice.append('<label class="col-sm-2 control-label">Antigüedad</label>');
		nuevoIndice.append('<div class="col-sm-2">' + campo + '</div>');
		
		comboLista = '<select class="form-control" id="estatus_abstract_' + contador + '" name="estatus_abstract[]">';
		comboLista += '<option selected="selected" value="">Selecciona</option>';
		comboLista += '<option value="2">En trámite</option>';
		comboLista += '<option value="1">Finalizado</option>';
		comboLista += '</select>';
		nuevoIndice.append('<label class="col-sm-2 control-label">Estatus</label>');
		nuevoIndice.append('<div class="col-sm-2">' + comboLista + '</div>');
		
		fs.children(".form-group").last().after(nuevoIndice);
	});
}

function agregarDistribucion() {
	$("#btnMasAccesos").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoIndice = '';
		var contador = $("#num_distribuciones").val();
		contador++;
		
		if(contador <= 10) {		
			nuevoIndice = $('<div class="form-group"></div>');
			
			campo = '<input id="anio_distribucion_' + contador + '" class="form-control" type="text" name="anio_distribucion[]">';		
			nuevoIndice.append('<label class="col-sm-1 control-label">Año</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			campo = '<input id="numero_consecutivo_' + contador + '" class="form-control" type="text" name="numero_consecutivo[]">';
			nuevoIndice.append('<label class="col-sm-2 control-label">Consecutivo</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			campo = '<input id="consultas_abs_distribucion_' + contador + '" class="form-control" type="text" name="consultas_abs_distribucion[]">';		
			nuevoIndice.append('<label class="col-sm-2 control-label">Número de consultas abstracts</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			campo = '<input id="html_distribucion_' + contador + '" class="form-control" type="text" name="html_distribucion[]">';
			nuevoIndice.append('<label class="col-sm-1 control-label">HTML</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			campo = '<input id="pdf_distribucion_' + contador + '" class="form-control" type="text" name="pdf_distribucion[]">';		
			nuevoIndice.append('<label class="col-sm-1 control-label">PDF</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			fs.children(".form-group").last().after(nuevoIndice);
			$("#num_distribuciones").val(contador);
		}
	});
	
	$("#btnMasVolumenes").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoIndice = '';
		var contador = $("#num_volumen").val();
		contador++;
		
		if(contador <= 5) {		
			nuevoIndice = $('<div class="form-group"></div>');
			
			campo = '<input id="anio_volumen_' + contador + '" class="form-control" type="text" name="anio_volumen[]">';		
			nuevoIndice.append('<label class="col-sm-2 control-label">Año</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			campo = '<input id="articulo_volumen_' + contador + '" class="form-control" type="text" name="articulo_volumen[]">';
			nuevoIndice.append('<label class="col-sm-2 control-label">Vol. artículo</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			campo = '<input id="consultas_volumen_' + contador + '" class="form-control" type="text" name="consultas_volumen[]">';		
			nuevoIndice.append('<label class="col-sm-2 control-label">Número de consultas abstracts</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			campo = '<input id="texto_volumen_' + contador + '" class="form-control" type="text" name="texto_volumen[]">';
			nuevoIndice.append('<label class="col-sm-2 control-label">Texto completo</label>');
			nuevoIndice.append('<div class="col-sm-1">' + campo + '</div>');
			
			fs.children(".form-group").last().after(nuevoIndice);
			$("#num_volumen").val(contador);
		}
	});
	
	$("#btnMasArticulos").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoIndiceF1 = '';
		var nuevoIndiceF2 = '';
		var contador = $("#num_articulo").val();
		contador++;
		
		if(contador <= 5) {		
			nuevoIndiceF1 = $('<div class="form-group"></div>');
			
			campo = '<input id="anio_articulo_' + contador + '" class="form-control" type="text" name="anio_articulo[]">';		
			nuevoIndiceF1.append('<label class="col-sm-2 control-label">Año</label>');
			nuevoIndiceF1.append('<div class="col-sm-4">' + campo + '</div>');
			
			campo = '<input id="articulo_articulo_' + contador + '" class="form-control" type="text" name="articulo_articulo[]">';
			nuevoIndiceF1.append('<label class="col-sm-2 control-label">Vol. artículo</label>');
			nuevoIndiceF1.append('<div class="col-sm-4">' + campo + '</div>');
			
			nuevoIndiceF2 = $('<div class="form-group"></div>');
			
			campo = '<input id="titulo_articulo_' + contador + '" class="form-control" type="text" name="titulo_articulo[]">';		
			nuevoIndiceF2.append('<label class="col-sm-2 control-label">Título del artículo</label>');
			nuevoIndiceF2.append('<div class="col-sm-4">' + campo + '</div>');
			
			campo = '<input id="autor_articulo_' + contador + '" class="form-control" type="text" name="autor_articulo[]">';
			nuevoIndiceF2.append('<label class="col-sm-2 control-label">Autor o autores</label>');
			nuevoIndiceF2.append('<div class="col-sm-4">' + campo + '</div>');
			
			fs.children(".form-group").last().after(nuevoIndiceF1);
			fs.children(".form-group").last().after(nuevoIndiceF2);
			$("#num_articulo").val(contador);
		}
	});
	
	$("#btnMasPaises").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoIndiceF1 = '';
		var nuevoIndiceF2 = '';
		var contador = $("#num_paises").val();
		contador++;
		
		if(contador <= 5) {
			nuevoIndiceF1 = $('<div class="form-group"></div>');
			
			campo = '<input id="anio_pais_' + contador + '" class="form-control" type="text" name="anio_pais[]">';		
			nuevoIndiceF1.append('<label class="col-sm-2 control-label">Año</label>');
			nuevoIndiceF1.append('<div class="col-sm-4">' + campo + '</div>');
			
			campo = '<input id="nombre_pais_' + contador + '" class="form-control" type="text" name="nombre_pais[]">';
			nuevoIndiceF1.append('<label class="col-sm-2 control-label">País</label>');
			nuevoIndiceF1.append('<div class="col-sm-4">' + campo + '</div>');
			
			nuevoIndiceF2 = $('<div class="form-group"></div>');
			
			campo = '<input id="consultas_pais_' + contador + '" class="form-control" type="text" name="consultas_pais[]">';		
			nuevoIndiceF2.append('<label class="col-sm-2 control-label">Consultas realizadas</label>');
			nuevoIndiceF2.append('<div class="col-sm-4">' + campo + '</div>');
			
			campo = '<input id="texto_pais_' + contador + '" class="form-control" type="text" name="texto_pais[]">';
			nuevoIndiceF2.append('<label class="col-sm-2 control-label">Texto completo</label>');
			nuevoIndiceF2.append('<div class="col-sm-4">' + campo + '</div>');
			
			fs.children(".form-group").last().after(nuevoIndiceF1);
			fs.children(".form-group").last().after(nuevoIndiceF2);
			$("#num_paises").val(contador);
		}
	});
}

function agregarManuscritos() {
	$("#btnMasMRechazados").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoManuscrito = '';
		var contador = fs.children(".form-group").length;
		contador++;
		
		nuevoManuscrito = $('<div class="form-group"></div>');
		
		campo = '<input id="mRechazado_' + contador + '" class="filestyle" data-buttonText="Buscar archivo" type="file" name="mRechazado[]">';
		nuevoManuscrito.append('<label class="col-sm-2 control-label">Añadir manuscrito rechazado</label>');
		nuevoManuscrito.append('<div class="col-sm-10">' + campo + '</div>');
		
		fs.children(".form-group").last().after(nuevoManuscrito);
		$(":file").filestyle({buttonText: "Buscar archivo"});
	});
	
	$("#btnMasMAceptados").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoManuscrito = '';
		var contador = fs.children(".form-group").length;
		contador++;
		
		nuevoManuscrito = $('<div class="form-group"></div>');
		
		campo = '<input id="mAceptado_' + contador + '" class="filestyle" data-buttonText="Buscar archivo" type="file" name="mAceptado[]">';
		nuevoManuscrito.append('<label class="col-sm-2 control-label">Añadir manuscrito aceptado</label>');
		nuevoManuscrito.append('<div class="col-sm-10">' + campo + '</div>');
		
		fs.children(".form-group").last().after(nuevoManuscrito);
		$(":file").filestyle({buttonText: "Buscar archivo"});
	});
}

function agregarAnexos() {
	$("#btnMasAnexos").click(function() {
		var fs = $(this).parents("fieldset");
		var campo = '';
		var nuevoIndice = '';
		var contador = fs.children(".form-group").length;
		contador++;
		
		if(contador <= 10) {
			nuevoIndice = $('<div class="form-group"></div>');
			
			campo = '<input id="descripcion_anexo_' + contador + '" class="form-control" type="text" name="descripcion_anexo[]">';		
			nuevoIndice.append('<label class="col-sm-2 control-label">Descripción</label>');
			nuevoIndice.append('<div class="col-sm-4">' + campo + '</div>');
			
			campo = '<input id="archivo_anexo_' + contador + '" class="filestyle" data-buttonText="Buscar archivo" type="file" name="archivo_anexo[]">';
			nuevoIndice.append('<label class="col-sm-2 control-label">Añadir anexo</label>');
			nuevoIndice.append('<div class="col-sm-4">' + campo + '</div>');
			
			fs.children(".form-group").last().after(nuevoIndice);
			$(":file").filestyle({buttonText: "Buscar archivo"});
		}
	});
}

function validarCambios() {
	$("#btnGuardar").click(function(e) {
		e.preventDefault();
		
		$("#formSolicitud input, #formSolicitud select").each(function() {
			$(this).rules('remove');
		});
		
		// Datos de la revista
		$("#nombre_revista").rules('add', {
			required: true,
			messages: {
				required: "El nombre de la revista es obligatorio"
			}
		});
		
		$("#inicio_publicacion").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de inicio de la publicación debe ser numérico",
				minlength: "El año de inicio de la publicación no es válido",
				maxlength: "El año de inicio de la publicación no es válido"
			}
		});
		
		$("#promedio_articulos").rules('add', {
			digits: true,
			messages: {
				digits: "El número de artículos publicados no es válido"
			}
		});
		
		$("#issn_impreso").rules('add', {
			required: true,
			remote: {
				url: "./solicitud/revisarISSNRepetido",
				type: "post",
				async: false,
				data: {
					issn: function() {
						return $("#issn_impreso").val();
					},
					solicitud: function() {
						return $("#hdn_solicitud").val();
					},
					nombre: function() {
						return $("#nombre_revista").val();
					}
				}
			},
			messages: {
				required: "Es necesario capturar el ISSN impreso",
				remote: "Este revista ya cuenta con un registro previo"
			}
		});
		
		if($("#carta_exencion").length) {
			$("#carta_exencion").rules('add', {
				extension: "pdf",
				filesize: 10485760,
				messages: {
					extension: "La carta de exención debe estar en formato PDF",
					filesize: "El tamaño máximo de la carta de exención debe ser de 10 MB"
				}
			});
		}
		
		if($("input[name='num_dist_elect[]']").length) {
			$("input[name='num_dist_elect[]']").rules('add', {
				pattern: /^[0-9\-\s]+$/,
				messages: {
					pattern: "El formato del número de la revista es inválido"
				}
			});
		}
		
		if($("input[name='anio_dist_elect[]']").length) {
			$("input[name='anio_dist_elect[]']").rules('add', {
				digits: true,
				minlength: 4,
				maxlength: 4,
				messages: {
					digits: "El año de la publicación debe ser numérico",
					minlength: "El año de la publicación no es válido",
					maxlength: "El año de la publicación no es válido"
				}
			});
		}
		
		if($("input[name='url_dist_elect[]']").length) {
			$("input[name='url_dist_elect[]']").rules('add', {
				url: true,
				messages: {
					url: "La URL del número de la revista es inválida"
				}
			});
		}
		
		$("#cp_revista").rules('add', {
			digits: true,
			minlength: 5,
			maxlength: 5,
			messages: {
				digits: "El código postal debe ser numérico",
				minlength: "El código postal debe ser de 5 dígitos",
				maxlength: "El código postal debe ser de 5 dígitos"
			}
		});
		
		$("#carta_postulacion").rules('add', {
			extension: "pdf",
			filesize: 10485760,
			messages: {
				extension: "La carta de postulación debe estar en formato PDF",
				filesize: "El tamaño máximo de la carta de postulación debe ser de 10 MB"
			}
		});
		
		// Comite editorial
		$("#comite").rules('add', {
			extension: "xls|xlsx",
			filesize: 10485760,
			messages: {
				extension: "El archivo del comité editorial debe ser un documento de Excel",
				filesize: "El tamaño máximo del archivo del comité editorial debe ser de 10 MB"
			}
		});
		
		$("#actas_acuerdos").rules('add', {
			extension: "pdf",
			filesize: 10485760,
			messages: {
				extension: "El archivo de actas y acuerdos debe ser un documento PDF",
				filesize: "El tamaño máximo del archivo de actas y acuerdos debe ser de 10 MB"
			}
		});
		
		$("#url_funciones").rules('add', {
			url: true,
			messages: {
				url: "La URL de funciones, reponsabilidades y normatividad es inválida"
			}
		});
		
		// Arbitraje
		$("#arbitros").rules('add', {
			extension: "xls|xlsx",
			filesize: 10485760,
			messages: {
				extension: "El archivo de la cartera de árbitros debe ser un documento de Excel",
				filesize: "El tamaño máximo de la cartera de árbitros debe ser de 10 MB"
			}
		});
		
		$("#bitacora").rules('add', {
			extension: "xls|xlsx",
			filesize: 10485760,
			messages: {
				extension: "El archivo de la bitácora de arbitraje debe ser un documento de Excel",
				filesize: "El tamaño máximo de la bitácora de arbitraje debe ser de 10 MB"
			}
		});
		
		// Distribución electrónica
		$("input[name='anio_distribucion[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de la distribución electrónica debe ser numérico",
				minlength: "El año de la distribución electrónica no es válido",
				maxlength: "El año de la distribución electrónica no es válido"
			}
		});
		
		$("input[name='numero_consecutivo[]']").rules('add', {
			pattern: /^[0-9\-\s]+$/,
			messages: {
				pattern: "El consecutivo de la distribución electrónica es inválido"
			}
		});
		
		$("input[name='consultas_abs_distribucion[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consultas a abstracts de la distribución electrónica debe ser numérico"
			}
		});
		
		$("input[name='html_distribucion[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de HTML de la distribución electrónica debe ser numérico"
			}
		});
		
		$("input[name='pdf_distribucion[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de PDF de la distribución electrónica debe ser numérico"
			}
		});
		
		$("input[name='anio_volumen[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de los volúmenes más consultados no es válido",
				minlength: "El año de los volúmenes más consultados no es válido",
				maxlength: "El año de los volúmenes más consultados no es válido"
			}
		});
		
		$("input[name='articulo_volumen[]']").rules('add', {
			pattern: /^[0-9\-\s]+$/,
			messages: {
				pattern: "El número de artículo de los volúmenes más consultados es inválido"
			}
		});
		
		$("input[name='consultas_volumen[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de abstracts de los volúmenes más consultados debe ser numérico"
			}
		});
		
		$("input[name='texto_volumen[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consulta de texto completo de los volúmenes más consultados debe ser numérico"
			}
		});
		
		$("input[name='anio_articulo[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de los artículos más descargados no es válido",
				minlength: "El año de los artículos más descargados no es válido",
				maxlength: "El año de los artículos más descargados no es válido"
			}
		});
		
		$("input[name='articulo_articulo[]']").rules('add', {
			pattern: /^[0-9\-\s]+$/,
			messages: {
				pattern: "El número de artículo de los artículos más descargados es inválido"
			}
		});
		
		$("input[name='anio_pais[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de los países que más consultan no es válido",
				minlength: "El año de los países que más consultan no es válido",
				maxlength: "El año de los países que más consultan no es válido"
			}
		});
		
		$("input[name='consultas_pais[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consultas de los países que más consultan debe ser numérico"
			}
		});
		
		$("input[name='texto_pais[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consultas de texto completo de los países que más consultan debe ser numérico"
			}
		});
		
		// Manuscritos recibidos
		$("#manuscritos_condicionados").rules('add', {
			extension: "xls|xlsx|pdf|zip",
			filesize: 10485760,
			messages: {
				extension: "El archivo de manuscritos rechazados debe ser un documento Excel",
				filesize: "El tamaño máximo del archivo de manuscritos rechazados debe ser de 10 MB"
			}
		});
		
		$("#manuscritos_aceptados").rules('add', {
			extension: "xls|xlsx|pdf|zip",
			filesize: 10485760,
			messages: {
				extension: "El archivo de manuscritos aceptados debe ser un documento de Excel o PDF",
				filesize: "El tamaño máximo del archivo de manuscritos aceptados debe ser de 10 MB"
			}
		});
		
		if($("input[name='mAceptado[]']").length) {
			$("input[name='mAceptado[]']").rules('add', {
				extension: "xls|xlsx|pdf|zip",
				filesize: 10485760,
				messages: {
					extension: "El archivo de manuscritos aceptados debe ser un documento de Excel o PDF",
					filesize: "El tamaño máximo del archivo de manuscritos aceptados debe ser de 10 MB"
				}
			});
		}
		
		if($("input[name='mRechazado[]']").length) {
			$("input[name='mRechazado[]']").rules('add', {
				extension: "xls|xlsx|pdf|zip",
				filesize: 10485760,
				messages: {
					extension: "El archivo de manuscritos aceptados debe ser un documento de Excel o PDF",
					filesize: "El tamaño máximo del archivo de manuscritos aceptados debe ser de 10 MB"
				}
			});
		}
		
		$("#dictamen").rules('add', {
			extension: "pdf",
			filesize: 10485760,
			messages: {
				extension: "El archivo del formato de dictamen debe estar en formato PDF",
				filesize: "El tamaño máximo del formato de dictamen debe ser de 10 MB"
			}
		});
		
		// Anexos
		$("input[name='archivo_anexo[]']").rules('add', {
			extension: "xls|xlsx|pdf",
			filesize: 10485760,
			messages: {
				extension: "El anexo tiene que ser Excel o PDF",
				filesize: "El tamaño del anexo no debe ser mayor a 10 MB"
			}
		});
		
		$("#formSolicitud div").each(function() {
			$(this).removeClass("has-error");
		});
		
		/*if($("#formSolicitud").valid()) {
			$.post('./guardarCambios',
				$("#formSolicitud").serialize(),
				function(data) {
					$('#mensajesError h4').html('Guardando');
					$('#mensajesError .modal-body').html('Los cambios han sido guardados correctamente');
					$('#mensajesError').modal();
				}
			);
		} else {
			$('#mensajesError').modal();
		}*/
		if($("#formSolicitud").valid()) {
			$("#formSolicitud").submit();
		} else {
			$('#mensajesError').modal();
		}
		//$("#formSolicitud").submit();
	});
}

function validarEnvio() {
	$("#btnFinalizar").click(function(e) {
		e.preventDefault();
		
		$("#formSolicitud input, #formSolicitud select").each(function() {
			$(this).rules('remove');
		});
		
		// Datos de la revista
		$("#tipo_solicitud").rules('add', {
			required: true,
			messages: {
				required: "El tipo de solicitud es obligatorio"
			}
		});

		$("input[name=formato_revista]").rules('add', {
			required: true,
			messages: {
				required: "El formato de la revista es obligatorio"
			}
		});
		
		$("#nombre_revista").rules('add', {
			required: true,
			messages: {
				required: "El nombre de la revista es obligatorio"
			}
		});
		
		$("#inicio_publicacion").rules('add', {
			required: true,
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				required: "El año de inicio de la publicación es obligatorio",
				digits: "El año de inicio de la publicación debe ser numérico",
				minlength: "El año de inicio de la publicación no es válido",
				maxlength: "El año de inicio de la publicación no es válido"
			}
		});
		
		$("#periodicidad").rules('add', {
			required: true,
			messages: {
				required: "La periodicidad es obligatoria"
			}
		});
		
		$("#area_conocimiento").rules('add', {
			required: true,
			messages: {
				required: "El área al que pertenece el tema de la revista es obligatorio"
			}
		});
		
		$("#disciplina_revista").rules('add', {
			required: true,
			messages: {
				required: "La disciplina de la revista es obligatoria"
			}
		});
		
		$("#subdisciplina_revista").rules('add', {
			required: true,
			messages: {
				required: "La subdisciplina de la revista es obligatoria"
			}
		});
		
		$("#promedio_articulos").rules('add', {
			required: true,
			digits: true,
			messages: {
				required: "El número de artículos publicados es obligatorio",
				digits: "El número de artículos publicados no es válido"
			}
		});
		
		$("#porcentaje_rechazados").rules('add', {
			required: true,
			number: true,
			messages: {
				required: "El porcentaje de artículos rechazados es obligatorio",
				number: "El porcentaje de artículos rechazados tiene un formato inválido"
			}
		});
		
		$("#tiempo_promedio").rules('add', {
			required: true,
			digits: true,
			messages: {
				required: "El tiempo entre recepción y aprobación es obligatorio",
				digits: "Escribe únicamente el número de meses entre la recepción y aprobación"
			}
		});
		
		$("#factor_impacto").rules('add', {
			required: true,
			number: true,
			messages: {
				required: "El factor de impacto es obligatorio",
				number: "El factor de impacto tiene un formato inválido"
			}
		});
		
		$("#issn_impreso").rules('add', {
			required: true,
			remote: {
				url: "./solicitud/revisarISSNRepetido",
				type: "post",
				async: false,
				data: {
					issn: function() {
						return $("#issn_impreso").val();
					},
					solicitud: function() {
						return $("#hdn_solicitud").val();
					},
					nombre: function() {
						return $("#nombre_revista").val();
					}
				}
			},
			messages: {
				required: "Es necesario capturar el ISSN impreso",
				remote: "Este revista ya cuenta con un registro previo"
			}
		});
		
		if($("#carta_exencion").length) {
			$("#carta_exencion").rules('add', {
				extension: "pdf",
				filesize: 10485760,
				messages: {
					extension: "La carta de exención debe estar en formato PDF",
					filesize: "El tamaño máximo de la carta de exención debe ser de 10 MB"
				}
			});
		}
		
		$("input[name='num_dist_elect[]']").rules('add', {
			pattern: /^[0-9\-\s]+$/,
			messages: {
				pattern: "El formato del número de la revista es inválido"
			}
		});
		
		$("input[name='anio_dist_elect[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de la publicación debe ser numérico",
				minlength: "El año de la publicación no es válido",
				maxlength: "El año de la publicación no es válido"
			}
		});
		
		$("input[name='url_dist_elect[]']").rules('add', {
			url: true,
			messages: {
				url: "La URL del número de la revista es inválida"
			}
		});
		
		$("#num_ejemplares").rules('add', {
			min: 2,
			messages: {
				min: "Debes agregar los datos de los ejemplares solicitados"
			}
		});
		
		$("#institucion_revista").rules('add', {
			required: true,
			messages: {
				required: "El nombre de la institución que publica la revista es obligatorio"
			}
		});
		
		$("#calle_revista").rules('add', {
			required: true,
			messages: {
				required: "La calle y número son obligatorios"
			}
		});
		
		$("#colonia_revista").rules('add', {
			required: true,
			messages: {
				required: "La colonia es obligatoria"
			}
		});
		
		$("#pais_revista").rules('add', {
			required: true,
			messages: {
				required: "El país es obligatorio"
			}
		});
		
		$("#entidad_revista").rules('add', {
			required: true,
			messages: {
				required: "El estado o entidad federativa es obligatorio"
			}
		});
		
		$("#ciudad_revista").rules('add', {
			required: true,
			messages: {
				required: "La ciudad es obligatoria"
			}
		});
		
		$("#cp_revista").rules('add', {
			required: true,
			digits: true,
			minlength: 5,
			maxlength: 5,
			messages: {
				required: "El código postal es obligatorio",
				digits: "El código postal debe ser numérico",
				minlength: "El código postal debe ser de 5 dígitos",
				maxlength: "El código postal debe ser de 5 dígitos"
			}
		});
		
		$("#grado_editor").rules('add', {
			required: true,
			messages: {
				required: "El grado del editor es obligatorio"
			}
		});
		
		$("#cargo_editor").rules('add', {
			required: true,
			messages: {
				required: "El cargo del editor es obligatorio"
			}
		});
		
		$("#telefono_editor").rules('add', {
			required: true,
			messages: {
				required: "El teléfono del editor es obligatorio"
			}
		});
		
		$("#carta_postulacion").rules('add', {
			required: true,
			extension: "pdf",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar la carta de postulación",
				extension: "La carta de postulación debe estar en formato PDF",
				filesize: "El tamaño máximo de la carta de postulación debe ser de 10 MB"
			}
		});
		
		$("#url_sistema_gestion").rules('add', {
			required: function() {
				if($('#tipo_solicitud option:selected').text() == 'Renovación automática') {
					return true;
				} else {
					return false;
				}
			},
			url: true,
			messages: {
				required: "La url de su sistema de gestión editorial es obligatoria",
				url: "La url del sistema de gestión editorial es inválida"
			}
		});
		
		$("#usr_temporal").rules('add', {
			required: function() {
				if($('#tipo_solicitud option:selected').text() == 'Renovación automática') {
					return true;
				} else {
					return false;
				}
			},
			messages: {
				required: "El usuario para acceder temporalmente a su sistema de gestión es obligatorio"
			}
		});
		
		$("#psw_temporal").rules('add', {
			required: function() {
				if($('#tipo_solicitud option:selected').text() == 'Renovación automática') {
					return true;
				} else {
					return false;
				}
			},
			messages: {
				required: "La contraseña para acceder temporalmente a su sistema de gestión es obligatorio"
			}
		});
		
		// Comite editorial
		$("#comite").rules('add', {
			required: true,
			extension: "xls|xlsx",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar el archivo del comité editorial",
				extension: "El archivo del comité editorial debe ser un documento de Excel",
				filesize: "El tamaño máximo del archivo del comité editorial debe ser de 10 MB"
			}
		});
		
		$("#actas_acuerdos").rules('add', {
			required: true,
			extension: "pdf",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar el archivo de actas y acuerdos",
				extension: "El archivo de actas y acuerdos debe ser un documento PDF",
				filesize: "El tamaño máximo del archivo de actas y acuerdos debe ser de 10 MB"
			}
		});
		
		$("#url_funciones").rules('add', {
			required: true,
			url: true,
			messages: {
				required: "La URL de funciones, reponsabilidades y normatividad es obligatoria",
				url: "La URL de funciones, reponsabilidades y normatividad es inválida"
			}
		});
		
		// Arbitraje
		$("#arbitros").rules('add', {
			required: true,
			extension: "xls|xlsx",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar el archivo de la cartera de árbitros",
				extension: "El archivo de la cartera de árbitros debe ser un documento de Excel",
				filesize: "El tamaño máximo de la cartera de árbitros debe ser de 10 MB"
			}
		});
		
		$("#bitacora").rules('add', {
			required: true,
			extension: "xls|xlsx",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar el archivo de la bitácora de arbitraje",
				extension: "El archivo de la bitácora de arbitraje debe ser un documento de Excel",
				filesize: "El tamaño máximo de la bitácora de arbitraje debe ser de 10 MB"
			}
		});
		
		//Índices
		$("#url_presencia_bd").rules('add', {
			required: true,
			url: true,
			messages: {
				required: "La URL de presencia en bases de datos es obligatoria",
				url: "La URL de presencia en bases de datos es inválida"
			}
		});
		
		$("#num_indices").rules('add', {
			min: 2,
			messages: {
				min: "Debes agregar los datos de los índices solicitados"
			}
		});
		
		$("#num_abstracts").rules('add', {
			min: 2,
			messages: {
				min: "Debes agregar los datos de los servicios de resúmenes solicitados"
			}
		});
		
		// Distribución electrónica
		$("input[name='anio_distribucion[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de la distribución electrónica debe ser numérico",
				minlength: "El año de la distribución electrónica no es válido",
				maxlength: "El año de la distribución electrónica no es válido"
			}
		});
		
		$("#num_distribuciones").rules('add', {
			min: 2,
			messages: {
				min: "Debes agregar los datos de las distribuciones electrónicas solicitados"
			}
		});
		
		$("input[name='numero_consecutivo[]']").rules('add', {
			pattern: /^[0-9\-\s]+$/,
			messages: {
				pattern: "El consecutivo de la distribución electrónica es inválido"
			}
		});
		
		$("input[name='consultas_abs_distribucion[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consultas a abstracts de la distribución electrónica debe ser numérico"
			}
		});
		
		$("input[name='html_distribucion[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de HTML de la distribución electrónica debe ser numérico"
			}
		});
		
		$("input[name='pdf_distribucion[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de PDF de la distribución electrónica debe ser numérico"
			}
		});
		
		$("#num_volumen").rules('add', {
			min: 3,
			messages: {
				min: "Debes agregar los datos de los volúmenes consultados que se solicitan"
			}
		});
		
		$("input[name='anio_volumen[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de los volúmenes más consultados no es válido",
				minlength: "El año de los volúmenes más consultados no es válido",
				maxlength: "El año de los volúmenes más consultados no es válido"
			}
		});
		
		$("input[name='articulo_volumen[]']").rules('add', {
			pattern: /^[0-9\-\s]+$/,
			messages: {
				pattern: "El número de artículo de los volúmenes más consultados es inválido"
			}
		});
		
		$("input[name='consultas_volumen[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de abstracts de los volúmenes más consultados debe ser numérico"
			}
		});
		
		$("input[name='texto_volumen[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consulta de texto completo de los volúmenes más consultados debe ser numérico"
			}
		});
		
		$("#num_articulo").rules('add', {
			min: 3,
			messages: {
				min: "Debes agregar la información de los artículos descargados que se solicitan"
			}
		});
		
		$("input[name='anio_articulo[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de los artículos más descargados no es válido",
				minlength: "El año de los artículos más descargados no es válido",
				maxlength: "El año de los artículos más descargados no es válido"
			}
		});
		
		$("input[name='articulo_articulo[]']").rules('add', {
			pattern: /^[0-9\-\s]+$/,
			messages: {
				pattern: "El número de artículo de los artículos más descargados es inválido"
			}
		});
		
		$("#num_paises").rules('add', {
			min: 3,
			messages: {
				min: "Debes agregar la información de los países que se solicitan"
			}
		});
		
		$("input[name='anio_pais[]']").rules('add', {
			digits: true,
			minlength: 4,
			maxlength: 4,
			messages: {
				digits: "El año de los países que más consultan no es válido",
				minlength: "El año de los países que más consultan no es válido",
				maxlength: "El año de los países que más consultan no es válido"
			}
		});
		
		$("input[name='consultas_pais[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consultas de los países que más consultan debe ser numérico"
			}
		});
		
		$("input[name='texto_pais[]']").rules('add', {
			digits: true,
			messages: {
				digits: "El número de consultas de texto completo de los países que más consultan debe ser numérico"
			}
		});
		
		// Manuscritos recibidos
		$("#manuscritos_condicionados").rules('add', {
			required: true,
			extension: "xls|xlsx|pdf|zip",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar el archivo de manuscritos rechazados o condicionados",
				extension: "El archivo de manuscritos rechazados debe ser un documento Excel",
				filesize: "El tamaño máximo del archivo de manuscritos rechazados debe ser de 10 MB"
			}
		});
		
		$("#manuscritos_aceptados").rules('add', {
			required: true,
			extension: "xls|xlsx|pdf|zip",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar el archivo de manuscritos aceptados",
				extension: "El archivo de manuscritos aceptados debe ser un documento de Excel",
				filesize: "El tamaño máximo del archivo de manuscritos aceptados debe ser de 10 MB"
			}
		});
		
		if($("input[name='mAceptado[]']").length) {
			$("input[name='mAceptado[]']").rules('add', {
				extension: "xls|xlsx|pdf|zip",
				filesize: 10485760,
				messages: {
					extension: "El archivo de manuscritos aceptados debe ser un documento de Excel o PDF",
					filesize: "El tamaño máximo del archivo de manuscritos aceptados debe ser de 10 MB"
				}
			});
		}
		
		if($("input[name='mRechazado[]']").length) {
			$("input[name='mRechazado[]']").rules('add', {
				extension: "xls|xlsx|pdf|zip",
				filesize: 10485760,
				messages: {
					extension: "El archivo de manuscritos aceptados debe ser un documento de Excel o PDF",
					filesize: "El tamaño máximo del archivo de manuscritos aceptados debe ser de 10 MB"
				}
			});
		}
		
		$("#dictamen").rules('add', {
			required: true,
			extension: "pdf",
			filesize: 10485760,
			messages: {
				required: "Falta adjuntar el archivo del formato de dictamen",
				extension: "El archivo del formato de dictamen debe estar en formato PDF",
				filesize: "El tamaño máximo del formato de dictamen debe ser de 10 MB"
			}
		});
		
		// Anexos
		$("input[name='descripcion_anexo[]']").rules('add', {
			required: function(element){
	            return $("input[name='archivo_anexo[]']").val().length > 0;
	        },
			messages: {
				required: "La descripción del archivo anexo es obligatoria"
			}
		});
		
		$("input[name='archivo_anexo[]']").rules('add', {
			extension: "xls|xlsx|pdf",
			filesize: 10485760,
			messages: {
				extension: "El anexo tiene que ser Excel o PDF",
				filesize: "El tamaño del anexo no debe ser mayor a 10 MB"
			}
		});
		
		// Disposición para reunirse con el comité
		$("input[name=rdb_reunion]").rules('add', {
			required: true,
			messages: {
				required: "Seleccione si puede reunirse con el comité en caso de ser necesario"
			}
		});
		
		$("#formSolicitud div").each(function() {
			$(this).removeClass("has-error");
		});
		
		if($("#formSolicitud").valid()) {
			$("#formSolicitud").attr("action", "./solicitud/finalizarSolicitud");
			
			$("#mensajeEliminar h4.modal-title").html('Advertencia');
			$("#mensajeEliminar .modal-body").html('<p>Una vez finalizada tu solicitud no se podrá hacer modificación alguna, ¿deseas continuar?</p>');
			$("#mensajeEliminar .modal-footer .btn-primary").html("Finalizar");
			$("#mensajeEliminar .modal-footer .btn-primary").css("display", "inline");
			$("#mensajeEliminar .modal-footer .btn-default").html("Cancelar");
			$("#mensajeEliminar").modal();
			
			$("#mensajeEliminar .modal-footer .btn-primary").click(function() {
				$('#mensajeEliminar').modal('hide');
				$("#formSolicitud").submit();
			});
		} else {
			$('#mensajesError').modal();
		}
	});
}

function validar() {
	$.validator.addMethod('filesize', function(value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param)
	});
	
	$.validator.addMethod('minElements', function(value, element, param) {
		var el = $(element);
		var total = 0;
		
		$("input").each(function() {
			if($(this).attr("name") == el.attr("name")) {
				total++;
			}
		});
		
	    return (total >= param)
	});

	$("#formSolicitud").validate({
		ignore: [],
		errorLabelContainer: "#mensajesError .modal-body ul",
		errorElement: 'li',
		onkeyup: false,
        highlight: function(element) {
            $(element).closest('div').addClass('has-error');
            $(element).closest('div').removeClass('has-success');
            //$("ul.nav-tabs li a").find("#" + $(element).parents(".tab-pane").attr("id")).css('border', "1px #f00 solid");
            //$("ul.nav-tabs li:nth-child(2) a").css('border', "1px #f00 solid");
		},
        unhighlight: function(element) {
            $(element).closest('div').addClass('has-success ');
        	$(element).closest('div').removeClass('has-error');
		}
	});
}

$(function() {
	inicializar();
	mostrarTipoSolicitud();
	agregarURL();
	agregarIndices();
	agregarDistribucion();
	agregarManuscritos();
	agregarAnexos();
	validar();
	validarCambios();
	validarEnvio();
})