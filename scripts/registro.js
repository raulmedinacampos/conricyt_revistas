/**
 * Funciones utilizadas en el formulario de registro
 */

function inicializar() {
	$.validator.addMethod('filesize', function(value, element, param) {
	    // param = size (en bytes) 
	    // element = element to validate (<input>)
	    // value = value of the element (file name)
	    return this.optional(element) || (element.files[0].size <= param) 
	});
	
	cancelarRegistro();
	
	$("#correo_conf").bind("cut copy paste",function(e) {
		e.preventDefault();
	});
	
	$("#btn_guardar").click(function() {
		if($("#formRegistro").valid()) {
			$("#formRegistro").submit();
		} else {
			$('#mensajesError').modal();
		}
	});
	
	$("#archivo_cvu").tooltip();
	
	$(".bootstrap-filestyle *").mouseover(function() {
		$("#archivo_cvu").trigger("mouseover");
	});
	
	$(".bootstrap-filestyle *").mouseout(function() {
		$("#archivo_cvu").trigger("mouseout");
	});
	
	$("#btn_captcha").click(function(e) {
		obtenerImagen();
	});
}

function validarApellidos() {
	$("#chkApPaterno, #chkApMaterno").click(function() {
		if($(this).is(":checked")) {
			$(this).parents("div").children(".form-control").attr("disabled", "disabled");
			$("#chkApPaterno, #chkApMaterno").not($(this)).attr("disabled", "disabled");
			
			if($(this).closest("div").hasClass("has-error")) {
				$(this).closest("div").removeClass("has-error").addClass("has-success");
			}
		} else {
			$(this).parents("div").children(".form-control").removeAttr("disabled");
			$("#chkApPaterno, #chkApMaterno").not($(this)).removeAttr("disabled");
			
			if($(this).closest("div").hasClass("has-success") && !$(this).parents("div").children(".form-control").val()) {
				$(this).closest("div").removeClass("has-success").addClass("has-error");
			}
		}
	});
}

function validarFormulario() {
	$("#formRegistro").validate({
		errorLabelContainer: "#mensajesError .modal-body ul",
		errorElement: 'li',
		onkeyup: false,
		rules: {
			nombre: {
				required: true
			},
			ap_paterno: {
				required: "#chkApPaterno:unchecked",
			},
			ap_materno: {
				required: "#chkApMaterno:unchecked",
			},
			correo: {
				required: true,
				email: true,
				remote: {
					url: "./registro/revisarCorreoRepetido",
					type: "post",
					async: false
				}
			},
			correo_conf: {
				required: true,
				equalTo: "#correo"
			},
			archivo_cvu: {
				required: true,
				extension: "doc|docx|pdf",
				filesize: 10485760
			},
			captcha: {
				required: true,
				equalTo: "#oculto"
			}				
		},
		messages: {
			nombre: "El nombre es obligatorio",
			ap_paterno: "El apellido paterno es obligatorio",
			ap_materno: "El apellido materno es obligatorio",
			correo: {
				required: "El correo es obligatorio",
				email: "El formato del correo es incorrecto",
				remote: "El usuario ya existe"
			},
			correo_conf: {
				required: "Falta confirmar su correo electrónico",
				equalTo: "El correo electrónico no coincide"
			},
			archivo_cvu: {
				required: "Es necesario subir su CVU",
				extension: "El CVU debe ser un documento de Word o PDF",
				filesize: "El tamaño máximo del archivo debe ser de 10 MB"
			},
			captcha: {
				required: "Falta escribir el texto de la imagen",
				equalTo: "El código escrito es incorrecto"
			}
		},
        highlight: function(element) {
            $(element).closest('div').addClass('has-error');
            $(element).closest('div').removeClass('has-success');
		},
        unhighlight: function(element) {
            $(element).closest('div').addClass('has-success ');
        	$(element).closest('div').removeClass('has-error');
		}
	});
}

$(function() {
	inicializar();
	obtenerImagen();
	validarApellidos();
	validarFormulario();
});