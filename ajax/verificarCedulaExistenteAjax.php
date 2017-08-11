<?php

require_once('../config.php');

require_once '../class/dbPdo.php';
require_once '../class/crud.php';

$cedula = $_POST["cedula"];

$fila = 0;

$obj = new Crud();




$condicion = "lower(cedula) = '$cedula' " ;
$filas = $obj->contarFilas("datos_personales", $condicion);



echo $filas;