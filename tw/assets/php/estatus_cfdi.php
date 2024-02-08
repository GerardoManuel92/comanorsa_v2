<?php
		
		namespace TIMBRADORXPRESS\API;
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

        $idcfdi = trim($_POST["idcfdi"]);
        $tdocumento = trim($_POST["tdocumento"]);

        switch ($tdocumento) {
            case 1:
                
                ////FACTURA
                $sql1 = "SELECT a.uuid,a.total,b.rfc, CONCAT_WS('',c.serie,c.folio) AS fol_fact
                FROM alta_factura a, alta_clientes b, folio_factura c
                WHERE a.idcliente=b.id
                AND a.idfolio=c.id
                AND a.id=".$idcfdi;

                $documento="factura_comprobante";

            break;

            case 2:
                
                ////COMPLEMENTO
                $sql1 = "SELECT a.uuid,a.total,b.rfc, CONCAT_WS('',c.serie,c.folio) AS fol_fact
                FROM alta_ppd a, alta_clientes b, folio_ppd c
                WHERE a.idcliente=b.id
                AND a.idfolio=c.id
                AND a.id=".$idcfdi;

                $documento="factura_comprobante_pago";

            break;

            case 3:
                
                ////NC
                $sql1 = "SELECT a.uuid,a.total,c.rfc, CONCAT_WS('',d.serie,d.folio) AS fol_fact
                FROM `alta_nota_credito` a, alta_factura b, alta_clientes c, folio_nota_credito d
                WHERE a.idfactura=b.id
                AND b.idcliente=c.id
                AND a.idfolio=d.id
                AND a.id=".$idcfdi;

                $documento="factura_comprobante_nc";

            break;

            case 4:
                
                /////FACTURA SIN COTIZACION
                $sql1 = "SELECT a.uuid,a.total,b.rfc, CONCAT_WS('',c.serie,c.folio) AS fol_fact
                FROM alta_factura_sustitucion a, alta_clientes b, folio_factura c
                WHERE a.idcliente=b.id
                AND a.idfolio=c.id
                AND a.id=".$idcfdi;

                $documento="factura_comprobante";

            break;
            
            
        }

        
            $buscar1=$db->sql_query($sql1);
            $row1 = $db->sql_fetchrow($buscar1);
            $uuid = trim($row1["uuid"]);
            $rfcReceptor = trim($row1["rfc"]);
            //$total=trim($row1["total"]);
            $folio=trim($row1["fol_fact"]);


        /////************ OBTENER EL TOTAL DESDE EL XML 

        $xml = simplexml_load_file( $documento.'/'.$folio.'.xml');
        
        foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
            $atributos      = $cfdiComprobante->attributes();
            $total = $atributos['Total'];
            //$fechax = $atributos['Fecha'];
        }

        //////*********** DATOS DEL EMISOR
        $sql="SELECT rfc, apikey FROM `datos_generales` WHERE estatus = 0";
        $buscar = $db->sql_query($sql);
        $row = $db->sql_fetchrow($buscar);

        $rfcEmisor = trim($row["rfc"]);
        $apikey = trim($row["apikey"]);
        
        //$datos= array('APIKEY' => $apikey,'PASSCSD' => $passCSD,'UUID' => $uuid, 'EMISOR' => $rfcEmisor, 'RECEPTOR' => $rfcReceptor, 'TOTAL' => $total );

        //echo json_encode($datos);

        echo $objConexion->operacion_consultarEstadoSAT($apikey, $uuid, $rfcEmisor, $rfcReceptor, $total);

?>