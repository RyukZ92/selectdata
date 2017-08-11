<?php
 		session_start();
		include_once('php_conexion.php'); 
		include_once('class/funciones.php');
		include_once('class/class.php');
		if($_SESSION['tipo_usu']=='a'){
		}else{
			header('location:error.php');
		}
		$usuario=limpiar($_SESSION['username']);
		$objProfesor=new Consultar_Profesor($usuario);
		$nit=$objProfesor->consultar('nit');
		if(!empty($_GET['dec'])){
			$id_mate=limpiar($_GET['dec']);
			$objMateria=new Consultar_Materias($id_mate);
			if($objMateria->consultar('nombre')==NULL){
				header('location:error.php');
			}
			if(!empty($_GET['borrar'])){
				$id_borra=limpiar($_GET['borrar']);
				mysql_query("DELETE FROM material WHERE id=$id_borra");
				unlink("profesor/material/".$id_borra.".pdf");
				header('location:decano.php?dec='.$id_mate);
			}
		}else{
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
	<strong>
    	<a href="miscursos.php">
        Mis Cursos - Decano</a> >> 
        <a href="decano.php?dec=<?php echo $id_mate; ?>">
        	<?php echo $objMateria->consultar('nombre'); ?>
        </a>
    </strong>
	<table class="table table-bordered">
      <tr class="info">
        <td>
       	    <div class="row-fluid">
	            <div class="span8">
                    <h3 class="text-info"><img src="img/intro.png" class="img-circle" width="100" height="100"> 
	                Estructura de la Materia "<?php echo $objMateria->consultar('nombre'); ?>"</h3>
                </div>
    	        <div class="span4">
                	<div align="right"><br>
                	<a href="#nuevo" role="button" class="btn" data-toggle="modal">
                    	<i class="icon-book"></i> <strong>Nuevo Material de Estudio</strong>
                    </a> 
                    <a href="#actividad" role="button" class="btn" data-toggle="modal">
                    	<i class="icon-file"></i> <strong>Ingresar Actividad</strong>
                    </a>
                    </div>
					<!-- INGRESAR O CREAR ACTIVIDADES -->
                    <div id="actividad" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    	<form name="form5" method="post" action="" class="form-inline">
                        <div class="modal-header">
                        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       	 	<h3 id="myModalLabel">Ingresar Actividad</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row-fluid">
	                            <div class="span6">
                                	<strong>Nombre de Actividad</strong><br>
	                                <input type="text" name="nombre" autocomplete="off" required><br><br>
                                	<strong>Fecha de Apertura</strong><br>
                                    <input type="date" name="apertura" autocomplete="off" required value="<?php echo date('Y-m-d'); ?>"><br><br>
                                </div>
    	                        <div class="span6">
                                	<strong>Actividad</strong><br>
                                    <select name="tipo">
                                    	<?php
											$can1=mysql_query("SELECT * FROM tactividad WHERE estado='s'");
					                        while($info=mysql_fetch_array($can1)){
												echo '<option value="'.$info['id'].'">'.$info['nombre'].'</option>';
											}
										?>
                                    </select><br><br>
                                	<strong>Fecha de Cierre</strong><br>
                                    <input type="date" name="cierre" autocomplete="off" required value="<?php echo date('Y-m-d'); ?>"><br>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cancelar</strong></button>
            	            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Guardar</strong></button>
                        </div>
                        </form>
                    </div>
                    <!-- ingresar nuevo material de estudio --->
                    <div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    	<form name="form2" method="post" enctype="multipart/form-data" action="" class="form-inline">
                        <div class="modal-header">
	                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	                    <h3 id="myModalLabel">Nuevo Material de Estudio</h3>
                        </div>
                        <div class="modal-body">
        	                <strong>Nombre del Documento</strong><br>
                            <input type="text" name="nombre" autocomplete="off" required><br><br>
                            <strong>Buscar Archivo</strong><br>
                            <input name="imagen" type="file" required>
                        </div>
                        <div class="modal-footer">
                	        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cancelar</strong></button>
            	            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Guardar</strong></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>              
        </td>
      </tr>
    </table>
    <?php
		if(!empty($_POST['nombre'])){
			$nombre=limpiar($_POST['nombre']);			
			//subir la imagen del articulo
			$nameimagen = $_FILES['imagen']['name'];
			$tmpimagen = $_FILES['imagen']['tmp_name'];
			$extimagen = pathinfo($nameimagen);				
				
			if(is_uploaded_file($tmpimagen)){
				if(empty($_POST['id'])){							
					mysql_query("INSERT INTO material (nombre, materia, estado)	VALUES ('$nombre','$id_mate','s')");
					$prosql=mysql_query("SELECT MAX(id)as numero FROM material");
					if($pro=mysql_fetch_array($prosql)){	
						$numero=$pro['numero'];
					}
					$urlnueva = "profesor/material/".$numero.".pdf";
					$mensaje='El Material de Estudio "'.$nombre.'" Guardado con Exito';
				}else{
					$id=limpiar($_POST['id']);
					mysql_query("UPDATE material SET nombre='$nombre' WHERE id=$id");
					$urlnueva = "profesor/material/".$id.".pdf";
					$mensaje='El Material de Estudio "'.$nombre.'" Actualizado con Exito';
				}
														
				copy($tmpimagen,$urlnueva);	
				echo '	<div class="alert alert-success" align="center">
					  		<button type="button" class="close" data-dismiss="alert">×</button>
					  		<strong>'.$mensaje.'</strong>
						</div>';				
			}else{
				if(empty($_POST['id'])){							
					mysql_query("INSERT INTO material (nombre, materia, estado)	VALUES ('$nombre','$id_mate','s')");
					$prosql=mysql_query("SELECT MAX(id)as numero FROM material");
					if($pro=mysql_fetch_array($prosql)){	
						$numero=$pro['numero'];
					}
					$urlnueva = "profesor/material/".$numero.".pdf";
					$mensaje='El Material de Estudio "'.$nombre.'" Guardado con Exito';
				}else{
					$id=limpiar($_POST['id']);
					mysql_query("UPDATE material SET nombre='$nombre' WHERE id=$id");
					$urlnueva = "profesor/material/".$id.".pdf";
					$mensaje='El Material de Estudio "'.$nombre.'" Actualizado con Exito';
				}
				echo '	<div class="alert alert-success" align="center">
					  		<button type="button" class="close" data-dismiss="alert">×</button>
					  		<strong>'.$mensaje.'</strong>
						</div>';
			}
		}
	?>
    <div class="row-fluid">
        <div class="span4">
        	<center><strong>Contenido de Estudio</strong></center>
            <table class="table table-bordered table table-hover">
              <tr class="info">
                <td width="78%"><strong class="text-info">Titulo del Archivo</strong><strong class="text-info"><center></center></strong></td>
                <td width="22%">&nbsp;</td>
              </tr>
              <?php
                $prosql=mysql_query("SELECT * FROM material where materia='$id_mate'");
                while($info=mysql_fetch_array($prosql)){
              ?>
              <tr>
                <td>
                	<a href="profesor/material/<?php echo $info['id']; ?>.pdf" target="_blank" title="Ver Archivo">
                	<i class="icon-book"></i> <?php echo $info['nombre']; ?>
                    </a>
                </td>
                <td>
                	<center>
                	<a href="decano.php?dec=<?php echo $id_mate.'&borrar='.$info['id']; ?>" title="Eliminar de la Lista" class="btn btn-mini">
                    	<i class="icon-remove"></i>
                    </a>
                    <a href="#edit<?php echo $info['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Actualizar">
                    	<i class="icon-edit"></i>
                    </a>
                    </center>
                </td>
              </tr>
              <!-- actualizar material de estudio --->
              <div id="edit<?php echo $info['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <form name="form2" method="post" enctype="multipart/form-data" action="" class="form-inline">
                  <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      <h3 id="myModalLabel">Nuevo Material de Estudio</h3>
                  </div>
                  <div class="modal-body">
                      <strong>Nombre del Documento</strong><br>
                      <input type="text" name="nombre" autocomplete="off" required value="<?php echo $info['nombre']; ?>"><br><br>
                      <strong>Buscar Archivo</strong><br>
                      <input name="imagen" type="file" >
                  </div>
                  <div class="modal-footer">
                      <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cancelar</strong></button>
                      <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Guardar</strong></button>
                  </div>
                  </form>
              </div>
              <?php } ?>
            </table>    
        </div>
        <div class="span8">
        	<center><strong>Listado de Actividades Ingresadas</strong></center>
        	<table class="table table-bordered table table-hover">
              <tr class="info">
                <td><strong class="text-info">Nombre de la Actividad</strong></td>
                <td><strong class="text-info">Fecha de Apertura</strong></td>
                <td><strong class="text-info">Fecha de Cierre</strong></td>
                <td>&nbsp;</td>
              </tr>
              <?php ?>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <?php ?>
            </table>

        </div>
    </div>
    

</body>
</html>