google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.load('current', {'packages':['line']});
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawBasic);
function drawBasic() {
  if ($("#column-chart1").length > 0) {
    /*peticionAjax('POST', '', 'catalogos/inicio/obtenerInfoGrafica.php', function(response) {
          response = JSON.parse(response);
          if(response.success===1){
              var a = google.visualization.arrayToDataTable(response.info),
              b = {
                chart: {
                  title: "Desempeño de la compañía",
                  subtitle: "Pagos, Gastos, Creditos:"
                },
                bars: "vertical",
                vAxis: {
                  format: "decimal"
                },
                height: 400,
                width:'100%',
                colors: ["#FA5858", "#FA8258", "#C8FE2E","#58ACFA","#8258FA","#FA5882","#BDBDBD"]
              },
            c = new google.charts.Bar(document.getElementById("column-chart1"));
            c.draw(a, google.charts.Bar.convertOptions(b));
          }
      });*/
      cargando(1,'column-chart1');
      peticionAjax('POST', '', 'catalogos/inicio/obtenerInfoGrafica.php', function(response) {
        response = JSON.parse(response);
        cargando(0,'column-chart1');
        if(response.success===1){
      var data = google.visualization.arrayToDataTable(response.info);
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
        { calc: "stringify",
          sourceColumn: 1,
          type: "string",
          role: "annotation" 
        },
        2]);
      var options = {
        title: "Desempeño de la compañía",
        width:'100%',
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("column-chart1"));
      chart.draw(view, options);
   
    }
  });
  }
 
}
