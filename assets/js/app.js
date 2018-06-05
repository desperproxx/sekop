var $ = require("jquery");
require('bootstrap-sass');
var d3 = require("d3");

$(".qwerty").click(function(){
	var paragraph = $(this).text();
  //alert(paragraph);
  $('.tabs').css('margin-left', '100px')
  .css('transition-duration', '1s');
  $('.period').css('opacity','1')
  .css('transition-duration', '1s');
  $(".period").load("jsonkassperiod/"+paragraph);
});

(function($){				
	jQuery.fn.lightTabs = function(options){

		var createTabs = function(){
			tabs = this;
			i = 0;

			showPage = function(i){
				$(tabs).children("div").children("div").hide();
				$(tabs).children("div").children("div").eq(i).show();
				$(tabs).children("ul").children("li").removeClass("active");
				$(tabs).children("ul").children("li").eq(i).addClass("active");
			}

			showPage(0);				

			$(tabs).children("ul").children("li").each(function(index, element){
				$(element).attr("data-page", i);
				i++;                        
			});

			$(tabs).children("ul").children("li").click(function(){
				showPage(parseInt($(this).attr("data-page")));
			});				
		};		
		return this.each(createTabs);
	};	
})(jQuery);
$(document).ready(function(){
	$(".tabs").lightTabs();
});

$(document).ready(function(){
	$("#button").click(function(){
		$("body").load("2015");
	});
});
$(document).ready(function(){
	$("#button1").click(function(){
		$("body").load("2016");
	});
});
$(document).ready(function(){
	$("#button2").click(function(){
		$("body").load("2017");
	});
});

$(".menu-wrapper").click(function(e) {
	e.preventDefault();
	$("#wrapper").toggleClass("toggled");
});

(function () {
	$('.menu-wrapper').on('click', function() {
		$('.hamburger-menu').toggleClass('animate');
	})
})();

$(document).ready(function() {
	createGraph('#data-table', '.chart');
	function createGraph(data, container) {
		var bars = [];
		var figureContainer = $('<div id="figure"></div>');
		var graphContainer = $('<div class="graph"></div>');
		var barContainer = $('<div class="bars"></div>');
		var data = $(data);
		var container = $(container);
		var chartData;		
		var chartYMax;
		var columnGroups;
		var barTimer;
		var graphTimer;
		var tableData = {
			chartData: function() {
				var chartData = [];
				data.find('tbody td').each(function() {
					chartData.push($(this).text());
				});
				return chartData;
			},
			chartHeading: function() {
				var chartHeading = data.find('caption').text();
				return chartHeading;
			},
			// Get legend data from table body
			chartLegend: function() {
				var chartLegend = [];
				data.find('tbody th').each(function() {
					chartLegend.push($(this).text());
				});
				return chartLegend;
			},
			chartYMax: function() {
				var chartData = this.chartData();
				var chartYMax = Math.ceil(Math.max.apply(Math, chartData) / 1000) * 1000;
				return chartYMax;
			},
			yLegend: function() {
				var chartYMax = this.chartYMax();
				var yLegend = [];
				var yAxisMarkings = 5;						
				for (var i = 0; i < yAxisMarkings; i++) {
					yLegend.unshift(((chartYMax * i) / (yAxisMarkings - 1)) / 1000);
				}
				return yLegend;
			},
			xLegend: function() {
				var xLegend = [];
				data.find('thead th').each(function() {
					xLegend.push($(this).text());
				});
				return xLegend;
			},
			columnGroups: function() {
				var columnGroups = [];
				var columns = data.find('tbody tr:eq(0) td').length;
				for (var i = 0; i < columns; i++) {
					columnGroups[i] = [];
					data.find('tbody tr').each(function() {
						columnGroups[i].push($(this).find('td').eq(i).text());
					});
				}
				return columnGroups;
			}
		}

		chartData = tableData.chartData();		
		chartYMax = tableData.chartYMax();
		columnGroups = tableData.columnGroups();
		$.each(columnGroups, function(i) {
			var barGroup = $('<div class="bar-group"></div>');
			for (var j = 0, k = columnGroups[i].length; j < k; j++) {
				var barObj = {};
				barObj.label = this[j];
				barObj.height = Math.floor(barObj.label / chartYMax * 100) + '%';
				barObj.bar = $('<div class="bar fig' + j + '"><span>' + barObj.label + '</span></div>')
				.appendTo(barGroup);
				bars.push(barObj);
			}
			barGroup.appendTo(barContainer);			
		});
		var chartHeading = tableData.chartHeading();
		var heading = $('<h4>' + chartHeading + '</h4>');
		heading.appendTo(figureContainer);
		var chartLegend	= tableData.chartLegend();
		var legendList	= $('<ul class="legend"></ul>');
		$.each(chartLegend, function(i) {			
			var listItem = $('<li><span class="icon fig' + i + '"></span>' + this + '</li>')
			.appendTo(legendList);
		});
		legendList.appendTo(figureContainer);
		var xLegend	= tableData.xLegend();		
		var xAxisList	= $('<ul class="x-axis"></ul>');
		$.each(xLegend, function(i) {			
			var listItem = $('<li><span>' + this + '</span></li>')
			.appendTo(xAxisList);
		});
		xAxisList.appendTo(graphContainer);
		var yLegend	= tableData.yLegend();
		var yAxisList	= $('<ul class="y-axis"></ul>');
		$.each(yLegend, function(i) {			
			var listItem = $('<li><span>' + this + '</span></li>')
			.appendTo(yAxisList);
		});
		yAxisList.appendTo(graphContainer);		
		barContainer.appendTo(graphContainer);		
		graphContainer.appendTo(figureContainer);
		figureContainer.appendTo(container);
		function displayGraph(bars, i) {		
			if (i < bars.length) {
				$(bars[i].bar).animate({
					height: bars[i].height
				}, 800);
				barTimer = setTimeout(function() {
					i++;				
					displayGraph(bars, i);
				}, 20);
			}
		}
		function resetGraph() {
			$.each(bars, function(i) {
				$(bars[i].bar).stop().css('height', 0);
			});
			clearTimeout(barTimer);
			clearTimeout(graphTimer);
			graphTimer = setTimeout(function() {		
				displayGraph(bars, 0);
			}, 100);
		}
		$('#reset-graph-button').click(function() {
			resetGraph();
			return false;
		});
		resetGraph();
	}	
});