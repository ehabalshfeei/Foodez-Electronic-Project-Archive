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
if (isset($_SESSION['username'])) { // makes sure employee is logged in and establishes the employee as a variable in this php session
	$currentUser = $_SESSION['username'];
}
else // if not logged in, we go to the login page
	header("location:index.html");

$server="localhost"; // Server
$sqluser="root"; // SQL user
$sqlpw=""; // SQL PW
$sqldb="foodezwo_shifts"; // Database

switch ($currentUser) { // depending on the user, we change the database to display the correct schedule details
	        case 'waiter1':
	            break;
	        case 'waiter2':
	            break;
	        case 'chef1':
	        	$sqldb = "foodezwo_shifts_chef";
	            break;
	        case 'chef2':
	        	$sqldb = "foodezwo_shifts_chef";
	            break;
	        case 'busboy1':
	        	$sqldb = "foodezwo_shifts_bb";
	            break;
	        case 'busboy2':
	        	$sqldb = "foodezwo_shifts_bb";
	            break;
}

$connection = mysqli_connect($server, $sqluser, $sqlpw, $sqldb); // make the connection to the database.

echo '<div id="logo" align="left" style="margin-left:3em;margin-top:1em"><span>Welcome <strong> ' . $currentUser . '</strong>.</span></div>'; // welcome header

date_default_timezone_set('America/New_York'); // set local time zone
$date = date('Y-m-d'); // initialize today's date as a var
$newDate = new DateTime($date); // make it a DateTime object for functionality and easier handling
$num = date('N', strtotime($date)); // get a number representation of today's day of the week
findSunday($newDate, $num); // get the current week by finding the last known Sunday - that sunday's date is stored in $newDate

// these lines of code work to store the dates for every day of THIS week (found by getting the local time) in their respectively named variables
$sunday = $newDate;
$monday = new DateTime($sunday->format('Y-m-d'));
$monday->add(new DateInterval('P1D'));
$tuesday = new DateTime($monday->format('Y-m-d'));
$tuesday->add(new DateInterval('P1D'));
$wednesday = new DateTime($tuesday->format('Y-m-d'));
$wednesday->add(new DateInterval('P1D'));
$thursday = new DateTime($wednesday->format('Y-m-d'));
$thursday->add(new DateInterval('P1D'));
$friday = new DateTime($thursday->format('Y-m-d'));
$friday->add(new DateInterval('P1D'));
$saturday = new DateTime($friday->format('Y-m-d'));
$saturday->add(new DateInterval('P1D'));

// formatted for easier readability and comparison in database
$currentSunday = $sunday->format('n/j/y');
$currentMonday = $monday->format('n/j/y');
$currentTuesday = $tuesday->format('n/j/y');
$currentWednesday = $wednesday->format('n/j/y');
$currentThursday = $thursday->format('n/j/y');
$currentFriday = $friday->format('n/j/y');
$currentSaturday = $saturday->format('n/j/y');

// the ID (controlling which row we're dealing with in SQL) is a persisting session variable through the entire time an employee is logged in
// this is important to keep track of what week the user sees
if (isset($_SESSION['idn'])) {
	$id = $_SESSION['idn'];
}

else { // we come into this else is the $id is not set which means we have just logged in, so we first set the ID
	$id = getIDFromDate($connection, $currentSunday);
}

$_SESSION['idn'] = $id;
	
// initializing variables for later use and comparison
$tableID = '';
$userID = '';
$shiftID = '';

function findSunday(&$newDate, $dayNum) { // this function finds the last Sunday starting at your current local date. it is recursive and calls itself moving back one by one until we find a sunday
  	 	if ($dayNum != 7) {
    		$newDate->sub(new DateInterval('P1D'));
			$update = $newDate->format('Y-n-j');
			$dayNum = date('N', strtotime($update));
    		findSunday($newDate, $dayNum);
    	}
}

function getIDFromDate($connection, $date) { // we take the current date and look for the row which corresponds to it - by storing its ID number, we know that every other database/day of the week corresponds with the same ID
	$arb = false;
	$request = "SELECT * FROM sunday";
	$result = mysqli_query($connection, $request);

	while (!$arb) {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		if ($row['date'] == $date) {
			$arb = true;
			$id = $row['id'];
		}
	}	
	return $id;
}

