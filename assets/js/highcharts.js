var $ = require("jquery");
require('bootstrap-sass');
var Highcharts = require('highcharts');
var d3 = require("d3");


var data1  = new Array(); 
var data2  = new Array();
var data3  = new Array();
var data4  = new Array();
var data5  = new Array();
var data6  = new Array();
var processed_json = new Array();  
var xhttp = new XMLHttpRequest();
var txt = "";
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.responseText);
       //d3.select('body').select('p').text(myObj[1]);
       for (x in myObj) {
         data1.push([myObj[x].txn_year, parseFloat(myObj[x].monthly_sum)]);
       }

       $.getJSON('jsonformation/2016', function(data) { 
         $.each(data, function (index, value) {

            data2.push([value.txn_year, parseFloat(value.monthly_sum)]);       // PUSH THE VALUES INSIDE THE ARRAY.
          });
         $.getJSON('jsonformation/2017', function(data) { 
           $.each(data, function (index, value) {
            if(value.monthly_sum>400000)
             value.monthly_sum=365000;
            data6.push([value.txn_year, parseFloat(value.monthly_sum)]);       // PUSH THE VALUES INSIDE THE ARRAY.
          });
           $(document).ready(function() {
             Highcharts.chart('overview', {
               chart: {

                 defaultSeriesType: 'spline'
               },
               title: {
                text: 'Динамика роста количества проданных билетов по годам'
              },
              xAxis: {
                categories: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']
              },
              yAxis: {
               labels: {
                formatter: function () {
                  return Highcharts.numberFormat(this.value,0);
                }
              },
              min: 320000, max: 380000
            },
            plotOptions: {
              line: {
                dataLabels: {
                 enabled: false
               },
               enableMouseTracking: true
             }
           },
           series: [{
            name: 'Динамика изменения за 2015 год',
            data: data1,
          },{
            name: 'Динамика изменения за 2016 год',
            data: data2,
            visible: false
          },{
            name: 'Динамика изменения за 2017 год',
            data: data6,
          }]				
        });
           });	
         });	
       });

     }
   };
   xhttp.open("GET", "jsonformation/2015", true);
   xhttp.send();

   /*------------------------------------------------------------------------------------------------------------------------*/


   var i = 0;
   var mm1;
   var mm2;
   var con = "";
   var months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
   $(".button2").click(function(){


    con = con+" "+$(this).text();

    if(i<=2){
      $(this).css('margin-left', '40px')
      .css('transition-duration', '1s')
      .css('color', 'rgb(255,255,255)')
      .css('width', '78px')
      .css('text-align','center')
      .css('background', 'rgb(24,110,244)')
      .css('opacity','1')
      .css('border-radius','100px');
      i++;
    }
    if(i>=2){

      con = con.trim();
      var arr = con.split(' ',2);
      var m1 = arr[0];
      var m2 = arr[1];

      months.forEach(function(item, index) {
        if(item==m1){
         mm1 = index+1;
       } 
     });
      months.forEach(function(item, index) {
        if(item==m2){
         mm2 = index+1;
       }
     });
   if(i>2){
     location.reload();
   }
    document.getElementById("button3").disabled = false;
 }

});


var copy = [];
$(document).ready(function(){
  $("#button3").click(function(){
   $('.button2').css('margin-left', '0')
   .css('text-align','left')
   .css('transition-duration', '1s')
   .css('color', 'blue')
   .css('opacity','.7')
   .css('background', 'white');

   months.forEach(function(item, index) {
     index++;
     if(index>=mm1 && index<= mm2)
       copy.push(item);

   });
        var url = "jsonformation/2015/"+mm1+"/"+mm2;
        var url2 = "jsonformation/2016/"+mm1+"/"+mm2;
        var url3 = "jsonformation/2017/"+mm1+"/"+mm2;
        var xhttp = new XMLHttpRequest();
        var txt = "";
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
       //d3.select('body').select('p').text(myObj[1]);
       for (x in myObj) {
         data3.push([myObj[x].txn_year, parseFloat(myObj[x].monthly_sum)]);
       }

       $.getJSON(url2, function(data) { 
         $.each(data, function (index, value) {
            data4.push([value.txn_year, parseFloat(value.monthly_sum)]);       // PUSH THE VALUES INSIDE THE ARRAY.
          });
         $.getJSON(url3, function(data) { 
           $.each(data, function (index, value) {
            if(value.monthly_sum>400000)
             value.monthly_sum=365000;
            data5.push([value.txn_year, parseFloat(value.monthly_sum)]);       // PUSH THE VALUES INSIDE THE ARRAY.
          });
           $(document).ready(function() {
             Highcharts.chart('overview', {
               chart: {
                 defaultSeriesType: 'spline'
               },
               title: {
                text: 'Динамика роста количества проданных билетов по годам'
              },
              xAxis: {
                categories: copy,
              },
              yAxis: {
               labels: {
                formatter: function () {
                  return Highcharts.numberFormat(this.value,0);
                }
              },
              min: 320000, max: 380000
            },
            plotOptions: {
              line: {
                dataLabels: {
                 enabled: true
               },
               enableMouseTracking: false
             }
           },
           series: [{
            name: 'Динамика изменения за 2015 год',
            data: data3,
          },{
            name: 'Динамика изменения за 2016 год',
            data: data4,
            visible: false
          },{
            name: 'Динамика изменения за 2017 год',
            data: data5,
          }]				
        });
           });	
         });
       });
     }
   };
   xhttp.open("GET", url, true);
   xhttp.send();

 });
});

/*-------------------------------------------------------------------------------------------------------*/
