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

$tabla = "curriculo";
$datos = null;
$condicion = "id = '$id'";
$curriculo = $objetoCrud->consultar($tabla, $datos, $condicion);
$datosF = $objetoCrud->consultar("formacion", null ,"curriculo = '" . $curriculo[0]['id']. "'", "anio_fin DESC");
$datosEl = $objetoCrud->consultar("experiencia_laboral", null ,"curriculo = '" . $curriculo[0]['id']. "'", "anio_fin DESC, mes_fin DESC");

$dpCompletado = $objetoCrud->contarFilas("datos_personales", "id = '".$id."' AND completado = '1'");



if (isset($_POST["guardar"])) {
    #print "<pre>";print_r($_POST);print "<pre>";

    $categoria = limpiarCampo($_POST["categoria"]);
    $profesion = limpiarCampo($_POST["profesion"]);   
    $cargoPostulado = limpiarCampo($_POST["cargo_postulado"]);

    $tipo_foto = explode('/',$_FILES[('foto')]['type']);
    $tamanio_foto = $_FILES[('foto')]['size'];
    $tamanio_foto /= 512;	
    /*
    if (strtolower($tipo_foto[1]) != 'png'
                && strtolower($tipo_foto[1]) !='jpeg'
                && strtolower($tipo_foto[1]) != 'jpg'
                && strtolower($tipo_foto[1]) !='gif')
            $notificacion = $mensaje['seleccione_foto'];
	else if ($tamanio_foto > 1024)
            $notificacion = $mensaje['foto_muy_pesada'];		
	else {*/
    $nombre_foto=$_FILES[('foto')]['name'];
    $ruta_foto = $_FILES[('foto')]['tmp_name'];
    $rutaRaiz = $_SERVER["DOCUMENT_ROOT"];
    $destino_foto = $rutaRaiz . '/selectdata/img/fotos/foto-'.$_SESSION["id_username"].'.'.$tipo_foto[1];
    //$archivoViejo = $_SESSION["foto"];
    $rutaDeFoto = 'img/fotos/foto-'.$_SESSION["id_username"].'.'.$tipo_foto[1];
    
    if(empty($nombre_foto)) {
        $fotoMovida = true;
        $rutaDeFoto = $curriculo[0]['ruta_de_foto'];
    } else {
        $fotoMovida = move_uploaded_file($ruta_foto, $destino_foto);
    }
    //INICIO: Guarda en table currículo
    $datos = array( 'categoria'           =>  $categoria,
                    'profesion'           =>  $profesion,                
                    'cargo_postulado'     =>  $cargoPostulado,
                    'ruta_de_foto'        =>  $rutaDeFoto,
                    'fecha_postulacion'   =>  date('Y-m-d'),
                    'completado'          =>  '1');
    $condicion = "id = '".$curriculo[0]['id']."'";
    $resultado = $objetoCrud->guardar($tabla, $datos, $condicion);
    /*
    if($objetoCrud->contarFilas("estatus_postulacion", "curriculo = '" . $curriculo[0]['id'] . "'") == 0) {
        $resultado = $objetoCrud->guardar("estatus_postulacion", array("curriculo" => $curriculo[0]['id'],         
        "fecha_estatus" => date('Y-m-d')));
    }
    */
    //FIN: Guardar en tabla currículo
 
    //INICIO: Guardar en tabla formacion
    for($i=0; $i<=$_POST['total_f'];$i++) {
        if ($_POST['indice_f_'.$i] == 'registrar') {
                $_nivel = $_POST["nivel_f_".$i];
                $_centroEducativo = $_POST["centro_educativo_f_".$i];
                //$_ = $_POST["mes_inicio_el_".$i];
                $_anioInicio = $_POST["anio_inicio_f_".$i];
                //$_mesFin = $_POST["mes_fin_el_".$i];
                $_anioFin = $_POST["anio_fin_f_".$i];

                $tabla = 'formacion';
                $datos = array( 'nivel'             =>  $_nivel,
                                'centro_educativo'  =>  $_centroEducativo,                
                                //'mes_inicio'    =>  $_mesInicio,
                                'anio_inicio'       =>  $_anioInicio,
                                //'mes_fin'       =>  $_mesFin,
                                'anio_fin'          =>  $_anioFin,
                                'curriculo'         =>  $curriculo[0]['id']);
            if(empty($_POST['id_f_'.$i])) {
                $resultado = $objetoCrud->guardar($tabla, $datos);
            } else {
                $condicion = "id = '".$_POST['id_f_'.$i]."'";
                $resultado = $objetoCrud->guardar($tabla, $datos, $condicion);
            }
        }
        if($_POST['eliminar_f_'.$i] == '1') {
            $tabla = 'formacion';
            $condicion = "id = '" . $_POST['id_f_'.$i] . "'";
            $objetoCrud->eliminar($tabla, $condicion);
        }
    }
    //FIN: Guardar en tabla formacion 
    
    //INICIO: Guardar en tabla experiencia laboral
    for($i=0; $i<=$_POST['total_el'];$i++) {
        if ($_POST['indice_el_'.$i] == 'registrar') {
                $_cargo = $_POST["cargo_el_".$i];
                $_empresa = $_POST["empresa_el_".$i];
                $_mesInicio = $_POST["mes_inicio_el_".$i];
                $_anioInicio = $_POST["anio_inicio_el_".$i];
                $_mesFin = $_POST["mes_fin_el_".$i];
                $_anioFin = $_POST["anio_fin_el_".$i];

                $tabla = 'experiencia_laboral';
                $datos = array( 'cargo'         =>  $_cargo,
                                'empresa'       =>  $_empresa,                
                                'mes_inicio'    =>  $_mesInicio,
                                'anio_inicio'   =>  $_anioInicio,
                                'mes_fin'       =>  $_mesFin,
                                'anio_fin'      =>  $_anioFin,
                                'curriculo'     =>  $curriculo[0]['id']);
            if(empty($_POST['id_el_'.$i])) {
                $resultado = $objetoCrud->guardar($tabla, $datos);
            } else {
                $condicion = "id = '".$_POST['id_el_'.$i]."'";
                $resultado = $objetoCrud->guardar($tabla, $datos, $condicion);
            }
        }

        if($_POST['eliminar_el_'.$i] == '1') {
            $tabla = 'experiencia_laboral';
            $condicion = "id = '" . $_POST['id_el_'.$i] . "'";
            $objetoCrud->eliminar($tabla, $condicion);
        }
    }
    //FIN: Guardar en tabla experiencia laboral
    
    if($resultado AND $fotoMovida) {
        $msj = notificacion("Los datos se han actualizado correctamente", "success");
        
    } else {
        $msj = notificacion("Error al actualizar los datos. ¡Intente de nuevo!", "danger", "times");
    }
} else {

    $categoria = $curriculo[0]['categoria'];    
    $profesion = $curriculo[0]['profesion'];    
    $cargoPostulado = $curriculo[0]['cargo_postulado'];
    $rutaDeFoto = $curriculo[0]['ruta_de_foto'];
   
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
    </head>
    <body>       
     <div class="container nuevo">
            <header><img id="banner_sistema" src="img/banner_sistema.png"></header> 
        
        
        <div class="col-lg-10">
        <?php
         if(!empty($msj)) {
            echo $msj;
         }   
        ?>
        <form enctype="multipart/form-data" role="form" method="POST">   
        <div class="panel panel-default">
        <div class="panel-heading"> <h4>Perfil Profesional</h4></div>
        <?php if($dpCompletado > 0): ?>
            <div class="panel-body"><br>          
                <div class="col-lg-8 nuevo">
                  <div class="form-group">
                      <img src="<?php echo  empty($rutaDeFoto) ? "img/default-user.png":$rutaDeFoto; ?>" style="height:128; width:128;">
                      <input type="file" name="foto">
                  </div>
                  <div class="form-group">
                    <span for="categoria">Categoría a postular</span>
                    <select class="form-control requerido" name="categoria">
                        <option></option>
                <?php foreach ($categorias as $_categoria): ?>
                        <option value="<?php echo $_categoria['nombre'] ?>" <?php if($_categoria['nombre'] == $categoria) {echo "selected";} ?>><?php echo $_categoria['nombre'] ?></option>
                <?php endforeach; ?>        
                    </select>
                  </div>
                  <div class="form-group">
                    <span for="profesion">Profesión</span>
                    <input type="text" class="form-control requerido" id="profesion" name="profesion" 
                           placeholder="Ej. Licenciado en Administración" value="<?php echo $profesion ?>">
                  </div>
                  <div class="form-group">
                    <span for="cargo_postulado">Cargo o Título Breve del Currículo</span>
                    <input type="text" class="form-control requerido" id="cargo_postulado"  name="cargo_postulado"
                           placeholder="Ej. Docente en Contabilidad" value="<?php echo $cargoPostulado ?>">
                  </div>
                </div>
            </div>
            
            <div class="panel-heading panel-heading2"> <h4>Formación</h4></div>
            <div class="panel-body"><br>          
                <div class="col-lg-8">
                    <a href="#" id="btn-campos-f"><i class="fa fa-plus-circle"></i> Añadir</a>
                    <div id="formacion" style="display: none;">                      
                      <div class="form-group">
                        <span for="centro_educativo_f">Centro educativo</span>
                        <input type="text" class="form-control requerido-f" id="centro_educativo_f" name="centro_educativo_f"
                               placeholder="Nombre de centro educativo donde estudió" value="<?php echo $empresaEl ?>">
                      </div>
                      <div class="form-group">
                        <span for="nivel_f">Nivel de estudios</span>
                        <select class="form-control requerido-f" name='nivel_f' id='nivel_f'>
                            <option value='0'></option>
                            <option value='Educación Básica Primaria'>Educación Básica Primaria</option>
                            <option value='Educación Básica Secundaria'>Educación Básica Secundaria</option>
                            <option value='Bachillerato / Educación Media'>Bachillerato / Educación Media</option>
                            <option value='Técnico Superior Universitario'>Técnico Superior Universitario</option>
                            <option value='Universidad'>Universidad</option>
                            <option value='Postgrado'>Postgrado</option>
                        </select>
                      </div>
                      <div class="form-group">                        
                        <div class="col-xs-3">
                            <span for="mes_inicio_f">Fecha: Inicio</span>
                            <!--<select name="mes_inicio_f" class="form-control requerido-f" id="mes_inicio_f">
                                <option value="0">Mes</option>
                                <?php for($i=1; $i<13; $i++): ?>
                                <option value="<?php echo $i ?>" <?php if($mesInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor;?>
                            </select>
                        </div>-->
                          
                        <!--<div class="col-xs-3">-->
                            <span for="anio_inicio_f">&nbsp;</span>
                            <select name="anio_inicio_f" class="form-control requerido-f" id="anio_inicio_f">
                                <option value="0">Año</option>
                                <?php for($i=1980; $i<date('Y')+1; $i++): ?>
                                <option value="<?php echo $i ?>" <?php if($anioInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                          
                        <div class="col-xs-3">
                            <span for="mes_fin_f">Fecha: Fin</span>
                           <!-- <select name="mes_fin_f" class="form-control requerido-f" id="mes_fin_f">
                                <option value="0">Mes</option>
                                <?php for($i=1; $i<13; $i++): ?>
                                <option value="<?php echo $i ?>" <?php if($mesInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor;?>
                            </select>-->
                        <!--</div>
                        <div class="col-xs-3">-->
                            <span for="anio_fin_f">&nbsp;</span>
                            <select name="anio_fin_f" class="form-control requerido-f" id="anio_fin_f">
                                <option value="0">Año</option>
                                <?php for($i=1980; $i<date('Y')+1; $i++): ?>
                                        <option value="<?php echo $i ?>" <?php if($anioInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                      </div>
                        <input id='indice_f' name='indice_f'value='' type="hidden">
                        <input id='id_f' name='id_f'value='' type="hidden">
                        <BR>
                        <BR>
                        <BR>
                        <HR>
                    <div>
                        <a href="#" class="btn btn-default" id="btn-cancelar-f" onClick='cancelarF();'>Cancelar</a>
                        <a href="#" class="btn btn-success" id="btn-agregar-f">Añadir</a>
                    </div>
                    </div>    
                                        
              
                     
                    <div class="lista-f col-lg-12">
                    <?php
                        $j = 0;
                        if(count($datosF)):                            
                            foreach ($datosF as $data):
                                $fechaF =  $data['anio_inicio'] . " - " . $data['anio_fin'];
                    ?>      
                                <!--<div class="col-md-12">&nbsp;</div>-->
                                <div class="col-md-12 lista-temp">
                                    
                                    <div class="row" style="border-bottom: 1px; border-bottom-color: #f1f1f1; border-bottom-style: solid;" >
                                        <div class="col-md-6"><strong><?php echo $data['nivel'] ?></strong></div>
                                        <div class="col-md-6 text-right" >
                                            <a class='fa fa-edit btn-editar-f' href='#' onClick='editarF("<?php echo $j ?>")'></a>
                                            &nbsp;                                 
                                            <a class='btn-eliminar-f' onClick='eliminarF("<?php echo $j ?>")' href='#' title='Eliminar'>
                                            <i class='fa fa-remove text-danger' ></i></a>
                                        </div>
                                    </div>                        
                                    <div class="row">
                                        <div class="col-md-6"><?php echo $data['centro_educativo'] ?></div>
                                        <div class="col-md-6 text-right text-muted" ><small><?php echo $fechaF ?></small></div>
                                    </div>
                                </div>


                                <input type='hidden' value='<?php echo $data['id'] ?>' name='id_f_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['nivel'] ?>' name='nivel_f_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['centro_educativo'] ?>' name='centro_educativo_f_<?php echo $j ?>'>
                                <!--<input type='hidden' value='<?php echo $data['mes_inicio'] ?>' name='mes_inicio_f_<?php echo $j ?>'>-->
                                <input type='hidden' value='<?php echo $data['anio_inicio'] ?>' name='anio_inicio_f_<?php echo $j ?>'>
                                <!--<input type='hidden' value='<?php echo $data['mes_fin'] ?>' name='mes_fin_f_<?php echo $j ?>'>-->
                                <input type='hidden' value='<?php echo $data['anio_fin'] ?>' name='anio_fin_f_<?php echo $j ?>'>
                                <input type='hidden' value='' name='eliminar_f_<?php echo $j ?>'>
                                
                                <input type='hidden' class='form-control' name='indice_f_<?php echo $j ?>' value='registrar'>
                    <?php
                            $j++;
                            endforeach;
                        endif;
                    ?>    
                    </div>
                    <input type='hidden' class='form-control' name='total_f' value='<?php echo $j ?>'>
                    
                </div>
               
            </div><!-- FIN: formación -->  
           
           
           <!-- INICIO: experiencia labora --> 
            
            <div class="panel-heading panel-heading2"> <h4>Experiencia Laboral</h4></div>
            <div class="panel-body"><br>          
                <div class="col-lg-8" >
                    <a href="#" id="btn-campos-el"><i class="fa fa-plus-circle"></i> Añadir</a>
                    <div id="experiencia-laboral" style="display: none;">                      
                      <div class="form-group">
                        <span for="empresa_el">Empresa</span>
                        <input type="text" class="form-control requerido-el" id="empresa_el" name="empresa_el"
                               placeholder="Nombre de la empresa donde trabajó" value="<?php echo $empresaEl ?>">
                      </div>
                      <div class="form-group">
                        <span for="cargo_el">Cargo</span>
                        <input type="text" class="form-control requerido-el" id="cargo_el" name="cargo_el"
                               placeholder="Ej. Contador público" value="<?php echo $cargoEl ?>">
                      </div>
                      <div class="form-group">                        
                        <div class="col-xs-3">
                            <span for="mes_inicio_el">Fecha: Inicio</span>
                            <select name="mes_inicio_el" class="form-control requerido-el" id="mes_inicio_el">
                                <option value="0">Mes</option>
                                <?php for($i=1; $i<13; $i++): ?>
                                <option value="<?php echo $i ?>" <?php if($mesInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                          
                        <div class="col-xs-3">
                            <span for="anio_inicio_el">&nbsp;</span>
                            <select name="anio_inicio_el" class="form-control requerido-el" id="anio_inicio_el">
                                <option value="0">Año</option>
                                <?php for($i=1980; $i<date('Y')+1; $i++): ?>
                                <option value="<?php echo $i ?>" <?php if($anioInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                          
                        <div class="col-xs-3">
                            <span for="mes_fin_el">Fecha: Fin</span>
                            <select name="mes_fin_el" class="form-control requerido-el" id="mes_fin_el">
                                <option value="0">Mes</option>
                                <?php for($i=1; $i<13; $i++): ?>
                                <option value="<?php echo $i ?>" <?php if($mesInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <span for="anio_fin_el">&nbsp;</span>
                            <select name="anio_fin_el" class="form-control requerido-el" id="anio_fin_el">
                                <option value="0">Año</option>
                                <?php for($i=1980; $i<date('Y')+1; $i++): ?>
                                        <option value="<?php echo $i ?>" <?php if($anioInicio == $i) {echo "selected";} ?>><?php echo $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                      </div>
                        <input id='indice_el' name='indice_el'value='' type="hidden">
                        <input id='id_el' name='id_el'value='' type="hidden">
                        <BR>
                        <BR>
                        <BR>
                        <HR>
                    <div>
                        <a href="#" class="btn btn-default" id="btn-cancelar-el" onClick='cancelarEl();'>Cancelar</a>
                        <a href="#" class="btn btn-success" id="btn-agregar-el">Añadir</a>
                    </div>
                    </div>    
                    <br>

         
                        
              
                     
                    <div class="lista-el col-lg-12">
                    <?php
                        $j = 0;
                        if(count($datosEl)):                            
                            foreach ($datosEl as $data):
                                $fechaEl = obtenerMesPorNombre($data['mes_inicio']) . " " . $data['anio_inicio'] . " - "
                                . obtenerMesPorNombre($data['mes_fin']) . " " . $data['anio_fin'];
                    ?>      
                                <!--<div class="col-md-12">&nbsp;</div>-->
                                <div class="col-md-12 lista-temp">
                                    
                                    <div class="row" style="border-bottom: 1px; border-bottom-color: #f1f1f1; border-bottom-style: solid;" >
                                        <div class="col-md-6"><strong><?php echo $data['cargo'] ?></strong></div>
                                        <div class="col-md-6 text-right" >
                                            <a class='fa fa-edit btn-editar' href='#' onClick='editarEl("<?php echo $j ?>")'></a>
                                            &nbsp;                                 
                                            <a class='btn-eliminar' onClick='eliminarEl("<?php echo $j ?>")' href='#' title='Eliminar'>
                                            <i class='fa fa-remove text-danger' ></i></a>
                                        </div>
                                    </div>                        
                                    <div class="row">
                                        <div class="col-md-6"><?php echo $data['empresa'] ?></div>
                                        <div class="col-md-6 text-right text-muted" ><small><?php echo $fechaEl ?></small></div>
                                    </div>
                                </div>


                                <input type='hidden' value='<?php echo $data['id'] ?>' name='id_el_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['cargo'] ?>' name='cargo_el_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['empresa'] ?>' name='empresa_el_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['mes_inicio'] ?>' name='mes_inicio_el_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['anio_inicio'] ?>' name='anio_inicio_el_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['mes_fin'] ?>' name='mes_fin_el_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['anio_fin'] ?>' name='anio_fin_el_<?php echo $j ?>'>
                                <input type='hidden' value='<?php echo $data['anio_fin'] ?>' name='anio_fin_el_<?php echo $j ?>'>
                                <input type='hidden' class='form-control' name='eliminar_el_<?php echo $j ?>'>
                    <?php
                            $j++;
                            endforeach;
                        endif;
                    ?>    
                    </div>
                    <input type='hidden' class='form-control' name='total_el' value='<?php echo $j ?>'>
                    
                </div>
               
            </div>
         <div class="panel-footer">
             <div><button type="submit" name="guardar" class="btn btn-primary btn-lg">Guardar</button></div>
         </div>
        </div>  
        </form>   
        <?php else : ?>
        <div class="panel-body">    
            <p class="text-danger"><i class="fa fa-times-circle"></i> <strong>¡Lo sentimos!</strong> Debe completar los <u>datos personales</u> para poder acceder a las opciones de este módulo.</p>
        <?php endif; ?>
        </div>
        </div>
          
            
    </div>       
    <script src="js/bootstrapv3.3/bootstrap.min.js"></script>
    <script src="js/jquery-min.js"></script>
    <script src="js/scripts.js"></script>
    </body>
</html>
