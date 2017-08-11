<?php
session_start();
require_once '../config.php';
require_once '../class/dbPdo.php';
require_once '../class/crud.php';
require_once '../class/funciones.php';
$objetoCrud = new Crud;

$tablas = "datos_personales dp JOIN usuarios u ON dp.id = u.id ";

$datos = array("username", "nivel", "u.estatus", "fecha_creacion",
    "CONCAT(nombre,' ',apellido) as nombre_completo");
$usuarios = $objetoCrud->consultar($tablas, $datos);
ob_start();

    include "reporte2_html.php";
    $contenido = ob_get_clean();
 
    $salida = "reporte_de_usuarios_".date('d-m-Y')."_".date('h-i-s-a').".pdf";
    
ob_end_clean(); //Sustituye a "ob_clean()" para funcionar en el Hostinger 28/06/2017 2:00pm;
try {
    require_once "html2pdf-4.4.0/html2pdf.class.php";
    $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 10);
    $html2pdf->setDefaultFont('Arial');    
    $html2pdf->pdf->SetAuthor('Jośe Miguel Seijas');
    $html2pdf->pdf->SetTitle('Resumen de Postulantes');
    $html2pdf->pdf->SetSubject('Reporte');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($contenido, isset($_GET['vuehtml']));
    $html2pdf->Output($salida);
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
