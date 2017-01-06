<?php
class SqlService {

    function sql($opcion, $variable) {
    $cadenaSql='';
        switch ($opcion) {

                case "opxcdp":
                    
                        $cadenaSql=" SELECT DISTINCT TO_CHAR(DET_OP.VIGENCIA) VIGENCIA,";
                        $cadenaSql.=" DET_OP.UNIDAD_EJECUTORA UNIDADEJECUTORA,";
                        $cadenaSql.=" RUB.INTERNO_RUBRO INTERNORUBRO,";
                        $cadenaSql.=" RUB.CODIGO_NIVEL1 ||'-'||RUB.CODIGO_NIVEL2||'-'||RUB.CODIGO_NIVEL3||'-'||RUB.CODIGO_NIVEL4||'-'||RUB.CODIGO_NIVEL5||'-'||RUB.CODIGO_NIVEL6||'-'||RUB.CODIGO_NIVEL7||'-'||RUB.CODIGO_NIVEL8 CODIGORUBRO,";
                        $cadenaSql.=" RUB.DESCRIPCION NOMBRERUBRO,";
                        $cadenaSql.=" DET_OP.DISPONIBILIDAD DISPONIBILIDAD,";
                        $cadenaSql.=" CRP.NUMERO_REGISTRO REGISTROPRESUPUESTAL,";
                        $cadenaSql.=" TO_CHAR(CRP.FECHA_REGISTRO,'yyyy-mm-dd') FECHAREGISTRO,";
                        $cadenaSql.=" NVL(CRP_DISP.VALOR,0) VALOR_CRP,";
                        $cadenaSql.=" OP.NUMERO_DE_COMPROMISO NUMEROCOMPROMISO,";
                        $cadenaSql.=" TO_NUMBER(DET_OP.CONSECUTIVO) ORDENPAGO,";
                        $cadenaSql.=" DECODE(DET_OP.VALOR_BRUTO,0,PAGO.VALOR,DET_OP.VALOR_BRUTO )VALORORDEN,";
                        $cadenaSql.=" UPPER(DECODE(OP.FECHA_APROBACION,'',DECODE(EGR.FECHA_REGISTRO,'',TO_CHAR('01/01/1900','yyyy-mm-dd'),TO_CHAR(EGR.FECHA_REGISTRO,'yyyy-mm-dd')),TO_CHAR(OP.FECHA_APROBACION,'yyyy-mm-dd'))) FECHAORDEN,";
                        $cadenaSql.=" UPPER(TO_CHAR(EGR.FECHA_REGISTRO,'yyyy-mm-dd')) FECHAPAGO,";
                        $cadenaSql.=" BEN.IB_CODIGO_IDENTIFICACION IDENTIFICACION,";
                        $cadenaSql.=" BEN.IB_PRIMER_NOMBRE||' '||BEN.IB_SEGUNDO_NOMBRE||' '||BEN.IB_PRIMER_APELLIDO||' '||BEN.IB_SEGUNDO_APELLIDO BENEFICIARIO,";
                        $cadenaSql.=" UPPER(OP.DETALLE) DETALLEORDEN";
                        $cadenaSql.=" FROM SHD.SHD_INFORMACION_BASICA BEN";
                        $cadenaSql.=" INNER JOIN OGT.OGT_ORDEN_PAGO OP ON OP.TIPO_DOCUMENTO ='OP' AND OP.IND_APROBADO = 1 AND OP.TIPO_OP != 2 AND BEN.ID =OP.TER_ID";
                        $cadenaSql.=" INNER JOIN OGT.OGT_IMPUTACION DET_OP ON DET_OP.TIPO_DOCUMENTO = 'OP' AND DET_OP.VIGENCIA = OP.VIGENCIA AND DET_OP.ENTIDAD = OP.ENTIDAD AND DET_OP.UNIDAD_EJECUTORA = OP.UNIDAD_EJECUTORA AND DET_OP.CONSECUTIVO = OP.CONSECUTIVO AND DET_OP.ANO_PAC = OP.VIGENCIA";
                        $cadenaSql.=" INNER JOIN PR.PR_REGISTRO_PRESUPUESTAL CRP ON CRP.NUMERO_REGISTRO=DET_OP.REGISTRO AND CRP.NUMERO_DISPONIBILIDAD=DET_OP.DISPONIBILIDAD AND CRP.VIGENCIA=DET_OP.VIGENCIA AND CRP.CODIGO_UNIDAD_EJECUTORA=DET_OP.UNIDAD_EJECUTORA";
                        $cadenaSql.=" INNER JOIN PR.PR_REGISTRO_DISPONIBILIDAD CRP_DISP ON CRP.NUMERO_REGISTRO=CRP_DISP.NUMERO_REGISTRO AND CRP.NUMERO_DISPONIBILIDAD=CRP_DISP.NUMERO_DISPONIBILIDAD AND CRP.VIGENCIA=CRP_DISP.VIGENCIA AND CRP.CODIGO_UNIDAD_EJECUTORA=CRP_DISP.CODIGO_UNIDAD_EJECUTORA";
                        $cadenaSql.=" INNER JOIN PR.PR_V_RUBROS RUB ON DET_OP.VIGENCIA =RUB.VIGENCIA AND DET_OP.RUBRO_INTERNO=RUB.INTERNO_RUBRO";
                        $cadenaSql.=" LEFT OUTER JOIN OGT.OGT_DETALLE_EGRESO EGR ON OP.CONSECUTIVO=EGR.CONSECUTIVO AND OP.TER_ID =EGR.TER_ID AND OP.VIGENCIA =EGR.VIGENCIA AND OP.UNIDAD_EJECUTORA = EGR.UNIDAD_EJECUTORA";
                        $cadenaSql.=" LEFT OUTER JOIN OGT.OGT_PAGO PAGO ON PAGO.ID_PAGO=EGR.ID_PAGO";
                        $cadenaSql.=" WHERE OP.VIGENCIA=".$variable['id0'];
                        if(isset($variable['id1']) && $variable['id1']>0 )
                            {$cadenaSql .= " AND DET_OP.DISPONIBILIDAD=".$variable['id1'];}
                        $cadenaSql.=" ORDER BY FECHAPAGO,";
                        $cadenaSql.=" VIGENCIA,";
                        $cadenaSql.=" UNIDADEJECUTORA,";
                        $cadenaSql.=" CODIGORUBRO,";
                        $cadenaSql.=" NUMEROCOMPROMISO,";
                        $cadenaSql.=" DISPONIBILIDAD,";
                        $cadenaSql.=" REGISTROPRESUPUESTAL,";
                        $cadenaSql.=" ORDENPAGO";
                            
                    break;                    

                
                
                
                
                
                
                
                
                
        }
        return $cadenaSql;
    }
}
?>
