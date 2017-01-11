<?php
/* * *************************************************************************
 * @name sicapitaAPI.php
 * @author Jairo Lavado Hernandez
 * @revision Última revisión 10 de Enero de 2017
 * ***************************************************************************
 * @subpackage
 * @package clase
 * @copyright
 * @version 0.1
 * @author Jairo Lavado Hernández
 * @link http://computo.udistrital.edu.co
 * @description Esta clase esta disennada para administrar todas las peticiones
 * relacionadas con los servicios de consulta en el Sistema Sicapital
 * **************************************************************************** */
class SicapitalAPI {
    public function API(){
        header('Content-Type: application/JSON');                
        $method = $_SERVER['REQUEST_METHOD'];
        $path = ltrim($_SERVER['REQUEST_URI'], '?');    // Trim leading slash(es)
        $elements = explode('?', $path);                // Split path on slashes
        $element = ltrim($elements[1], '/');    // Trim leading slash(es)
        $request = explode('/', $element );                // Split path on slashes
        //$path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
        //$request = explode('/', $path );                // Split path on slashes
        $auxVar=0;
        foreach ($request as $key => $value) {
            if(!is_numeric($request[$key]) && $key==0  ) {
                        $_GET['service']=$value;//$request[$key];   
                }
            elseif(!is_numeric($request[$key]) && $key==1  ) {
                        $_GET['action']=$value;//$request[$key];   
                }
            elseif($key>1){
                       $_GET['id'.$auxVar]=$value;   
                       $auxVar++;
                }
         }
        include_once("../aplicativo/ProcesadorServicio.php");
        $procesar = new ProcesadorServicio(); 
        $procesar->Servicio($method);
    }
}
$sicapAPI = new SicapitalAPI();
$sicapAPI->API();
?>
