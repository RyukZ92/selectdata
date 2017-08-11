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
//print_r($_POST);

$curriculoCompletado = $objetoCrud->contarFilas("curriculo", "id = '$id' AND completado = '1'");

$postulacion = $objetoCrud->consultar("estatus_postulacion", null, "curriculo = '" . $id . "'");

if (isset($_POST["enviar"])) {	
    if($_POST["tipo_de_reporte"] == "reporte1") {
        header("location:reporte_pdf/reporte1.php");        
    } elseif($_POST["tipo_de_reporte"] == "reporte2") {
        header("location:reporte_pdf/reporte2.php");        
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
    <body data-spy="scroll" data-target=".bs-docs-sidebar">  
        <BR>
        <div class=" row-fluid" >
	
	        <div class="info col-lg-12" style="background: #d9edf7; border-radius: 5px;">
                    <h3 class="text-info "><img src="img/reporte.png" class="img-circle" width="100" height="100"> 
                    Reportes</h3>
                </div>
             
        
        <div class="col-lg-6"><BR> 
        <div class="panel panel-default">
        <div class="panel-heading"> <h4>Tipo de Repote</h4></div>
        
            <div class="panel-body nuevo">        
                <form class="form" method="POST">
                <div class="col-lg-12">
                    <select name="tipo_de_reporte" class="form-control requerido">
                        <option value="0">Seleccionar reporte</option>
                        <option value="reporte1">Reporte de Postulantes</option>
                        <option value="reporte2">Reporte de Usuarios</option>
                    </select>
                    <BR>
                    <button class="text-right btn btn-primary" name="enviar">Enviar</button>
                </div>
                </form>
           
            </div>  
                
        </div>                    
    </div> 
     </div>

<!-- Modal -->
  
  
    </body>
</html>
