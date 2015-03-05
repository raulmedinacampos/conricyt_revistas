function validarFormulario() {
	$("#formDictamen").validate({
		ignore: [],
		errorLabelContainer: "#mensajesError .modal-body ul",
		errorElement: 'li',
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
			dictamen: "required",
			comentarios: "required"
		},
		messages: {
			dictamen: "Seleccione el dictamen de la revista",
			comentarios: "Escriba los comentarios finales de la revista"
			
		}
	});
	
	$("#btnGuardar").click(function() {
		if($("#formDictamen").valid()) {
			$("#formDictamen").submit();
		} else {
			$("#mensajesError h4.modal-title").html("Error");
			$("#mensajesError .btn-default").html("Aceptar");
			$("#mensajesError .btn-primary").css("display", "none");
			$("#mensajesError").modal('show');
		}
	});
}

function imprimirComprobante() {
	$("#btnImprimir").click(function() {
		$("#formImprimir").submit();
	});
}

$(function() {
	validarFormulario();
	imprimirComprobante();
});