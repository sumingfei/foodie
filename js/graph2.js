var chart;
$(document).ready(function() {

	// define the options
	var options = {
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'spline'
		},
		title: {
			text: 'Monthly Average Temperature in Tokyo'
		},
		subtitle: {
			text: 'Source: WorldClimate.com'
		},
		xAxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
				'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
		},
		yAxis: {
			title: {
				text: 'Temperature (°„C)'
			}
		},
		legend: {
			enabled: false
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					this.x +': '+ this.y +'°„C';
			}
		},
		plotOptions: {
			spline: {
				cursor: 'pointer',
				point: {
					events: {
						click: function() {
							hs.htmlExpand(null, {
								pageOrigin: {
									x: this.pageX, 
									y: this.pageY
								},
								headingText: this.series.name,
								maincontentText: 'this.category: '+ this.category +
									'<br/>this.y: '+ this.y,
								width: 200
							});
						}
					}
				}
			}
		},
		series: []
	}
	
	// Load data asynchronously using jQuery. On success, add the data
	// to the options and initiate the chart.
	// http://api.jquery.com/jQuery.getJSON/
	jQuery.getJSON('tokyo.json', null, function(data) {
		options.series.push({
			name: 'Tokyo',
			data: data
		});
		
		chart = new Highcharts.Chart(options);
	});
	
});
