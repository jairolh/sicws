<?php

/*
 * ############################################################################ # UNIVERSIDAD DISTRITAL Francisco Jose de Caldas # # Copyright: Vea el archivo LICENCIA.txt que viene con la distribucion # ############################################################################
 */
/* * *************************************************************************
 * @name oci8.class.php
 * @author Paulo Cesar Coronado
 * @revision Última revisión 10 de Enero de 2017
 * ***************************************************************************
 * @subpackage
 * @package clase
 * @copyright
 * @version 0.3
 * @author Jairo Lavado Hernández
 * @link http://computo.udistrital.edu.co
 * @description Esta clase esta disennada para administrar todas las tareas
 * relacionadas con la base de datos ORACLE con OCI8.
 *
 * **************************************************************************** */


/* * ***************************************************************************
 * Atributos
 *
 * @access private
 * @param $servidor
 * URL del servidor de bases de datos.
 * @param $db
 * Nombre de la base de datos
 * @param $usuario
 * Usuario de la base de datos
 * @param $clave
 * Clave de acceso al servidor de bases de datos
 * @param $enlace
 * Identificador del enlace a la base de datos
 * @param $dbms
 * Nombre del DBMS oci8
 * @param $cadenaSql
 * Clausula SQL a ejecutar
 * @param $error
 * Mensaje de error devuelto por el DBMS
 * @param $numero
 * Número de registros a devolver en una consulta
 * @param $conteo
 * Número de registros que existen en una consulta
 * @param $registro
 * Matriz para almacenar los resultados de una búsqueda
 * @param $campo
 * Número de campos que devuelve una consulta
 * TO DO Implementar la funcionalidad en DBMS ORACLE con OCI8
 * ***************************************************************************** */

/* * ***************************************************************************
 * Métodos
 *
 * @access public
 *
 * @name db_admin
 * Constructor. Define los valores por defecto
 * @name especificar_db
 * Especifica a través de código el nombre de la base de datos
 * @name especificar_usuario
 * Especifica a través de código el nombre del usuario de la DB
 * @name especificar_clave
 * Especifica a través de código la clave de acceso al servidor de DB
 * @name especificar_servidor
 * Especificar a través de código la URL del servidor de DB
 * @name especificar_dbms
 * Especificar a través de código el nombre del DBMS
 * @name especificar_enlace
 * Especificar el recurso de enlace a la DBMS
 * @name conectar_db
 * Conecta a un DBMS
 * @name probar_conexion
 * Con la cual se realizan acciones que prueban la validez de la conexión
 * @name desconectar_db
 * Libera la conexion al DBMS
 * @name ejecutar_acceso_db
 * Ejecuta clausulas SQL de tipo INSERT, UPDATE, DELETE
 * @name obtener_error
 * Devuelve el mensaje de error generado por el DBMS
 * @name obtener_conteo_dbregistro_db
 * Devuelve el número de registros que tiene una consulta
 * @name registro_db
 * Ejecuta clausulas SQL de tipo SELECT
 * @name getRegistroDb
 * Devuelve el resultado de una consulta como una matriz bidimensional
 * @name obtener_error
 * Realiza una consulta SQL y la guarda en una matriz bidimensional
 *
 * **************************************************************************** */

class Oci8
{
	/*** Atributos: ***/
	/**
	 *
	 * @access privado
	 */
	var $servidor;
	var $db;
	var $usuario;
	var $clave;
	var $enlace;
	var $dbsys;
	var $cadena_sql;
	var $error;
	var $numero;
	var $conteo;
	var $registro;
	var $campo;


	/*** Fin de sección Atributos: ***/

    /**
	 * @name especificar_db
	 * @param string nombre_db
	 * @return void
	 * @access public
	 */

	function especificar_db( $nombre_db )
	{
		$this->db = $nombre_db;
	} // Fin del método especificar_db

	/**
	 * @name especificar_usuario
	 * @param string usuario_db
	 * @return void
	 * @access public
	 */
	function especificar_usuario( $usuario_db )
	{
		$this->usuario = $usuario_db;
	} // Fin del método especificar_usuario


	/**
	 * @name especificar_clave
	 * @param string nombre_db
	 * @return void
	 * @access public
	 */
	function especificar_clave( $clave_db )
	{
		$this->clave = $clave_db;
	} // Fin del método especificar_clave

	/**
     *
	 * @name especificar_servidor
	 * @param string servidor_db
	 * @return void
	 * @access public
	 */
	function especificar_servidor( $servidor_db )
	{
		$this->servidor = $servidor_db;
	} // Fin del método especificar_servidor

	/**
	 *
	 * @name especificar_dbms
	 *@param string dbms
	 * @return void
	 * @access public
	 */

	function especificar_dbsys( $sistema )
	{
		$this->dbsys = $sistema;

	} // Fin del método especificar_dbsys

	/**
	 *
	 * @name especificar_enlace
	 *@param resource enlace
	 * @return void
	 * @access public
	 */

	function especificar_enlace($enlace )
	{
		if(is_resource($enlace))
		{
			$this->enlace = $enlace;
		}
	} // Fin del método especificar_enlace


	/**
	 *
	 * @name obtener_enlace
	 * @return void
	 * @access public
	 */

	function getEnlace()
	{
		return $this->enlace;

	} // Fin del método obtener_enlace


	/**
	 *
     * @name conectar_db
     * @return void
     * @access public
     */
    function conectar_db() {

        //$this->enlace = oci_connect($this->usuario, $this->clave, $this->db);
        $this->enlace=oci_connect($this->usuario, $this->clave, $this->servidor.'/'.$this->db);
        if(!$this->enlace){
                $this->enlace = oci_connect($this->usuario, $this->clave, $this->db);
        }

        if ($this->enlace) {
            return $this->enlace;
        } else {
            $this->error = oci_error();
        }
    }

