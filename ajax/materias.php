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
		$cans=mysql_query("SELECT * FROM materias WHERE estado='s' and id='$nit'");
		if($dat=mysql_fetch_array($cans)){
			$xSQL="Update materias Set estado='n' Where id='$nit'";
			mysql_query($xSQL);
			header('location:materias.php');
		}else{
			$xSQL="Update materias Set estado='s' Where id='$nit'";
			mysql_query($xSQL);
			header('location:materias.php');
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
		
		$cans=mysql_query("SELECT COUNT(nombre)as total FROM materias");
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
                    Registro y Control de Materias</h3>        
                </div>
    			<div class="span6" align="right">
                	<a href="materias.php" class="btn btn-info"><strong><i class="icon-list"></i> Vista de Materias</strong></a> 
                    <a href="carreras.php" class="btn"><strong><i class="icon-list"></i> Vista de Carreras</strong></a><br><br>
                	<form name="form1" method="post" action="" class="form-inline">
                    <!-- INGRESAR NUEVA ASIGNATURA --->
                        <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                            <i class="icon-book"></i> <strong>Ingresar Nueva Materia</strong>
                        </a> |
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="icon-search"></i></span>
                            <input autofocus name="bus" type="text" placeholder="Buscar Materias por Nombre" class="input-xlarge" autocomplete="off">
                        </div>
                    </form>
                </div>
    		</div>
        </td>
      </tr>
    </table>
    <?php
		if(!empty($_POST['semestre']) and !empty($_POST['carrera'])){
			$semestre=limpiar($_POST['semestre']);
			$carrera=limpiar($_POST['carrera']);	$objCarrera=new Consultar_Carrera($carrera);
			$materia=limpiar($_POST['materia']);	$objMateria=new Consultar_Materias($materia);
		 	
			$can=mysql_query("SELECT * FROM detalle_carrera WHERE materia='$materia' and carrera='$carrera'");
			if(!$dato=mysql_fetch_array($can)){
				
				mysql_query("INSERT INTO detalle_carrera (materia, carrera, semestre, estado) 
				VALUES ('$materia','$carrera','$semestre','s')");
				
				echo '<div class="alert alert-success" align="center">
					  <button type="button" class="close" data-dismiss="alert">×</button>
						<strong>
							La Materia "'.$objMateria->consultar('nombre').'" Fue Asiganda a la Carrera "'.$objCarrera->consultar('nombre').'"<br>
							En el Semestre No '.$semestre.'
						</strong>
					</div>';
			}else{
				echo '	<div class="alert alert-error" align="center">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>
								La Materia "'.$objMateria->consultar('nombre').'" ya esta Asignada a la Carrera "'.$objCarrera->consultar('nombre').'"
							</strong>
						</div>';				
			}
		}
		if(!empty($_POST['nombre'])){
			$nombre=limpiar($_POST['nombre']);
			$director=limpiar($_POST['director']);
			$credito=limpiar($_POST['creditos']);
			$valor=limpiar($_POST['valor']);
			$objDirector=new Consultar_Profesor($director);
			$ndirector=$objDirector->consultar('nombre');
			if(empty($_POST['id'])){
				#guarda
				$obj= new Consultar_Materias($nombre);
				if($obj->consultar('nombre')==NULL){
					$objGuardar=new Proceso_Materias($nombre,$director,$credito,'',$valor);
					$objGuardar->crear();
					echo '	<div class="alert alert-success" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>La Materia "'.$nombre.'" con el Director "'.$ndirector.'" Guardado con Exito</strong>
							</div>';
				}else{
					echo '	<div class="alert alert-error" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>La Materia "'.$nombre.'" ya esta registrado en la base de datos</strong>
							</div>';
				}
			}else{
				#actualiza
				$id=limpiar($_POST['id']);
				$objActualizar = new Proceso_Materias($nombre,$director,$credito,$id,$valor);
				$objActualizar->actualizar();
				echo '	<div class="alert alert-success" align="center">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>La Materia "'.$nombre.'" con el Director "'.$ndirector.'" Actualizado con Exito</strong>
							</div>';
			}
		}
	
	?>
    <table class="table table-bordered table table-hover">
      <tr class="info">
        <td width="28%"><strong class="text-info">Nombre</strong></td>
        <td width="28%"><strong class="text-info">Decano</strong></td>
        <td width="18%"><div align="right"><strong class="text-info">Valor</strong></div></td>
        <td width="18%"><strong class="text-info"><center>Estado</center></strong></td>
        <td width="8%">&nbsp;</td>
      </tr>
      <?php
		if(empty($_POST['bus'])){
			$sql="SELECT * FROM materias ORDER BY nombre LIMIT $inicio, $maximo";
		}else{
			$bus=limpiar($_POST['bus']);
			$sql="SELECT * FROM materias WHERE nombre LIKE '%$bus%' ORDER BY nombre LIMIT $inicio, $maximo";
		}
		 	
		$can=mysql_query($sql);
		while($dato=mysql_fetch_array($can)){
			$objProfesor= new Consultar_Profesor($dato['director']);
	  ?>
      <tr>
        <td><i class="icon-book"></i> <?php echo $dato['nombre'].' ('.$dato['creditos'].')'; ?></td>
        <td><?php echo $objProfesor->consultar('nombre'); ?></td>
        <td>
        	<div align="right">
        		$ <?php echo formato($dato['valor']); ?>
            </div>
        </td>
        <td>
        	<center>
        	<a href="materias.php?estado=<?php echo $dato['id']; ?>" title="Cambiar Estado"><?php echo estado($dato['estado']); ?></a>
            </center>
        </td>
        <td>
            <a href="#act<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Actualizar Materia">
				<i class="icon-edit"></i>
            </a>
            <a href="#asi<?php echo $dato['id']; ?>" role="button" class="btn btn-mini" data-toggle="modal" title="Asignar a Carrera">
            	<i class="icon-retweet"></I>
            </a>
        </td>
      </tr>
    <!-- Asignar a una Carrera --->
    <div id="asi<?php echo $dato['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <form name="form3" method="post" action="" class="form-inline">
        <input type="hidden" name="materia" value="<?php echo $dato['id']; ?>">
        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <h3 id="myModalLabel" align="center">Asignar a una Carrera la Materia<br>"<?php echo $dato['nombre']; ?>"</h3>
        </div>
        <div class="modal-body">
        	<strong>Carreras Asignadas</strong><br>
            <?php
				$id_mate=$dato['id'];$listado='';
				$sql_c=mysql_query("SELECT * FROM detalle_carrera WHERE materia='$id_mate'");
				while($px=mysql_fetch_array($sql_c)){
					$objCarrera2=new Consultar_Carrera($px['carrera']);
					$listado=$listado.' '.$objCarrera2->consultar('nombre').', ';					
				}
				echo $listado.'<br><br>';
			?>
	        <div class="row-fluid">
	            <div class="span6">
                	<strong>Carrera</strong><br>
				   	<select name="carrera">
                   		<?php							                                  
							$sql_carrera=mysql_query("SELECT * FROM carreras WHERE estado='s' ORDER BY nombre");
							while($pc=mysql_fetch_array($sql_carrera)){
								echo '<option value="'.$pc['id'].'">'.$pc['nombre'].'</option>';
							}
						?>
                   	</select>
                </div>
                <div class="span6">
                	<strong>Semestre</strong><br>
                	<input type="number" name="semestre" min="1" value="1" required>
                </div>
        	</div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Asignar Carrera</strong></button>
        </div>
        </form>
    </div>
    <!-- ========================================-->
    <!-- cuadro de mensaje -->
	<div id="act<?php echo $dato['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     	<form name="form2" method="post" action="" class="form-inline">
        <input type="hidden" name="id" value="<?php echo $dato['id']; ?>">
        <div class="modal-header">
          	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	<h3 id="myModalLabel" align="justify">Actualizar Informacion</h3>
        </div>
        <div class="modal-body" align="justify">
    	    <div class="row-fluid">
	            <div class="span6">
        	       	<strong>Nombre de Materia</strong><br>
    	           	<input type="text" name="nombre" autocomplete="off" required value="<?php echo $dato['nombre']; ?>"><br>
                    <strong>Creditos</strong><br>
                    <input type="number" name="creditos" min="1" value="<?php echo $dato['creditos']; ?>" required>
                </div>
    	        <div class="span6">
					<strong>Asignar Director</strong><br>
                  	<select name="director">
                    <?php
						$sql1="SELECT * FROM profesor ORDER BY nombre";                                    
						$prosql=mysql_query($sql1);
						while($pro=mysql_fetch_array($prosql)){
							if($dato['director']==$pro['nit']){
								echo '<option value="'.$pro['nit'].'" selected>'.$pro['nombre'].'</option>';
							}else{
								echo '<option value="'.$pro['nit'].'">'.$pro['nombre'].'</option>';
							}
						}
					?>
                    </select><br>
                    <strong>Valor de la Materia</strong><br>
                    <input type="number" name="valor" min="0" required autocomplete="off" value="<?php echo $dato['valor']; ?>">
                </div>
            </div>
       	</div>
        <div class="modal-footer">
        	<button class="btn" data-dismiss="modal" aria-hidden="true"><strong><i class="icon-remove"></i> Cerrar</strong></button>
            <button type="submit" class="btn btn-primary"><strong><i class="icon-ok"></i> Actualizar</strong></button>
        </div>
        </form>
	</div>
    <!-- ==========================================================-->
    <?php } ?>
</table>
	<div class="pagination" align="center">
        <ul>
        	<?php
			if(empty($_POST['bus'])){
				$tp = ceil($total/$maximo);#funcion que devuelve entero redondeado
         		for	($n=1; $n<=$tp ; $n++){
					if($pag==$n){
						echo '<li class="active"><a href="materias.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
					}else{
						echo '<li><a href="materias.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';	
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
          	<h3 id="myModalLabel" align="justify">Ingresar Nueva Materia</h3>
        </div>
        <div class="modal-body" align="justify">
    	    <div class="row-fluid">
	            <div class="span6">
        	       	<strong>Nombre de Materia</strong><br>
    	           	<input type="text" name="nombre" autocomplete="off" required><br>
                    <strong>Creditos</strong><br>
                    <input type="number" name="creditos" min="1" value="1" required>
                </div>
    	        <div class="span6">
					<strong>Asignar Director</strong><br>
                  	<select name="director">
                    <?php
						$sql="SELECT * FROM profesor ORDER BY nombre";                                    
						$can=mysql_query($sql);
						while($dato=mysql_fetch_array($can)){
							echo '<option value="'.$dato['nit'].'">'.$dato['nombre'].'</option>';	
						}
					?>
                    </select>
                    <strong>Valor de la Materia</strong><br>
                    <input type="number" name="valor" value="0" min="0" required autocomplete="off">
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