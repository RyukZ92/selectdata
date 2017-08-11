<HTML>
	<head>
		<meta charset='utf8'>
		<title>Gráficas c3</title>
		<link href="c3-0.4.11/c3.css" rel="stylesheet" type="text/css">
		<script src="jquery-2.2.3.min.js" charset="utf-8"></script>
		<!-- Load d3.js and c3.js -->
		<script src="d3.min.js" charset="utf-8"></script>
		<script src="c3-0.4.11/c3.min.js"></script>

	</head>
	<body>
	Gráfica
	<div id="chart"></div>
		<script type="text/javascript">

		var auto_1 = ['camion', 1,4,5,0.5];
		var chart = c3.generate({
		    bindto: '#chart',
		    data: {
		      columns: [
		        auto_1
		      ]
		    }
		});
	  var nodes = [
	        {id: 1, label: 'Node 1'},
	        {id: 2, label: 'Node 2'},
	        {id: 3, label: 'Node 3'},
	        {id: 4, label: 'Node 4'},
	        {id: 5, label: 'Node 5'}
	    ];
	    for (var i in nodes) {
	    	console.log(nodes[i]['id'] + ' - ' + nodes[i]['label']);
	    }

		</script>



	</body>
</HTML>