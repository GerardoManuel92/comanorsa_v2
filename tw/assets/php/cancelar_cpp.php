<?php
		
		require __DIR__ . "/facturalo/class.conexion.php";
		use TIMBRADORXPRESS\API\Conexion;

		header('Content-Type: application/json');
		include("config.php"); 
        include("includes/mysqli.php");
        include("includes/db.php");
        set_time_limit(600000);
        date_default_timezone_set('America/Mexico_City');

        function changeString($string)
        {
         
            $string = trim($string);
         
            $string = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
                array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
                $string
            );
         
            $string = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
                $string
            );
         
            $string = str_replace(
                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
                $string
            );
         
            $string = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
                $string
            );
         
            $string = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
                $string
            );
         
            $string = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'),
                array('n', 'N', 'c', 'C',),
                $string
            );
         
            //Esta parte se encarga de eliminar cualquier caracter extraño
            $string = str_replace(
                array('º', '~','!','&','´',';','"','°'),
                array('','','','&amp;','','','&quot;',' grados'),
                $string
            );
         
         
            return $string;
        }

        $url = 'https://app.facturaloplus.com/ws/servicio.do?wsdl';
        $objConexion = new Conexion($url);

        # CREDENCIAL
        //$apikey='4056008b83334c1d84f6776c6144beba';
        //$tdocumento=trim($_POST["documento"]);
        $id_documento=trim($_POST["idfact"]);
        $motivo=trim($_POST["motivox"]);
        $obsx=trim($_POST["obsx"]);
        //$folio_factura="";//trim($_POST["foliox"]);

        $folioSustitucion="";

        
                
                ///// FACTURA
                $sql1="SELECT a.uuid, b.rfc, a.total,( SELECT clave FROM motivo_cancelacion WHERE id=".$motivo." LIMIT 0,1 ) AS mcancelacion, CONCAT_WS('',c.serie,c.folio) AS folio_factura
                FROM alta_ppd a, alta_clientes b, folio_ppd c
                WHERE
                a.idcliente=b.id
                AND a.idfolio=c.id
                AND a.id=".$id_documento;
                $buscar1=$db->sql_query($sql1);
                $row1=$db->sql_fetchrow($buscar1);

                $uuid=trim($row1["uuid"]);
                $rfcReceptor=trim($row1["rfc"]);
                $total=trim($row1["total"]);
                $mcancelacion=trim($row1["mcancelacion"]);
                $folio_factura=trim($row1["folio_factura"]);


        //////*********** DATOS DEL EMISOR
        $sql="SELECT rfc, apikey FROM `datos_generales` WHERE estatus = 0";
        $buscar = $db->sql_query($sql);
        $row = $db->sql_fetchrow($buscar);

        $rfcEmisor = trim($row["rfc"]);
        $apikey = trim($row["apikey"]);



        /*$cerCSD = "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";

    $keyCSD="MIIEogIBAAKCAQEAjR581c3qRNiu8cgSFUnuCqk5xI7VL7ahirUVQR1EtdPhJByA
D3Qg4gSMMroxNK23AYw4DHc9w3N5yQWXTWhNIdwjlhh/Ep8THRFfsc2L1Ewcdf1U
wG2qJVQ+kryy17jCnx882em2dDWNO/6LRzDv4xqHrMLwiPY/x3tIchtDxpGfsBCX
5P96ePs9IO1WbhN9+3uB2JIRS1eLZ8W+GGsOW8I87E5QBBj7Bbxf9TMGTRsuL2c/
UZ7nzx2ZKB2oboqZBoVHkNtSU96TIFnoTL65JjWQj8MHNEYgHt8LUF1v5Y5mS9q2
NpmePXBSEmhtIoQIowKZNsmgHVhNH6SH9GGlFQIDAQABAoIBAD8YYIxfstzxXNbx
s1QdZ/cQTqnZiuv4ZiXUbRpd8biycTlqHL/MFl+31M9hfFqnSOnCPdUlA1J+MPd2
Ln4HomT/PlH/xeEXir42ZGjlFB3podgHWntnDOn/zrJg+D2HeE0Y9GYiHte6kdk/
KBq+gKMz23Gc/1rdbwrLzkpmclk3VZfCoNBGkPpRTPImCOtQBSYketUChhN2FZWk
9kOLp1Zz2mEnpVZoCfLFU3wbZbxysdmY5SCnaA5p7StT1qcC33TORUizi44hMud6
XTXMLb9PdpW41taIeId/Te7wNUwQ+evI0Luvvy7RwTmKVDsHsaANqXA3CeqhH2VF
Z/PFxwECgYEA/1d3JP7phlXuQykM0fNU6Ci8mrz11Vjv65KK+u0SqdODYSzt6WT+
NjastK2p9lnPem2rGf5oJa2yl/y8bUhGlvSm8yYxcHeyylH9mSZRS0X55K6XqNzw
2D5gpXShgiwEoKzGwcZMRpP4ZGtIL3QwEUHaQTt/HpwbFt6HJ3DQ7XUCgYEAjXuh
mpKRuRHayEd+bli7wCRU1PUoSjj+wiuPVWF15bF4z0w+0CRKczgmxDOA3mXPta0g
pTclssF0jG/9AUDYt+8L+A/vec9Wz9eF3zcepX9iz/OOZtsoNUSrSqIJTEUYJM8N
jhx2IoDnq0u1wt4MSRYiRHcRLNUi6h7BYyjYxSECgYA8GBmyW0wakZ7Br6eUwe/5
s5yvzkkNLSFKD/MlmyYJUf5ZoHldtKcfmz6KR1T45aou5iCevYFFXNvraU/vaFM0
s9+W2iZIkeNCOom0wY/gZ1eoum53D4ifXA7i4dAhErsEFaWxdTn+YlTTTWxvvqiR
Zy42rAn+6j5142lrnuGNAQKBgCH0OaRO6Inxrv/BqKXyxZwnG/S/oRuu8fTHX26u
JQ0qukOFmM166CMepq8PbS3yYRbIpb0ArxtnMgFCHwXd+iSqScUOjfo9uCfJIWeg
Ysp099HQMaydi9i80h7nJDQZoOG0jxw72F4PcYm6cbSCdZBUr4SezpBj1i05lE+n
zd4BAoGARZp/veHhZkTVozDxUrBlM4NNYKfdQHjOnz0Ut37sB97AJ/A3Vh+SekAL
fNPown45RrLxRlYGg7glYoOAWOeTw7mQeIzDlJYFm5sJV6bLvoGYRXUltvkVTVzi
5MEXo2DBy5VRmnMKp4O4Tb6umQXyL7SpmdIxQzpWm8p3qAGWCb0=";

    $passCSD="Ca261316";*/

