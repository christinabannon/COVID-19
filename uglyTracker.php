<html>
<head>
 <title>Tracker</title>
</head>
<body>
<?php
    	// connect to db
    	if (!include('../connect.php')){
	    die('error finding connect file');
    	}
    	$dbh = ConnectDB();
?>

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
</body>
</html>
