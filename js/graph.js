Highcharts.visualize = function(table, options) {
	// the categories
	options.xAxis.categories = [];
	$('tbody th', table).each( function(i) {
		options.xAxis.categories.push(this.innerHTML);
	});
	
	// the data series
	options.series = [];
	$('tr', table).each( function(i) {
		var tr = this;
		$('th, td', tr).each( function(j) {
			if (j > 0) { // skip first column
				if (i == 0) { // get the name and init the series
					options.series[j - 1] = { 
						name: this.innerHTML,
						data: []
					};
				} else { // add values
					options.series[j - 1].data.push(parseFloat(this.innerHTML));
				}
			}
		});
	});
	
	var chart = new Highcharts.Chart(options);
}
	
// On document ready, call visualize on the datatable.
$(document).ready(function() {			
	var table = document.getElementById('datatable2'),
	options = {
		   chart: {
			  renderTo: 'container',
			  defaultSeriesType: 'spline'
		   },
		   title: {
			  text: ''
		   },
		   xAxis: {
		   },
		   yAxis: {
			  title: {
				 text: 'Units'
			  }
		   },
		   tooltip: {
			  formatter: function() {
				 return '<b>'+ this.series.name +'</b><br/>'+
					this.y +' '+ this.x.toLowerCase();
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
					}
		};
				
	Highcharts.visualize(table, options);
});