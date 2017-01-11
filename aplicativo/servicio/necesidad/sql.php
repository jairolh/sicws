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
 * relacionadas a los servicios relacionados con las necesidades en el
 * sistema Sicapital
 * **************************************************************************** */
class SqlService {

    function sql($opcion, $variable) {
        $cadenaSql='';
        switch ($opcion) {

                case "consultar_vigencia":
                        $cadenaSql = "SELECT ";
                        $cadenaSql .= "SOL.VIGENCIA AS Vigencia, ";
                        $cadenaSql .= "SOL.NUM_SOL_ADQ AS NumeroNecesidad, ";
                        $cadenaSql .= "SOL.CODIGO_UNIDAD_EJECUTORA AS UnidadEjecutora, ";
                        $cadenaSql .= "SOL.DEPENDENCIA AS Dependencia, ";
                        $cadenaSql .= "SOL.FECHA_SOLICITUD AS FechaNecesidad, ";
                        $cadenaSql .= "SOL.ESTADO AS EstadoNecesidad, ";
                        $cadenaSql .= "SOL.DEPENDENCIA_DESTINO AS DependenciaDestino, ";
                        $cadenaSql .= "SOL.VALOR_CONTRATACION AS ValorNecesidad, ";
                        $cadenaSql .= "SOL.OBJETO AS Objeto, ";
                        $cadenaSql .= "SOL.TIPO_CONTRATACION AS TipoContratacion, ";
                        $cadenaSql .= "SOL.RUBRO_INTERNO AS InternoRubro, ";
                        $cadenaSql .= "( RN1.CODIGO||'-'|| RN2.CODIGO||'-'|| RN3.CODIGO||'-'|| RN4.CODIGO||'-'|| RN5.CODIGO||'-'|| RN6.CODIGO||'-'|| RN7.CODIGO||'-'|| RN8.CODIGO ) AS CodigoRubro, ";
                        $cadenaSql .= " LTRIM(RTRIM(RUB.DESCRIPCION)) AS NombreRubro  ";
                        $cadenaSql .= "FROM CO.CO_SOLICITUD_ADQ SOL ";
                        $cadenaSql .= "INNER JOIN PR_RUBRO RUB ON SOL.VIGENCIA = RUB.VIGENCIA AND SOL.RUBRO_INTERNO = RUB.INTERNO ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL1 RN1 ON RUB.VIGENCIA = RN1.VIGENCIA AND RUB.INTERNO_NIVEL1 = RN1.INTERNO AND RUB.TIPO_PLAN = RN1.TIPO_PLAN ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL2 RN2 ON RUB.VIGENCIA = RN2.VIGENCIA AND RUB.INTERNO_NIVEL2 = RN2.INTERNO AND RUB.TIPO_PLAN = RN2.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL3 RN3 ON RUB.VIGENCIA = RN3.VIGENCIA AND RUB.INTERNO_NIVEL3 = RN3.INTERNO AND RUB.TIPO_PLAN = RN3.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL4 RN4 ON RUB.VIGENCIA = RN4.VIGENCIA AND RUB.INTERNO_NIVEL4 = RN4.INTERNO AND RUB.TIPO_PLAN = RN4.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL5 RN5 ON RUB.VIGENCIA = RN5.VIGENCIA AND RUB.INTERNO_NIVEL5 = RN5.INTERNO AND RUB.TIPO_PLAN = RN5.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL6 RN6 ON RUB.VIGENCIA = RN6.VIGENCIA AND RUB.INTERNO_NIVEL6 = RN6.INTERNO AND RUB.TIPO_PLAN = RN6.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL7 RN7 ON RUB.VIGENCIA = RN7.VIGENCIA AND RUB.INTERNO_NIVEL7 = RN7.INTERNO AND RUB.TIPO_PLAN = RN7.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL8 RN8 ON RUB.VIGENCIA = RN8.VIGENCIA AND RUB.INTERNO_NIVEL8 = RN8.INTERNO AND RUB.TIPO_PLAN = RN8.TIPO_PLAN  ";
                        $cadenaSql .= "WHERE SOL.VIGENCIA=".$variable['id0'];
                        //$cadenaSql .= "AND SOL.CODIGO_UNIDAD_EJECUTORA='01' ";
                        $cadenaSql .= " AND SOL.ORIGEN_SOLICITUD='SOLICITUD' ";
                        if(isset($variable['id1']) && $variable['id1']>0 )
                            {$cadenaSql .= " AND SOL.NUM_SOL_ADQ=".$variable['id1'];}
                        
                    break;                    

                
                
                
                
                
                
                
                
                
        }
        return $cadenaSql;
    }
}
?>
