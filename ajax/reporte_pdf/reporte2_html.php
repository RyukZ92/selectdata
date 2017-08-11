<?php include "reporte2_css.php"; #print_r($usuario);?>

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
    
        <div class="titulo">LISTADO DE USUARIOS DEL SISTEMA<hr></div>
   
    <div class="subtitulo">Usuarios registrados</div>
    <div class="contenido">
    <table>
        <tr>
            <th>Usuario</th>
            <th>Nombre Completo</th>
            <th>Nivel</th>
            <th>Estatus</th>
            <th>Registro</th>
                    
        </tr>
<?php foreach ($usuarios as $usuario): 
    if($usuario[estatus] == '1') {
        //$fondo = "style='background: green;'";
    } else {
        //$fondo = "style='background: red;'";
    }
       ?>
        <tr <?php echo $fondo ?>>
            <td><?php echo $usuario['username'] ?></td>
            <td><?php echo $usuario['nombre_completo'] ?></td>
            <td><?php echo $usuario['nivel'] == "Admin" ? "Administrador " : $usuario['nivel'] ?></td>
            <td><?php echo $usuario['estatus'] == '1' ? "Activo" : "Inactivo" ?></td>
            <td><?php echo formatoFecha($usuario['fecha_creacion']) ?></td>
        </tr>
<?php
        
      endforeach;?>
    </table>
  
        <div class="subtitulo">TOTAL: <?php echo count($usuarios) ?> usuarios</div>
        <span>
            
        </span>
    </div>
</page>
    
