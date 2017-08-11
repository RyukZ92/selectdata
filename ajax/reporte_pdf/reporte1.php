<?php
session_start();
require_once '../config.php';
require_once '../class/dbPdo.php';
require_once '../class/crud.php';
$objetoCrud = new Crud;
$datos = array("count(*) as total",
"(SELECT count(*) FROM estatus_postulacion WHERE estatus = 'En Proceso') as en_proceso",
"(SELECT count(*) FROM estatus_postulacion WHERE estatus = 'Pre Seleccionado') as pre_seleccionado",
"(SELECT count(*) FROM estatus_postulacion WHERE estatus = 'Seleccionado') as seleccionado",
"(SELECT count(*) FROM estatus_postulacion WHERE estatus = 'No Seleccionado') as no_seleccionado");
$tabla = "estatus_postulacion";
$condicion = " estatus != 'En Proceso'";
$_postulante = $objetoCrud->consultar($tabla, $datos, $condicion);

$tablas = "datos_personales dp JOIN curriculo c ON dp.id = c.id "
        . "JOIN estatus_postulacion ep ON c.id = ep.curriculo";

$datos = array("dp.*",
    "CONCAT(nombre,' ',apellido) as nombre_completo", "profesion", "categoria", 
    "ep.estatus as estatus_p", "cargo_postulado");
$postulantes = $objetoCrud->consultar($tablas, $datos);
ob_start();

    include "reporte1_html.php";
    $contenido = ob_get_clean();
    if(date('a') == 'PM') {
        $pm = 'p.m.';
    } else {
        $pm = 'a.m.';
    }
    $salida = "reporte_de_postulantes_".date('d-m-Y')."_".date('h-i-s-a').".pdf";
    
ob_clean();
try {
    require_once "html2pdf-4.4.0/html2pdf.class.php";
    $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 10);
    $html2pdf->setDefaultFont('Arial');    
    $html2pdf->pdf->SetAuthor('Jośe Miguel Seijas');
    $html2pdf->pdf->SetTitle('Resumen de Postulantes');
    $html2pdf->pdf->SetSubject('Reporte');
    //$html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($contenido, isset($_GET['vuehtml']));
    $html2pdf->Output($salida);
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
