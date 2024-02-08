<?php

    include("config.php"); 
    include("includes/mysqli.php");
    include("includes/db.php");
    set_time_limit (600000);
    date_default_timezone_set('America/Mexico_City');


    $sql="SELECT * FROM `alta_clientes` where nombre like '%operadora%' ";
    $prepare=$db->sql_prepare($sql);
    $total=$db->sql_numrows($prepare);

    $buscar=$db->sql_query($sql);
    $row=$db->sql_fetchrow($buscar);

    //echo $row["nombre"];

    echo $total;

?>