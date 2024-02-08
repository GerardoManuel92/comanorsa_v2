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
        $folio_factura=trim($_POST["foliox"]);

        $folioSustitucion="";

        
                
                ///// FACTURA
                $sql1="SELECT a.uuid, b.rfc, a.total,( SELECT clave FROM motivo_cancelacion WHERE id=".$motivo." LIMIT 0,1 ) AS mcancelacion
                FROM alta_nota_credito a, alta_clientes b, alta_factura c
                WHERE
                a.idfactura=c.id
                AND c.idcliente=b.id
                AND a.id=".$id_documento;
                $buscar1=$db->sql_query($sql1);
                $row1=$db->sql_fetchrow($buscar1);

                $uuid=trim($row1["uuid"]);
                $rfcReceptor=trim($row1["rfc"]);
                $total=trim($row1["total"]);
                $mcancelacion=trim($row1["mcancelacion"]);


        //////*********** DATOS DEL EMISOR
        $sql="SELECT rfc, apikey FROM `datos_generales` WHERE estatus = 0";
        $buscar = $db->sql_query($sql);
        $row = $db->sql_fetchrow($buscar);

        $rfcEmisor = trim($row["rfc"]);
        $apikey = trim($row["apikey"]);

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
        $updatex = "UPDATE `alta_nota_credito` SET `estatus` = '2', `obs_cancelacion` = '".$obsx."' WHERE `id`=".$id_documento;
        $db->sql_query($updatex);

        ## GUARDAR ACUSE EN DIRECTORIO ACTUAL ##
        file_put_contents('acuse_cancelacion_nc/acuse'.$folio_factura.'.xml',$separarx[1]);
        $respuesta = true;
        
    }else{

        $respuesta=$separarx[2].'-'.$separarx[1];   

    }

    echo json_encode($respuesta);

?>