<?php

function conectarBD(){

    //CONEXION CON LOCALHOST
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $bd = "tiendaOnline";

    //CONEXION PARA EL SERVIDOR
    // $servername = "212.227.149.154";
    // $user = "rootejerciciotiendaluzmaweb";
    // $pass = "ray36~E93";
    // $bd = "ejerciciotiendaluzmaweb";

    $conexion = new mysqli($servername,$user,$pass,$bd);

    if($conexion ->connect_error){
        die("Conexion fallida: " . $conexion->connect_error);
    }else{
        // echo "Conexión exitosa";
    }

    return $conexion;

}

?>