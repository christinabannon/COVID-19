<!-- Christina Bannon, 2020 -->


<html>
<head>
 <title>Tracker</title>

    <!-- Google charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Bootstrap's required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body>

<?php	    	    
    	// connect to db
    	if (!include('../connect.php')){
	    die('error finding connect file');
    	}
    	$dbh = ConnectDB();
?>

<div class="jumbotron text-center">
  <h2> NJ Coronavirus Tracker </h2>
</div>

<!-- Current totals chart -->
<div class="container">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Day');
      data.addColumn('number', 'Current Cases');
      data.addColumn('number', 'Recovered Cases');
      data.addColumn('number', 'Deaths');

      /*
      format: 
      data.addRows([
        [new Date(2020, 2, 14),  37.8, 80.8, 41.8],
        [new Date(2020, 2, 15),  30.9, 69.5, 32.4],
        [new Date(2020, 2, 16),  25.4,   57, 25.7]
      ]);
       */
      data.addRows([
<?php
  $sql = "call getDatesCountsNJ();";
  $stmt = $dbh->prepare($sql);
	$stmt->execute();
	$resultSet = $stmt->fetchAll();
	$totalRows = count($resultSet);
	$currentRow = 1;
        foreach ($resultSet as $row) {
                echo "[ new Date(".$row['date']."), "
			.$row['current'].", "
			.$row['recovered'].", "
			.$row['dead']."]";
		if ($currentRow < $totalRows) {
			echo ", ";
		}
	}
?>
      ]);

      var options = {
        chart: {
          title: 'Coronavirus Cases in NJ',
          subtitle: 'current, recovered and dead'
        },
        width: 900,
        height: 500,
        axes: {
          x: {
            0: {side: 'bottom'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));
      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>

  <div id="line_top_x"></div>
</div>

<br> 
<br> 
<br>


<!-- New Cases since yesterday chart -->
<div class="container">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawNewCases);

    function drawNewCases() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Day');
      data.addColumn('number', 'New Cases');
      data.addColumn('number', 'New Recoveries');
      data.addColumn('number', 'New Deaths');

      data.addRows([
<?php
        $sql = "call getNewCases();";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        $totalRows = count($resultSet);
        $currentRow = 1;
        foreach ($resultSet as $row) {
                echo "[ new Date(".$row['date']."), "
                        .$row['current'].", "
                        .$row['recovered'].", "
                        .$row['dead']."]";
                if ($currentRow < $totalRows) {
                        echo ", ";
                }
        }
?>
      ]);

      var options = {
        chart: {
          title: 'New Coronavirus Cases in NJ',
          subtitle: 'New cases diagnosed in the past day'
        },
        width: 900,
        height: 500,
        axes: {
          x: {
            0: {side: 'bottom'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('NewCases'));
      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>

  <div id="NewCases"></div>
</div>

<br> <br> <br> 
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" 
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
  crossorigin="anonymous"></script>
</body>
</html>
