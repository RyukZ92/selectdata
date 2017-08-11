<?php include "reporte1_css.php"; #print_r($postulante);?>

<page backtop="15mm" backbottom="20mm" backleft="15mm" backright="15mm">
    <page_header>
        <div class="banner">
            <img src="../img/banner_sistema.png">
        </div>
    </page_header>
    <page_footer>
        <div id="footer">
            <div id="pagina">Página [[page_cu]]/[[page_nb]]</div>
            <div id="datos-emision">Emitido por <?php echo $_SESSION["username"];  ?> el <?php date('d/m/Y') ?> a las <?php echo date('h:i:s a') . "."; ?></div> 
        </div>
    </page_footer>    
    
        <div class="titulo">LISTADO GENERAL DE LOS POSTULACIONES<hr></div>
        <div class="subtitulo" id="sub-seleccionado">Postulantes Seleccionados
        <label>(<?php echo $_postulante[0]['seleccionado'] ?>)</label></div>
    <div class="contenido">
        <?php #echo "<pre>"; print_r($postulantes); echo "</pre>"; ?>
        <!--<table id="resultados-generales">
            <tr>
                <th class="titulo-tabla">Postulantes En Proceso:</th>
                <td><?php echo $postulante[0]["en_proceso"] ?></td>
            </tr>
            <tr>
                <th class="titulo-tabla">Postulantes Pre-seleccionados:</th>
                <td><?php echo $postulante[0]["pre_seleccionado"] ?></td>
            </tr>
            <tr>
                <th class="titulo-tabla">Postulantes Seleccionados:</th>
                <td><?php echo $postulante[0]["seleccionado"] ?></td>
            </tr>
            <tr>
                <th class="titulo-tabla">Postulantes No Seleccionados:</th>
                <td><?php echo $postulante[0]["no_seleccionado"] ?></td>
            </tr>
        </table>-->
    <table>
        <tr>
            <th>Cédula</th>
            <th>Nombre Completo</th>
            <th>Cargo Postulado</th>
            <th>Profesion</th>
            <th>Categoría</th>
                
        </tr>
<?php foreach ($postulantes as $postulante): 
        if($postulante['estatus_p'] == "Seleccionado"):
    ?>        
        <tr>
            <td><?php echo $postulante['cedula'] ?></td>
            <td><?php echo $postulante['nombre_completo'] ?></td>
            <td><?php echo $postulante['cargo_postulado'] ?></td>
            <td><?php echo $postulante['profesion'] ?></td>
            <td><?php echo $postulante['categoria'] ?></td>
        </tr>
<?php
        endif;
      endforeach;?>
    </table>
    </div>
    
    <div class="subtitulo" id="sub-pre-seleccionado">Postulantes Pre-seleccionados
    <label>(<?php echo $_postulante[0]['pre_seleccionado'] ?>)</label></div>
    <div class="contenido">
    <table>
        <tr>
            <th>Cédula</th>
            <th>Nombre Completo</th>
            <th>Cargo Postulado</th>
            <th>Profesion</th>
            <th>Categoría</th>
                    
        </tr>
<?php foreach ($postulantes as $postulante): 
        if($postulante['estatus_p'] == "Pre Seleccionado" OR $postulante['estatus_p'] == "Pre-seleccionado"):
    ?>        
        <tr>
            <td><?php echo $postulante['cedula'] ?></td>
            <td><?php echo $postulante['nombre_completo'] ?></td>
            <td><?php echo $postulante['cargo_postulado'] ?></td>
            <td><?php echo $postulante['profesion'] ?></td>
            <td><?php echo $postulante['categoria'] ?></td>
        </tr>
<?php
        endif;
      endforeach;?>
    </table>
    </div>
        
    <div class="subtitulo" id="sub-no-seleccionado">Postulantes No Seleccionados 
        <label>(<?php echo $_postulante[0]['no_seleccionado'] ?>)</label></div>
    <div class="contenido">
    <table>
        <tr>
            <th>Cédula</th>
            <th>Nombre Completo</th>
            <th>Cargo Postulado</th>
            <th>Profesion</th>
            <th>Categoría</th>
                      
        </tr>
<?php foreach ($postulantes as $postulante): 
        if($postulante['estatus_p'] == "No Seleccionado" OR $postulante['estatus_p'] == "No-seleccionado"):
    ?>        
        <tr>
            <td><?php echo $postulante['cedula'] ?></td>
            <td><?php echo $postulante['nombre_completo'] ?></td>
            <td><?php echo $postulante['cargo_postulado'] ?></td>
            <td><?php echo $postulante['profesion'] ?></td>
            <td><?php echo $postulante['categoria'] ?></td>
        </tr>
<?php
        endif;
      endforeach;?>
    </table>
        <div class="subtitulo">TOTAL GENERAL DE POSTULANTES: <?php echo $_postulante[0]["total"]; ?> postulantes</div>
        <span>
            
        </span>
    </div>
</page>
    
