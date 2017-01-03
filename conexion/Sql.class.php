<?php
class Sql {
	
	var $cadenaSql;
	
	function __construct() {
	}
	
	function sql($servicio,$opcion, $parametro) {
                $ruta="../aplicativo/servicio/".$servicio;
                require_once ($ruta."/sql.php");
		$cadenaSql = new SqlService ();
                $this->cadenaSql=$cadenaSql->sql ( $opcion, $parametro );
		error_log($this->cadenaSql);
		return true;
	}
	
	function getCadenaSql(){
		return $this->cadenaSql;
	}
}
?>
