function inicializarCalendario() {
	$("#datetimepicker1").datetimepicker({
		format: 'DD/MM/YYYY'
	});
}

function calcularCalificacion() {
	var cp1 = 10;
	var rd1;
	$('input[name="rdb_1"]').each(function() {
		if($(this).is(":checked")) {
			rd1 = $(this).val();
		} 
	});
	rd1 = parseFloat(rd1);
	
	cp1 = cp1 * rd1;
	$("#cp_1").html("Calificación parcial: "+cp1.toFixed(2)+"%");
	
	var cp2 = 30;
	var rd;
	var rd2;
	$('input[name="rdb_2"]').each(function() {
		if($(this).is(":checked")) {
			rd2 = $(this).val();
		} 
	});
	rd2 = parseFloat(rd2);
	
	var rd3;
	$('input[name="rdb_3"]').each(function() {
		if($(this).is(":checked")) {
			rd3 = $(this).val();
		} 
	});
	rd3 = parseFloat(rd3);
	
	var rd4;
	$('input[name="rdb_4"]').each(function() {
		if($(this).is(":checked")) {
			rd4 = $(this).val();
		} 
	});
	rd4 = parseFloat(rd4);
	
	var rd5;
	$('input[name="rdb_5"]').each(function() {
		if($(this).is(":checked")) {
			rd5 = $(this).val();
		} 
	});
	rd5 = parseFloat(rd5);
	
	rd = (rd2+rd3+rd4+rd5)/4;
	cp2 = cp2 * rd;
	$("#cp_2").html("Calificación parcial: "+cp2.toFixed(2)+"%");
	
	var cp3 = 30;
	var rd;
	var rd6;
	$('input[name="rdb_6"]').each(function() {
		if($(this).is(":checked")) {
			rd6 = $(this).val();
		} 
	});
	rd6 = parseFloat(rd6);
	
	var rd7;
	$('input[name="rdb_7"]').each(function() {
		if($(this).is(":checked")) {
			rd7 = $(this).val();
		} 
	});
	rd7 = parseFloat(rd7);
	
	var rd8;
	$('input[name="rdb_8"]').each(function() {
		if($(this).is(":checked")) {
			rd8 = $(this).val();
		} 
	});
	rd8 = parseFloat(rd8);
	
	var rd9;
	$('input[name="rdb_9"]').each(function() {
		if($(this).is(":checked")) {
			rd9 = $(this).val();
		} 
	});
	rd9 = parseFloat(rd9);
	
	var rd10;
	$('input[name="rdb_10"]').each(function() {
		if($(this).is(":checked")) {
			rd10 = $(this).val();
		} 
	});
	rd10 = parseFloat(rd10);
	
	var rd11;
	$('input[name="rdb_11"]').each(function() {
		if($(this).is(":checked")) {
			rd11 = $(this).val();
		} 
	});
	rd11 = parseFloat(rd11);
	
	var rd12;
	$('input[name="rdb_12"]').each(function() {
		if($(this).is(":checked")) {
			rd12 = $(this).val();
		} 
	});
	rd12 = parseFloat(rd12);
	
	var rd13;
	$('input[name="rdb_13"]').each(function() {
		if($(this).is(":checked")) {
			rd13 = $(this).val();
		} 
	});
	rd13 = parseFloat(rd13);
	
	var rd14;
	$('input[name="rdb_14"]').each(function() {
		if($(this).is(":checked")) {
			rd14 = $(this).val();
		} 
	});
	rd14 = parseFloat(rd14);
	
	var rd15;
	$('input[name="rdb_15"]').each(function() {
		if($(this).is(":checked")) {
			rd15 = $(this).val();
		} 
	});
	rd15 = parseFloat(rd15);
	
	var rd19;
	$('input[name="rdb_19"]').each(function() {
		if($(this).is(":checked")) {
			rd19 = $(this).val();
		} 
	});
	rd19 = parseFloat(rd19);
	
	/* rd9 no se cuenta porque es extra */
	rd = (rd6+rd7+rd8+rd10+rd11+rd12+rd13+rd14+rd15+rd19)/10;
	cp3 = cp3 * rd;
	$("#cp_3").html("Calificación parcial: "+cp3.toFixed(2)+"%");
	
	var cp4 = 20;
	var rd;
	var rd22;
	$('input[name="rdb_22"]').each(function() {
		if($(this).is(":checked")) {
			rd22 = $(this).val();
		} 
	});
	rd22 = parseFloat(rd22);
	
	var rd23;
	$('input[name="rdb_23"]').each(function() {
		if($(this).is(":checked")) {
			rd23 = $(this).val();
		} 
	});
	rd23 = parseFloat(rd23);
	
	var rd24;
	$('input[name="rdb_24"]').each(function() {
		if($(this).is(":checked")) {
			rd24 = $(this).val();
		} 
	});
	rd24 = parseFloat(rd24);
	
	var rd25;
	$('input[name="rdb_25"]').each(function() {
		if($(this).is(":checked")) {
			rd25 = $(this).val();
		} 
	});
	rd25 = parseFloat(rd25);
	
	var rd26;
	$('input[name="rdb_26"]').each(function() {
		if($(this).is(":checked")) {
			rd26 = $(this).val();
		} 
	});
	rd26 = parseFloat(rd26);
	
	/* rd26 no se cuenta porque es extra */
	rd = (rd22+rd23+rd24+rd25)/4;
	cp4 = cp4 * rd;
	$("#cp_4").html("Calificación parcial: "+cp4.toFixed(2)+"%");
	
	var cp5 = 10;
	var rd35;
	$('input[name="rdb_35"]').each(function() {
		if($(this).is(":checked")) {
			rd35 = $(this).val();
		} 
	});
	rd35 = parseFloat(rd35);
	
	cp5 = cp5 * rd35;
	$("#cp_5").html("Calificación parcial: "+cp5.toFixed(2)+"%");
	
	var cf = parseFloat(cp1)+parseFloat(cp2)+parseFloat(cp3)+parseFloat(cp4)+parseFloat(cp5);
	if(rd9 > 0) {
		cf = cf + 1.36;
	}
	
	if(rd26 > 0) {
		cf = cf + 2.5;
	}
	
	if(isNaN(cf) == false) {	
		$("#calificacion_final").val(cf);
	} else {
		$("#calificacion_final").val('');
	}
}