$cerCSD = "MIIGRTCCBC2gAwIBAgIUMDAwMDEwMDAwMDA1MTQ5MTkzNjYwDQYJKoZIhvcNAQELBQAwggGEMSAwHgYDVQQDDBdBVVRPUklEQUQgQ0VSVElGSUNBRE9SQTEuMCwGA1UECgwlU0VSVklDSU8gREUgQURNSU5JU1RSQUNJT04gVFJJQlVUQVJJQTEaMBgGA1UECwwRU0FULUlFUyBBdXRob3JpdHkxKjAoBgkqhkiG9w0BCQEWG2NvbnRhY3RvLnRlY25pY29Ac2F0LmdvYi5teDEmMCQGA1UECQwdQVYuIEhJREFMR08gNzcsIENPTC4gR1VFUlJFUk8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQQ0lVREFEIERFIE1FWElDTzETMBEGA1UEBwwKQ1VBVUhURU1PQzEVMBMGA1UELRMMU0FUOTcwNzAxTk4zMVwwWgYJKoZIhvcNAQkCE01yZXNwb25zYWJsZTogQURNSU5JU1RSQUNJT04gQ0VOVFJBTCBERSBTRVJWSUNJT1MgVFJJQlVUQVJJT1MgQUwgQ09OVFJJQlVZRU5URTAeFw0yMjA5MDUxNDM5MTJaFw0yNjA5MDUxNDM5MTJaMIIBEjEzMDEGA1UEAxMqQ09NRVJDSUFMSVpBRE9SQSBBTkdFTCBERSBPUklFTlRFIFNBIERFIENWMTMwMQYDVQQpEypDT01FUkNJQUxJWkFET1JBIEFOR0VMIERFIE9SSUVOVEUgU0EgREUgQ1YxMzAxBgNVBAoTKkNPTUVSQ0lBTElaQURPUkEgQU5HRUwgREUgT1JJRU5URSBTQSBERSBDVjElMCMGA1UELRMcQ0FPMTYwMTI1SVQ3IC8gQUVDRTg3MDExM0k5QTEeMBwGA1UEBRMVIC8gQUVDRTg3MDExM0hNQ05NRDA1MSowKAYDVQQLEyFDT01FUkNJQUxJWkFET1JBIEFOR0VMIERFIE9SSUVOVEUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCC6XFgNWuvd+5n64t8mIXNBbk+E2TtcYBisKWkzld73CtN43nRA83D4fy/Iv5CWr8XBG623jW11WDdLNRcaeBIJGiIEH8VtHjM/o4z1HH4HLVhk43ZamK2Bc5mG0k3qh+UOFIRDzy/p2xLJCCUv/45UCYPDQ3uCvy50Nsz3gTNED3v6xB+vsyzBBMkYYvtQOPNx2ltgBAt9f+PV6Yzt40x7i5Uz/Bp3wrAwHyVDwuOTgcRuct8pZyDF8ucn/FEPXib/x86K4CU70pwK4sR0sp+2r2LUdRwrEjbGCYxsgORe5S4JHPiB4o4YtztT7bw+N/d5sB9wLWiIN7+jgjOrYSbAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQCaOliEUosmt3aSUCp/gt0Lz458NcAmwJsDs1FBLQugyUp5ueGKabwWFEsjGEk42LMiCt2coKFT4SOh31sM505K7gIx48dpAaWvgxroznRCfBAB1rSiQ8zVIuKmFSrFqyT1+8Vah7vC7+IotrQn31Er5hknMGXUruRVCsr1UNaPiDZzaXYK0yK8wdoik+Y++k/8+/+UYLVDf2476q2DwZ7lJe58u2yx5Ae27LJKBJX6FfgtOqgQKoNRaekneEH2PwHD7n60Uij5+AsLqFHBJeDXKNhq3xa8wrAsTFzI+5O5czQrNOINAj+ngcS6MoBjE7WaEuH3gyhlI2sx9MChWd84xDrZIn3LOh/7ssKvG1zR6EovbPCNOEKOvWH5Ua68vPX0coiwBC7vunCTZXMsnMFxJloDev3crr44ICgSue42wtqdXNgKVo9JTOYKW6Ag/31g21RH9PHUTYOcTipUc9QIA7OwVjOu/vaVEZqvjDptOOtnuMe1UlFoXlbU5o0kqF2M619zOJn2t+g4fax+yZhvbDn60TgwJk+lqIBEt9cEay3kVdBMJVbjrwo/fEgXz5hyGFfSBCuQzvMrT4m/x20Gt5IRHLdMieBJ5JZPdLGLuNLG9+G9I5iuWbIoQnKnR4mVSevTV+dD1PIzw/Vma7F+m2g5EGy5blwi2zmeRNgS2A==";

