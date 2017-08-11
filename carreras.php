<?php
 		session_start();
		include_once('php_conexion.php'); 
		include_once('class/funciones.php');
		include_once('class/class.php');
		if($_SESSION['tipo_usu']=='a'){
		}else{
			header('location:error.php');
		}
	if(!empty($_GET['estado'])){
		$nit=limpiar($_GET['estado']);
		$cans=mysql_query("SELECT * FROM carreras WHERE estado='s' and id='$nit'");
		if($dat=mysql_fetch_array($cans)){
			$xSQL="Update carreras Set estado='n' Where id='$nit'";
			mysql_query($xSQL);
			header('location:carreras.php');
		}else{
			$xSQL="Update carreras Set estado='s' Where id='$nit'";
			mysql_query($xSQL);
			header('location:carreras.php');
		}
	}
	#paginar
		$maximo=5;
		if(!empty($_GET['pag'])){
			$pag=limpiar($_GET['pag']);
		}else{
			$pag=1;
		}
		$inicio=($pag-1)*$maximo;
		
		$cans=mysql_query("SELECT COUNT(nombre)as total FROM carreras");
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
        			<h3 class="text-info"><img src="img/intro.png" class="img-circle" width="100" height="100"> 
                    Registro y Control de Carreras</h3>        
                </div>
    			<div class="span6" align="right">
                	<a href="materias.php" class="btn"><strong><i class="icon-list"></i> Vista de Materias</strong></a> 
                    <a href="carreras.php" class="btn btn-info"><strong><i class="icon-list"></i> Vista de Carreras</strong></a><br><br>
                	<form name="form1" method="post" action="" class="form-inline">
                    <!-- INGRESAR NUEVA carrera --->
                        <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                            <i class="icon-book"></i> <strong>Ingresar Nueva Carrera</strong>
                        </a> |
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="icon-search"></i></span>
                            <input name="bus" autofocus type="text" placeholder="Buscar Materias por Nombre" class="input-xlarge" autocomplete="off">
                        </div>
                    </form>
                </div>
    		</div>
        </td>
      </tr>
    </table>
    <?php
		if(!empty($_POST['nombre'])){
			$nombre=limpiar($_POST['nombre']);
			$tipo=limpiar($_POST['tipo']);
			if(empty($_POST['id'])){
				#guarda
				$obj= new Consultar_Carrera($nombre);
				if($obj->consultar('nombre')==NULL){
					$objGuardar=new Proceso_Carrera($nombre,$tipo,'');
					$objGuardar->crear();
					echo '	<div class="alert alert-success" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>La Carrera "'.$nombre.'" Guardado con Exito</strong>
							</div>';
				}else{
					echo '	<div class="alert alert-error" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>La Carrera "'.$nombre.'" ya esta registrado en la base de datos</strong>
							</div>';
				}
			}else{
				#actualiza
				$id=limpiar($_POST['id']);
				$objActualizar = new Proceso_Carrera($nombre,$tipo,$id);
				$objActualizar->actualizar();
				echo '	<div class="alert alert-success" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>La Carrera "'.$nombre.'" Actualizado con Exito</strong>
							</div>';
			}
		}
	
	?>
    <table class="table table-bordered table table-hover">
      <tr class="info">
        <td width="35%"><strong class="text-info">Nombre</strong></td>
        <td width="23%"><strong class="text-info">Tipo</strong></td>
        <td width="35%"><center><strong class="text-info">Estado</strong></center></td>
        <td width="7%">&nbsp;</td>
      </tr>
      <?php
		if(empty($_POST['bus'])){
			$sql="SELECT * FROM carreras ORDER BY nombre LIMIT $inicio, $maximo";
		}else{
			$bus=limpiar($_POST['bus']);
			$sql="SELECT * FROM carreras WHERE nombre LIKE '%$bus%' ORDER BY nombre LIMIT $inicio, $maximo";
		}
		 	
		$can=mysql_query($sql);
		while($dato=mysql_fetch_array($can)){
			$carrera=$dato['id'];
			$objTipo=new Consultar_tCarrera($dato['tipo']);
	  ?>
      <tr>
        <td><i class="icon-book"></i> <?php echo $dato['nombre']; ?></td>
        <td><?php echo $objTipo->consultar('nombre'); ?></td>
        <td>
        	<center>
            	<a href="carreras.php?estado=<?php echo $dato['id']; ?>" title="Cambiar Estado">
					<?php echo estado($dato['estado']); ?>
                </a>
            </center>
        </td>
        <td>
        	<div align="center">
            <a href="#act<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Actualizar Carrera">
				<i class="icon-edit"></i>
            </a>
            <a href="#det<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Listar Detalle de Carrera">
            	<i class="icon-list"></i>
            </a>
            </div>
        </td>
      </tr>
      <!-- VER LISTADO -->
	  	<div id="det<?php echo $dato['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header" align="center">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	        <h3 id="myModalLabel">Detalle de la Carrera <br>"<?php echo $dato['nombre']; ?>"</h3>
            </div>
            <div class="modal-body">
            	
                	
                    	<?php	
							$sqls=mysql_query("SELECT * FROM detalle_carrera WHERE carrera=$carrera");
							if($info=mysql_fetch_array($sqls)){
								echo '<div id="" style="overflow:scroll; height:300px;">
								<blockquote>';
								$n=mysql_query("SELECT MAX(semestre) AS ms FROM detalle_carrera WHERE carrera=$carrera");
								if($ns=mysql_fetch_array($n)){
									$max_seme=$ns['ms'];
								}
								for($x=1;$x<=$max_seme;$x=$x+1){
									echo '<br><strong>Semestre '.$x.'</strong><br>';
									$a=mysql_query("SELECT * FROM detalle_carrera WHERE carrera=$carrera and semestre=$x");
									while($date=mysql_fetch_array($a)){
										$objMateria=new Consultar_Materias($date['materia']);
										echo '<i class="icon-chevron-right"></i> '.$objMateria->consultar('nombre').' ('.$objMateria->consultar('creditos').')<br>';	
									}
								}
								echo '</div></blockquote>';
							}else{
								echo '	<div class="alert alert-error" align="center">
											<strong>No hay Materias Asignadas para esta Carrera</strong>
										</div>';
							}
							
						?>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            </div>
        </div>
      <!-- ===================================-->
      <div id="act<?php echo $dato['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     	<form name="form2" method="post" action="" class="form-inline">
        <input type="hidden" name="id" value="<?php echo $dato['id']; ?>">
        <div class="modal-header">
          	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	<h3 id="myModalLabel" align="justify">Actualizar Carrera</h3>
        </div>
        <div class="modal-body" align="justify">
    	    <div class="row-fluid">
	            <div class="span6">
        	       	<strong>Nombre de la Carrera</strong><br>
    	           	<input type="text" name="nombre" autocomplete="off" value="<?php echo $dato['nombre']; ?>" required><br>
                </div>
    	        <div class="span6">
					<strong>Tipo</strong><br>
                  	<select name="tipo">
                    <?php
						$ssql="SELECT * FROM tcarrera WHERE estado='s' ORDER BY nombre";                                    
						$casn=mysql_query($ssql);
						while($row=mysql_fetch_array($casn)){
							if($row['id']==$dato['tipo']){
								echo '<option value="'.$row['id'].'" selected>'.$row['nombre'].'</option>';	
							}else{
								echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';	
							}
						}
					?>
                    </select>
                </div>
            </div>
       	</div>
        <div class="modal-footer">
        	<button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
            <button type="submit" class="btn btn-primary"><strong><i class="icon-ok"></i> Actualizar</strong></button>
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
						echo '<li class="active"><a href="carreras.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
					}else{
						echo '<li><a href="carreras.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
					}
				}
			}
			?>
        </ul>
    </div>
    
    
    <!-- cuadro de mensaje -->
	<div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     	<form name="form2" method="post" action="" class="form-inline">
        <div class="modal-header">
          	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	<h3 id="myModalLabel" align="justify">Ingresar Nueva Carrera</h3>
        </div>
        <div class="modal-body" align="justify">
    	    <div class="row-fluid">
	            <div class="span6">
        	       	<strong>Nombre de la Carrera</strong><br>
    	           	<input type="text" name="nombre" autocomplete="off" required><br>
                </div>
    	        <div class="span6">
					<strong>Tipo</strong><br>
                  	<select name="tipo">
                    <?php
						$sql="SELECT * FROM tcarrera WHERE estado='s' ORDER BY nombre";                                    
						$can=mysql_query($sql);
						while($dato=mysql_fetch_array($can)){
							echo '<option value="'.$dato['id'].'">'.$dato['nombre'].'</option>';	
						}
					?>
                    </select>
                </div>
            </div>
       	</div>
        <div class="modal-footer">
        	<button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
            <button type="submit" class="btn btn-primary"><strong><i class="icon-ok"></i> Guardar</strong></button>
        </div>
        </form>
	</div>
    <!-- ==========================================================-->
</body>
</html>