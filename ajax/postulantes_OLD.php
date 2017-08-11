<?php
session_start();

require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';

		include_once('php_conexion.php'); 
		include_once('class/funciones.php');
		include_once('class/class.php');
		/*if($_SESSION['nivel'] != 'Postulante'){
		}else{
			header('location:error.php');
		}*/
	$busqueda='';#inicializar la variable
	if(!empty($_GET['estatus'])){
		$postulante=limpiar($_GET['estatus']);
		$cans=mysql_query("SELECT estatus FROM usuarios WHERE id = '$postulante'");
		if($dat=mysql_fetch_array($cans)){
			if($dat['estatus']=='1'){
				$xSQL="Update usuarios Set estatus = '0' Where id='$postulante'";
				mysql_query($xSQL);
				header('location:postulantes.php');
			}else{
				$xSQL="Update usuarios Set estatus = '1' Where id='$postulante'";
				mysql_query($xSQL);
				header('location:postulantes.php');
			}	
		}
	}
	if(!empty($_GET['eliminar'])){
		$postulante=limpiar($_GET['eliminar']);
		$cans=mysql_query("SELECT eliminado FROM usuarios WHERE id = '$postulante'");
		if($dat=mysql_fetch_array($cans)){
			if($dat['eliminado'] == '1'){
				$xSQL="Update usuarios Set eliminado = '0' Where id='$postulante'";
				mysql_query($xSQL);
				header('location:postulantes.php');
			}else{
				$xSQL="Update usuarios Set eliminado = '1' Where id='$postulante'";
				mysql_query($xSQL);
				header('location:postulantes.php');
			}	
		}
	}
	#paginar
		$maximo=10;
		if(!empty($_GET['pag'])){
			$pag=limpiar($_GET['pag']);
		}else{
			$pag=1;
		}
		$inicio=($pag-1)*$maximo;
		
		$cans=mysql_query("SELECT COUNT(id) as total FROM usuarios");
		if($dat=mysql_fetch_array($cans)){
			$total=$dat['total']; #inicializo la variable en 0
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

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script type="text/javascript" src="js/widgets.js"></script>
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
    
    
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">

	<table class="table table-bordered">
      <tr class="info">
        <td>
       	    <div class="row-fluid">
                <div class="span6">
                    <h3 class="text-info"><img src="img/salon.png" class="img-circle" width="100" height="100"> 
                    Administración y Selección de Postulantes</h3>
                </div>
    	        <div class="span6" align="right">
                	<form name="form1" method="POST"  class="form-inline">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="icon-search"></i></span>
                            <input name="busqueda" type="text" placeholder="Búsqueda" class="input-xlarge" autocomplete="off" autofocus>
                        </div>
                    </form>

                </div>
            </div>
        </td>
      </tr>
    </table>
    <?php
    if(!empty($_POST['nombre'])){
        $nombre = limpiarCampo($_POST["nombre"]);
        $apellido = limpiarCampo($_POST["apellido"]);
        $cedula = $_POST["tipo_cedula"] . "-". limpiarCampo($_POST["cedula"]);                       

        if(empty($_POST['id'])){ //Se comprueba si es registro o actualización de Data.
            $objetoUsuario = new Crud();
            $tabla = "usuarios";
            $pass = $objetoUsuario->consultar($tabla, array("password", "key_password"), "username = '$username'");

            $nombre = limpiarCampo($_POST['nombre']);
            $apellido = limpiarCampo($_POST['apellido']);


            $keyPassword = sha1(generarCadenaAleatoria());
            $newPassword = encrypt($_POST["password"], $keyPassword);


            $datos = array( 'email'                 =>  $email,
                            'nivel'                 =>  $nivel,
                            'username'              =>  $username,
                            'password'              =>  $newPassword,
                            'key_password'          =>  $keyPassword,
                            'fecha_actualizacion'   =>  date("Y-m-d"),
                            'hora_actualizacion'    =>  date("H:i:s"));
            $ultimoId = $objetoUsuario->guardar($tabla, $datos, null, true);

            $datos = array( 'nombre'                 =>  $nombre,
                            'apellido'               =>  $apellido,                                            
                            'fecha_actualizacion'    =>  date("Y-m-d"),
                            'hora_actualizacion'     =>  date("H:i:s"),
                            'id'                     =>  $ultimoId);
            $resultadoDatos = $objetoUsuario->guardar("datos_personales", $datos);
            if($ultimoId and $resultadoDatos) {
                echo notificacion("Usuario registrado exitosamente", "success");
            } else {
                echo notificacion("Error al intentar registrar registro", "danger", "times");

            }
        }else {
            $id = $_POST["id"];
            $objetoUsuario = new Crud();
            $tabla = "usuarios";
            $pass = $objetoUsuario->consultar($tabla, array("password", "key_password"), "username = '$username'");

            $nombre = limpiarCampo($_POST['nombre']);
            $apellido = limpiarCampo($_POST['apellido']);

            if(!empty($_POST['password'])) {
                $keyPassword = sha1(generarCadenaAleatoria());
                $newPassword = encrypt($_POST["password"], $keyPassword);
            } else {
                $keyPassword = $pass[0]['key_password'];
                $newPassword = $pass[0]['password'];
            }

            $datos = array( 'email'                 =>  $email,
                            'nivel'                 =>  $nivel,
                            'password'              =>  $newPassword,
                            'key_password'          =>  $keyPassword,
                            'fecha_actualizacion'   =>  date("Y-m-d"),
                            'hora_actualizacion'    =>  date("H:i:s"));
            $resultadoUsuario = $objetoUsuario->guardar($tabla, $datos, "id = '$id'");

            $datos = array( 'nombre'                 =>  $nombre,
                            'apellido'               =>  $apellido,                                            
                            'fecha_actualizacion'    =>  date("Y-m-d"),
                            'hora_actualizacion'     =>  date("H:i:s"));
            $resultadoDatos = $objetoUsuario->guardar("datos_personales", $datos, "id = '$id'");
            if($resultadoUsuario and $resultadoDatos) {
                echo notificacion("Registro actualizado exitosamente", "success");
            } else {
                echo notificacion("Error al intentar actualizar registro", "danger", "times");

            }
        }

    }
	?>
	<table class="table table-bordered table table-hover">
      <tr class="info">
          
      	<td ><strong class="text-info">Documento</strong></td>
        <td> <strong class="text-info">Nombre completo</strong></td>
      	<td ><strong class="text-info">Profesión</strong></td>
        <td ><strong class="text-info">Categoría</strong></td>
        <td><strong class="text-info">Estatus</strong></td>
      	<td ><center><strong class="text-info">Acciones</strong></center></td>
      	
   	  </tr>
      <?php
		if(empty($_POST['busqueda'])){
			$sql="SELECT dp.id, cedula, dp.nombre, dp.apellido, profesion, categoria, cargo_postulado, ep.estatus as estatus_p "
                                . "FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) JOIN curriculo c ON (c.id = dp.id) JOIN estatus_postulacion ep ON (ep.curriculo = c.id) "
                                . "WHERE u.eliminado = '0' AND nivel = 'Postulante' ORDER BY nombre,apellido LIMIT $inicio, $maximo";
		}else{
			$busqueda=limpiar($_POST['busqueda']);
			$sql="SELECT dp.id, cedula, dp.nombre, dp.apellido, profesion, categoria, cargo_postulado "
                                . "FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) JOIN curriculo c ON (c.id = dp.id) JOIN estatus_postulacion ep ON (ep.curriculo = c.id) "
                                . "WHERE eliminado = '0' AND nivel = 'Postulante' "
                                . "AND (profesion LIKE '%$busqueda%' or nombre LIKE '%$busqueda%' or apellido LIKE '%$busqueda%' or cedula LIKE '%$busqueda%' or categoria LIKE '%$busqueda%') "
                                . "ORDER BY nombre, apellido LIMIT $inicio, $maximo";
		}
		 	
		$can=mysql_query($sql);
                $objetoPersona = new Crud();
		while($dato=mysql_fetch_array($can)){
                    $nivel=$dato['nivel'];
                    $_postulantes[] = $dato['id'];
                    $nombreCompleto = $dato["nombre"]. " " . $dato["apellido"];
	  ?>
      <tr>
          
        <td><?php echo $dato['id'] . " | | . ". $dato['cedula']; ?></td>
        <td title="<?php echo $nombreCompleto; ?>"><?php echo $nombreCompleto; ?></td>
        <td><?php echo $dato['profesion']; ?></td>
        <td><?php echo $dato['categoria']; ?></td>
        <td title="Clic aquí para cambiar de estatus"><a href="#est<?php echo $dato['id'] ?>"><?php echo obtenerEstatusPostulacion($dato['estatus_p']); ?></a></td>
        <td>
        	<center>
            <a href="#act<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Actualizar">
                <i class="icon-edit"></i>                
            </a>                
              
                
            <a href="#eli<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Eliminar">
            	<i class="icon-remove"></i>                
            </a>
            </center>
        </td>
      </tr>
      
    <!-- actualizar nuevos -->
    <div id="act<?php echo $dato['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form name="form1" method="post" action="" class="form-inline">
    	<input type="hidden" name="id" value="<?php echo $dato['id']; ?>">
        <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
       	 	<h3 id="myModalLabel">Actualizar Usuario</h3>
        </div>
        <div class="modal-body">
       	    <div class="row-fluid">
	            <div class="span6">
                	<strong>Usuario</strong><br>
                	<input type="text" name="username" autocomplete="off" 
                               readonly value="<?php echo $dato['username']; ?>"><br>
                    <strong>Contraseña</strong><br>
                    <input type="text" name="password" autocomplete="off" value=""><br>  
                    <strong>Correo Electronico</strong><br>
                    <input type="text" name="email" autocomplete="off" required value="<?php echo $dato['email']; ?>">    
                </div>
    	        <div class="span6">
                    
                    <strong>Nombres</strong><br>
                	<input type="text" name="nombre" autocomplete="off" 
                               value="<?php echo $dato['nombre']; ?>"><br>
                    <strong>Apellidos</strong><br>
                	<input type="text" name="apellido" autocomplete="off" 
                               value="<?php echo $dato['apellido']; ?>"> <BR>
                        <strong>Tipo de Usuario</strong> <br>
                    <select name="nivel">
                    	<option value="Admin" <?php if($nivel=='Admin'){ echo 'selected'; } ?>>Admin</option>
                        <option value="Secretario" <?php if($nivel=='Secretario'){ echo 'selected'; } ?>>Secretario</option>
                        <option value="Postulante" <?php if($nivel=='Postulante'){ echo 'selected'; } ?>>Postulante</option>
                    </select> 
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Actualizar</strong></button>
        </div>
        </form>
    </div>
      <?php } ?>
    </table>
    <?php
		$can=mysql_query($sql);
		if(!$dato=mysql_fetch_array($can)){
			echo '	<div class="alert alert-error" align="center">
						<strong>No hay resultados con la busqueda "'.$busqueda.'"</strong>
					</div>';
		}
	?>
    <div class="pagination" align="center">
        <ul>
        <?php
            if(empty($_POST['bus'])){
                $tp = ceil($total/$maximo);#funcion que devuelve entero redondeado
                for($n=1; $n<=$tp ; $n++){
                    if($pag==$n){
                        echo '<li class="active"><a href="postulantes.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
                    }else{
                        echo '<li><a href="postulantes.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
                    }
                }
            }
	?>
        </ul>
    </div>
    <!-- guardar nuevos -->
    <div id='nuevo' class="modal hide fade nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form name="form1" method="post" action="" class="form-inline">
    	
        <div class="modal-header">
        	<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
       	 	<h3 id="myModalLabel">Crear Nuevo Postulante</h3>-->
        </div>
        <div class="modal-body">
       	    <div class="row-fluid">
	            <div class="span6">
                	<strong>Usuario</strong><br>
                        <input type="text" name="username" autocomplete="off" class="requerido"
                               value="<?php echo $_POST['username']; ?>"><br>
                    <strong>Contraseña</strong><br>
                    <input type="text" name="password" autocomplete="off" class="requerido"><br>  
                    <strong>Correo Electronico</strong><br>
                    <input type="email" name="email" autocomplete="off" class="requerido" value="<?php echo $_POST['email']; ?>">    
                </div>
    	        <div class="span6">
                    
                    <strong>Nombres</strong><br>
                	<input type="text" name="nombre" autocomplete="off" class="requerido" 
                               value="<?php echo $_POST['nombre']; ?>"><br>
                    <strong>Apellidos</strong><br>
                	<input type="text" name="apellido" autocomplete="off"  class="requerido"
                               value="<?php echo $_POST['apellido']; ?>"> <BR>
                        <strong>Tipo de Usuario</strong> <br>
                    <select name="nivel">
                    	<option value="Admin" <?php if($_POST['nivel'] =='Admin'){ echo 'selected'; } ?>>Admin</option>
                        <option value="Secretario" <?php if($_POST['nivel']=='Secretario'){ echo 'selected'; } ?>>Secretario</option>
                        <option value="Postulante" <?php if($_POST['nivel']=='Postulante'){ echo 'selected'; } ?>>Postulante</option>
                    </select> 
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Registrar</strong></button>
        </div>
        </form>
    </div>
<?php
foreach ($_postulantes as $id):          
?>    
    <div class="modal hide fade" id="est<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3><i class="icon-info"></i>Confirmación</h3>
               </div>
               <div class="modal-body">
                  <h5>¿Está seguro que desea eliminar este postulante?</h5> 
                  <p>Le recordamos que no podrá deshacer los cambios.</p>
           </div>
               <div class="modal-footer">
              <!--<a href="#" data-dismiss="modal" class="btn btn-default">Cancelar</a>
              <a href="postulante.php?estatus=<?php echo $id ?>" class="btn btn-primary">Confirmar</a>-->
              <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
              <a style="color:#fff" href="postulantes.php?eliminar=<?php echo $id ?>"><button class="btn btn-primary"><i class="icon-ok"></i> <strong>Confirmar</strong></button></a>
               </div>
          </div>
       </div>
    </div>
<?php endforeach; ?>
    <script src="js/bootstrap-modal.js"></script>
</body>
</html>
