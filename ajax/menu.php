<?php
    session_start();
    
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
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table class="table table-bordered">
  <tr class="info">
    <td>
    	<h3 class="text-info"><img src="img/admin.jpg" class="img-circle" width="80" height="80"> 
        Bienvenido  <?php echo $_SESSION['nombre_apellido']; ?></h3>
    </td>
  </tr>
</table>
    <div class="row-fluid" align="center">
        <div class="span4">
        	<h3 align="center">Usuarios</h3>
            <img src="img/salon.png" style="width: 200px; height: 200px;" title="Usuarios"><br>
            <h3>Registrados: <?php echo $n_usuario; ?></h3><br>
            <a href="usuarios.php" class="btn btn-large btn-block btn-primary" type="button"><strong>Acceder</strong></a>
        </div>
        <div class="span4">
        	<h3 align="center">Áreas</h3>
            <img src="img/intro.png" style="width: 200px; height: 200px;" title="Áreas"><br>
            <h3>Registradas: <?php echo $n_materias; ?></h3><br>
            <a href="materias.php" class="btn btn-large btn-block btn-primary" type="button"><strong>Acceder</strong></a>
        </div>
        <div class="span4">
        	<h3 align="center">Postulantes</h3>
            <img src="img/usuarios.png" style="width: 200px; height: 200px;" title="Postulantes"><br>
            <h3>Registrados: <?php echo $n_alumno; ?></h3><br>
            <a href="postulante.php" class="btn btn-large btn-block btn-primary" type="button"><strong>Acceder</strong></a>
        </div>
    </div>
</body>
</html>
