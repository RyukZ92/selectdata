<?php 
/**
 * 
 */
session_start();
require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';
require_once 'class/funciones.php';

$id = $_SESSION['id_username'];

$objetoPostulante = new Crud();

$tabla = "datos_personales";
$datos = null;
$condicion = "id = '$id'";
$postulante = $objetoPostulante->consultar($tabla, $datos, $condicion);
#print_r($postulante);


//$areas = $objetoPostulante->consultar("areas");
if (isset($_POST["actualizar"])) {
    #print "<pre>"; print_r($_POST); print"</pre>";
    $tipo_cedula = limpiarCampo($_POST["tipo_cedula"]);
    $cedula = limpiarCampo($_POST["cedula"]);
    $cedulaCompleta =  $tipo_cedula . "-" . $cedula;    
    $nombre = limpiarCampo($_POST["nombre"]);
    $apellido = limpiarCampo($_POST["apellido"]);   
    $genero = limpiarCampo($_POST["genero"]);
    $fechaNatal = formatoFecha(limpiarCampo($_POST['fecha_natal']));
    
    $lugarNatal = limpiarCampo($_POST['lugar_natal']);
    $codTelefMovil = limpiarCampo($_POST['cod_telef_movil']);    
    $telefMovil = $_POST['telefono_movil'];    
    $telefonoMovil = limpiarCampo($_POST['cod_telef_movil'] . "-" . $_POST["telefono_movil"]);
    
    $codTelefHab = limpiarCampo($_POST['cod_telef_hab']);
    $telefHab = $_POST["telefono_hab"];
    $telefonoHab = limpiarCampo($_POST['cod_telef_hab'] . "-" . $_POST["telefono_hab"]);

    
    $direccion = limpiarCampo($_POST['direccion']);
    $estadoCivil = limpiarCampo($_POST['estado_civil']);
    
    
    $datos = array( 'cedula'                =>  $cedulaCompleta,
                    'nombre'                =>  $nombre,
                    'apellido'              =>  $apellido,                    
                    'genero'                =>  $genero,
                    'fecha_natal'           =>  $fechaNatal,
                    'estado_civil'          =>  $estadoCivil,
                    'telefono_movil'        =>  $telefonoMovil,
                    'telefono_hab'          =>  $telefonoHab,
                    'lugar_natal'           =>  $lugarNatal,
                    'direccion'             =>  $direccion,
                    'fecha_actualizacion'   =>  date('Y-m-d'),
                    'hora_actualizacion'    =>  date('Y-m-d'),
                    'completado'            =>  '1');
    $resultado = $objetoPostulante->guardar($tabla, $datos, "id = '$id'");
    $fechaNatal = $_POST["fecha_natal"];
    if($resultado) {
        $msj = notificacion("Los datos se han actualizado correctamente", "success");
        
    } else {
        $msj = notificacion("Error al actualizar los datos. ¡Intente de nuevo!", "danger", "times");
    }
} else {
    $tipo_cedula = explode("-", $postulante[0]['cedula'])[0];
    $cedula = explode("-", $postulante[0]['cedula'])[1];
    $nombre = $postulante[0]['nombre'];    
    $apellido = $postulante[0]['apellido'];    
    $genero = $postulante[0]['genero'];
    $fechaNatal = formatoFecha($postulante[0]['fecha_natal']);
    $lugarNatal = $postulante[0]['lugar_natal'];
    $codTelefMovil = explode('-', $postulante[0]["telefono_movil"])[0];
    $telefMovil = explode('-', $postulante[0]["telefono_movil"])[1];
    $codTelefHab = explode('-', $postulante[0]["telefono_hab"])[0];
    $telefHab = explode('-', $postulante[0]["telefono_hab"])[1];
    $direccion = $postulante[0]['direccion'];
    $estadoCivil = $postulante[0]['estado_civil'];
}
$extracFechaNat = explode('-',$postulante[0]['fecha_natal'])[0];
if(!is_numeric($extracFechaNat) OR $extracFechaNat == 0) {
    $fechaNatal = "";
}
//Solucionar detalle al actualizar fecha natal cuando no existe data, porque se borra.
?>
<html>
    <head>
        <title>Actualizar datos del postulante</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="css/bootstrapv3.3/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap-datepicker3.css"/>
        <link href="css/estilos.css" rel="stylesheet">
    </head>
    <body>       
        <div class="container">
            <header><img id="banner_sistema" src="img/banner_sistema.png"></header>           
        <?php
         if(!empty($msj)) {
             echo $msj;
         }   
        if(!$resultado or $resultado): ?>
        <div class="col-lg-12">
        <div class="panel panel-default">
        <div class="panel-heading"> <h4>Actualizar datos personales</h4></div>
        

        <div class="panel-body actualizar"><br>


          <form class="form-horizontal" role="form" method="post" id="formActualizarDatos">
            <div class="col-lg-6">
              
                
                  <div class="form-group">
                    <label for="tipo_cedula" class="col-lg-4 control-label">Documento</label>
                    <div class="col-lg-2 ">
                        <select name="tipo_cedula" class="form-control requerido">
                            <option value="0"></option>
                            <option value="V" <?php if($tipo_cedula == "V") {echo "selected";} ?>>V</option>
                            <option value="E" <?php if($tipo_cedula == "E") {echo "selected";} ?>>E</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-4">
                      <input type="text" class="form-control solo-albabeto-espaniol-con-espacio requerido" id="cedula"
                             placeholder="Cédula" name="cedula"
                             value="<?php echo $cedula ?>"
                             maxlength="8" autocomplete="off">
                    </div>
                    
                    <div class="col-lg-1 ">
                      <span for="cedula" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>                    
                  <div class="form-group">
                    <label for="nombre" class="col-lg-4 control-label">Nombres</label>
                    <div class="col-lg-6 ">
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
                    <div class="col-lg-6 ">
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
                    <label for="genero" class="col-lg-4 control-label">Genero</label>
                    <div class="col-lg-6 ">
                        <select name="genero" class="form-control requerido">
                            <option value="0"></option>
                            <option value="F" <?php if($genero == "F") {echo "selected";} ?>>Femenino</option>
                            <option value="M" <?php if($genero == "M") {echo "selected";} ?>>Masculino</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-1 ">
                      <span for="usuario" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>
                <div class="form-group">
                    <label for="estado_civil" class="col-lg-4 control-label">Estado Civil</label>
                    <div class="col-lg-6">
                        <select name="estado_civil" class="form-control requerido">
                            <option value="0"></option>
                            <option value="Soltero" <?php if($estadoCivil == "Soltero") {echo "selected";} ?>>Soltero</option>
                            <option value="Casado" <?php if($estadoCivil == "Casado") {echo "selected";} ?>>Casado</option>
                            <option value="Divorciado" <?php if($estadoCivil == "Divorciado") {echo "selected";} ?>>Divorciado</option>
                            <option value="Viudo" <?php if($estadoCivil == "Viudo") {echo "selected";} ?>>Viudo</option>
                        </select>
                    </div>
                    <div class="col-lg-1 ">
                      <span for="usuario" class="control-label text-danger">Requerido</span>
                    </div>                    
                </div>
                  <div class="form-group">
                    <label for="fecha_natal" class="col-lg-4 control-label">Fecha de nacimiento</label>
                    <div class="col-lg-6 ">
                        <input type="text" class="form-control fecha" id="fecha_natal"
                             placeholder="dd-mm-yyyy" name="fecha_natal"
                             value="<?php echo $fechaNatal; ?>"
                             maxlength="40" autocomplete="off">
                    </div>
                    <div class="col-lg-1 ">
                      <span for="usuario" class="control-label text-danger">Requerido</span>
                    </div>
                  </div> 

            </div>  
            <div class="col-lg-6">
                  <div class="form-group">
                    <label for="telefono" class="col-lg-4 control-label">Teléfono móvil</label>
                    <div class="col-lg-2 ">
                        <input type="text" class="form-control solo-numero-entero requerido" id="cod_telef_movil"
                             placeholder="0416" name="cod_telef_movil"
                             value="<?php echo $codTelefMovil ?>"
                             maxlength="4" autocomplete="off">
                    </div>
                    <div class="col-lg-4 ">
                      <input type="text" class="form-control solo-numero-entero requerido" id="telefono_movil"
                             placeholder="1881236" name="telefono_movil"
                             value="<?php echo $telefMovil ?>"
                             maxlength="7" autocomplete="off">
                    </div>
                    <div class="col-lg-1 ">
                      <span for="usuario" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="teefono" class="col-lg-4 control-label">Teléfono de Habitación</label>
                    <div class="col-lg-2 ">
                        <input type="text" class="form-control solo-numero-entero" id="cod_telef_hab"
                             placeholder="0294" name="cod_telef_hab"
                             value="<?php echo $codTelefHab ?>"
                             maxlength="4" autocomplete="off">
                    </div>
                    <div class="col-lg-4 ">
                      <input type="text" class="form-control solo-numero-entero" id="telefono_hab"
                             placeholder="3323231" name="telefono_hab"
                             value="<?php echo $telefHab ?>"
                             maxlength="7" autocomplete="off">
                    </div>
                    <div class="col-lg-1 ">
                      <span for="usuario" class="control-label text-danger"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="lugar_natal" class="col-lg-4 control-label">Lugar de nacimiento</label>
                    <div class="col-lg-6 ">
                      <input type="text" class="form-control solo-albabeto-espaniol-con-espacio requerido" id="nombre"
                             placeholder="Lugar donde nació" name="lugar_natal"
                             value="<?php echo $lugarNatal ?>"
                             maxlength="50" autocomplete="off">
                    </div>
                    
                    <div class="col-lg-1 ">
                      <span for="nombre" class="control-label text-danger">Requerido</span>
                    </div>                    
                  </div>
                  <!--<div class="form-group">
                    <label for="nacionalidad" class="col-lg-4 control-label">Nacionalidad</label>
                    <div class="col-lg-6 ">
                      <input type="text" class="form-control solo-albabeto-espaniol-con-espacio requerido" id="nacionalidad"
                             placeholder="Nacionalidad" name="nacionalidad"
                             value="<?php echo $_POST["nacionalidad"] ?>"
                             maxlength="50" autocomplete="off">
                    </div>
                    
                    <div class="col-lg-1 ">
                      <span for="nombre" class="control-label text-danger">Requerido</span>
                    </div>                    
                  </div>-->
                  <div class="form-group">
                    <label for="direccion" class="col-lg-4 control-label">Dirección de habitación</label>
                    <div class="col-lg-6">
                      
                      <textarea name="direccion" id="direccion" class="form-control solo-albabeto-espaniol-con-espacio requerido"><?php echo $direccion ?></textarea>
                    </div>
                    <div class="col-lg-1 ">
                      <span for="apellido" class="control-label text-danger">Requerido</span>
                    </div>
                  </div>
                  <!--<div class="form-group">
                    <label for="area" class="col-lg-4 control-label">Perfil del trabajador</label>
                    <div class="col-lg-6">
                        <select name="area" class="form-control requerido" id="nivel_usuario">
                            <option value="0"></option>
                <?php foreach ($areas as $area): ?>            
                            <option value='<?php echo $area["id"] ?>' 
                                <?php if ($_POST["area"] == $area["id"]) { echo "selected"; }?>><?php echo $area['nombre'] ?></option>
                <?php endforeach; ?>
                            
                        <</select>
                    </div>
                    <div class="col-lg-1 ">
                      <span for="usuario" class="control-label text-danger">Requerido</span>
                    </div>  
                  </div>-->
                    
                  <div class="form-group">                      
                    <div class="col-lg-offset-4 col-lg-8 ">                        
                        <!--<a onclick="window.location.href='principal.php'" class="btn btn-default">Cancelar</a>
                      &nbsp;
                      &nbsp;-->
                      <button type="submit" name="actualizar" class="btn btn-primary" id="btn-nuevo">Actualizar</button>
                    </div>
                  </div>
            
            </div> 
                        </form>

        
      </div>
</div>
        </div>
            <?php endif; ?>
    </div>
        
    <script src="js/bootstrapv3.3/bootstrap.min.js"></script>
    <script src="js/jquery-min.js"></script>
    <!-- Date picker bostrap -->
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.datepicker-es.js"></script>
    <!--Scripts personales -->
    <script src="js/scripts.js"></script>
    <script>
        var date_input=$('.fecha'); //our date input has the name "date"
        //var container=$('#formActualizarDatos').length>0 ? $('#formActualizarDatos').parent() : "body";
        date_input.datepicker({
            //container: container,
            todayHighlight: true,
            autoclose: true,
            language: 'es',
            format: 'dd-mm-yyyy',
        }); 
    </script>
    </body>
</html>
