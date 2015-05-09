<?php
	/* Written by:  Kanav Tahilramani and Omar Warraky
 	* Debugged by: Kanav Tahilramani and Omar Warraky
 	* Tested by:   Kanav Tahilramani and Omar Warraky
 	*/
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="http://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
	<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<script src="jquery-1.11.2.js"></script>
<?php
	echo '<div id="logo" align="left" style="margin-left:3em;margin-top:1em"><span>Welcome <strong> ' . $_SESSION['username'] . '</strong>.</span></div>';
?>

<div class="menu" align="left">
	<ul>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="schedule.php">Schedule</a></li>
	</ul>
</div>

<div class="upcoming" align="center">
	<h1 id="mainup">Upcoming Shifts</h1>

<?php
	// here, we display the upcoming shifts for the user currently logged in. 
	// printShifts gets the currrent day of the week and shows all upcoming shifts for the week depending on the ID set.
	$hours = 0;
	printShifts($hours);

    function printShifts(&$hours) {
    	$server="localhost"; // Server
		$sqluser="root";
		$sqlpw="";
		$sqldb="foodezwo_shifts"; // Database
		$connection = mysqli_connect($server, $sqluser, $sqlpw, $sqldb);
		$hourTable = '';

    	date_default_timezone_set('America/New_York');
		$hourDate = date('N');

		setDay($hourDate, $hourTable);

	    while ($hourDate < 7) {
	    	$request = "SELECT * FROM $hourTable WHERE id=" . $_SESSION['idn'];
			$result = mysqli_query($connection, $request);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

			if ($row['user0'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$currentDay = date('l, M j, Y', strtotime($currentDate));
				echo '<p id="upcome">'.$currentDay.' - 12:00 PM to 3:00 PM<br><br></p>';
				$hours += 3;
			}

			if ($row['user1'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$currentDay = date('l, M j, Y', strtotime($currentDate));
				echo '<p id="upcome">'.$currentDay.' - 3:00 PM to 6:00 PM<br><br></p>';
				$hours += 3;
			}

			if ($row['user2'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$currentDay = date('l, M j, Y', strtotime($currentDate));
				echo '<p id="upcome">'.$currentDay.' - 6:00 PM to 9:00 PM<br><br></p>';
				$hours += 3;
			}

			if ($row['user3'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$currentDay = date('l, M j, Y', strtotime($currentDate));
				echo '<p id="upcome">'.$currentDay.' - 9:00 PM to 12:00 AM<br><br></p>';
				$hours += 3;
			}

			$hourDate++;
			setDay($hourDate, $hourTable);
	    }
    }

    // sets the $table according to the day of the week
    function setDay($num, &$table) {
    	switch ($num) {
	        case 1:
	            $table = "monday";
	            break;
	        case 2:
	        	$table = "tuesday";
	            break;
	        case 3:
	        	$table = "wednesday";
	            break;
	        case 4:
	        	$table = "thursday";
	            break;
	        case 5:
	        	$table = "friday";
	            break;
	        case 6:
	        	$table = "saturday";
	            break;
	        case 7:
	        	$table = "sunday";
	            break;
	    }
    }
?>

</body>
</html>

