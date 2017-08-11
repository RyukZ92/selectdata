<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta charset="utf-8">
<title></title>
<meta name ="author" content ="Norfi Carrodeguas">
<script src="Chart.js"></script>
</head>
<body>  	    <center>  
<h3>Postulantes</h3><br>


<div id="canvas-holder">

<canvas id="chart-area" width="300" height="300"></canvas>
    </center>
<!--
<canvas id="chart-area2" width="300" height="300"></canvas>
<canvas id="chart-area3" width="600" height="300"></canvas>
<canvas id="chart-area4" width="600" height="300"></canvas>-->
</div>

<script>
var pieData = [ {
                    value: 40,
                    color:"#0b82e7",
                    highlight: "#0c62ab",
                    label: "En Proceso"},
                {
                        value: 16,
                        color: "#e3e860",
                        highlight: "#a9ad47",
                        label: "Pre Seleccionados"
                },
                {
                        value: 11,
                        color: "#eb5d82",
                        highlight: "#b74865",
                        label: "No Seleccionados"
                },
                {
                        value: 10,
                        color: "#5ae85a",
                        highlight: "#42a642",
                        label: "Seleccionados"
                },/*
                {
                        value: 8.6,
                        color: "#e965db",
                        highlight: "#a6429b",
                        label: "Safari"
                }*/
        ];

	/*var barChartData = {
		labels : ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio"],
		datasets : [
			{
				fillColor : "#6b9dfa",
				strokeColor : "#ffffff",
				highlightFill: "#1864f2",
				highlightStroke: "#ffffff",
				data : [90,30,10,80,15,5,15]
			},
			{
				fillColor : "#e9e225",
				strokeColor : "#ffffff",
				highlightFill : "#ee7f49",
				highlightStroke : "#ffffff",
				data : [40,50,70,40,85,55,15]
			}
		]

	}	
		var lineChartData = {
			labels : ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio"],
			datasets : [
				{
					label: "Primera serie de datos",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "#6b9dfa",
					pointColor : "#1e45d7",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [90,30,10,80,15,5,15]
				},
				{
					label: "Segunda serie de datos",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "#e9e225",
					pointColor : "#faab12",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [40,50,70,40,85,55,15]
				}
			]

		}*/
var ctx = document.getElementById("chart-area").getContext("2d");
/*var ctx2 = document.getElementById("chart-area2").getContext("2d");
var ctx3 = document.getElementById("chart-area3").getContext("2d");
var ctx4 = document.getElementById("chart-area4").getContext("2d");*/
window.myPie = new Chart(ctx).Pie(pieData);	
/*
window.myPie = new Chart(ctx2).Doughnut(pieData);				
window.myPie = new Chart(ctx3).Bar(barChartData, {responsive:true});
window.myPie = new Chart(ctx4).Line(lineChartData, {responsive:true});
*/
</script>
</center>
</body>
</html>