$keyCSD="MIIEpAIBAAKCAQEAgulxYDVrr3fuZ+uLfJiFzQW5PhNk7XGAYrClpM5Xe9wrTeN5
0QPNw+H8vyL+Qlq/FwRutt41tdVg3SzUXGngSCRoiBB/FbR4zP6OM9Rx+By1YZON
2WpitgXOZhtJN6oflDhSEQ88v6dsSyQglL/+OVAmDw0N7gr8udDbM94EzRA97+sQ
fr7MswQTJGGL7UDjzcdpbYAQLfX/j1emM7eNMe4uVM/wad8KwMB8lQ8Ljk4HEbnL
fKWcgxfLnJ/xRD14m/8fOiuAlO9KcCuLEdLKftq9i1HUcKxI2xgmMbIDkXuUuCRz
4geKOGLc7U+28Pjf3ebAfcC1oiDe/o4Izq2EmwIDAQABAoIBAAgxHXQcw6lOQu/j
0G2yiaTjt8zHn+gv0w3Z6fOfKeBJTbhpBKVsrIKWcJ9xTCHQ1eZV06vDye6f9JjC
hmNmCK/a/2OMTLeJ/IkvYKyjnaIeAceiWR0CyDyFrn27NWCzV5iJ0bDZmD6R9nfZ
QeStAvaJKmiEs5tyuo/SHvVm7jv6skv7LWUFcDwNvdf9Vxa63lTe07DMpRomE9gm
YGx4Mx8wuGWbuj7GyHYmh0J3X2HB9I5+ntKHLbArArfUVZ6eHrhcmjPFLnAMhNgS
131yFCu6GGo00l5e3HLo1y5IAPqGkwgkgbXk9zaLfeuvvOuIH67FPeqJ4uvyZVFl
lTWuzTECgYEAuLpJojLTUJLFKHoL/NdE1Ql7cdGvbfViwgKg+/dZF7HTfkbLR8S+
cYbq+IbEzYwL1Z5X85NbC0Wq8EZVuMK5JxMpOOr7ApeohuOtfba91XXKV6cmT4+o
o44NP4AteSSo4DbW4IZzwUwzzgY3t53yymGkIQtnLAHiU970R9vURnkCgYEAtWu4
8O/q6DaYUF7aNGE1O+pdiSRQm83htSOz8ehutvVojlNNBGBln9jT/fhHAXMZiSDI
0qiOyHafzT1BNCOl0akWqQxfPA4yK7J3NnmiTwAO9BLpIG1UHwqrAzan+zEchITT
276KCj+Zth/7rnf51eHUFwCARif/CrsKw+2qrrMCgYEAkPTFwTzG64wwoEGdVIwM
HGwzbS5QziVnmLx9XRtM0zYcsxOUgr3Vf7qSefEvT+hchQWbGK0CHYdOyvs2WySa
LBpyF5L046Tkfuz8gBC9SFsFK+EjQ/2EJMvcg37usAhfaIo/9bIr9Xv5jur8H98W
3U7ff3q2PCdCVfQ3loffPGkCgYBHc1SUN7lJmW7lgGXp6TsBDO2nvJCuvCgfoh8V
sBgioIZ8P1x+08RSbyAWzziP3pf5BNty9AW/99A6EdzjPwLojvKow4GicmjaAuCm
qML+4CQDhosgRU6zJw1xJ46DBLWZj4Ks8d8F6ESOkQwbi47u6JESOhVLDCeLP10f
CzSEtwKBgQCWlUMPhApr0I8KaBhoGDZ3sNwmGSv/0EIlso+ULmcBLZ8O2vjBeZ3j
eE7iS6EPJ8R8AWFstKrHRavGUrb0n361RgmHyZyidaqIc7T1mZpcZ0j/TQkGVYOR
RC6MJSnygZZR99Vq/f9xBzibcg0mcmwMPR31lT9FZ48VUgP5OcJMog==";