// goes through and looks for instances where the currently logged in employee's username shows up in the database and adds 3 (since all shifts are 3 hours long) for each instance
// returns the total hours they have for the week for whatever manipulation or printing we need
function getHours($sqldb) { 
    	$server="localhost"; // Server
		$sqluser="root";
		$sqlpw="";
		$connection = mysqli_connect($server, $sqluser, $sqlpw, $sqldb);
		$hourTable = '';
		$hours = 0;

		$hourDate = 1;

		setDay($hourDate, $hourTable);

	    while ($hourDate <= 7) {
	    	$request = "SELECT * FROM $hourTable";
			$result = mysqli_query($connection, $request);

			for ($i = 0; $i < $_SESSION['idn']; $i++) { // $i = $_SESSION['idn']; $i < $_SESSION['idn']+1
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			}

			if ($row['user0'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$hours += 3;
			}

			if ($row['user1'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$hours += 3;
			}

			if ($row['user2'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$hours += 3;
			}

			if ($row['user3'] == $_SESSION['username']) {
				$currentDate = $row['date'];
				$hours += 3;
			}

			$hourDate++;
			setDay($hourDate, $hourTable);
	    }

	    return $hours;
    }


    // depending on the current day of the week, we set the $table accordingly so we can use it in the schedule later
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

    $hours = getHours($sqldb);
?>

<script>
// AJAX which controls back-end manipulation on user interaction with elements
// this line passively stays on and waiting after the page has loaded for the user
$(document).ready(function(){
	// .shift represents the shift class of buttons - on clicking them, we run code below
    $('.shift').click(function(){
    	// we get the name of the button and take a substring of the first few letters to find out whether it's "take" or "drop" shift
        var buttonClicked = $(this).attr("name");
        var sub = buttonClicked.substring(0, 4);
        var employee = <?php echo json_encode($currentUser);?>;
        var tableID = <?php echo json_encode($tableID);?>;
        var userID = <?php echo json_encode($userID);?>;
        var shiftID = <?php echo json_encode($shiftID);?>;
        var idn = <?php echo json_encode($id);?>;
        var hours = <?php echo json_encode($hours);?>;

        // at this point, we check to make sure that the user does not have the maximum available hours for the week
        // otherwise, we cannot let them schedule anymore
        if (hours >= 24 && sub != "drop") {
        	alert("You have reached the hour limit for this week.");
        }

        // we POST some of the data initialized above to takeShift.php
        else {
        	data =  {'action': buttonClicked, 'employee': employee, 'id': idn, 'table': tableID, 'user': userID, 'shift': shiftID},
        		$.post('takeShift.php', data, function (response) {
        			// reload the page after the user successfuly takes or drops the shift
            		location.reload();
        		});
        } 
    });

	// .next is the class repesenting the next week button
    $('.next').on('click', function(){
    	// POST to incrementWeek and ++ the persisting ID variable in the session
    	$.post ('incrementWeek.php', function (response) {
            	location.reload();
        });
    });

    // .prev is the class representing the previous week button
    $('.prev').on('click', function(){
    	// POST to decrementWeek and -- the persisting ID variable in the session
    	$.post ('decrementWeek.php', function (response) {
            	location.reload();
        });
    });
});
</script>


<div class="menu" align="left">
	<ul>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="upcomingShifts.php">View upcoming shifts</a></li>
		<?php
			if ($_SESSION['idn'] > 1) // as long as we are not on the first week stored in the database, we will show a previous week button
				echo '<li><a href="#" class="prev">Previous week</a></li>';
		?>
		<?php
			if ($_SESSION['idn'] < 10) // as long as we are not on the last week stored in the database, we will show a next week button
				echo '<li><a href="#" class="next">Next week</a></li>';
		?>
		<li><p>Total Hours this Week: <?php echo json_encode($hours); ?></p></li>
	</ul>
</div>

<!-- we create the primary schedule table and add all of the current days and dates throughout the first row -->
<div class="wrapper">
	<h1 id="overlying">Schedule</h1>
	<div id="tab">
	<table class="schedule" width="165%" border="1" align="center" cellpadding="0">
	<tr> <!-- Weeks -->
		<td align="center">
			<strong>Sunday</strong>
			<?php
				$request = "SELECT * FROM sunday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$date = $row['date'];
				echo "<br><strong>$date</strong>";
			?>
		</td>
		<td align="center">
			<strong>Monday</strong>
			<?php
				$request = "SELECT * FROM monday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$date = $row['date'];
				echo "<br><strong>$date</strong>";
			?>
		</td>
		<td align="center">
			<strong>Tuesday</strong>
			<?php
				$request = "SELECT * FROM tuesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$date = $row['date'];
				echo "<br><strong>$date</strong>";
			?>
		</td>
		<td align="center">
			<strong>Wednesday</strong>
			<?php
				$request = "SELECT * FROM wednesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$date = $row['date'];
				echo "<br><strong>$date</strong>";
			?>
		</td>
		<td align="center">
			<strong>Thursday</strong>
			<?php
				$request = "SELECT * FROM thursday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$date = $row['date'];
				echo "<br><strong>$date</strong>";
			?>
		</td>
		<td align="center">
			<strong>Friday</strong>
			<?php
				$request = 'SELECT * FROM friday WHERE id=' . $_SESSION["idn"];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$date = $row['date'];
				echo "<br><strong>$date</strong>";
			?>
		</td>
		<td align="center">
			<strong>Saturday</strong>
			<?php
				$request = "SELECT * FROM saturday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$date = $row['date'];
				echo "<br><strong>$date</strong>";
			?>
		</td>
	</tr>
	<!-- in the schedule, are 28 blocks of code representing each shift for the week. when displaying each individual shift, we check a number of things as seen below.-->
	<tr> <!-- (Button series) 12:00 PM to 3:00 PM -->
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = "SELECT * FROM sunday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) { // this and line below change depending on what shift we're working with. if shift is taken, we display username of employee that has it.
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
					// if the currently logged in user has the shift, we make sure it is at least 48 hours before the shift date to see whether or not we should show a "drop shift" button
					if ($currentUser == $employee)  { 
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftone" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					// this else structure controls a few things. to show the "take shift" button on a shift that has not been taken, we set a few conditions:
					// 1) it needs to be within 2 weeks (anything more will not show take shift)
					// 2) only dates today and in the future will show it
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftone" style="margin-bottom:10px" value="Take Shift"/><?php
				    }
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = "SELECT * FROM monday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) {
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwo" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwo" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = "SELECT * FROM tuesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) {
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftthree" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftthree" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = "SELECT * FROM wednesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) {
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftfour" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftfour" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = "SELECT * FROM thursday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) {
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftfive" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftfive" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = 'SELECT * FROM friday WHERE id=' . $_SESSION["idn"];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) {
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftsix" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftsix" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = "SELECT * FROM saturday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) {
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftseven" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 13;
				            break;
				        case 2:
				        	$toCompare = 12;
				            break;
				        case 3:
				        	$toCompare = 11;
				            break;
				        case 4:
				        	$toCompare = 10;
				            break;
				        case 5:
				        	$toCompare = 9;
				            break;
				        case 6:
				        	$toCompare = 8;
				            break;
				        case 7:
				        	$toCompare = 14;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftseven" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
	</tr>
	<tr> <!-- 3:00 PM to 6:00 PM -->
		<td width="14%" align="center">
			<p style="margin-top:5px">3:00 PM<br>to<br>6:00 PM</p>
			<?php
				$request = "SELECT * FROM sunday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift1']) {
					$employee = $row['user1'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifteight" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifteight" style="margin-bottom:10px" value="Take Shift"/><?php // asdadadsadsad
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">3:00 PM<br>to<br>6:00 PM</p>
			<?php
				$request = "SELECT * FROM monday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift1']) {
					$employee = $row['user1'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftnine" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftnine" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">3:00 PM<br>to<br>6:00 PM</p>
			<?php
				$request = "SELECT * FROM tuesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift1']) {
					$employee = $row['user1'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftten" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftten" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">3:00 PM<br>to<br>6:00 PM</p>
			<?php
				$request = "SELECT * FROM wednesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift1']) {
					$employee = $row['user1'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifteleven" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifteleven" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">3:00 PM<br>to<br>6:00 PM</p>
			<?php
				$request = "SELECT * FROM thursday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift1']) {
					$employee = $row['user1'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwelve" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwelve" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">3:00 PM<br>to<br>6:00 PM</p>
			<?php
				$request = 'SELECT * FROM friday WHERE id=' . $_SESSION["idn"];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift1']) {
					$employee = $row['user1'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftthirteen" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftthirteen" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">3:00 PM<br>to<br>6:00 PM</p>
			<?php
				$request = "SELECT * FROM saturday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift1']) {
					$employee = $row['user1'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftfourteen" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 13;
				            break;
				        case 2:
				        	$toCompare = 12;
				            break;
				        case 3:
				        	$toCompare = 11;
				            break;
				        case 4:
				        	$toCompare = 10;
				            break;
				        case 5:
				        	$toCompare = 9;
				            break;
				        case 6:
				        	$toCompare = 8;
				            break;
				        case 7:
				        	$toCompare = 14;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftfourteen" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
	</tr>
	<tr> <!-- 6:00 PM to 9:00 PM -->
		<td width="14%" align="center">
			<p style="margin-top:5px">6:00 PM<br>to<br>9:00 PM</p>
			<?php
				$request = "SELECT * FROM sunday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift2']) {
					$employee = $row['user2'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftfifteen" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftfifteen" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">6:00 PM<br>to<br>9:00 PM</p>
			<?php
				$request = "SELECT * FROM monday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift2']) {
					$employee = $row['user2'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftsixteen" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftsixteen" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">6:00 PM<br>to<br>9:00 PM</p>
			<?php
				$request = "SELECT * FROM tuesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift2']) {
					$employee = $row['user2'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftseventeen" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftseventeen" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">6:00 PM<br>to<br>9:00 PM</p>
			<?php
				$request = "SELECT * FROM wednesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift2']) {
					$employee = $row['user2'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifteighteen" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifteighteen" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">6:00 PM<br>to<br>9:00 PM</p>
			<?php
				$request = "SELECT * FROM thursday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift2']) {
					$employee = $row['user2'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshiftnineteen" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shiftnineteen" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">6:00 PM<br>to<br>9:00 PM</p>
			<?php
				$request = 'SELECT * FROM friday WHERE id=' . $_SESSION["idn"];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift2']) {
					$employee = $row['user2'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwenty" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwenty" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">6:00 PM<br>to<br>9:00 PM</p>
			<?php
				$request = "SELECT * FROM saturday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift2']) {
					$employee = $row['user2'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentyone" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 13;
				            break;
				        case 2:
				        	$toCompare = 12;
				            break;
				        case 3:
				        	$toCompare = 11;
				            break;
				        case 4:
				        	$toCompare = 10;
				            break;
				        case 5:
				        	$toCompare = 9;
				            break;
				        case 6:
				        	$toCompare = 8;
				            break;
				        case 7:
				        	$toCompare = 14;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentyone" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
	</tr>
	<tr> <!-- 9:00 PM to 12:00 AM -->
		<td width="14%" align="center">
			<p style="margin-top:5px">9:00 PM<br>to<br>12:00 AM</p>
			<?php
				$request = "SELECT * FROM sunday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift3']) {
					$employee = $row['user3'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentytwo" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentytwo" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">9:00 PM<br>to<br>12:00 AM</p>
			<?php
				$request = "SELECT * FROM monday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift3']) {
					$employee = $row['user3'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentythree" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentythree" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">9:00 PM<br>to<br>12:00 AM</p>
			<?php
				$request = "SELECT * FROM tuesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift3']) {
					$employee = $row['user3'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentyfour" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentyfour" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">9:00 PM<br>to<br>12:00 AM</p>
			<?php
				$request = "SELECT * FROM wednesday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift3']) {
					$employee = $row['user3'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentyfive" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentyfive" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">9:00 PM<br>to<br>12:00 AM</p>
			<?php
				$request = "SELECT * FROM thursday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift3']) {
					$employee = $row['user3'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentysix" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentysix" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">9:00 PM<br>to<br>12:00 AM</p>
			<?php
				$request = 'SELECT * FROM friday WHERE id=' . $_SESSION["idn"];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift3']) {
					$employee = $row['user3'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentyseven" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 12;
				            break;
				        case 2:
				        	$toCompare = 11;
				            break;
				        case 3:
				        	$toCompare = 10;
				            break;
				        case 4:
				        	$toCompare = 9;
				            break;
				        case 5:
				        	$toCompare = 8;
				            break;
				        case 6:
				        	$toCompare = 7;
				            break;
				        case 7:
				        	$toCompare = 13;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentyseven" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
		<td width="14%" align="center">
			<p style="margin-top:5px">9:00 PM<br>to<br>12:00 AM</p>
			<?php
				$request = "SELECT * FROM saturday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift3']) {
					$employee = $row['user3'];
					echo "Taken by <strong>$employee</strong>";
					if ($currentUser == $employee)  {
						$today = new DateTime(date('n/j/y'));
						$storedDate = new DateTime($row['date']);
						$preDiff = date_diff($today, $storedDate);
						$postDiff = $preDiff->format("%r%a");
						if ($postDiff >= 2) {
							?>
							<input type="submit" class="shift" name="dropshifttwentyeight" style="margin-bottom:10px; margin-top:10px;" value="Drop Shift"/>
							<?php
						}
					}
				}
				else {
					$today = new DateTime(date('n/j/y'));
					$futureDay = new DateTime($row['date']);
					$dayToday = $today->format('N');
					$toCompare = 0;

					switch ($dayToday) {
				        case 1:
				            $toCompare = 13;
				            break;
				        case 2:
				        	$toCompare = 12;
				            break;
				        case 3:
				        	$toCompare = 11;
				            break;
				        case 4:
				        	$toCompare = 10;
				            break;
				        case 5:
				        	$toCompare = 9;
				            break;
				        case 6:
				        	$toCompare = 8;
				            break;
				        case 7:
				        	$toCompare = 14;
				            break;
				    }

				    $preFormat = date_diff($today, $futureDay);
				    $postFormat = $preFormat->format("%r%a");

				    if ($postFormat < $toCompare and $postFormat >= 0) {
				    	?>
						<input type="submit" class="shift" name="shifttwentyeight" style="margin-bottom:10px" value="Take Shift"/><?php
					}
				}
			?>
		</td>
	</tr>
		</table>
	</div>
</div>

</body>
</html>