  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'House');
        data.addColumn('number', 'Users');

        
        <?php foreach ($house_total as $house): ?>
        data.addRows([
          ["<?= key($house) ?>", <?= $house[key($house)] ?>]
        ]);
        <?php endforeach ?>


        

        // Set chart options
        var options = {'title':'IMguru Users By House',
                       'width':400,
                       'height':300,
                      'is3D':true};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);


        // SECOND CHART

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Type');
        data.addColumn('number', 'Users');

        
      
        data.addRows([
          ["IMguru user", <?= $total ?>],
          ["Non-IMguru user"  , <?= 6700-$total ?> ]
        ]);
      


        

        // Set chart options
        var options = {'title':'School Usage of IMguru',
                       'width':400,
                       'height':300,
                      'is3D':true};

         // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
        chart.draw(data, options);



      }
    </script>
  </head>
<?php if (isset($_SESSION["name"])): ?>
  <?php include 'navigation.php';?>
  <h1 style="margin:0 0 20px 0;"> IMguru Data </h1>
<?php else: ?>
   <h1 style="margin:20px 0 20px 0;"> IMguru Data </h1>
<?php endif ?>
 
 


  <!--Div that will hold the pie chart-->
  <h4> Total Users: <?= $total ?></h4>
  <h4> Total games played: <?= $count_games ?> </h4>
  <div id="chart_div" style="display: inline-block;"></div>
  <div id="chart_div1" style="display: inline-block;"></div>









