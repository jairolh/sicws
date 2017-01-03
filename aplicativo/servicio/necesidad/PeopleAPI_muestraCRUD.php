<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PeopleAPI
 *
 * @author jlavadoh
 */
class PeopleAPI {
    public function API(){
        header('Content-Type: application/JSON');                
        $method = $_SERVER['REQUEST_METHOD'];
        $path = ltrim($_SERVER['REQUEST_URI'], '?');    // Trim leading slash(es)
        $elements = explode('?', $path);                // Split path on slashes
        $element = ltrim($elements[1], '/');    // Trim leading slash(es)
        $request = explode('/', $element );                // Split path on slashes

        $auxVar=0;
        /*
        foreach ($request as $key => $value) {
           // echo "<br>".$request[$key];
            if(!is_numeric($request[$key]) && $key==0  ) {
                   switch ($method) {
                        case 'GET':
                            $_GET['action']=$request[$key];   
                        break;
                        case 'POST':
                            $_POST['action']=$request[$key];   
                        break;
                    }

            } else if(is_numeric($request[$key]) && $key>0  ){
                   switch ($method) {
                        case 'GET':
                            $_GET['id'.$auxVar]=$request[$key];   
                        break;
                        case 'POST':
                            $_POST['id'.$auxVar]=$request[$key];   
                        break;
                    }

                    $auxVar++;
            }

        }*/
        
    switch ($method) 
        {   case 'GET'://consulta
                foreach ($request as $key => $value) {
                    if(!is_numeric($request[$key]) && $key==0  ) {
                                $_GET['action']=$request[$key];   
                        }
                    elseif(is_numeric($request[$key]) && $key>0){
                               $_GET['id'.$auxVar]=$request[$key];   
                               $auxVar++;
                        }
                 }
                $this->getPeoples();
                break;     
            case 'POST'://inserta
                $_GET['action']=$request[0];   
                $this->savePeople();
                
                break;                
            case 'PUT'://actualiza
                foreach ($request as $key => $value) {
                    if(!is_numeric($request[$key]) && $key==0  ) {
                                $_GET['action']=$request[$key];   
                        }
                    elseif(is_numeric($request[$key]) && $key>0){
                               $_GET['id'.$auxVar]=$request[$key];   
                               $auxVar++;
                        }
                 }
                $this->updatePeople();
                break; 
            case 'DELETE'://elimina
                foreach ($request as $key => $value) {
                    if(!is_numeric($request[$key]) && $key==0  ) {
                                $_GET['action']=$request[$key];   
                        }
                    elseif(is_numeric($request[$key]) && $key>0){
                               $_GET['id'.$auxVar]=$request[$key];   
                               $auxVar++;
                        }
                 }
                $this->deletePeople();
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
    function getPeoples(){
        require_once "PeopleDB.php";
        if($_GET['action']=='peoples'){         
            $db = new PeopleDB();
            if(isset($_GET['id0'])){//muestra 1 solo registro si es que existiera ID                 
                $response = $db->getPeople($_GET['id0']);                
                echo json_encode($response,JSON_PRETTY_PRINT);
            }else{ //muestra todos los registros                   
                $response = $db->getPeoples();              
                echo json_encode($response,JSON_PRETTY_PRINT);
            }
        }else{
            $this->response(400);
            }       
      }       

/**
 * metodo para guardar un nuevo registro de persona en la base de datos
 */
 function savePeople(){
     require_once "PeopleDB.php";
     if($_GET['action']=='peoples'){   
         //Decodifica un string de JSON
         $obj = json_decode( file_get_contents('php://input') );   
         $objArr = (array)$obj;
         if (empty($objArr)){
             $this->response(422,"error","Nothing to add. Check json");                           
         }else if(isset($obj->name)){
             $people = new PeopleDB();     
             $people->insert( $obj->name );
             $this->response(200,"success","new record added");                             
         }else{
             $this->response(422,"error","The property is not defined");
         }
     } else{               
         $this->response(400);
     }  
 } 
 
    /**
    * Actualiza un recurso
    */
   function updatePeople() {
       
       require_once "PeopleDB.php";
       var_dump($_GET);
       if( isset($_GET['action']) && isset($_GET['id0']) ){
           if($_GET['action']=='peoples'){
               $obj = json_decode( file_get_contents('php://input') );   
               $objArr = (array)$obj;
               if (empty($objArr)){                        
                   $this->response(422,"error","Nothing to add. Check json");                        
               }else if(isset($obj->name)){
                   $db = new PeopleDB();
                   $db->update($_GET['id0'], $obj->name);
                   $this->response(200,"success","Record updated");                             
               }else{
                   $this->response(422,"error","The property is not defined");                        
               }     
               exit;
          }
       }
       $this->response(400);
   }
   

    /**
     * elimina persona
     */
    function deletePeople(){
         require_once "PeopleDB.php";
        if( isset($_GET['action']) && isset($_GET['id0']) ){
            if($_GET['action']=='peoples'){                   
                $db = new PeopleDB();
                $db->delete($_GET['id0']);
                $this->response(204);                   
                exit;
            }
        }
        $this->response(400);
    }   
}
   