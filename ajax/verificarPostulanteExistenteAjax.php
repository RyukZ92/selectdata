<?php
require_once('../config.php');
require_once('../php_conexion.php');

$nit = $_POST["nit"];
$fila = null;
$html = "Azul";
if($_POST["tipo"] == "registro") {
    $resultado=mysql_query("SELECT nombre FROM postulantes WHERE cedula = '$nit';");
    $fila = mysql_num_rows($resultado);
} else {
    $resultado=mysql_query("SELECT nit FROM postulantes WHERE cedula = '$nit';");
    $fila = mysql_num_rows($resultado);  
    while($dato = mysql_fetch_array($resultado)) {
        if($dato["nit"] != $nit AND $fila > 0) {
            $fila = 1;
        }
    }
}
if ($fila) {
    $html = true;
} else {
    $html = false;
}

echo $html;