
<?php 
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
$condicion = "";
$postulante = $objetoCrud->consultar($tabla, $datos);


?>
<input type="hidden" id="seleccionado" value="<?php echo $postulante[0]['seleccionado'] ?>">
<input type="hidden" id="no-seleccionado" value="<?php echo $postulante[0]['no_seleccionado'] ?>">
<input type="hidden" id="pre-seleccionado" value="<?php echo $postulante[0]['pre_seleccionado'] ?>">
<input type="hidden" id="en-proceso" value="<?php echo $postulante[0]['en_proceso'] ?>">
        
        
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title></title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script src="amcharts/amcharts.js" type="text/javascript"></script>
        <script src="amcharts/pie.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            var seleccionado = document.getElementById('seleccionado').value;
            var no_seleccionado = document.getElementById('no-seleccionado').value;
            var pre_seleccionado = document.getElementById('pre-seleccionado').value;
            var en_proceso = document.getElementById('en-proceso').value;
            
            
            var chart;
            var legend;

            var chartData = [
                {
                    "tipo": "Seleccionados",
                    "cantidad": seleccionado
                },
                {
                    "tipo": "No Seleccionados",
                    "cantidad": no_seleccionado
                },
                {
                    "tipo": "Pre-seleccionado",
                    "cantidad": pre_seleccionado
                },
                {
                    "tipo": "En Proceso",
                    "cantidad": en_proceso
                }
            ];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "tipo";
                chart.valueField = "cantidad";

                // LEGEND
                legend = new AmCharts.AmLegend();
                legend.align = "center";
                legend.markerType = "circle";
                chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                chart.addLegend(legend);

                // WRITE
                chart.write("chartdiv");
            });

            // changes label position (labelRadius)
            function setLabelPosition() {
                if (document.getElementById("rb1").checked) {
                    chart.labelRadius = 30;
                    chart.labelText = "[[title]]: [[value]]";
                } else {
                    chart.labelRadius = -30;
                    chart.labelText = "[[percents]]%";
                }
                chart.validateNow();
            }


            // makes chart 2D/3D                   
            function set3D() {
                if (document.getElementById("rb3").checked) {
                    chart.depth3D = 10;
                    chart.angle = 10;
                } else {
                    chart.depth3D = 0;
                    chart.angle = 0;
                }
                chart.validateNow();
            }

            // changes switch of the legend (x or v)
            function setSwitch() {
                if (document.getElementById("rb5").checked) {
                    legend.switchType = "x";
                } else {
                    legend.switchType = "v";
                }
                legend.validateNow();
            }
        </script>
    </head>
    
    <body>

    <center><h3>Resumen de Estadísticas de los Postulantes</h3></center>
        <div id="chartdiv" style="width: 50%; height: 400px; margin:auto;"></div>
        <table align="center" cellspacing="20">
            <tr>
                <!--<td>
                    <input type="radio" checked="true" name="group" id="rb1" onclick="setLabelPosition()">labels outside
                    <input type="radio" name="group" id="rb2" onclick="setLabelPosition()">labels inside
                </td>-->
                <td>Tipo de vista
                    <input type="radio" name="group2" id="rb3" onclick="set3D()">3D
                    <input type="radio" checked="true" name="group2" id="rb4" onclick="set3D()">2D
                </td>
                <!--<td>Legend switch type:
                    <input type="radio" checked="true" name="group3" id="rb5"
                    onclick="setSwitch()">x
                    <input type="radio" name="group3" id="rb6" onclick="setSwitch()">v
                </td>-->
            </tr>
        </table>
    </body>

</html>
