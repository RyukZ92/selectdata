<?php
session_start();

require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';

include_once('php_conexion.php'); 
include_once('class/funciones.php');
include_once('class/class.php');
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cambiar Clave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>
    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>
    <script src="js/application.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<table width="50%" border="0">
<tr>
  <td>
<table border="0" class="table table-bordered">
  <tr class="success">
    <td>
    	<center><strong>
        	<h3><img src="img/seguridad.jpg " class="img-circle img-polaroid" width="100" height="100"> 
            Cambiar Contraseña</h3>
        </strong></center>
    </td>
  </tr>
  <tr>
    <td>
        <div align="center" class="nuevo">
          <form name="form" method="POST" id="form">
          <label><strong>Contraseña Actual: </strong></label><input type="password" name="clave_actual" id="clave_actual" class="requerido">
          <label><strong>Nueva Contraseña: </strong></label><input type="password" name="clave1" id="clave1" class="requerido">
          <label><strong>Repetir Nueva Contraseña: </strong></label><input type="password" name="clave2" id="clave2" class="requerido"><br><br>
          <input type="submit" id="button" class="btn btn-primary" name="enviar" value="Cambiar Contraseña">
          </form>
        <?php 
	if(isset($_POST['enviar'])) {
            
            $objetoUsuario = new Crud();
            $pass = $objetoUsuario->consultar("usuarios", array("password", "key_password"), "id = '".$_SESSION['id_username']."'");

            $clave1 = limpiarCampo($_POST['clave1']);
            $clave2 = limpiarCampo($_POST['clave2']);
            $claveActualBb = decrypt($pass[0]["password"], $pass[0]["key_password"]);
            $claveActualPost = $_POST["clave_actual"];
            if($claveActualBb == $claveActualPost) {
                if($clave1 != $clave2) {
                    $msj = notificacion("Las nuevas contraseñas deben coincidir. ¡Intente de nuevo!", "danger", "times-circle");
                } else {
                    $keyPassword = sha1(generarCadenaAleatoria());
                    $newPassword = encrypt($clave1, $pass[0]["key_password"]);
                    $resultado = $objetoUsuario->guardar("usuarios", array("password"=>$keyPassword,"key_password"=>$newPassword), "id = '".$_POST["id_username"]."'");
                    $msj = notificacion("La contraseña fue cambiada exitosamente", "success", "check");
                }    
            } else {
                $msj = notificacion("La contraseña actual es incorrecta", "danger", "times-circle");
            }
		/*echo "Clave actual DB: " . $claveActualBb;
                echo "<br>Clave actual Post: " . $claveActualPost;
                echo "<br>Nueva Clave: " . $clave1;*/
                if(!empty($msj)){
                        echo $msj;
                }
        }
	
	?>
        </div>
      </td>
    </tr>
</table>
</td></tr>
</table>
</div>
</body>
</html>
