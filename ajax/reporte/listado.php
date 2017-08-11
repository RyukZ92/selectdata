<?php 
	session_start();
	include_once('../php_conexion.php'); 
	include_once('../class/funciones.php');
	include_once('../class/class.php');
	if($_SESSION['tipo_usu']=='a'){
		
		if(!empty($_GET['id'])){
			$id_curso=decrypt($_GET['id'],'urlcurso');
		}else{
			header('location:error.php');
		}
		$objSalon=new Consultar_Cursos($id_curso);
		$nombre=$objSalon->consultar('nombre');
		header("Content-Disposition: attachment; filename=Listado_".$nombre.".xls"); 
		header("Pragma: no-cache");
	}else{
		header('location:error.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Alumno por Salon</title>
</head>

<body>
<table width="70%" border="1">
  <tr>
    <td colspan="3"><center><strong><?php echo $nombre; ?></strong></center></td>
  </tr>
  <tr>
    <td width="8%"><strong>No</strong></td>
    <td width="23%"><strong>DOCUMENTO</strong></td>
    <td width="69%"><strong>APELLIDO Y NOMBRE</strong></td>
  </tr>
  <?php
  	$n=0;
  	$n1=mysql_query("SELECT * FROM salon_alum WHERE salon='$id_curso'");
	while($info=mysql_fetch_array($n1)){
		$n++;
		$objAlumno=new Consultar_Alumno($info['alumno']);
		$objCarrera=new Consultar_Carrera($objAlumno->consultar('carrera'));
  ?>
  <tr>
    <td><?php echo $n; ?></td>
    <td><div align="left"><?php echo $info['alumno']; ?></div></td>
    <td><?php echo $objAlumno->consultar('apellido').' '.$objAlumno->consultar('nombre'); ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>