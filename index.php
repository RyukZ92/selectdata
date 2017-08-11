<?php
require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';

session_start();
error_reporting(0);
include_once('php_conexion.php'); 
include_once('class/funciones.php');
include_once('class/class.php');
//print "<pre>"; print_r($_POST); print"</pre>";
if(!empty($_POST['username']) and !empty($_POST['password'])){
    
    $username = limpiarCampo($_POST["username"]);
    $password = limpiarCampo($_POST["password"]);
    $objetoUsuario = new Crud();
    $condicion =  "lower(username) = '".strtolower($username)."' AND estatus = '1' AND eliminado = '0'";
    $usuario = $objetoUsuario->consultar("usuarios u JOIN datos_personales dp ON (u.id = dp.id)", 
            array("u.id", "username", "password", "key_password", "nivel", "nombre", "apellido", "cedula"), 
            $condicion);
    
    if(count($usuario)) {
        $key = $usuario[0]['key_password'];
        $passwordDb = $usuario[0]['password'];
        $passwordDb = decrypt($passwordDb, $key);
        $login = $objetoUsuario->contarFilas("usuarios", $condicion);

        if($password == $passwordDb) {
            $_SESSION['nivel'] = $usuario[0]['nivel'];
            $_SESSION['username'] = $usuario[0]['username'];
            $_SESSION['id_username'] = $usuario[0]['id'];
            $_SESSION['nombre_apellido'] = explode(' ', $usuario[0]['nombre'])[0] . " " . explode(' ', $usuario[0]['apellido'])[0];
            $_SESSION['nombre'] = $usuario[0]['nombre'];
            $_SESSION['apellido'] = $usuario[0]['apellido'];
            if($usuario[0]['nivel'] == 'Admin') {
  
                header('refresh:0;principal.php');
            } else if($usuario[0]['nivel'] == 'Secretario') {
    
                header('refresh:0;principal.php');
            } else {
    
                header('refresh:0;principal.php');
            }
        } else {
            $error = true;
           
        }
    } else {
        $error = true;
        //echo "El usuario no existe";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
   <meta charset="utf-8">
    <title>Entrar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
	padding-top: 50px;
	padding-bottom: 50px;
	background-color: #f5f5f5;
	background-image: url(img/Fondox.png);
      }

      .form-signin {
        max-width: 350px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

        
        <link href="css/bootstrapv3.3/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
	    <center>
    	    <img src="img/banner_sistema.png" /></a>
            </center>

    	    <center>
         <br>
            
            <strong><h5>Sistema de Seleccion del Departamento de Talento Humano del UPTP "Luis M. Rivera"<h5></strong><BR>
            </center>
      <form name="form1" method="post" action="" class="form-signin">
        <h2 class="form-signin-heading"><center>Inicio de Sesión</center></h2>
        <input autocomplete="off" type="text" name="username" class="input-block-level" placeholder="Usuario" autocomplete="off">
        <input type="password" name="password" class="input-block-level" placeholder="Contraseña" autocomplete="off">
       <center>
	<button class="btn  btn-large btn-primary" type="submit" style="padding:10px 15px;">Ingresar</button>
	</center>

        <p>&nbsp;</p>
        <div style="float:right;">
            <a href="registrarse.php">Crear nueva cuenta</a>
        </div>
        <p>&nbsp;</p>
        <div>
            <center>
<?php
            if($error) {
                echo '<p class="help-block text-danger"><i class="fa fa-warning text-danger"></i> 
                          <span class="text-danger">Los datos ingresados son incorrectos</span>
                      </p>';
            }         

	?>
            </center>
        </div>  
      </form>

    <!-- Le javascript
    ================================================== -->
    <script src="js/bootstrapv3.3/bootstrap.min.js"></script>
    <script src="js/jquery-min.js"></script>
    <script src="js/scripts.js"></script>

<footer>
<br>
<br>
<br>
<p><center><h5>Oficina de Talento Humano Tlf:5466464644</h5></center></p>
</footer>

  </body>
</html>
