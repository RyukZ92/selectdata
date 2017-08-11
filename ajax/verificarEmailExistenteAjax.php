<?php

require_once('../config.php');

require_once '../class/dbPdo.php';
require_once '../class/crud.php';

$email = $_POST["email"];
$username = $_POST["id"];
$fila = 0;
//$html = "Azul";
$obj = new Crud();


if($_POST["tipo"] == "actualizar") {

    $_usuario = $obj->consultar("usuarios", array("email"), "id = '$username'");
    $condicion = "lower(email) = '$email' "            
        . "AND lower(email) != '".strtolower($_usuario[0]["email"])."'";
    $filas = $obj->contarFilas("usuarios", $condicion);
}


echo $filas;