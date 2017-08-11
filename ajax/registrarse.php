<?php 
/**
 * 
 */
require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';
require_once 'class/funciones.php';


$objetoPostulante = new Crud();
//$areas = $objetoPostulante->consultar("areas");
if (isset($_POST["registrar"])) {
    //print "<pre>"; print_r($_POST); print"</pre>";
    $tipoCedula = $_POST["tipo_cedula"];
    $cedula = $_POST["cedula"];
    $cedulaCompleta = $tipoCedula . "-" . $cedula;
    $nombre = $_POST["nombre"];    
    $apellido = $_POST["apellido"];
    
    
    $genero = $_POST["genero"];
    $email = $_POST["email"];
    $telef = $_POST["telefono"];
    
    $key = sha1(generarCadenaAleatoria());    
    $usuario = limpiarCampo($_POST["usuario"]);
    $clave = limpiarCampo($_POST["clave"]);
    $clave = encrypt($clave, $key);
    if(($objetoPostulante->contarFilas("usuarios", "lower(username) = lower('$usuario')") > 0)){
        $mensajes[] = "<li class='text-danger'> El nombre de usuario no se encuestra disponible</li>";
        $validacion = true;
    }if(($objetoPostulante->contarFilas("datos_personales", "cedula = '$cedulaCompleta'") > 0)){
        $mensajes[] = "<li class='text-danger'> El número de cédula ingresado se encuentra registrada</li>";
        $validacion = true;
    }if(($objetoPostulante->contarFilas("usuarios", "lower(email) = lower('$email')") > 0)){
        $mensajes[] = "<li class='text-danger'> El correo electrónico ingresado está siendo usando por otra persona</li>";
        $validacion = true;
        echo 1;
    }
    if(!$validacion) {
        $tabla = "usuarios";
        $datos = array( 'username'          =>  $usuario,
                        'password'          =>  $clave,
                        'key_password'      =>  $key,
                        'email'             =>  $email,
                        'fecha_creacion'    =>  date("Y-m-d"),
                        'hora_creacion'     =>  date("H:i:s"));
        $ultimoId = $objetoPostulante->guardar($tabla, $datos, null, true);
            $resultado = $objetoPostulante->guardar("datos_personales", 
                        array("id" => $ultimoId,         
                        'cedula'            =>  $cedulaCompleta,
                        'nombre'            =>  $nombre,
                        'apellido'          =>  $apellido));
                $resultado = $objetoPostulante->guardar("curriculo", array("id" => $ultimoId), null, true);
                    //$resultado = $objetoPostulante->guardar("experiencia_laboral", array("curriculo" => $ultimoId));
                    //$resultado = $objetoPostulante->guardar("cursos_realizados", array("curriculo" => $ultimoId));
                    //$resultado = $objetoPostulante->guardar("estudios_academicos", array("curriculo" => $ultimoId));
                    //$resultado = $objetoPostulante->guardar("certificados", array("curriculo" => $ultimoId));
        if($resultado) {
            $msj = notificacion("Su registro fue realizado exitosamente", "success");

        } else {
            $msj = notificacion("Error al registrase. ¡Intente de nuevo!", "danger", "times");
        }
    }

}
?>
<html>
    <head>
        <title>Nueva cuenta de usuario</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="css/bootstrapv3.3/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
    </head>
    <body>
        

        
        
        <div class="container">
            <header><img id="banner_sistema" src="img/banner_sistema.png"></header>

            <div class="container" style="margin-left:1%;">
                            <?php
            
                            if(count($mensajes)>0) {
                    echo "<span class='text-danger'><i class='fa fa-times-circle'></i> Se han encontrado los suguientes errores:</span><br>";
                }?>
                <div class="row">
                    <ul>
                    <?php

                    foreach ($mensajes as $mensaje):
                        echo $mensaje;
                    endforeach;
                    ?>
                    </ul>
                </div>
            </div>
        <?php if($resultado): ?>    
            <div class="panel panel-default">
                
                <div class="panel-body"><br>
                    <div class="col-lg-12">
               <?php
               //$msj = notificacion("Su registro fue realizado exitosamente", "success");
                if(!empty($msj)) {
                    echo $msj;
                }               
               ?>
               <center><a href="index.php"><button class="btn btn-success btn-large">Continuar</button></a></center>
                    </div> 
                </div> 
            </div> 
            
        <?php
        endif; 
        if(!$resultado): ?> 
        <div class="col-lg-12">
        <div class="panel panel-default">
        <div class="panel-heading"> <h4>Crear nueva cuenta</h4></div>    

        <div class="panel-body"><br>          
            <div class="col-lg-8 nuevo" >
              
                <form class="form-horizontal" role="form" method="post" id="form">
                  <div class="form-group">
                    <label for="tipo_cedula" class="col-lg-4 control-label">Documento</label>
                    <div class="col-lg-2 ">
                        <select name="tipo_cedula" class="form-control requerido solo-numero-entero">
                            <option value="0"></option>
                            <option value="V" <?php if($tipoCedula == "V") {echo "selected";} ?>>V</option>
                            <option value="E" <?php if($tipo_cedula == "E") {echo "selected";} ?>>E</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-5">
                      <input type="text" class="form-control solo-albabeto-espaniol-con-espacio requerido" id="cedula"
                             placeholder="Cédula" name="cedula"
                             value="<?php echo $cedula ?>"
                             maxlength="8" autocomplete="off">
                      <?php echo $msj; ?>
                    </div>
                    
                    <div class="col-lg-1 ">
                      <span for="cedula" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>                    
                  <div class="form-group">
                    <label for="nombre" class="col-lg-4 control-label">Nombres</label>
                    <div class="col-lg-7 ">
                      <input type="text" class="form-control solo-albabeto-espaniol-con-espacio requerido" id="nombre"
                             placeholder="Nombres" name="nombre"
                             value="<?php echo $nombre ?>"
                             maxlength="80" autocomplete="off">
                    </div>
                    
                    <div class="col-lg-1 ">
                      <span for="nombre" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apellido" class="col-lg-4 control-label">Apellidos</label>
                    <div class="col-lg-7 ">
                      <input type="text" class="form-control solo-albabeto-espaniol-con-espacio requerido" id="apellido"
                             placeholder="Apellidos" name="apellido"
                             value="<?php echo $apellido ?>"
                             maxlength="80" autocomplete="off">
                    </div>
                    <div class="col-lg-1 ">
                      <span for="apellido" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>        
                  <div class="form-group">
                    <label for="usuario" class="col-lg-4 control-label">Nombre de Usuario</label>
                    <div class="col-lg-7 ">
                      <input type="text" class="form-control alfanumerico-sin-espacio requerido" id="usuario"
                             placeholder="Nombre de Usuario" name="usuario"
                             value="<?php echo $_POST["usuario"] ?>"
                             maxlength="40" autocomplete="off">
                      <?php echo $msj; ?>
                    </div>
                    <div class="col-lg-1 ">
                      <span for="usuario" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="clave" class="col-lg-4 control-label">Contraseña</label>
                    <div class="col-lg-7">
                      <input type="password" class="form-control requerido" id="clave" 
                             placeholder="Contraseña" name="clave" value="<?php echo $_POST['clave'] ?>">  
                      <p class="help-block text-primary"><i class="fa fa-info-circle text-primary"></i> 
                          <small class="text-primary">Mímimo 8 caráteres con mayúsculas, minúsculas y números</small>
                      </p>
                    </div>
                    <div class="col-lg-1 ">
                      <span for="clave" class="control-label text-danger">Requerido</span>
                    </div>                     
                  </div>

                  <div class="form-group">
                    <label for="clave2" class="col-lg-4 control-label">Repite la Contraseña</label>
                    <div class="col-lg-7 ">
                      <input type="password" class="form-control requerido" id="clave2" 
                             placeholder="Repita la Contraseña" name="clave2" value="<?php echo $_POST['clave2'] ?>">
                    <p class="help-block text-primary" id="aviso">
                    </p>
                    </div>
                    <div class="col-lg-1 ">
                      <span for="clave2" class="control-label text-danger">Requerido</span>
                    </div>  
                  </div> 

                  <div class="form-group">
                    <label for="email" class="col-lg-4 control-label">Correo Electrónico</label>
                    <div class="col-lg-7 ">
                      <input type="text" class="form-control requerido" id="email" 
                             placeholder="Correo Electrónico" name="email"
                             value="<?php echo $_POST["email"] ?>"
                             maxlength="50" autocomplete="off">
                      <?php echo $msj; ?>
                    </div>
                    <div class="col-lg-1 ">
                      <span for="email" class="control-label text-danger">Requerido</span>
                    </div>  
                  </div>  
                    
                  <div class="form-group">                      
                    <div class="col-lg-offset-4 col-lg-8 ">                        
                        <a href="index.php" class="btn btn-default">Regresar</a>
                      &nbsp;
                      &nbsp;
                      <button type="submit" name="registrar" class="btn btn-primary" id="btn-nuevo">Registrar</button>
                    </div>
                  </div>
                </form>
            
            </div> 
        
        
    </div>
    </div>
    </div>            
           
            <?php endif; ?>
    </div>

    <script src="js/bootstrapv3.3/bootstrap.min.js"></script>
    <script src="js/jquery-min.js"></script>
    <script src="js/scripts.js"></script>
    </body>
</html>
