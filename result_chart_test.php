<!DOCTYPE HTML>
<html>
	<head>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/data.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
	</head>

	<script type="text/javascript">
		Highcharts.getJSON(
			'result.json',
			function (data) {

				Highcharts.chart('container', {
					chart: {
						zoomType: 'x'
					},
					title: {
						text: 'USD to EUR exchange rate over time'
					},
					subtitle: {
						text: document.ontouchstart === undefined ?
							'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
					},
					xAxis: {
						type: 'datetime'
					},
					yAxis: {
						title: {
							text: 'Exchange rate'
						}
					},
					legend: {
						enabled: false
					},
					plotOptions: {
						area: {
							fillColor: {
								linearGradient: {
									x1: 0,
									y1: 0,
									x2: 0,
									y2: 1
								},
								stops: [
									[0, Highcharts.getOptions().colors[0]],
									[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
								]
							},
							marker: {
								radius: 2
							},
							lineWidth: 1,
							states: {
								hover: {
									lineWidth: 1
								}
							},
							threshold: null
						}
					},

					series: [{
						type: 'area',
						name: 'USD to EUR',
						data: data
					}]
				});
			}
		);
	</script>
	</head>
	<body>

		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