function guardarCambios() {
	$("#btnGuardar").click(function() {
		$("#formDatos").attr("action", "./guardarCambios");
		$("#formDatos").submit();
	});
}

function finalizarEvaluacion() {
	$("#btnFinalizar").click(function() {
		$("#formDatos").attr("action", "./finalizarEvaluacion");
		validarFormulario();
		
		if($("#formDatos").valid()) {
			$("#formDatos").submit();
		} else {
			$("#mensajeAvisos h4.modal-title").html("Error");
			$("#mensajeAvisos .modal-body p").html("Faltan preguntas por responder, revíse cuidadosamente el formulario");
			$("#mensajeAvisos .modal-footer .btn-default").html("Aceptar");
			$("#mensajeAvisos .modal-footer .btn-primary").css("display", "none");
			$("#mensajeAvisos").modal();
		}
	});
}

function validarFormulario() {
	$("#formDatos").validate({
		ignore: [],
		errorElement: 'span',
		onkeyup: false,
        highlight: function(element) {
            $(element).closest('div').addClass('has-error');
            $(element).closest('div').removeClass('has-success');
		},
        unhighlight: function(element) {
            $(element).closest('div').addClass('has-success ');
        	$(element).closest('div').removeClass('has-error');
		},
		rules: {
			fecha_evaluacion: "required",
			rdb_1: "required",
			txt_1: "required",
			rdb_2: "required",
			txt_2: "required",
			rdb_3: "required",
			txt_3: "required",
			rdb_4: "required",
			txt_4: "required",
			rdb_5: "required",
			txt_5: "required",
			rdb_6: "required",
			txt_6: "required",
			rdb_7: "required",
			txt_7: "required",
			rdb_8: "required",
			txt_8: "required",
			rdb_9: "required",
			txt_9: "required",
			rdb_10: "required",
			txt_10: "required",
			rdb_11: "required",
			txt_11: "required",
			rdb_12: "required",
			txt_12: "required",
			rdb_13: "required",
			txt_13: "required",
			rdb_14: "required",
			txt_14: "required",
			rdb_15: "required",
			txt_15: "required",
			rdb_19: "required",
			txt_19: "required",
			rdb_22: "required",
			txt_22: "required",
			rdb_23: "required",
			txt_23: "required",
			rdb_24: "required",
			txt_24: "required",
			rdb_25: "required",
			txt_25: "required",
			rdb_35: "required",
			txt_35: "required",
		},
		messages: {
			fecha_evaluacion: "",
			rdb_1: "",
			txt_1: "",
			rdb_2: "",
			txt_2: "",
			rdb_3: "",
			txt_3: "",
			rdb_4: "",
			txt_4: "",
			rdb_5: "",
			txt_5: "",
			rdb_6: "",
			txt_6: "",
			rdb_7: "",
			txt_7: "",
			rdb_8: "",
			txt_8: "",
			rdb_9: "",
			txt_9: "",
			rdb_10: "",
			txt_10: "",
			rdb_11: "",
			txt_11: "",
			rdb_12: "",
			txt_12: "",
			rdb_13: "",
			txt_13: "",
			rdb_14: "",
			txt_14: "",
			rdb_15: "",
			txt_15: "",
			rdb_19: "",
			txt_19: "",
			rdb_22: "",
			txt_22: "",
			rdb_23: "",
			txt_23: "",
			rdb_24: "",
			txt_24: "",
			rdb_25: "",
			txt_25: "",
			rdb_35: "",
			txt_35: ""
		}
	});
}

$(function() {
	inicializarCalendario();
	calcularCalificacion();
	//validarFormulario();
	guardarCambios();
	finalizarEvaluacion();
	
	$('input[type="radio"]').click(function() {
		calcularCalificacion();
	});
});