    // Fin del método conectar_db

    /**
     *
     * @name probar_conexion
     * @return void
     * @access public
     */
    function probar_conexion() {

        return $this->enlace;
    }

    // Fin del método probar_conexion

    /**
     *
     * @name desconectar_db
     * @param
     *            resource enlace
     * @return void
     * @access public
     */
    function desconectar_db() {

        oci_close($this->enlace);
    }

    // Fin del método desconectar_db
    // Funcion para el acceso a las bases de datos
    function ejecutarAcceso($cadena, $tipo = "", $numeroRegistros = 0) {

        if (!is_resource($this->enlace)) {
            return FALSE;
        }

        if ($tipo == "busqueda") {

            $this->ejecutar_busqueda($cadena, $numeroRegistros);
            return $this->getRegistroDb();
        } else {
            return $this->ejecutar_acceso_db($cadena);
        }
    }

    	/**
	 * @name getRegistroDb
	 * @return registro []
	 * @access public
	 */

	function getRegistroDb()
	{
		if(isset($this->registro))
		{

			return $this->registro;
		}
		else
		{
			return false;
		}
	}//Fin del método getRegistroDb

    
    /**
     *
     * @name obtener_error
     * @param
     *            string cadena_sql
     * @param
     *            string conexion_id
     * @return boolean
     * @access public
     */
    function obtener_error() {

        return $this->error;
    }

    // Fin del método obtener_error

    /**
     *
     * @name registro_db
     * @param
     *            string cadena_sql
     * @param
     *            int numero
     * @return boolean
     * @access public
     */
    function registro_db($cadena, $numeroRegistros = 0) {

        if (!is_resource($this->enlace)) {
            return FALSE;
        }

        $cadenaParser = oci_parse($this->enlace, $cadena);

        if (oci_execute($cadenaParser)) {
            return $this->procesarResultado($cadenaParser, $numeroRegistros);
        } else {

            unset($this->registro);
            $this->error = oci_error($this->enlace);
            return 0;
        }
    }

    // Fin del método registro_db

    private function procesarResultado($cadenaParser, $numeroRegistros) {
        unset($this->registro);
        $this->campo = oci_num_fields($cadenaParser);

        $registrosProcesados = 0;

        $salida = oci_fetch_array($cadenaParser);

        $this->keys = array_keys($salida);
        $i = 0;
        foreach ($this->keys as $clave => $valor) {
            if (is_string($valor)) {
                $this->claves [$i] = $valor;
                $i ++;
            }
        }

        $j = 0;

        do {

            for ($unCampo = 0; $unCampo < $this->campo; $unCampo ++) {
                $this->registro [$j] [$unCampo] = $salida [$unCampo];
                $this->registro [$j] [$this->claves [$unCampo]] = $salida [$unCampo];
            }
            $j ++;
            $registrosProcesados ++;

            if ($numeroRegistros > 0 && $registrosProcesados >= $numeroRegistros) {
                break;
            }
        } while ($salida = oci_fetch_array($cadenaParser));

        $this->conteo = $j;

        return $this->conteo;
    }

    /**
     *
     * @name transaccion
     * @return boolean resultado
     * @access public
     */
    function transaccion($clausulas) {

        $acceso = true;

        $this->instrucciones = count($clausulas);

        for ($contador = 0; $contador < $this->instrucciones; $contador ++) {
            $acceso .= $this->ejecutar_acceso_db($insert [$contador], true);
        }
        if (!$acceso) {
            oci_rollback($this->enlace);
            return FALSE;
        } else {
            oci_commit($this->enlace);
            return TRUE;
        }
    }

    // Fin del método transaccion
    function limpiarVariables($variables) {

        return $variables;
    }

    function tratarCadena($cadena) {

        return $cadena;
    }

    /**
     *
     * @name db_admin
     *      
     */
    function __construct($registro) {

        $this->servidor = trim($registro ["dbdns"]);
        $this->db = trim($registro ["dbnombre"]);
        $this->puerto = isset($registro ['dbpuerto']) ? $registro ['dbpuerto'] : 1521;
        $this->usuario = trim($registro ["dbusuario"]);
        $this->clave = trim($registro ["dbclave"]);
        $this->dbsys = trim($registro ["dbsys"]);
        //$this->dbesquema = trim($registro ['dbesquema']);
        
        //isset($registro ['dbesquema'])?$this->dbesquema = trim($registro ['dbesquema']):$this->dbesquema = '';
        
        $this->dbesquema = isset($registro ['dbesquema'])? trim($registro ['dbesquema']):'';

        $this->enlace = $this->conectar_db();
    }

    // Fin del método db_admin
    function ejecutar_busqueda($cadena, $numeroRegistros = 0) {

        $this->registro_db($cadena, $numeroRegistros);
        return $this->getRegistroDb();
    }

    /**
     *
     * @name ejecutar_acceso_db
     * @param
     *            string cadena_sql
     * @param
     *            string conexion_id
     * @return boolean
     * @access public
     */
    private function ejecutar_acceso_db($cadena, $esTransaccion = false) {

        $cadenaParser = oci_parse($this->enlace, $cadena);

        if ($esTransaccion) {
            $busqueda = oci_execute($cadenaParser, OCI_NO_AUTO_COMMIT);
        } else {
            $busqueda = oci_execute($cadenaParser);
        }
        return $busqueda;
    }

}

// Fin de la clase db_admin
?>