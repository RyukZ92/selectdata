<?php
session_start();

require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';

include_once('php_conexion.php'); 
include_once('class/funciones.php');
include_once('class/class.php');
	$busqueda='';#inicializar la variable

	if(!empty($_POST['estatus_postulacion']) and isset($_POST["enviar_estatus"])){
            $objetoCrud = new Crud();
            //print_r($_POST);

            $curriculo = $_POST['id'];
            $estatus = limpiar($_POST['estatus_postulacion']);
            $descripcion = limpiar($_POST['descripcion']);
            if(empty($descripcion)) {
                $descripcion = '';
            }
            if($_SESSION['nivel'] == 'Secretario') {
                $_recomendador = $_SESSION['id_username'];
                $datos = array ('descripcion' =>  $descripcion,
                            'estatus'           =>  $estatus,
                            'recomendador'      =>  $_recomendador,
                            'fecha_estatus'     =>  date('Y-m-d'));
            
            } else {
                $_recomendador = NULL;
                $datos = array ('descripcion' =>  $descripcion,
                            'estatus'           =>  $estatus,
                            'fecha_estatus'     =>  date('Y-m-d'));
            }
            $resultado = $objetoCrud->guardar("estatus_postulacion", $datos, "curriculo = '".$curriculo."'");
            if($resultado){
                $msj =  notificacion("El estatus ha sido actualizado éxitosamente", "success");
            } else {
                $msj =  notificacion("Problemas al actualizar el estatus de la postulación. ¡Intente de nuevo!", "danger");
            }
	}
	if(empty($_POST['busqueda'])) {
		$sql = "SELECT count(u.id) as total "
                        . "FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) JOIN curriculo c ON (c.id = dp.id) JOIN estatus_postulacion ep ON (ep.curriculo = c.id) "
                        . "WHERE u.eliminado = '0' AND nivel = 'Postulante' "
                        . "ORDER BY ep.estatus, nombre,apellido";
        } else {
            //print_r($_POST);
                $busqueda=limpiar($_POST['busqueda']);
                $sql = "SELECT count(u.id) as total "
                        . "FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) JOIN curriculo c ON (c.id = dp.id) JOIN estatus_postulacion ep ON (ep.curriculo = c.id) "
                        . "WHERE u.eliminado = '0' AND nivel = 'Postulante' "
                        . "AND (profesion LIKE lower('%$busqueda%') or nombre LIKE lower('%$busqueda%') or apellido LIKE lower('%$busqueda%') or cedula LIKE lower('%$busqueda%') or categoria LIKE lower('%$busqueda%')) or ep.estatus = '$busqueda' "
                        . "ORDER BY ep.estatus, nombre, apellido";
        }
		$maximo = 10;
		if(!empty($_GET['pag'])){
			$pag = limpiar($_GET['pag']);
		}else{
			$pag = 1;
		}
		$inicio = ($pag - 1) * $maximo;
		
		$cans = mysqli()->query($sql);
		if($dat = $cans->fetch_assoc()){
			$total = $dat['total']; #inicializo la variable en 0
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
                        <h3 class="text-info"><img src="img/postulantes.png" class="img-circle" width="100" height="100"> 
                    Administración de Postulaciones</h3>
                </div>
                
    	        <div class="span6" align="right">
                    
                    <form name="form1" method="post" action="" class="form-inline">
                        
                        <select name="busqueda">
                            <option value="">Todos</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Pre Seleccionado">Pre Seleccionados</option>
                            <?php if($_SESSION['nivel'] == "Admin"): ?>
                            <option value="Seleccionado">Seleccionados</option>
                            <option value="No Seleccionado">No Seleccionados</option>
                            <?php endif;?>
                        </select>
                        <button name='btn-categoria' class="btn btn-default ">Filtrar</button>
                    </form>
                    <form name="form1" method="post" action="" class="form-inline">
                    	<div class="input-prepend">
                            <span class="add-on"><i class="icon-search"></i></span>
                            <input name="busqueda" type="text" placeholder="Buscar postulantes" class="input-xlarge" autocomplete="off" autofocus>
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
                $msj = notificacion("Registro actualizado exitosamente", "success");
            } else {
                $msj =  notificacion("Error al intentar actualizar registro", "danger", "times");

            }
        }

    }
    if(!empty($msj)) {
        echo $msj;
        //header('refresh:2;postulantes.php');
    }
	?>
	<table class="table table-bordered table table-hover">
      <tr class="info">
          
        <td><strong class="text-info" title="Cédula de identidad del postulante">Documento</strong></td>
        <td><strong class="text-info" title="Nombre y apellido del postulante">Nombre completo</strong></td>
        <td><strong class="text-info" title="Profesión del postulante">Cargo Postulado</strong></td>
        <td><strong class="text-info" title="Profesión del postulante">Profesión</strong></td>
        <td><strong class="text-info" title="Categoría postulada">Categoría</strong></td>
        <td><strong class="text-info" title="Estatus de la postulación">Estatus</strong></td>
        <td><strong class="text-info" title="Fecha del último estatus">Último Estatus</strong></td>
        <td><strong class="text-info" title="Fecha de postulación">Postulación</strong></td>
        <?php //if($_SESSION['nivel'] == 'Admin'): ?>
        <td><strong class="text-info">Recomendado por</strong></td>
        <?php //endif; ?>
      	
   	  </tr>
      <?php
      
		if(empty($_POST['busqueda'])){
			$sql="SELECT fecha_estatus, cargo_postulado, fecha_postulacion, descripcion, dp.id, cedula, dp.nombre, dp.apellido, CONCAT(dp.nombre, ' ', dp.apellido) as nombre_completo, profesion, categoria, cargo_postulado, ep.estatus as estatus_p, recomendador "
                                . "FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) JOIN curriculo c ON (c.id = dp.id) JOIN estatus_postulacion ep ON (ep.curriculo = c.id) "
                                . "WHERE u.eliminado = '0' AND nivel = 'Postulante' "
                                . "ORDER BY ep.estatus, nombre,apellido LIMIT $inicio, $maximo";
		}else{
                    
                    
			$busqueda=limpiar($_POST['busqueda']);
                        
                        if($_SESSION['nivel'] != "Admin") {
                            if($busqueda == 'Seleccionado' OR $busqueda == 'No Seleccionado'){
                             //   $busqueda = "/0112321'¿¿'123''";
                            }
                        }
			$sql="SELECT fecha_estatus, cargo_postulado, fecha_postulacion, descripcion, dp.id, cedula, dp.nombre, dp.apellido, CONCAT(dp.nombre, ' ', dp.apellido) as nombre_completo, profesion, categoria, cargo_postulado, ep.estatus as estatus_p, recomendador "
                                . "FROM usuarios u JOIN datos_personales dp ON(u.id = dp.id) JOIN curriculo c ON (c.id = dp.id) JOIN estatus_postulacion ep ON (ep.curriculo = c.id) "
                                . "WHERE u.eliminado = '0' AND nivel = 'Postulante' "
                                . "AND (profesion LIKE lower('%$busqueda%') or nombre LIKE lower('%$busqueda%') or apellido LIKE lower('%$busqueda%') or cedula LIKE lower('%$busqueda%') or categoria LIKE lower('%$busqueda%')) or lower(ep.estatus) = lower('$busqueda') "
                                . "ORDER BY ep.estatus, nombre, apellido LIMIT $inicio, $maximo";
		}
		#echo $sql;	
		$can=mysqli()->query($sql);
                $objetoPersona = new Crud();
                $i = 0;
		while($dato=$can->fetch_assoc()):
                    $nivel=$dato['nivel'];
                    $_postulantes[$i]['id'] = $dato['id'];
                    $_postulantes[$i]['nombre_completo'] = $dato['nombre_completo'];
                    $_postulantes[$i]['cedula'] = $dato['cedula'];
                    $_postulantes[$i]['profesion'] = $dato['profesion'];
                    $nombreCompleto = $dato["nombre_completo"];
                    $i++;
                    
                    $objetoPostulante = new Crud();
                    $recomendador = $objetoPersona->consultar("datos_personales dp JOIN usuarios u ON dp.id = u.id", 
                                  array('username', 'nombre', 'apellido', "CONCAT(nombre, ' ', apellido) as nombre_completo"), 
                                  "u.id = '".$dato['recomendador']."'");
                    if(explode('-',$dato['fecha_estatus'])[2] == 0) {
                        $fechaEstatus = "";
                    } else {
                        $fechaEstatus = formatoFecha($dato['fecha_estatus']);
                    }
                    if(($_SESSION['nivel'] == 'Secretario' and $dato['estatus_p'] == 'En Proceso') 
                            or $dato['estatus_p'] == 'Pre Seleccionado'
                            OR ($_SESSION['nivel'] == 'Admin')):
                        /*if($_SESSION['nivel'] == 'Secretario' 
                                and $dato['recomendador'] == $_SESSION['id_username'] 
                                AND $dato['estatus_p'] == 'Pre Seleccionado'
                                OR $_SESSION['nivel'] == 'Admin'):*/
                        
	  ?>
      <tr>
          
        <td><?php echo $dato['cedula']; ?></td>
        <td title="<?php echo $nombreCompleto; ?>"><a href='detalle-postulante.php?id=<?php echo $dato['id'] ?>'><?php echo $nombreCompleto; ?></a></td>
        <td><?php echo $dato['cargo_postulado']; ?></td>
        <td><?php echo $dato['profesion']; ?></td>
        <td><?php echo $dato['categoria']; ?></td>
        <td title="Clic aquí para cambiar de estatus">
            <a href="#est<?php echo $dato['id'] ?>" role="button" data-toggle="modal">
                <?php echo obtenerEstatusPostulacion($dato['estatus_p']) ?>
            </a></td>
        <td><?php echo ($fechaEstatus); ?></td>
        <td><?php echo formatoFecha($dato['fecha_postulacion']); ?></td>
        <?php //if($_SESSION['nivel'] = 'Admin'): ?>
        <td><?php echo count($recomendador) > 0 ? "<a class='text-warning'>" . $recomendador[0]['username'] . " (" .$recomendador[0]['nombre_completo'] . ")</a>" : "<a class='text-muted'>Sin recomendar</a>"; ?></td>
        <?php //endif; ?>
      </tr>
                <?php 
                endif; 
                
                //endif;
                ?>
      <?php endwhile; //print "<PRE>"; print_r($_postulantes); print "</pre>"; ?>
    </table>
    <?php
		$can = mysqli()->query($sql);
		if(!$dato=$can->fetch_assoc()){
			echo '	<div class="alert alert-error" align="center">
						<strong>No hay resultados con la búsqueda "'.$busqueda.'"</strong>
					</div>';
		}
	?>
    <div class="pagination" align="center">
        <ul>
        <?php
            if(empty($busqueda)){
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
<?php
foreach ($_postulantes as $_postulante):          
?>    
    <div class="modal hide fade" id="est<?php echo $_postulante['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form class="form" method="POST">
               <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3><i class="icon-info"></i>Cambiar Estatus de la Postulación</h3>
               </div>
               <div class="modal-body">
                   
                   <div class="col-xs-12" style="margin:auto;">
                       
                       <b class="control-label">Postulante: </b><span><?php echo $_postulante['cedula']. " " . $_postulante['nombre_completo']. " (" . $_postulante['profesion'] . ")"; ?></span>
                       <br/>
                       
                        <input type="hidden" name='id' value="<?php echo $_postulante['id'] ?>">
                        <div class="form-group">
                            <span for="estatus_postulacion" class="col-lg-2 control-label">Nuevo Estatus</span>
                            <div class="col-lg-10">
                            <select class="form-control estatus_postulacion" name="estatus_postulacion">
                        <?php if($_SESSION['nivel'] == 'Secretario'): ?>      
                                <option value='En Proceso'>En Proceso</option>
                        <?php endif; ?>
                        <?php if($_SESSION['nivel'] != 'Secretario'): ?>
                                <option value="Seleccionado">Seleccionado</option>
                        <?php endif; ?>                
                        <?php if($_SESSION['nivel'] == 'Secretario'): ?>
                                <option value="Pre Seleccionado">Pre Seleccionado</option>
                        <?php endif; ?>
                        <?php if($_SESSION['nivel'] != 'Secretario'): ?>  
                                <option value="No Seleccionado">No Seleccionado</option>
                        <?php endif; ?>        
                            </select>
                            </div>
                        </div>
                        <div class="form-group descripcion" style="display: none;">
                            <span for="descripcion" class="col-lg-2 control-label">Descripción</span>
                            
                            <div class="col-lg-10">
                                <textarea class="form-control" name="descripcion" maxlength="100" placeholder="Espeficar brevemente el motivo del nuevo estatus"></textarea>
                            </div>
                        </div>
                    
                   </div>
               </div>
                   
               <div class="modal-footer">             
              <a href='#' class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></a>
              <span style="color:#fff" href=""><button class="btn btn-primary" name="enviar_estatus"><i class="icon-ok"></i> <strong>Confirmar</strong></button></span>
               </div>
                </form>
          </div>
       </div>
    </div>
<?php endforeach; ?>
    <script>
    $(function(){
        $('.estatus_postulacion').change(function(){    
            if($(this).val() == 'No Seleccionado') {
                $('.descripcion').css('display', 'block');
            } else {
                $('.descripcion').css('display', 'none');
            }
        });
    });
    </script>
</body>
</html>
