<?php

require_once('../config.php');

require_once '../class/dbPdo.php';
require_once '../class/crud.php';

$username = $_POST["username"];
$fila = 0;
//$html = "Azul";
$obj = new Crud();


if($_POST["tipo"] == "registro") {        
    //$html = "Error1";
    $filas = $obj->contarFilas("usuarios", "username = '$username'");
    
} else {
    $condicion = "lower(username) = '".strtolower($_POST["username"])."' "            
        . "AND lower(username) != '".strtolower($_usuario[0]["username"])."'";
    $_usuario = $obj->consultar("usuarios", "username = '$username'");
    $filas = $obj->contarFilas("usuarios", $condicion);
}


echo $filas;