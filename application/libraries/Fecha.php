<?php
class Fecha {
	public static function ConvertirMySQL($fecha, $hora = "") {
		$nFecha = explode("/", $fecha);
		$nFecha = array_reverse($nFecha);
		$nFecha = implode("-", $nFecha);

		return $nFecha;
	}
	
	public static function ConvertirNormal($fecha, $hora = "") {
		$nFecha = explode("-", $fecha);
		$nFecha = array_reverse($nFecha);
		$nFecha = implode("/", $nFecha);
	
		return $nFecha;
	}
}
?>