<?php
include('header.php');
?>
<script>
var today = new Date();
var lastMonth = new Date();
var nextMonth = new Date();
// day of week of month's first day
function getFirstDay(theYear, theMonth){
    var firstDate = new Date(theYear,theMonth,1)
    return firstDate.getDay()
}
// number of days in the month
function getMonthLen(theYear, theMonth) {
    return monLen[theMonth];
	/*
	var oneDay = 1000 * 60 * 60 * 24
    var thisMonth = new Date(theYear, theMonth, 1)
    var nextMonth = new Date(theYear, theMonth + 1, 1)
    var len = Math.ceil((nextMonth.getTime() - 
        thisMonth.getTime())/oneDay)
    return len
	*/
}
// create array of English month names
var theMonths = ["January","February","March","April","May","June","July","August",
"September","October","November","December"];
var monLen = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];


function populateTable(){
	populateTable2(today.getMonth(), today.getFullYear());
}

// clear and re-populate table based on form's selections
function populateTable2(month, year) {
	$("#tableBody").remove();
	$("#calendarTable").append('<tbody id="tableBody"></tbody>');
    var theMonth = month;
	var theYear = year;
	// initialize date-dependent variables
    var firstDay = getFirstDay(theYear, theMonth);
    var howMany = getMonthLen(theYear, theMonth);
    
	//console.debug(firstDay);
	//console.debug(howMany);
	var numRows  = Math.ceil((howMany+firstDay) / 7);
	
    $("#tableHeader").text(theMonths[theMonth] + " " + theYear);
	var i, j, counter = 1;
	var create = '';
	//init first line
	create += '<tr valign="top">';
	for(i = 0; i < firstDay; i++){
		create += '<td></td>';
	}
	for(j = i; j < 7; j++){
		create += '<td><b>' + counter + '</b><div style="padding-right: 4px; padding-left: 4px;" align="right">';
			create += '<div> food </div>';
			create += '<div> exercise </div>';
			/*
			<div style="padding-right: 4px; padding-left: 4px;" align="right">
										<div>
											
												<a href="/Diary.aspx?pa=fj&amp;dt=15034&amp;id=635514" title="edit">
													<span style="font-size: 10px;">Add Food</span>

												</a>
											
										</div>
										<div>
											
												<a href="/Diary.aspx?pa=aj&amp;dt=15034&amp;id=635514" title="edit">
													<span style="font-size: 10px;">Add Exercise</span>
												</a>
											
										</div>
										
									</div>
*/
			create += '</div></td>';
			counter ++;
	}
	create += '</tr>';
	
	//rest of the lines
	for(i = 1; i < numRows; i++){
		create += '<tr valign="top">';
		for(j = 0; j < 7; j++){
			create += '<td><b>' + counter + '</b><div style="padding-right: 4px; padding-left: 4px;" align="right">';
			create += '<div> food </div>';
			create += '<div> exercise </div>';
			/*
			<div style="padding-right: 4px; padding-left: 4px;" align="right">
										<div>
											
												<a href="/Diary.aspx?pa=fj&amp;dt=15034&amp;id=635514" title="edit">
													<span style="font-size: 10px;">Add Food</span>

												</a>
											
										</div>
										<div>
											
												<a href="/Diary.aspx?pa=aj&amp;dt=15034&amp;id=635514" title="edit">
													<span style="font-size: 10px;">Add Exercise</span>
												</a>
											
										</div>
										
									</div>
*/
			create += '</div></td>';
			counter ++;
			if(counter > howMany) break;
		}
		create += '</tr>';
	}
	$("#tableBody").append(create);
}
function incMonth(){
	today.setMonth(today.getMonth()+1);
	populateTable();
	initMonthLinks();
	
}
function decMonth(){
	today.setMonth(today.getMonth()-1);
	populateTable();
	initMonthLinks();
}
function initMonthLinks(){
	lastMonth.setMonth(today.getMonth()-1);
	nextMonth.setMonth(today.getMonth()+1);
	//$("#last_month").text("<<"+lastMonth.toDateString());
	//$("#next_month").text(nextMonth.toDateString()+">>");
}

	$(function() {
		initMonthLinks();
		populateTable();
	});
</script>
<div id="calendar-navi">
	<a id="last_month" href="javascript:decMonth()"></a>
	<h3 id="tableHeader"></h3>
	<a id="next_month" href="javascript:incMonth();"></a>
</div>

<table id="calendarTable" border=1 align="center">
	<tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th>
	<th>Thursday</th><th>Friday</th><th>Saturday</th></tr>
	<tbody id="tableBody"></tbody>
</table>

<?php
include('footer.php');
?>