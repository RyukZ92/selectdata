<?php
    session_start();
    include_once('php_conexion.php'); 
    include_once('class/funciones.php');
    include_once('class/class.php');
    if($_SESSION['nivel'] != 'Postulante' 
        OR $_SESSION['nivel'] != 'Admin' 
        OR $_SESSION['nivel'] != 'Secretario'){
    }else{
        header('location:error.php');
    }
    $usuario=limpiar($_SESSION['username']);
    $objUsuario=new Consultar_Profesor($usuario);
    $nombre=$objUsuario->consultar('nombre');
    $nombre=ucwords(strtolower($nombre));

    $can=mysql_query("SELECT COUNT(username) as numero FROM usuarios ");
    if($dato=mysql_fetch_array($can)){
            $n_usuario=$dato['numero'];
    }
    $can=mysql_query("SELECT COUNT(nombre) as numero FROM materias");
    if($dato=mysql_fetch_array($can)){
            $n_materias=$dato['numero'];
    }
    $can=mysql_query("SELECT COUNT(username)as numero FROM usuarios WHERE nivel = 'Postulante'");
    if($dato=mysql_fetch_array($can)){
            $n_postulantes=$dato['numero'];
    }
    if($_SESSION['nivel'] == "Admin") {
        $accesoAdminUsuarios = " href='usuarios.php'";
        $accesoAdminReportes = " href='reportes.php'";
    } else {
        $accesoAdminUsuarios = "disabled";
        $accesoAdminReportes = "disabled";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blanco</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
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
<table class="table table-bordered">
  <tr class="info">
    <td>
    	<h3 class="text-info"><img src="img/user-black.png" class="img-circle" width="80" height="80"> 
        Bienvenido  <?php echo $_SESSION['nombre_apellido']; ?></h3>
    </td>
  </tr>
</table>
    <div class="row-fluid" align="center">
        <div class="span4">
        	<h3 align="center">Usuarios</h3>
            <img src="img/usuarios.png" style="width: 200px; height: 200px;" title="Usuarios"><br>
            <h3>Registrados: <?php echo $n_usuario; ?></h3><br>
            <a <?php echo $accesoAdminUsuarios; ?> class="btn btn-large btn-block btn-primary" type="button"><strong>Acceder</strong></a>
        </div>
        <div class="span4">
        	<h3 align="center">Postulantes</h3>
            <img src="img/postulantes.png" style="width: 200px; height: 200px;" title="Postulantes"><br>
            <h3>Registrados: <?php echo $n_postulantes; ?></h3><br>
            <a href="postulantes.php" class="btn btn-large btn-block btn-primary" type="button"><strong>Acceder</strong></a>
        </div>
        <div class="span4">
        	<h3 align="center">Reportes</h3>
            <img src="img/reporte.png" style="width: 200px; height: 200px;" title="Áreas"><br>
            <h3>Tipos de reportes: <?php echo 2 ?></h3><br>
            <a <?php echo $accesoAdminReportes; ?> class="btn btn-large btn-block btn-primary" type="button"><strong>Acceder</strong></a>
        </div>
    </div>
</body>
</html>
