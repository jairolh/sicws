<?php
class SqlService {

    function sql($opcion, $variable) {
        $cadenaSql='';
        switch ($opcion) {

                case "cdpxnecesidad":
                        $cadenaSql .= "SELECT  ";
                        $cadenaSql .= "RCDP.VIGENCIA VIGENCIA, ";
                        $cadenaSql .= "RCDP.CODIGO_UNIDAD_EJECUTORA UNIDADEJECUTORA, ";
                        $cadenaSql .= "CDP.NUM_SOL_ADQ NUMERONECESIDAD, ";
                        $cadenaSql .= "RCDP.NUMERO_DISPONIBILIDAD DISPONIBILIDAD, ";
                        $cadenaSql .= "TO_CHAR(CDP.FECHA_REGISTRO, 'YYYY-MM-DD') FECHADISP, ";
                        $cadenaSql .= "LTRIM(RTRIM(REPLACE(CDP.OBJETO,CHR(10),''))) OBJETODISP, ";
                        $cadenaSql .= "RCDP.RUBRO_INTERNO INTERNORUBRO, ";
                        $cadenaSql .= "( RN1.CODIGO||'-'||RN2.CODIGO||'-'||RN3.CODIGO||'-'||RN4.CODIGO||'-'||RN5.CODIGO||'-'||RN6.CODIGO||'-'||RN7.CODIGO||'-'||RN8.CODIGO ) CODIGORUBRO, ";
                        $cadenaSql .= "LTRIM(RTRIM(RUB.DESCRIPCION)) NOMBRERUBRO, ";
                        $cadenaSql .= "RCDP.VALOR VALOR_DISP, ";
                        $cadenaSql .= "NVL(CDP_ANULADO.VALOR,0) VALOR_ANULADO, ";
                        $cadenaSql .= "(CASE WHEN CDP_REINT.VALOR_REINT<0 THEN NVL(CDP_REINT.VALOR_REINT*-1,0) ELSE  NVL(CDP_REINT.VALOR_REINT,0) END ) VALOR_REINTEGRO, ";
                        $cadenaSql .= "EST.RESULTADO ESTADO ";
                        $cadenaSql .= "FROM PR_DISPONIBILIDADES CDP ";
                        $cadenaSql .= "INNER JOIN PR_DISPONIBILIDAD_RUBRO RCDP ";
                        $cadenaSql .= "ON CDP.VIGENCIA=RCDP.VIGENCIA ";
                        $cadenaSql .= " AND CDP.CODIGO_COMPANIA=RCDP.CODIGO_COMPANIA ";
                        $cadenaSql .= " AND CDP.CODIGO_UNIDAD_EJECUTORA=RCDP.CODIGO_UNIDAD_EJECUTORA  ";
                        $cadenaSql .= "AND CDP.NUMERO_DISPONIBILIDAD=RCDP.NUMERO_DISPONIBILIDAD ";
                        $cadenaSql .= "INNER JOIN  CO.CO_SOLICITUD_ADQ NEC ON NEC.VIGENCIA=CDP.VIGENCIA AND NEC.CODIGO_UNIDAD_EJECUTORA=CDP.CODIGO_UNIDAD_EJECUTORA AND NEC.NUM_SOL_ADQ=CDP.NUM_SOL_ADQ ";
                        $cadenaSql .= "INNER JOIN PR_RUBRO RUB ON RCDP.VIGENCIA = RUB.VIGENCIA AND RCDP.RUBRO_INTERNO = RUB.INTERNO ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL1 RN1 ON RUB.VIGENCIA = RN1.VIGENCIA AND RUB.INTERNO_NIVEL1 = RN1.INTERNO AND RUB.TIPO_PLAN = RN1.TIPO_PLAN ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL2 RN2 ON RUB.VIGENCIA = RN2.VIGENCIA AND RUB.INTERNO_NIVEL2 = RN2.INTERNO AND RUB.TIPO_PLAN = RN2.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL3 RN3 ON RUB.VIGENCIA = RN3.VIGENCIA AND RUB.INTERNO_NIVEL3 = RN3.INTERNO AND RUB.TIPO_PLAN = RN3.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL4 RN4 ON RUB.VIGENCIA = RN4.VIGENCIA AND RUB.INTERNO_NIVEL4 = RN4.INTERNO AND RUB.TIPO_PLAN = RN4.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL5 RN5 ON RUB.VIGENCIA = RN5.VIGENCIA AND RUB.INTERNO_NIVEL5 = RN5.INTERNO AND RUB.TIPO_PLAN = RN5.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL6 RN6 ON RUB.VIGENCIA = RN6.VIGENCIA AND RUB.INTERNO_NIVEL6 = RN6.INTERNO AND RUB.TIPO_PLAN = RN6.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL7 RN7 ON RUB.VIGENCIA = RN7.VIGENCIA AND RUB.INTERNO_NIVEL7 = RN7.INTERNO AND RUB.TIPO_PLAN = RN7.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN PR_NIVEL8 RN8 ON RUB.VIGENCIA = RN8.VIGENCIA AND RUB.INTERNO_NIVEL8 = RN8.INTERNO AND RUB.TIPO_PLAN = RN8.TIPO_PLAN  ";
                        $cadenaSql .= "INNER JOIN BINTABLAS EST ON EST.GRUPO = 'PREDIS' AND EST.NOMBRE = 'ESTADO_CDP' AND EST.ARGUMENTO = CDP.ESTADO ";
                        $cadenaSql .= "LEFT OUTER JOIN  ( ";
                            $cadenaSql .= " SELECT ";
                            $cadenaSql .= "  CDP_ANULA.VIGENCIA, ";
                            $cadenaSql .= "  CDP_ANULA.CODIGO_COMPANIA, ";
                            $cadenaSql .= "  CDP_ANULA.CODIGO_UNIDAD_EJECUTORA UNIDAD, ";
                            $cadenaSql .= "  CDP_ANULA.RUBRO_INTERNO RUBRO, ";
                            $cadenaSql .= "  CDP_ANULA.NUMERO_DISPONIBILIDAD CDP, ";
                            $cadenaSql .= "  SUM(NVL(CDP_ANULA.VALOR_ANULADO,0)) VALOR ";
                            $cadenaSql .= "  FROM PR.PR_CDP_ANULADOS CDP_ANULA ";
                            $cadenaSql .= "  GROUP BY CDP_ANULA.VIGENCIA, ";
                            $cadenaSql .= "  CDP_ANULA.CODIGO_COMPANIA, ";
                            $cadenaSql .= "  CDP_ANULA.RUBRO_INTERNO, ";
                            $cadenaSql .= "  CDP_ANULA.CODIGO_UNIDAD_EJECUTORA, ";
                            $cadenaSql .= "  CDP_ANULA.NUMERO_DISPONIBILIDAD ) CDP_ANULADO ";
                        $cadenaSql .= " ON CDP_ANULADO.VIGENCIA=CDP.VIGENCIA ";
                        $cadenaSql .= " AND CDP_ANULADO.CODIGO_COMPANIA=CDP.CODIGO_COMPANIA ";
                        $cadenaSql .= " AND CDP_ANULADO.UNIDAD=CDP.CODIGO_UNIDAD_EJECUTORA ";
                        $cadenaSql .= " AND CDP_ANULADO.RUBRO=RCDP.RUBRO_INTERNO ";
                        $cadenaSql .= " AND CDP_ANULADO.CDP=CDP.NUMERO_DISPONIBILIDAD ";
                        $cadenaSql .= "LEFT OUTER JOIN ( ";
                        $cadenaSql .= "  SELECT TO_NUMBER(DT_ACTA.DOC_VIGENCIA) VIGENCIA, ";
                        $cadenaSql .= "  SUBSTR(DT_ACTA.DOC_ENTIDAD, 1, 3) CODIGO_COMPANIA, ";
                        $cadenaSql .= "  SUBSTR(DT_ACTA.DOC_UNIDAD_EJECUTORA, 1, 2) UNIDAD_EJECUTORA, ";
                        $cadenaSql .= "  DT_ACTA.RUBRO_INTERNO RUBRO, ";
                        $cadenaSql .= "  DT_ACTA.DISPONIBILIDAD CDP, ";
                        $cadenaSql .= "  SUM(DT_ACTA.VALOR) VALOR_REINT ";
                        $cadenaSql .= "  FROM OGT.OGT_ORDEN_PAGO OP ";
                        $cadenaSql .= "  INNER JOIN  OGT.OGT_DETALLE_ACTAS DT_ACTA ";
                        $cadenaSql .= "  ON OP.VIGENCIA = DT_ACTA.DOC_VIGENCIA ";
                        $cadenaSql .= "  AND OP.ENTIDAD = DT_ACTA.DOC_ENTIDAD ";
                        $cadenaSql .= "  AND OP.UNIDAD_EJECUTORA = DT_ACTA.DOC_UNIDAD_EJECUTORA ";
                        $cadenaSql .= "  AND OP.TIPO_DOCUMENTO = DT_ACTA.DOC_TIPO_DOCUMENTO ";
                        $cadenaSql .= "  AND OP.CONSECUTIVO = DT_ACTA.DOC_CONSECUTIVO ";
                        $cadenaSql .= "  INNER JOIN  OGT.OGT_ACTAS ACTA ";
                        $cadenaSql .= "  ON DT_ACTA.CONSECUTIVO = ACTA.CONSECUTIVO ";
                        $cadenaSql .= "  AND DT_ACTA.VIGENCIA = ACTA.VIGENCIA ";
                        $cadenaSql .= "  AND DT_ACTA.TIPO_DOCUMENTO = ACTA.TIPO_DOCUMENTO ";
                        $cadenaSql .= "  AND DT_ACTA.ENTIDAD = ACTA.ENTIDAD ";
                        $cadenaSql .= "  AND DT_ACTA.UNIDAD_EJECUTORA = ACTA.UNIDAD_EJECUTORA ";
                        $cadenaSql .= "  GROUP BY TO_NUMBER(DT_ACTA.DOC_VIGENCIA) , ";
                        $cadenaSql .= "  SUBSTR(DT_ACTA.DOC_ENTIDAD, 1, 3), ";
                        $cadenaSql .= "  SUBSTR(DT_ACTA.DOC_UNIDAD_EJECUTORA, 1, 2), ";
                        $cadenaSql .= "  DT_ACTA.RUBRO_INTERNO, ";
                        $cadenaSql .= "  DT_ACTA.DISPONIBILIDAD) CDP_REINT ";
                        $cadenaSql .= "  ON CDP_REINT.VIGENCIA=CDP.VIGENCIA ";
                        $cadenaSql .= "  AND CDP_REINT.CODIGO_COMPANIA=CDP.CODIGO_COMPANIA ";
                        $cadenaSql .= " AND CDP_REINT.UNIDAD_EJECUTORA=CDP.CODIGO_UNIDAD_EJECUTORA ";
                        $cadenaSql .= " AND CDP_REINT.RUBRO=RCDP.RUBRO_INTERNO ";
                        $cadenaSql .= " AND CDP_REINT.CDP=CDP.NUMERO_DISPONIBILIDAD ";
                        $cadenaSql .= "WHERE CDP.VIGENCIA=".$variable['id0'];
                        if(isset($variable['id1']) && $variable['id1']>0 )
                            {$cadenaSql .= " AND CDP.NUM_SOL_ADQ=".$variable['id1'];}
                        $cadenaSql .= " ORDER BY RN1.CODIGO, RN2.CODIGO, RN3.CODIGO, RN4.CODIGO, RN5.CODIGO,RN6.CODIGO, RN7.CODIGO, RN8.CODIGO, ";
                        $cadenaSql .= " CDP.FECHA_REGISTRO,CDP.NUMERO_DISPONIBILIDAD ";
                        
                            
                            
                            
                    break;                    

                
                
                
                
                
                
                
                
                
        }
        return $cadenaSql;
    }
}
?>