$passCSD="C64526452";


    //$datos= array('APIKEY' => $apikey,'PASSCSD' => $passCSD,'UUID' => $uuid, 'EMISOR' => $rfcEmisor, 'RECEPTOR' => $rfcReceptor, 'TOTAL' => $total, 'OBS' => $obsx );

    //echo json_encode($datos);

    $respuesta = false;

    $resultado = $objConexion->operacion_cancelar($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total, $mcancelacion, $folioSustitucion, $folio_factura);

    $separarx=explode("%", $resultado);

    if ( $separarx[0] == 0 ) {

        /////******** ACTUALIZAR ESTATUS DE LA FACTURA 
        $updatex = "UPDATE `alta_ppd` SET `estatus` = '2', `obs_cancelacion` = '".$obsx."' WHERE `id`=".$id_documento;
        $db->sql_query($updatex);

        ////////////*********** RETIRAR LOS PAGOS DE LAS FACTURAS DEL COMPLEMENTO

        $sql_cpp="SELECT a.idfactura,a.tipo,a.pago,a.id
        FROM alta_pagos_ppd a WHERE a.idppd=(SELECT x.id FROM alta_datos_ppd x WHERE x.idcpd=".$id_documento." )";
        $buscar_cpp=$db->sql_query($sql_cpp);
        while( $row_cpp=$db->sql_fetchrow($buscar_cpp) ) {
            
            if ( $row_cpp["tipo"]==0 ) {
                
                $update_fact="UPDATE alta_factura a SET a.pago=0 WHERE a.id=".trim($row_cpp["idfactura"]);
                $db->sql_query($update_fact);

                $update_pago_comp="UPDATE pagos_factura a SET a.estatus=0 WHERE a.idfactura=".trim($row_cpp["idfactura"])." AND a.idppd=".$id_documento." AND a.tipo=0";
                $db->sql_query($update_pago_comp);


            }elseif( $row_cpp["tipo"]==1 ) {
                
                $update_fact="UPDATE alta_factura_sustitucion a SET a.pago=0 WHERE a.id=".trim($row_cpp["idfactura"]);
                $db->sql_query($update_fact);

                $update_pago_comp="UPDATE pagos_factura a SET a.estatus=0 WHERE a.idfactura=".trim($row_cpp["idfactura"])." AND a.idppd=".$id_documento." AND a.tipo=1";
                $db->sql_query($update_pago_comp);

            }

            $update_pago="UPDATE alta_pagos_ppd a SET a.estatus=1 WHERE a.id=".trim($row_cpp["id"]);
            $db->sql_query($update_pago);

        }

        ## GUARDAR ACUSE EN DIRECTORIO ACTUAL ##
        file_put_contents('acuse_cancelacion_cpp/acuse'.$folio_factura.'.xml',$separarx[1]);
        $respuesta = true;
        
    }else{

        
        $respuesta=$separarx[2].'-'.$separarx[1];
    }

    echo json_encode($respuesta);

?>