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
    
    </div>

      
    <script src="js/bootstrapv3.3/bootstrap.min.js"></script>
    <script src="js/jquery-min.js"></script>
    <script src="js/scripts.js"></script>
    </body>
</html>
