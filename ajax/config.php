<?php
/**
 * COnfiguración de base de datos
 */
$config['manager'] = "mysql";     //Tipo de gestor utilizado
define('MANGER', $config['manager']);
        
$config['host'] = "localhost";    //Nombre del host o servidor de la base de datos
define('HOST', $config['host']);

$config['user'] = "root";         //Usuario de acceso a la base de datos 
define('USER', $config['user']);

$config['pass'] = "MariaDB";      //Contraseña de acceso a la base de datos
define('PASS', $config['pass']);

$condig['db'] = "bd_selectdata";        //Nombre de la base de datos utilizada
define('DB', $condig['db']);

date_default_timezone_set("America/Caracas");   //DEfinición del tipo de horario utilizado en el servidor

#Estas son las áreas utilizadas para llenar el perfil profesional
$categorias = Array(1 => Array("nombre" => "Administrativo", "id" => 1),
               2 => Array("nombre" => "Docente", "id" => 2),
               3 => Array("nombre" => "Obrero", "id" => 3));