var $ = require("jquery");
var Highcharts = require('highcharts');
var d3 = require("d3");



var name = [];
var data1 = [];
var final = [];
$.getJSON('pie/2015', function(data) { 
  $.each(data, function (index, value) {
    name.push(String(value.name)); 
    data1.push(parseFloat(value.y));
  });
  for(var i=0; i < name.length; i++) {
    final.push({
      name: name[i],
      y: data1[i]       
    });      
  }  
  var name2 = [];
  var data2 = [];
  var final2 = [];
  $.getJSON('lastmonth', function(data) { 
    $.each(data, function (index, value) {
      name2.push(String(value.name)); 
      data2.push(parseFloat(value.y));
    });
    for(var i=0; i < name2.length; i++) {
      final2.push({
        name: name2[i],
        y: data2[i]       
      });      
    }

    Highcharts.chart('container', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Диаграмма продаж по типу билета'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: [{
        name: 'Процент',
        colorByPoint: true,
        data: final
      }]
    });

    Highcharts.chart('container1', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Диаграмма продаж по типу билета за последний месяц'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: [{
        name: 'Процент',
        colorByPoint: true,
        data: final2
      }]
    });
  });
});
$(document).ready(function(){
  $("#pie2015").click(function(){
    var name = [];
    var data1 = [];
    var final = [];
    $.getJSON('pie/2015', function(data) { 
      $.each(data, function (index, value) {
        name.push(String(value.name)); 
        data1.push(parseFloat(value.y));
      });
      for(var i=0; i < name.length; i++) {
        final.push({
          name: name[i],
          y: data1[i]       
        });      
      }  
      var name2 = [];
      var data2 = [];
      var final2 = [];
      $.getJSON('lastmonth', function(data) { 
        $.each(data, function (index, value) {
          name2.push(String(value.name)); 
          data2.push(parseFloat(value.y));
        });
        for(var i=0; i < name2.length; i++) {
          final2.push({
            name: name2[i],
            y: data2[i]       
          });      
        }
        Highcharts.chart('container', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Диаграмма продаж по типу билета за 2015'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Процент',
            colorByPoint: true,
            data: final
          }]
        });

        Highcharts.chart('container1', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Диаграмма продаж по кассиру за 2015'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Процент',
            colorByPoint: true,
            data: final2
          }]
        });



      });

    });

  });
});

$(document).ready(function(){
  $("#pie2016").click(function(){

    var name = [];
    var data1 = [];
    var final = [];
    $.getJSON('pie/2016', function(data) { 
      $.each(data, function (index, value) {
        name.push(String(value.name)); 
        data1.push(parseFloat(value.y));
      });
      for(var i=0; i < name.length; i++) {
        final.push({
          name: name[i],
          y: data1[i]       
        });      
      }  
      var name2 = [];
      var data2 = [];
      var final2 = [];

      $.getJSON('lastmonth', function(data) { 
        $.each(data, function (index, value) {
          name2.push(String(value.name)); 
          data2.push(parseFloat(value.y));
        });
        for(var i=0; i < name2.length; i++) {
          final2.push({
            name: name2[i],
            y: data2[i]       
          });      
        }

        Highcharts.chart('container', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Диаграмма продаж по типу билета за 2016'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Процент',
            colorByPoint: true,
            data: final
          }]
        });

        Highcharts.chart('container1', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Диаграмма продаж по кассиру за 2016'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Процент',
            colorByPoint: true,
            data: final2
          }]
        });
      });

    });
  });
});

$(document).ready(function(){
  $("#pie2017").click(function(){

    var name = [];
    var data1 = [];
    var final = [];
    $.getJSON('pie/2017', function(data) { 
      $.each(data, function (index, value) {
        name.push(String(value.name)); 
        data1.push(parseFloat(value.y));
      });
      for(var i=0; i < name.length; i++) {
        final.push({
          name: name[i],
          y: data1[i]       
        });      
      }  
      var name2 = [];
      var data2 = [];
      var final2 = [];

      $.getJSON('lastmonth', function(data) { 
        $.each(data, function (index, value) {
          name2.push(String(value.name)); 
          data2.push(parseFloat(value.y));
        });
        for(var i=0; i < name2.length; i++) {
          final2.push({
            name: name2[i],
            y: data2[i]       
          });      
        }

        Highcharts.chart('container', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Диаграмма продаж по типу билета за 2016'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Процент',
            colorByPoint: true,
            data: final
          }]
        });

        Highcharts.chart('container1', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Диаграмма продаж по кассиру за 2017'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Brands',
            colorByPoint: true,
            data: final2
          }]
        });

        Highcharts.chart('container2', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'За месяц'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Процент',
            colorByPoint: true,
            data: final
          }]
        });
      });
    });
  });
});

$(document).ready(function(){

  $("#lstmnth").click(function(){
   $("#stat").load("exelexplstmnth");
   $("#stat").fadeIn();
 });
  $("#alltime").click(function(){
   $("#stat").load("exelexpalltime");
   $("#stat").fadeIn();
 });
  $("#word_alltime").click(function(){
   $("#stat").load("wordexportalltime");
   $("#stat").fadeIn();
 });
  $("#word_lasttime").click(function(){
   $("#stat").load("wordexportlstmnth");
   $("#stat").fadeIn();
 });
  setInterval(function(){ 
    $("#stat").fadeOut(); 


  }, 3000);

});
