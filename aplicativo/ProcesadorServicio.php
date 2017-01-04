<?php
require_once ("DatoConexion.php");
require_once ("../conexion/FabricaDbConexion.class.php");
class ProcesadorServicio {

    var $miFabricaConexiones;
    var $conexionOracle;
    var $conexionPostgresql;
    var $conexionMysql;
    var $mensajeError;
    var $servicio;
    var $recurso;

    function __construct(){

    $this->miFabricaConexiones = new FabricaDBConexion ();
    $this->mensajeError='NINGUNO';
    $this->servicio=$_GET['service'];
    $this->crearConexiones();
    }

    private function crearConexiones(){

            $datosConexion = new DatoConexion ();
            $datosConexion->setDatosConexion ( "oracle" );
            $this->miFabricaConexiones->setRecursoDB ( "oracle", $datosConexion );
            $this->conexionOracle = $this->miFabricaConexiones->getRecursoDB ( "oracle" );		
            if (! $this->conexionOracle) {
                error_log ('NO SE CONECTO A ORACLE' );
                //Si no se puede realizar la conexión
                http_response_code(500);
                exit;
            }
            return true;	
    }


    function Servicio($method) {
        //se identifica el metodo de conexion al WS
        switch ($method) 
            {   case 'GET'://consulta
                    $this->getService();
                    break;     
                case 'POST'://inserta
                    $this->saveService();
                    break;                
                case 'PUT'://actualiza
                    $this->updateService();    
                    break; 
                case 'DELETE'://elimina
                    $this->deleteService();
                break;
                default://metodo NO soportado
                    $this->response(405);
                break;
            }
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

   /**
    * función que segun el valor de "action" e "id":
    *  - mostrara una array con todos los registros de personas
    *  - mostrara un solo registro 
    *  - mostrara un array vacio
    */
    function getService(){

        switch($this->servicio)
            { case 'necesidad':
                include ("servicio/necesidad/necesidad.php");
                $this->recurso=new Necesidad($this->conexionOracle,$this->servicio,$this->miFabricaConexiones);
                $this->recurso->rescatarNecesidad();
              break;
              case 'disponibilidad':
                include ("servicio/disponibilidad/disponibilidad.php");
                $this->recurso=new Disponibilidad($this->conexionOracle,$this->servicio,$this->miFabricaConexiones);
                $this->recurso->rescatarDisponibilidad();
              break;          
              default://contiene sintaxis errónea
                $this->response(400);
              break;
            }
      } 

    /**
     * metodo para guardar un nuevo registro en la base de datos
     */
     function saveService(){
         //no soportado hasta generar un servicio
        switch($this->servicio)
            { case '':
                 $this->response(405);
              break;
              default://contiene sintaxis errónea
                $this->response(400);
              break;
            }
     } 

    /**
    * Actualiza un recurso
    */
   function updateService() {
       //no soportado hasta generar un servicio
        switch($this->servicio)
            { case '':
                 $this->response(405);
              break;
              default://contiene sintaxis errónea
                $this->response(400);
              break;
            }

   }
   

    /**
     * elimina un recurso
     */
    function deleteService(){
        //no soportado hasta generar un servicio
        switch($this->servicio)
            { case '':
                 $this->response(405);
              break;
              default://contiene sintaxis errónea
                $this->response(400);
              break;
            }

    }         
        
}


