<?php
 		session_start();

require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';

include_once('php_conexion.php'); 
include_once('class/funciones.php');
include_once('class/class.php');
		if($_SESSION['nivel'] != 'Postulante'){
		}else{
			header('location:error.php');
		}
	$bus='';#inicializar la variable
	if(!empty($_GET['estatus'])){
		$usuario=limpiar($_GET['estatus']);
		$cans=mysqli()->query("SELECT estatus FROM usuarios WHERE id = '$usuario'");
                desconectar();
		if($dat=$cans->fetch_assoc()){
			if($dat['estatus']=='1'){
				$xSQL="Update usuarios Set estatus = '0' Where id='$usuario'";
				mysqli()->query($xSQL); desconectar();
				header('location:usuarios.php');
			}else{
				$xSQL="Update usuarios Set estatus = '1' Where id='$usuario'";
				mysqli()->query($xSQL); desconectar();
				header('location:usuarios.php');
			}	
		}
	}
	if(!empty($_GET['eliminar'])){
		$usuario=limpiar($_GET['eliminar']);
		$cans=mysqli()->query("SELECT eliminado FROM usuarios WHERE id = '$usuario'");
		if($dat=$cans->fetch_assoc()){
			if($dat['eliminado'] == '1'){
				$xSQL="Update usuarios Set eliminado = '0' Where id='$usuario'";
				mysqli()->query($xSQL);
				header('location:usuarios.php');
			}else{
				$xSQL="Update usuarios Set eliminado = '1' Where id='$usuario'";
				mysqli()->query($xSQL);
				header('location:usuarios.php');
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
		
		$cans=mysqli()->query("SELECT COUNT(username) as total FROM usuarios");
		if($dat=$cans->fetch_assoc()){
			$total=$dat['total']; #inicializo la variable en 0
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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
                    Registro y Control de Usuarios</h3>
                </div>
    	        <div class="span6" align="right">
                	<form name="form1" method="post" action="" class="form-inline">
                    <!-- INGRESAR NUEVO USUARIO -->

                        <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                            <i class="icon-plus"></i> <strong>Ingresar Nuevo Usuario</strong>
                        </a> |
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="icon-search"></i></span>
                            <input name="bus" type="text" placeholder="Filtrar Usuarios" class="input-xlarge" autocomplete="off" autofocus>
                        </div>
                    </form>

                </div>
            </div>
        </td>
      </tr>
    </table>
<?php
    if(!empty($_POST['username'])){
        $username = limpiarCampo($_POST["username"]);
        $email = limpiarCampo($_POST["email"]);
        $nivel = limpiarCampo($_POST["nivel"]);                       

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

            $datos = array( 'nombre'                =>  $nombre,
                            'apellido'              =>  $apellido,                                            
                            'fecha_actualizacion'   =>  date("Y-m-d"),
                            'hora_actualizacion'    =>  date("H:i:s"),
                            'id'                    =>  $ultimoId);
            $resultadoDatos = $objetoUsuario->guardar("datos_personales", $datos);
            $objetoUsuario->guardar("cursos_realizados", array("curriculo" => $ultimoId));
            $objetoUsuario->guardar("estudios_academicos", array("curriculo" => $ultimoId));
            $objetoUsuario->guardar("certificados", array("curriculo" => $ultimoId));
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
                unset($_POST);
                echo notificacion("Registro actualizado exitosamente", "success");
            } else {
                echo notificacion("Error al intentar actualizar registro", "danger", "times");

            }
        }

    }
?>
	<table class="table table-bordered table table-hover">
      <tr class="info">
          <td> <strong class="text-info">Usuario</strong></td>
      	<td ><strong class="text-info">E-mail</strong></td>
      	<td ><strong class="text-info">Tipo de usuario</strong></td>
        <td><center><strong class="text-info">Estatus</strong></center></td>
      	<td ><center><strong class="text-info">Acciones</strong></center></td>
      	
   	  </tr>
      <?php
		if(empty($_POST['bus'])){
			$sql="SELECT u.*, dp.nombre, dp.apellido FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) WHERE eliminado = '0' ORDER BY username LIMIT $inicio, $maximo";
		}else{
			$bus=limpiar($_POST['bus']);
			$sql="SELECT u.*, dp.nombre, dp.apellido FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) "
                                . "WHERE eliminado = '0' AND username LIKE '%$bus%' "
                                . "or (eliminado = '0' AND email LIKE '%$bus%')  or (eliminado = '0' AND nivel LIKE '%$bus%') ORDER BY username LIMIT $inicio, $maximo";
		}
			
		$res = mysqli()->query($sql);               
                desconectar();
                
		while($dato = $res->fetch_assoc()){
                    $nivel = $dato['nivel'];
                    $users[] = $dato['id'];
	  ?>
      <tr>
          <td title="<?php echo $dato["nombre"]. " " . $dato["apellido"]; ?>"><?php echo $dato['username']; ?></td>
        <td><?php echo $dato['email']; ?></td>
        <td><?php echo $dato['nivel'] == "Admin" ? "Administrador" : $dato["nivel"]; ?></td>
        <td>
        	<center>
            	<a href="usuarios.php?estatus=<?php echo $dato['id']; ?>" title="Clic aqui para cambiar estatus">
				<?php echo obtenerEstatus($dato['estatus']); 	?>
                </a>
            </center>
        </td>
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
                    <input onblur="verificarEmailExistente(this.value, <?php echo $dato['id'] ?>);" type="text" name="email" autocomplete="off" class="requerido" value="<?php echo $dato['email']; ?>">    
                     <span  class="text-danger" id='msj-email<?php echo $dato['id'] ?>'></span>
                </div>
    	        <div class="span6">
                    
                    <strong>Nombres</strong><br>
                	<input type="text" name="nombre" autocomplete="off" 
                               value="<?php echo $dato['nombre']; ?>" class="requerido solo-letras-con-espacio-y-acentos"><br>
                    <strong>Apellidos</strong><br>
                	<input type="text" name="apellido" autocomplete="off" 
                               value="<?php echo $dato['apellido']; ?>" class="requerido solo-letras-con-espacio-y-acentos"> <BR>
                        <strong>Tipo de Usuario</strong> <br>
                    <select name="nivel">
                    	<option value="Admin" <?php if($nivel=='Admin'){ echo 'selected'; } ?>>Administrador</option>
                        <option value="Secretario" <?php if($nivel=='Secretario'){ echo 'selected'; } ?>>Secretario</option>
                        <option value="Postulante" <?php if($nivel=='Postulante'){ echo 'selected'; } ?>>Postulante</option>
                    </select> 
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            <button type="submit" class="btn btn-primary" id='btn-actualizar<?php echo $dato['id']; ?>'><i class="icon-ok"></i> <strong>Actualizar</strong></button>
        </div>
        </form>
    </div>
      <?php } ?>
    </table>
    <?php
		$can=mysqli()->query($sql);
		if(!$dato=$can->fetch_assoc()){
			echo '	<div class="alert alert-error" align="center">
						<strong>No hay resultados con la busqueda "'.$bus.'"</strong>
					</div>';
		}
	?>
    <div class="pagination" align="center">
        <ul>
        	<?php
			if(empty($_POST['bus'])){
				$tp = ceil($total/$maximo);#funcion que devuelve entero redondeado
         		for	($n=1; $n<=$tp ; $n++){
					if($pag==$n){
						echo '<li class="active"><a href="usuarios.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
					}else{
						echo '<li><a href="usuarios.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
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
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
       	 	<h3 id="myModalLabel">Crear Nuevo Usuario</h3>
        </div>
        <div class="modal-body">
       	    <div class="row-fluid">
	            <div class="span6">
                	<strong>Usuario</strong><br>
                        <input type="text" name="username" autocomplete="off" class="requerido alfanumerico-sin-espacio" id='username'
                               value="<?php echo $_POST['username']; ?>" onblur="verificarUsuarioExistente(this.value)"><br>
                        <span  class="text-danger" id="msj-username"></span>
                    <strong>Contraseña</strong><br>
                    
                    <input type="text" name="password" autocomplete="off" class="requerido" value="1234" ><br>  
                    <strong>Correo Electronico</strong><br>
                    <input type="email" name="email" autocomplete="off" class="requerido" value="<?php echo $_POST['email']; ?>">    
                    
                </div>
    	        <div class="span6">
                    
                    <strong>Nombres</strong><br>
                	<input type="text" name="nombre" autocomplete="off" class="requerido solo-letras-con-espacio-y-acentos" 
                               value="<?php echo $_POST['nombre']; ?>"><br>
                    <strong>Apellidos</strong><br>
                	<input type="text" name="apellido" autocomplete="off"  class="requerido solo-letras-con-espacio-y-acentos"
                               value="<?php echo $_POST['apellido']; ?>"> <BR>
                        <strong>Tipo de Usuario</strong> <br>
                    <select name="nivel">
                    	<option value="Admin" <?php if($_POST['nivel'] =='Admin'){ echo 'selected'; } ?>>Admin</option>
                        <option selected value="Secretario" <?php if($_POST['nivel']=='Secretario'){ echo 'selected'; } ?>>Secretario</option>
                        <!--<option value="Postulante" <?php if($_POST['nivel']=='Postulante'){ echo 'selected'; } ?>>Postulante</option>-->
                    </select> 
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            <button type="submit" class="btn btn-primary" id='btn-nuevo'><i class="icon-ok" ></i> <strong>Registrar</strong></button>
        </div>
        </form>
    </div>
<?php
foreach ($users as $id):          
?>    
    <div class="modal hide fade" id="eli<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3><i class="icon-info"></i>Confirmación</h3>
               </div>
               <div class="modal-body">
                  <h5>¿Está seguro que desea eliminar este usuario?</h5> 
                  <p>Le recordamos que no podrá deshacer los cambios.</p>
           </div>
               <div class="modal-footer">
              <!--<a href="#" data-dismiss="modal" class="btn btn-default">Cancelar</a>
              <a href="postulante.php?estatus=<?php echo $id ?>" class="btn btn-primary">Confirmar</a>-->
              <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
              <a style="color:#fff" href="usuarios.php?eliminar=<?php echo $id ?>"><button class="btn btn-primary"><i class="icon-ok"></i> <strong>Confirmar</strong></button></a>
               </div>
          </div>
       </div>
    </div>
<?php endforeach; ?>
</body>
</html>
