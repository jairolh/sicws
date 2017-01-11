<?php

class DatoConexion{
    
    private $motorDB;
    private $direccionServidor;
    private $puerto;
    private $db;
    private $usuario;
    private $clave;

    
    function __construct(){
    	
    }
    
    function setDatosConexion($nombre){
    	
    	switch($nombre){
    		
    		case "oracle":
    			
    			$this->motorDB='Oci8';
    			$this->direccionServidor='10.20.0.251';
    			$this->puerto='1521';
    			$this->db="ud";
    			$this->usuario="SICGEFAD";
    			$this->clave="s1cg3f@d2014=EVA";   			
    			break;
    			
    		case "postgresql":
    			    			 
    			$this->motorDB="pgsql";
    			$this->direccionServidor="10.20.0.0";
    			$this->puerto="5432";
    			$this->db="s";
    			$this->usuario="s";
    			$this->clave="s";
    			break;

    		case "mysql":
    			    			 
    			$this->motorDB="mysql";
    			$this->direccionServidor="localhost";
    			$this->puerto="3306";
    			$this->db="a";
    			$this->usuario="a";
    			$this->clave="c";
    			break;
    		
    	}
    	
    	return true;
    	
    	
    }    
    
    function getMotorDB(){
    	return $this->motorDB;
    }

    function getDireccionServidor(){
    	return $this->direccionServidor;
    }
    
    function getPuerto(){
    	return $this->puerto;
    }
    
    function getDb(){
    	return $this->db;
    }
    
    function getUsuario(){
    	return $this->usuario;
    }
    
    function getClave(){
    	return $this->clave;
    }
    
	
}



?>
