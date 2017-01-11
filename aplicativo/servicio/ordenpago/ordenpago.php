<?php
/* * *************************************************************************
 * @name ordenpago.php
 * @author Jairo Lavado Hernandez
 * @revision Última revisión 10 de Enero de 2017
 * ***************************************************************************
 * @subpackage
 * @package clase
 * @copyright
 * @version 0.1
 * @author Jairo Lavado Hernández
 * @link http://computo.udistrital.edu.co
 * @description Esta clase esta disennada para administrar todas las funciones
 * relacionadas a los servicios relacionados con las ordenes de pago en el
 * sistema Sicapital
 * **************************************************************************** */
class Ordenpago {

	var $conexionOracle;
	var $mensajeError;
        var $miFabricaConexiones;
        var $miservicio;

	function __construct($conexion,$servicio,$FabricaConexiones){
                
		$this->mensajeError='NINGUNO';
                $this->conexionOracle=$conexion;
                $this->miFabricaConexiones=$FabricaConexiones;
                $this->servicio=$servicio;

                }
    /**
    * Respuesta al cliente
    * @param int $code Codigo de respuesta HTTP
    * @param String $status indica el estado de la respuesta puede ser "success" o "error"
    * @param String $message Descripcion de lo ocurrido
    * 
    * Los códigos de respuesta que utilizados:
    * 500 : Internal Server Error → Se ha producido un error interno
    * 422 : Unprocessable Entity → Entidad no procesable
    * 400 : Bad Request → La solicitud contiene sintaxis errónea y no debería repetirse
    * 200 : Éxito → La petición se ha completado con éxito
    * 204 : No Content → La petición se ha completado con éxito pero su respuesta no tiene ningún contenido      
    * 
    */
    function response($code=200, $status="", $message="") {
       http_response_code($code);
       if( !empty($status) && !empty($message) ){
           $response = array("status" => $status ,"message"=>$message);  
           echo json_encode($response,JSON_PRETTY_PRINT);    
       }            
    }                 

    function rescatarOrdenpago(){
            $parametros=array();
            //rescata los valores de los parametros
            foreach ($_GET as $key => $value) 
                { if(strpos($key, 'id')===0)
                        { $parametros[$key]=$value;}
                }

            switch($_GET['action'])
                { case 'opcdp':
                      $cadenaSql = $this->miFabricaConexiones->getCadenaSql ($this->servicio, 'opxcdp', $parametros);
                  break;
                  default://contiene sintaxis errónea
                      $this->response(400);
                  break;
                }
            $registro=$this->conexionOracle->ejecutarAcceso ( $cadenaSql, "busqueda" );
            echo json_encode($registro,JSON_PRETTY_PRINT);
            //return $registro;

    }
        /*
        private function insertarTRubros(){

		$cadenaSql = $this->miFabricaConexiones->getCadenaSql ( 'insertar_Trubros', $this->transaccion );
		$registro=$this->conexionMysql->ejecutarAcceso ( $cadenaSql, "insertar" );
		return $registro;

	}
        
        private function actualizarTRubros(){

		$cadenaSql = $this->miFabricaConexiones->getCadenaSql ( 'actualizar_Trubros', $this->transaccion );
		$registro=$this->conexionMysql->ejecutarAcceso ( $cadenaSql, "actualizar" );
		return $registro;

	}
        
        private function borrarTRubros(){

		$cadenaSql = $this->miFabricaConexiones->getCadenaSql ( 'borrar_Trubros', $this->transaccion );
		$registro=$this->conexionMysql->ejecutarAcceso ( $cadenaSql, "borrar" );
		return $registro;

	}
	private function rescatarRPadre(){

		$cadenaSql = $this->miFabricaConexiones->getCadenaSql ( 'consultar_RPadre', $this->transaccion );
		@$registro=$this->conexionMysql->ejecutarAcceso ( $cadenaSql, "busqueda" );
		return $registro;

	}        
        */
}

?>
