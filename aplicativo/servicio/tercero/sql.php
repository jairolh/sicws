<?php
/* * *************************************************************************
 * @name sql.php
 * @author Jairo Lavado Hernandez
 * @revision Última revisión 10 de Enero de 2017
 * ***************************************************************************
 * @subpackage
 * @package clase
 * @copyright
 * @version 0.1
 * @author Jairo Lavado Hernández
 * @link http://computo.udistrital.edu.co
 * @description Esta clase esta disennada para administrar todas las consultas SQL
 * relacionadas a los servicios relacionados con terceros en el
 * sistema Sicapital
 * **************************************************************************** */
class SqlService {

    function sql($opcion, $variable) {
    $cadenaSql='';
        switch ($opcion) {

                case "basicos":
                    
                        $cadenaSql=" SELECT DISTINCT";
                        $cadenaSql.=" ID,";
                        $cadenaSql.=" IB_PRIMER_NOMBRE||' '||IB_SEGUNDO_NOMBRE NOMBRES,";
                        $cadenaSql.=" IB_PRIMER_APELLIDO||' '||IB_SEGUNDO_APELLIDO APELLIDOS,";
                        $cadenaSql.=" IB_CODIGO_IDENTIFICACION IDENTIFICACION ,";
                        $cadenaSql.=" IB_TIPO_IDENTIFICACION TIPOIDENTIFICACION ,";
                        $cadenaSql.=" (SELECT CTO.CO_VALOR FROM SHD.SHD_CONTACTOS CTO WHERE CTO.CO_TIPO_CONTACTO='DIR' AND CTO.ID=BEN.ID AND ROWNUM < 2 ) DIRECCION,";
                        $cadenaSql.=" (SELECT CTO.CO_VALOR FROM SHD.SHD_CONTACTOS CTO WHERE CTO.CO_TIPO_CONTACTO='EMAIL' AND CTO.ID=BEN.ID AND ROWNUM < 2 ) CORREO,";
                        $cadenaSql.=" (SELECT CTO.CO_VALOR FROM SHD.SHD_CONTACTOS CTO WHERE CTO.CO_TIPO_CONTACTO='TEL' AND CTO.ID=BEN.ID AND ROWNUM < 2 ) TELEFONO,";
                        $cadenaSql.=" (SELECT CTO.CO_VALOR FROM SHD.SHD_CONTACTOS CTO WHERE CTO.CO_TIPO_CONTACTO='CEL' AND CTO.ID=BEN.ID AND ROWNUM < 2 ) CELULAR";
                        $cadenaSql.=" FROM SHD.SHD_INFORMACION_BASICA BEN ";
                        $cadenaSql.=" WHERE IB_NATURALEZA='PN'";
                        if(isset($variable['id0']) && $variable['id0']>0 )
                            {$cadenaSql .= " AND TRIM(IB_CODIGO_IDENTIFICACION) IN ('".$variable['id0']."')";}
                        $cadenaSql.=" ORDER BY IB_CODIGO_IDENTIFICACION";
                            
                    break;                    

                
                
                
                
                
                
                
                
                
        }
        return $cadenaSql;
    }
}
?>
