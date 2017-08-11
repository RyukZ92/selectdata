<?php 
/**
 * 
 */
require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';
require_once 'class/funciones.php';

$id = limpiarCampo($_GET['id']);
$objetoCrud = new Crud();
$tablas = "datos_personales dp JOIN curriculo c ON dp.id = c.id ";
$datos = array("dp.*, profesion",  "cargo_postulado", "fecha_postulacion", "categoria", "ruta_de_foto", "c.id as curriculo");
$postulante = $objetoCrud->consultar($tablas, 
        $datos, "c.id = '$id'");
$formaciones = $objetoCrud->consultar("formacion", null ,"curriculo = '" . $postulante[0]['curriculo']. "'", "anio_fin DESC");
$experienciasLaborales = $objetoCrud->consultar("experiencia_laboral", null ,"curriculo = '" . $postulante[0]['curriculo']. "'", "anio_fin DESC, mes_fin DESC");
?>
<html>
    <head>
        <title>Nueva cuenta de usuario</title>
        <meta charset="utf-8">
        <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
        
        <link href="css/bootstrapv3.3/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <style>
            .row {
                padding:0.6%;
            }
        </style>
    </head>
    <body>
        

        
        
    <div class="container">
        <header><img id="banner_sistema" src="img/banner_sistema.png"></header>
        <div class="col-md-11" style="background: #f6f6f6; margin:auto;">

            <div class="row" >
                
                <div class="col-md-2" ><img src="<?php echo empty($postulante[0]['ruta_de_foto']) ? "img/default-user.png":$postulante[0]['ruta_de_foto']; ?>" style="height:128; width:128;"></div>
                <div class="col-md-6">
                    <h4 class="text-primary"><strong><?php echo $postulante[0]['nombre'] . " " . $postulante[0]['apellido'] ?></strong>
                        <BR><small class="text-primary"><?php echo $postulante[0]["cargo_postulado"]; ?></small>
                    </h4>
                    
                    <div><?php echo calcularEdad($postulante[0]["fecha_natal"]) . " años"; ?></div>
                    <div><?php echo $postulante[0]['direccion'] ?></div>
                    <div><?php echo $postulante[0]['telefono_movil'] ?></div>
                </div>
            </div>
            <div class="row">&nbsp</div>
            <div class="row text-left">
                <div class="col-md-2"><strong>ESTUDIOS</strong></div>
            </div>
            <?php 
            if(count($formaciones) > 0):
                foreach ($formaciones as $formacion):
            ?>
                    <div class="row">
                        <div class="col-md-2" ><small><?php echo $formacion['anio_inicio'] . " - " . $formacion['anio_fin'] ?></small></div>
                        <div class="col-md-6">
                            <div><?php echo $formacion['centro_educativo'] ?>
                                <br><small class="text-muted"><?php $formacion['nivel'] ?></small></div>

                        </div>
                    </div>
            <?php 
                endforeach;
            else:
                ?>
            <div class="row text-danger">No posee estudios compleados</div>
            <?php endif;
            ?>
            <!--<div class="row">&nbsp</div>-->
            <div class="row text-left">
                <div class="col-md-2"><strong>EXPERIENCIA</strong></div>
            </div>
            <?php
            if(count($experienciasLaborales) > 0):
                foreach ($experienciasLaborales as $el):
                    $fecha = obtenerMesPorNombre($el['mes_inicio']) . " " . $el['anio_inicio'] . " - "
                                . obtenerMesPorNombre($el['mes_fin']) . " " . $el['anio_fin'];
            ?>
                <div class="row">
                    <div class="col-md-2" ><small><?php echo $fecha;?></small></div>
                    <div class="col-md-6">
                        <div><?php echo $el['empresa'] ?>
                            <br><small class="text-muted"><?php echo $el['cargo'] ?></small></div>

                    </div>
                </div>
            <?php 
            endforeach;
            else :
                ?>
            <div class="row text-danger">No posee experiencia laboral</div>
            <?php 
            endif;
            ?>
        </div>
        <div class="col-md-11">
            <div class="row">
                <hr>
                <div class="col-md-3"><strong>Fecha de Postulación:</strong></div><div class="col-md-9"><?php echo formatoFecha($postulante[0]['fecha_postulacion']) ?></div>
                <div class="col-md-3"><strong>Categoría Postulada:</strong></div><div class="col-md-9"><?php echo $postulante[0]['categoria'] ?></div>
                <div class="col-md-12"><a style="float:right;" href="#" onClick="history.back();" class="fa fa-reply">
                        Volver</a></div>
            </div>
        </div>
    <!--<div class="col-lg-12">
    <div class="panel panel-default">
    <div class="panel-heading"> <h4>Detalle del Postulante</h4></div>  
    <div class="container">
        <div class="row">
          <div class="col-md-3 "><label class="control-label">Nombre</label></div>
          <div class="col-md-3"><?php echo $postulante[0]['nombre'] ?></div>
          <div class="col-md-3"><label class="control-label">Apellido</label></div>
          <div class="col-md-3"><?php echo $postulante[0]['apellido'] ?></div>
        </div>
        <div class="row">
          <div class="col-md-3"><label class="control-label">Género</label></div>
          <div class="col-md-3"><?php echo $postulante[0]['genero'] ?></div>
          <div class="col-md-3"><label class="control-label">Estado Civil</label></div>
          <div class="col-md-3"><?php echo $postulante[0]['estado_civil'] ?></div>
        </div>
        <div class="row">
          <div class="col-md-3"><label class="control-label">Edad</label></div>
          <div class="col-md-3"><?php echo calcularEdad($postulante[0]['fecha_natal']) ?></div>
          <div class="col-md-3"><label class="control-label">Lugar de Nacimiento</label></div>
          <div class="col-md-3"><?php echo ($postulante[0]['lugar_natal']) ?></div>
        </div>
        <div class="row">
          <div class="col-md-3"><label class="control-label">Dirección</label></div>
          <div class="col-md-3"><?php echo $postulante[0]['direccion'] ?></div>
          <div class="col-md-3"><label class="control-label">Telefonos</label></div>
          <div class="col-md-3"><?php echo $postulante[0]['telefono_hab'] . " / " . $postulante[0]['telefono_movil'] ?></div>
        </div>
    </div>
    </div>
    </div>   -->         
        
    <!--<div class="panel panel-default">
        <div class="panel-heading"><label class="text-uppercase">Datos Personales</label>
        <a style="float:right;" 
           href="#" onClick="history.back();" class="fa fa-reply">
            Volver</a></div>
        <input type="hidden" name="pagina_referencia" value="<?php echo $_POST["pagina_referencia"]; ?>">
        <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>">

        <table class="table">
            <tr>
                <th colspan="5"><img src="img/default-user.png" style="height:124; width:124;"></th>
            </tr>
            <tr>                
                <th><small>Nombre Completo:</small></th>
                <td><small><?php echo $postulante[0]["nombre"]; ?></small></td>
                <th><small>Edad:</small></td>
                <td><small><?php echo calcularEdad($postulante[0]["fecha_natal"]) . " años"; ?></small></th>
            </tr>
            <tr>
                <th><small>Genero:</small></th>
                <td><small><?php echo $postulante[0]["genero"] == "M" ? "Masculino" : "Femenino"; ?></small></td>
                <th><small>Estado Civil:</small></th>
                <td><small><?php echo $postulante[0]["estado_civil"]; ?></small></td>
            </tr>
            <tr>
                <th><small>Lugar de Nacimiento:</small></th>
                <td><small><?php echo $postulante[0]["lugar_natal"]; ?></small></td>
                <th><small>Dirección:</small></th>
                <td><small><?php echo $postulante[0]["direccion"]; ?></small></td>
            </tr>
            <tr>
                <th><small>Contacto:</small></th>
                <td><small><?php echo $postulante[0]['telefono_hab'] . " / " . $postulante[0]['telefono_movil'] ?></small></td>
                <th><small></small></th>
                <td><small></small></td>
            </tr>
        </table>
        <div class="panel-heading"><label class="text-uppercase">Perfil Profesional</label></div>
        <table class="table ">
            <tr>
                <th><small>Categoría:</small></th>
                <td><small><?php echo $postulante[0]["categoria"]; ?></small></td>
                <th><small>Cargo Postulado:</small></th>
                <td><small><?php echo ($postulante[0]["cargo_postulado"]); ?></small></td>
            </tr>
            <tr>
                <th><small>Profesión:</small></th>
                <td><small><?php echo $postulante[0]["profesion"]; ?></small></td>
                <th><small>Fecha de Postulación:</small></th>
                <td><small><?php echo formatoFecha($postulante[0]["fecha_postulacion"]); ?></small></td>
            </tr>
        </table>
        <div class="panel-heading"><label class="text-uppercase">Experiencia Laboral</label></div>
        <table class="table">
            <tr>
                <th><small>Categoría:</small></th>
                <td><small><?php echo $postulante[0]["categoria"]; ?></small></td>
                <th><small>Cargo Postulado:</small></th>
                <td><small><?php echo ($postulante[0]["cargo_postulado"]); ?></small></td>
            </tr>
            <tr>
                <th><small>Profesión:</small></th>
                <td><small><?php echo $postulante[0]["profesion"]; ?></small></td>
                <th><small>Fecha de Postulación:</small></th>
                <td><small><?php echo formatoFecha($postulante[0]["fecha_postulacion"]); ?></small></td>
            </tr>
        </table>
    </div>        
    </div>-->
    
    </div>

      
    <script src="js/bootstrapv3.3/bootstrap.min.js"></script>
    <script src="js/jquery-min.js"></script>
    <script src="js/scripts.js"></script>
    </body>
</html>
