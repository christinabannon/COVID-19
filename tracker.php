<!-- Christina Bannon, 2020 -->


<html>
<head>
 <title>Tracker</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
</head>
<body>


<?php	    	    
    	// connect to db
    	if (!include('../connect.php')){
	    die('error finding connect file');
    	}
    	$dbh = ConnectDB();
        $sql = "call getDatesCountsNJ();";
        $stmt = $dbh->prepare($sql);
	$stmt->execute();
?>

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
      data.addRows([
        [new Date(2020, 2, 14),  37.8, 80.8, 41.8],
        [new Date(2020, 2, 15),  30.9, 69.5, 32.4],
        [new Date(2020, 2, 16),  25.4,   57, 25.7]
      ]);
       */

      data.addRows([
<?php
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

<br> <br> <br>


<!-- New Cases since yesterday -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawNewCases);

    function drawNewCases() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Day');
      data.addColumn('number', 'New Cases');

      /*
      data.addRows([
        [new Date(2020, 2, 14),  37.8, 80.8, 41.8],
        [new Date(2020, 2, 15),  30.9, 69.5, 32.4],
        [new Date(2020, 2, 16),  25.4,   57, 25.7]
      ]);
       */

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
                        .$row['newCases']."]";
                if ($currentRow < $totalRows) {
                        echo ", ";
                }
        }
?>
      ]);
      var options = {
        chart: {
          title: 'New Coronavirus Cases in NJ',
          subtitle: 'New cases diagnosed per day'
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


<?php
	$sql = "call getDatesCountsNJ();";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
	echo '<table style="text-align:center">';
    	echo   "<tr>
		    <th> Date  </th>
		    <th> Number of  Current Cases </th>
    	   	</tr>";

	foreach ($stmt->fetchAll() as $row) {
	    echo "<tr>"; 
	    echo "<td>".$row['date']."</td>";
	    echo "<td>".$row['current']."</td>";
	    echo "</tr>";
	}
	
    	echo "</tr>";
	echo "</table>";
	echo "</p>";


?>

<?php
	/*
        $sql = "call getDatesCountsNJ();";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
	$countSoFar = 0;
	$totalCount = count($array);
	foreach($array as $row){
		echo $row['date']."   ";
		echo $row['current']."   ";
		echo $row['dead']."   ";
		echo $row['recovered']."   ";
		$countSoFar = $countSoFar + 1; 
		echo "<br>";
		echo $countSoFar." ";
		echo $totalCount;
		if ($countSoFar < $totalCount) {
			echo ",,,,,,";
		}
		echo "<br>";
	}
	 */
?>

</body>
</html>
