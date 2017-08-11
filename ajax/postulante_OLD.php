<?php
 		session_start();
		include_once('php_conexion.php'); 
		include_once('class/funciones.php');
		include_once('class/class.php');
		if($_SESSION['nivel'] != 'Postulante'){
		}else{
			header('location:error.php');
		}
		$bus='';#inicializar la variable
		if(!empty($_GET['estatus'])){
			$nit=limpiar($_GET['estatus']);
			$cans=mysql_query("SELECT estatus FROM postulantes WHERE id='$nit'");
			if($dat=mysql_fetch_array($cans)){
				if($dat['estatus']=='Seleccionado'){					
					$xSQL="Update postulantes Set estatus='No seleccionado' Where id='$nit'";
					mysql_query($xSQL);
					header('location:postulante.php');
				}else{
					$xSQL="Update postulantes Set estatus='Seleccionado' Where id='$nit'";
					mysql_query($xSQL);
					header('location:postulante.php');
				}
			}
                        
                } else if(!empty($_GET["eliminar"])) {
			$nit=limpiar($_GET['eliminar']);
			$cans=mysql_query("SELECT estado FROM postulantes WHERE id='$nit'");
			if($dat=mysql_fetch_array($cans)){
				if($dat['estado'] == 's'){					
					$xSQL="Update postulantes Set estado='n' Where id='$nit'";
					mysql_query($xSQL);
					header('location:postulante.php');
				}else{
					$xSQL="Update postulantes Set estado='s' Where id='$nit'";
					mysql_query($xSQL);
					header('location:postulante.php');
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
		
		$cans=mysql_query("SELECT COUNT(nombre)as total FROM postulantes");
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
    <script src="js/scripts.js"></script>

    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datepicker3.css"/>
    <script type="text/javascript" src="js/jquery.ui.datepicker-es.js"></script>

    <script>
        $(document).ready(function(){
            var date_input=$('input[name="fecha_natal"]'); //our date input has the name "date"
            var container=$('#nuevo form1').length>0 ? $('#nuevo form1').parent() : "body";
            date_input.datepicker({
                container: container,
                todayHighlight: true,
                autoclose: true,
                language: 'es',
                format: 'dd-mm-yyyy',
            })
        })
    </script>

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
        	<div class="row-fluid">
	  			<div class="span6">
        			<h3 class="text-info"><img src="img/usuarios.png" class="img-circle" width="100" height="100"> 
                    Registro y Control de Postulantes</h3>        
                </div>
    			<div class="span6" align="right">
                	<form name="form1" method="post" action="" class="form-inline">
                    <!-- INGRESAR NUEVO POSTULANTE -->
                        <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                            <i class="icon-plus"></i> <strong>Ingresar Nuevo Postulante</strong>
                        </a> |
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="icon-search"></i></span>
                            <input name="bus" type="text" placeholder="Buscar Alumno por Nombre" class="input-xlarge" autocomplete="off" autofocus>
                        </div>
                    </form>
                </div>
    		</div>
        </td>
      </tr>
    </table>
    <?php
		if(!empty($_POST['nombre']) OR !empty($_POST["nit"] OR !empty($_POST['apellido']))){
			$nit=limpiar($_POST['nit']);			
                        $nombre=limpiar($_POST['nombre']);
			$apellido=limpiar($_POST['apellido']);	
                        $genero=limpiar($_POST['genero']);
			$correo=limpiar($_POST['correo']);		
                        $con=$nit;				
			$carrera=limpiar($_POST['carrera']);
  //                      echo "Traer fecha: ".$_POST["fecha_natal"]."<BR>";
//                        echo "Fecha convertida: ".$fechaNatal;
                        
			if(empty($_POST['id'])){
				#guardar
				$can=mysql_query("SELECT * FROM postulantes WHERE cedula='$nit'");
				if(!$dato=mysql_fetch_array($can)){
					$objGuardar=new Proceso_Postulante('',$nit,$nombre,$apellido,$genero,$correo,$con,$carrera, formatoFecha($_POST["fecha_natal"]));
					$objGuardar->crear();
					echo '	<div class="alert alert-success" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>El postulante "'.$apellido.' '.$nombre.'" Guardado con Exito</strong>
							</div>';
				}
				
			}else{
				#actualizar
				$id=limpiar($_POST['id']);
				$objActualizar=new Proceso_Postulante($id,$nit,$nombre,$apellido,$genero,$correo,$con,$carrera, formatoFecha($_POST["fecha_natal"]));
				$objActualizar->actualizar();
				echo '	<div class="alert alert-success" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>El postulante "'.$apellido.' '.$nombre.'" Actualizado con Exito</strong>
							</div>';
			}
		}else{
		
		}
	?>

    
    
    <table class="table table-bordered table table-hover">
      <tr class="info">
        <td><strong>#</strong></td>
        <td><strong>Cedula</strong></td>
        <td><strong>Nombre Completo</strong></td>
        <td><strong>Tipo</strong></td>
        <td><strong>Correo</strong></td>
        <td><strong><center>Estatus</center></strong></td>
        <td>&nbsp;</td>
      </tr>
      <?php
		if(empty($_POST['bus'])){
			$sql="SELECT * FROM postulantes WHERE estado = 's' ORDER BY apellido LIMIT $inicio, $maximo";
		}else{
			$bus=limpiar($_POST['bus']);
			$sql="SELECT * FROM postulantes WHERE estado = 's' AND nombre LIKE '%$bus%' or apellido LIKE '%$bus%' or nit='$bus' ORDER BY apellido LIMIT $inicio, $maximo";
		}
		$n=1;
		$can=mysql_query($sql);
		while($dato=mysql_fetch_array($can)) {
                    $_nit[] = $dato['id'];
			
			$objCarrera=new Consultar_Carrera($dato['carrera']);
			if($objCarrera->consultar('nombre')==NULL){
				$ncarrera='Sin Asignar';
			}else{
				$ncarrera=$objCarrera->consultar('nombre');
			}
	  ?>
      <tr>
        <td><?php echo $n++ ?></td>
        <td><?php echo $dato['nit']; ?></td>
        <td><?php echo $dato['apellido'].' '.$dato['nombre']; ?></td>
        <td><?php echo $ncarrera; ?></td>
        <td><?php echo $dato['correo']; ?></td>
        <td>
            <center>
	            <!--<a href="postulante.php?estatus=<?php echo $dato['id']; ?>" title="Cambiar Estatus">-->
                    <a href="#est<?php echo $dato['id'] ?>" data-toggle="modal" title="Cambiar Estatus">
    	    	    <?php echo cambiarEstatusDeSelecccion($dato['estatus']); 	?>
        	    </a>
            </center>
        </td>
        <td>
        	<center>
        	<a href="#act<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Actualizar Información">
                    <i class="icon-edit"></i>
                </a>
        	<a href="#eli<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Eliminar Postulante">
                    <i class="icon-remove"></i>
                </a>
            </center>
        </td>
      </tr>
    <div id="act<?php echo $dato['id']; ?>" class="modal hide fade "  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
        
        
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<h3 id="myModalLabel">Actualizar Postulante</h3>
    	</div>
     
            
        <form onsubmit="validarCamposActualizacion(<?php echo $dato['id']; ?>)" onblur="verificarPostulanteExistente(<?php echo $dato['id']; ?>)" name="form1" method="post" action="" class="form-inline">
            <input type="hidden" name="id" value="<?php echo $dato['id']; ?>">
    	<div class="modal-body">
            
   		    <div class="row-fluid">
	            <div class="span6">
                	<strong>Documento de Identidad</strong><br>
                        <input class="requerido" type="text" name="nit" autocomplete="off" value="<?php echo $dato['nit']; ?>"><br>
                        <span class="text-danger msj-validacion-nit"></span><br>
                	<strong>Apellido</strong><br>
                    <input class="requerido" type="text" name="apellido" autocomplete="off"  value="<?php echo $dato['apellido']; ?>"><br>
                    <strong>Nombre</strong><br>
                    <input class="requerido" type="text" name="nombr" autocomplete="off"  value="<?php echo $dato['nombre']; ?>"><br>
                    <strong>Fecha de Nacimiento</strong><br>
                    <input class="requerido" type="text" name="fecha_natal" autocomplete="off"  value="<?php echo formatoFecha($dato['fecha_natal']); ?>"><br>
                </div>
    	        <div class="span6">
                	<strong>Género</strong><br>
                            <select class="requerido" name="genero">
                                <option value="Femenino" <?php if($dato['genero'] == "Femenino") {echo "selected";} ?>>Femenino</option>
                                <option value="Masculino" <?php if($dato['genero'] == "Masculino") {echo "selected";} ?>>Masculino</option>
                            </select>
                    <strong>Correo Electrónico</strong><br>
                    <input class="requerido" type="text" name="correo" autocomplete="off"  value="<?php echo $dato['correo']; ?>"><br>
                    <strong>Carrera</strong><br>
                    <select class="requerido" name="carrera">
                    	<?php
                            $cn=mysql_query("SELECT * FROM carreras WHERE estado='s'");
                            while($do=mysql_fetch_array($cn)){
                                if($dato['carrera']==$do['id']){
                                    echo '<option value="'.$do['id'].'" selected>'.$do['nombre'].'</option>';		
                                }else{
                                    echo '<option value="'.$do['id'].'">'.$do['nombre'].'</option>';
                                }	

                        }
                    ?>
                    </select>
                </div>
            </div>
            <span class="text-danger" id="aviso"></span><br>
    	</div>
   	 	<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
    		<button id="btn-actualizar" type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Actualizar</strong></button>
	    </div>
        </form>
     
    </div>  
      <?php } ?>
    </table>
	<div class="pagination" align="center">
        <ul>
        	<?php
			if(empty($_POST['bus'])){
				$tp = ceil($total/$maximo);#funcion que devuelve entero redondeado
         		for	($n=1; $n<=$tp ; $n++){
					if($pag==$n){
						echo '<li class="active"><a href="postulante.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
					}else{
						echo '<li><a href="postulante.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
					}
				}
			}
			?>
        </ul>
    </div>
   
    <div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	 <form onSubmit="validarCampos();" name="form1" method="post" action="" class="form-inline" id="nuevo-postulante">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<h3 id="myModalLabel">Guardar Nuevo Postulante</h3>
    	</div>
    	<div class="modal-body">
        
   		    <div class="row-fluid">
	            <div class="span6">
                	<strong>Documento de Identidad</strong><br>
                    <input class="requerido" id="nit" type="text" name="nit" autocomplete="off" ><br>
                    <small class="msj-validacion-nit text-danger"></small><br>
                    
                	<strong>Apellido</strong><br>
                    <input class="requerido"  id="apellido" type="text" name="apellido" autocomplete="off" ><br>
                    <small class="text-danger" id="msj-validacion-apellido"></small><br>
                    
                    <strong>Nombre</strong><br>                    
                    <input class="requerido"  id="nombre" type="text" name="nombre" autocomplete="off" ><br>
                    <small class="text-danger" id="msj-validacion-nombre"></small><br>
                    
                    <strong>Fecha de Nacimiento</strong><br>
                    <input class="requerido"  id="fecha_natal" type="text" name="fecha_natal" autocomplete="off" ><br>
                    <small class="text-danger" id="msj-validacion-fecha_natal"></small><br>
                </div>
                        
    	        <div class="span6">
                	<strong>Género</strong><br>
                            <select class="requerido" id="genero" name="genero">
                                <option value="0"></option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                            </select><br>
                        <small class="text-danger" id="msj-validacion-genero"></small><br>
                    <strong>Correo Electrónico</strong><br>
                    <input class="requerido"  id="correo" type="text" name="correo" autocomplete="off" ><br>
                    <small class="text-danger" id="msj-validacion-correo"></small><br>
                    

                    <strong>Carrera</strong><br>
                    
                    <select class="requerido"  id="carrera" name="carrera">
                    	<?php
                            $cn=mysql_query("SELECT * FROM carreras WHERE estado='s'");
                            while($do=mysql_fetch_array($cn)){
                                echo '<option value="'.$do['id'].'">'.$do['nombre'].'</option>';							
                            }
                        ?>
                    </select>
                    <small class="text-danger" id="msj-validacion-carrera"></small><br>
                </div>
                
            </div>
            <span class="text-danger" id="aviso"></span><br>
    	</div>
   	 	<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
    		<button id="btn-nuevo" type="submit" class="btn btn-primary" ><i class="icon-ok"></i> <strong>Guardar</strong></button>
                
	    </div>
        </form>
    </div>
<?php
foreach ($_nit as $id):          
?>    
    <div class="modal hide fade" id="est<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3><i class="icon-info"></i>Confirmación</h3>
               </div>
               <div class="modal-body">
                  <h5>¿Está seguro que desea cambiar el estatus de este postulante?</h5>   
           </div>
               <div class="modal-footer">
              <!--<a href="#" data-dismiss="modal" class="btn btn-default">Cancelar</a>
              <a href="postulante.php?estatus=<?php echo $id ?>" class="btn btn-primary">Confirmar</a>-->
              <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
              <a style="color:#fff" href="postulante.php?estatus=<?php echo $id ?>"><button class="btn btn-primary"><i class="icon-ok"></i> <strong>Confirmar</strong></button></a>
               </div>
          </div>
       </div>
    </div>
<?php endforeach; ?>
<?php
foreach ($_nit as $id):          
?>    
    <div class="modal hide fade" id="eli<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
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
              <a style="color:#fff" href="postulante.php?eliminar=<?php echo $id ?>"><button class="btn btn-primary"><i class="icon-ok"></i> <strong>Confirmar</strong></button></a>
               </div>
          </div>
       </div>
    </div>
<?php endforeach; ?>
</body>
</html>
