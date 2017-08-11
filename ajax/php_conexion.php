<?php
require_once "config.php";
    $conexion = mysql_connect($config['host'], $config['user'], $config['pass']);
    
    mysql_select_db($condig['db'], $conexion);
    mysql_query("SET NAMES 'utf8'");
    
    $s='$';

    function limpiar($tags){
            $tags = strip_tags($tags);
            return $tags;
    }
function mysqli(){
    
    //$conex=new mysqli('localhost','root','MariaDB','bd_sigaf');
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    $mysqli->query("SET NAMES 'utf8'");
    if ($mysqli -> connect_errno) {
    die( "Fallo la conexión a MySQL: (" . mysqli_connect_errno() 
    . ") " . mysqli_connect_error());
}
    
    return $mysqli;
}
function desconectar()  {
    return mysqli()->close();
}/*
$res = mysqli()->query("SELECT username, id FROM usuarios;");
$users = $res->fetch_assoc();
//print_r($res->fetch_assoc());
foreach ($users as $user)
    //echo "<br>".$user["id"];

while($persona=$res->fetch_assoc())
  echo "<br>". $persona["username"];

print_r($persona);*/			
?>
