<script type="text/javascript">
	$(function() {
		$("a").click(function(e) {
			e.preventDefault();
			
			var id = $(this).data("solicitud");
			$("#hdnListaSol").val(id);
			$("#formListado").submit();
		});
	});
</script>

<?php
	$attr = array(
		'id'	=>	'formListado',
		'name'	=>	'formListado'
	);
	
	echo form_open(base_url('solicitud'), $attr);
?>
<table class="table table-bordered table-condensed table-striped">
    <tr>
      <th>#</th>
      <th>Nombre de la revista</th>
      <th>Estatus</th>
    </tr>
    <?php
	$i = 1;
	$estatus = "";
	
	foreach($registros->result() as $val) {
		$estatus = ($val->estatus == 1) ? "En proceso" : "Finalizado";
?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><a href="#" data-solicitud="<?php echo $val->id_solicitud; ?>"><?php echo $val->nombre; ?></a></td>
      <td><?php echo $estatus; ?></td>
    </tr>
    <?php
		$i++;
	}
?>
  </table>
<?php
	$attr = array(
		'id'	=>	'hdnListaSol',
		'name'	=>	'hdnListaSol',
		'value'	=>	'',
		'type'	=>	'hidden'
	);
	
	echo form_input($attr);
	
	echo form_close();
?>