<?php
session_start();
include_once('php_conexion.php');
include_once('class/funciones.php'); 
include_once('class/class.php');
if($_SESSION['nivel'] == 'Admin' 
        OR $_SESSION['nivel'] == 'Secretario' OR $_SESSION['nivel'] == 'Postulante'):
    
if($_SESSION['nivel'] == 'Admin') {
    $accesoMenuUsuarios = "<a href='usuarios.php' target='admin'><strong>Usuarios</strong></a>";
    $accesoMenuReportesPdf = "<a href='reportes.php' target='admin'><strong>Reportes</strong></a>";
    $accesoMenuGraficos = "<a href='reportes_graficos/index.php' target='admin'><strong>Reportes Gráficos</strong></a>";
    $disabledUsuarios = "active";
    $disabledeportesPdf = "active";
    $disabledGraficos = "active";
} else {
    $accesoMenuUsuarios = "<a target='admin'><strong>Usuarios</strong></a>";
    $accesoMenuReportesPdf = "<a target='admin'><strong>Reportes</strong></a>";
    $accesoMenuGraficos = "<a target='admin'><strong>Reportes Gráficos</strong></a>";
    $disabledUsuarios = "disabled";
    $disabledReportesPdf = "disabled";
    $disabledGraficos = "disabled";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Benvenido a SelectData</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    
    <style>
        /*.disabled:hover {
            color:gray;
        }*/
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
	<!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav-collapse collapse">
            <ul class="nav">
<?php 
            if($_SESSION["nivel"] != "Postulante"):
?> 
              <li class="active">
                <a href="admin_pre.php" target="admin"><strong>Principal</strong></a>
              </li>
 
              <li class="<?php echo $disabledUsuarios ?>">
                <?php echo $accesoMenuUsuarios ?>
              </li> 
              <li class="active">
                <a href="postulantes.php" target="admin"><strong>Postulantes</strong></a>
              </li>
<?php 
          endif;
            if($_SESSION["nivel"] == "Postulante"):
?>              
              <li class="active">
                <a href="curriculo.php" target="admin"><strong>Mi Currículo</strong></a>
              </li>
              <li class="active">
                <a href="postulacion.php" target="admin"><strong>Postulación</strong></a>
              </li>
<?php 
            endif; 
            if($_SESSION["nivel"] != "Postulante"):
?>     
              <li class="<?php echo $disabledeportesPdf ?>">
                  <?php echo $accesoMenuReportesPdf ?>
              </li>
	       <li class="<?php echo $disabledGraficos ?>">
                <?php echo $accesoMenuGraficos ?>
              </li>
<?php 
          endif;
?>  
            </ul>
          <!-- lado derecho --->
            <ul class="nav pull-right">
            <li id="fat-menu" class="dropdown active">
              <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown"><strong><?php echo $_SESSION['nombre_apellido']; ?></strong> <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="datos_personales.php" target="admin"><i class="fa fa-angle-right"></i> Datos personales</a>
                </li>
                <!--<li role="presentation">
                    <a role="menuitem" tabindex="-1" href="cambiar_clave.php" target="admin"><i class="fa fa-angle-right"></i> Datos de Seguridad</a>
                </li>-->
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="cambiar_clave.php" target="admin"><i class="fa fa-angle-right"></i> Cambiar Contraseña</a>
                </li>                
                <li role="presentation" class="divider"></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="php_cerrar.php"><i class="icon-off"></i> Salir</a></li>
              </ul>
            </li>
          </ul>
          <!--========================================================-->
          </div>
        </div>
      </div>
    </div>
	<!-- Navbar ================================================== -->
    <div align="center">
        <table width="97%" border="0">
          <tr>
            <td>
            	<iframe src="<?php echo $_SESSION['nivel'] == 'Postulante' ? "datos_personales.php" : "admin_pre.php"; ?>" name="admin" frameborder="0" scrolling="auto" width="100%" height="900"></iframe>
            </td>
          </tr>
        </table>
	</div>
</body>
</html>
<?php
else:
    header('location:index.php');
endif;
	
?>