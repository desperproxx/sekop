var $ = require("jquery");
var Highcharts = require('highcharts');
var d3 = require("d3");

var transport = new Array();
var transport2 = new Array();
var transport3 = new Array();
var transport4 = new Array();

$.getJSON('transportjson/2015', function(data) { 
  $.each(data, function (index, value) {
            transport.push([value.name, parseFloat(value.sum)]);       // PUSH THE VALUES INSIDE THE ARRAY.
          });
  $.getJSON('transportjson/2016', function(data) { 
    $.each(data, function (index, value) {
      transport2.push([value.name, parseFloat(value.sum)]);       
    });
    $.getJSON('transportjson/2017', function(data) { 
      $.each(data, function (index, value) {
        transport3.push([value.name, parseFloat(value.sum)]);      
      });
      $.getJSON('transportjson/lstmnth', function(data) { 
        $.each(data, function (index, value) {
          transport4.push([value.name, parseFloat(value.sum)]);     
        });
        Highcharts.chart('barchart', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'График продаж за 2015'
          },
          xAxis: {
            type: 'category',
            labels: {
              rotation: -45,
              style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
              }
            }
          },
          yAxis: {
            min: 10000,
            title: {
              text: 'Кол-во'
            }
          },
          legend: {
            enabled: false
          },
          tooltip: {
            pointFormat: 'Кол-во проданных билетов: <b>{point.y:.1f}</b>'
          },
          plotOptions: {
            column: {
              color: '#186ef4',
            }
          },
          series: [{
            name: 'Population',
            data: transport,
            dataLabels: {
              enabled: true,
              rotation: -90,
              align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 20, // 10 pixels down from the top
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        }]
      });

        Highcharts.chart('barchart1', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'График продаж за 2016'
          },
          xAxis: {
            type: 'category',
            labels: {
              rotation: -45,
              style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
              }
            }
          },
          yAxis: {
            min: 10000,
            title: {
              text: 'Кол-во'
            }
          },
          legend: {
            enabled: false
          },
          tooltip: {
            pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
          },
          plotOptions: {
            column: {
              color: '#15bf88',
            }
          },
          series: [{
            name: 'Population',
            data: transport2,
            dataLabels: {
              enabled: true,
              rotation: -90,
              align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 20, // 10 pixels down from the top
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        }]
      });

        Highcharts.chart('barchart2', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'График продаж за 2017'
          },
          xAxis: {
            type: 'category',
            labels: {
              rotation: -45,
              style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
              }
            }
          },
          yAxis: {
            min: 10000,
            title: {
              text: 'Кол-во'
            }
          },
          legend: {
            enabled: false
          },
          tooltip: {
            pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
          },
          plotOptions: {
            column: {
              color: '#af24d2',
            }
          },
          series: [{
            name: 'Population',
            data: transport3,
            dataLabels: {
              enabled: true,
              rotation: -90,
              align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 20, // 10 pixels down from the top
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        }]
      });

        Highcharts.chart('barchart3', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'График продаж за последний месяц'
          },
          xAxis: {
            type: 'category',
            labels: {
              rotation: -45,
              style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
              }
            }
          },
          yAxis: {
            min: 10000,
            title: {
              text: 'Кол-во'
            }
          },
          legend: {
            enabled: false
          },
          tooltip: {
            pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
          },
          plotOptions: {
            column: {
              color: '#d4424f',
            }
          },
          series: [{
            name: 'Population',
            data: transport4,
            dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#d4424f',
              align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 20, // 10 pixels down from the top
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        }]
      });
      });
});
});
});



