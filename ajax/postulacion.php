<?php 
session_start();
/**
 * 
 */
require_once 'config.php';
require_once 'class/dbPdo.php';
require_once 'class/crud.php';
require_once 'class/funciones.php';


$id = $_SESSION['id_username'];

$objetoCrud = new Crud();


$curriculoCompletado = $objetoCrud->contarFilas("curriculo", "id = '$id' AND completado = '1'");

$postulacion = $objetoCrud->consultar("estatus_postulacion", null, "curriculo = '" . $id . "'");

if (isset($_POST["postularme"])) {	
    if(count($postulacion) == 0) {
        $resultado = $objetoCrud->guardar("estatus_postulacion", array("curriculo" => $id,         
        "fecha_estatus" => date('Y-m-d')));
        if($resultado) {
            $msj =  notificacion("Su postulación ha sido enviada éxitosamente", "success");
        } else {
            $msj =  notificacion("Error al enviar postulación. ¡Intente de nuevo!", "danger");
        }
    }    
}

?>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="css/bootstrapv3.3/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <script src="js/jquery-min.js"></script>
        <script src="js/bootstrapv3.3/bootstrap.min.js"></script>
    
        <script src="js/scripts.js"></script>
    </head>
    <body>       
     <div class="container nuevo">
            <header><img id="banner_sistema" src="img/banner_sistema.png"></header> 
        
        
        <div class="col-lg-10"> 
        <?php
         if(!empty($msj)) {
             echo $msj;
         } ?>
        <div class="panel panel-default">
        <div class="panel-heading"> <h4>Estatus de la postulación</h4></div>
        
            <div class="panel-body">        
                <div class="col-lg-12">
                    <?php 
                    if($curriculoCompletado > 0):
                    if(count($postulacion) == 0): ?>
                    <span class="text-info">Usted aún no ha hecho una postulación.</span>              

                    <a href='#myModal' class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Clic aquí para Postularse</a>
                    <?php else: ?>
                        <?php if($postulacion[0]['estatus'] == 'En Proceso'): ?>
                            <p class="text-primary">Actualmente su postulación se está <strong>Procesando</strong>.</p>                            
                        <?php elseif($postulacion[0]['estatus'] == 'Pre Seleccionado'): ?>
                            <p class="text-warning">¡Buenas noticia!. Usted se encuestra <strong>Pre Selecccionado</strong>. <BR>Revise el estatus más tarde para traerle novedades.</p>
                        <?php elseif($postulacion[0]['estatus'] == 'Seleccionado'): ?>
                            <p class="text-success">¡Falicidades! Usted ha sido <strong>Seleccionado</strong>. <br>Su perfil cumple los requisitos para nuestra empresa.
                                <br>Para más información debe dirigirse a la Oficina de Talento Humano de la Institución.</p>
                        <?php elseif($postulacion[0]['estatus'] == 'No Seleccionado'): ?>
                            <p class="text-danger">¡Disculpe! Usted <strong>no ha sido seleccionado</strong>. 
                                <BR>Parece que su perfil laboral no es requerido para nuestra empresa.
                                <BR><?php echo empty($postulacion[0]['descripcion']) ? "": "<BR>DETALLES: ".$postulacion[0]["descripcion"] ?>
                            </p>
                        <?php endif; ?>
                    <?php endif;
                          else: ?>
                            <p class="text-danger"><i class="fa fa-times-circle"></i> <strong>¡Lo sentimos!</strong> Debe completar su <u>currículo</u> para poder acceder a las opciones de este módulo.</p>
                    <?php endif; ?>
                </div>            
           
            </div>  
                
        </div>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-danger">Confirmación</h4>
              </div>
              <div class="modal-body">
                <label>¿Está seguro que desea postularse?</label>
              </div>
              <div class="modal-footer">
                <form method="POST">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" name='postularme'>Confirmar</button>
                </form>
              </div>
            </div>
          
          </div>
        </div> 
        
            
    </div> 

<!-- Modal -->
  
  
    </body>
</html>
