<?php
	/* Written by:  Kanav Tahilramani and Omar Warraky
 	* Debugged by: Kanav Tahilramani and Omar Warraky
 	* Tested by:   Kanav Tahilramani and Omar Warraky
 	*/
// this file is the manager panel and it is primarily the same as schedule.php
// though it does have a few notable differences. it does not show take/drop shift at all.
// we are only viewing schedule for the different employees to see who are working this week.
// in addition, we have a menu on the left here to switch between the employee type we are viewing.
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

<div id="logo" align="left" style="margin-left:3em;margin-top:1em"><span>Welcome <strong>manager</strong>.</span></div>

<?php
	$server="localhost"; // Server
	$sqluser="root";
	$sqlpw="";
	$sqldb="foodezwo_shifts"; // Database

	$default = "Waiter";
	$defaultDB = "foodezwo_shifts";

	if (isset($_SESSION['sched'])) {
		$default = $_SESSION['sched'];
		$defaultDB = $_SESSION['schedDB'];
	}

	$_SESSION['sched'] = $default;
	$_SESSION['schedDB'] = $defaultDB;

	$connection = mysqli_connect($server, $sqluser, $sqlpw, $_SESSION['schedDB']);

	date_default_timezone_set('America/New_York');
	$date = date('Y-m-d');
	$newDate = new DateTime($date);
	$num = date('N', strtotime($date));
	findSunday($newDate, $num);

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

	$currentSunday = $sunday->format('n/j/y');
	$currentMonday = $monday->format('n/j/y');
	$currentTuesday = $tuesday->format('n/j/y');
	$currentWednesday = $wednesday->format('n/j/y');
	$currentThursday = $thursday->format('n/j/y');
	$currentFriday = $friday->format('n/j/y');
	$currentSaturday = $saturday->format('n/j/y');

	if (isset($_SESSION['idn'])) {
		$id = $_SESSION['idn'];
	}

	else {
		$id = getIDFromDate($connection, $currentSunday);
	}

	$_SESSION['idn'] = $id;
		

	$tableID = '';
	$userID = '';
	$shiftID = '';

	function findSunday(&$newDate, $dayNum) {
	  	 	if ($dayNum != 7) {
	    		$newDate->sub(new DateInterval('P1D'));
				$update = $newDate->format('Y-n-j');
				$dayNum = date('N', strtotime($update));
	    		findSunday($newDate, $dayNum);
	    	}
	}

	function getIDFromDate($connection, $date) {
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

<script>
$(document).ready(function(){
	$('.next').on('click', function(){
		var sess = <?php echo json_encode($_SESSION['sched']);?>;
		var sessDB = <?php echo json_encode($_SESSION['schedDB']);?>;

		data =  {'sess': sess, 'sessDB': sessDB},
    	$.post ('incrementWeek.php', data, function (response) {
            	location.reload();
        });
    });

    $('.prev').on('click', function(){
    	var sess = <?php echo json_encode($_SESSION['sched']);?>;
		var sessDB = <?php echo json_encode($_SESSION['schedDB']);?>;

		data =  {'sess': sess, 'sessDB': sessDB},
    	$.post ('decrementWeek.php', data, function (response) {
            	location.reload();
        });
    });

    $('.busboytype').on('click', function(){
    	<?php
    		$_SESSION['sched'] = "Busboy";
    		$_SESSION['schedDB'] = "foodezwo_shifts_busboy";
    	?>

    	$.post ('setBusboy.php', function (response) {
            	location.reload();
        });
    });

    $('.waitertype').on('click', function(){
    	<?php
    		$_SESSION['sched'] = "Waiter";
    		$_SESSION['schedDB'] = "foodezwo_shifts";
    	?>

    	$.post ('setWaiter.php', function (response) {
            	location.reload();
        });
    });

    $('.cheftype').on('click', function(){
    	<?php
    		$_SESSION['sched'] = "Chef";
    		$_SESSION['schedDB'] = "foodezwo_shifts_chef";
    	?>

    	$.post ('setChef.php', function (response) {
            	location.reload();
        });
    });

    $('.randomize').on('click', function(){
    	var dbName = <?php echo json_encode($_SESSION['sched']);?>;
    	var dbType = <?php echo json_encode($_SESSION['schedDB']);?>;
    	var id = <?php echo json_encode($_SESSION['idn']);?>;
    	<?php $_SESSION['rand'] = 1; ?>

    	data = {'dbName': dbName, 'db': dbType, 'id': id},
    	$.post ('randomizeShifts.php', data, function (response) {
            	location.reload();
        });
    });
});
</script>

<div class="menu" align="left">
	<ul>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="#" class="waitertype"><br>Waiter Schedule</a></li>
		<li><a href="#" class="cheftype">Chef Schedule</a></li>
		<li><a href="#" class="busboytype">Busboy Schedule</a></li>
		<?php
			if ($_SESSION['idn'] > 1)
				echo '<li><br><a href="#" class="prev">Previous week</a></li>';
		?>
		<?php
			if ($_SESSION['idn'] < 10) {
				if ($_SESSION['idn'] == 1)
					echo '<li><br><a href="#" class="next">Next week</a></li>';
				else
					echo '<li><a href="#" class="next">Next week</a></li>';
			}
		?>
		<li><a href="#" class="randomize"><br>Randomize Shifts this Week</a></li>
	</ul>
</div>

<div class="wrapper">
	<h1 id="overlying"><?php echo $default;?> Schedule</h1>
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
	<tr> <!-- (Button series) 12:00 PM to 3:00 PM -->
		<td width="14%" align="center">
			<p style="margin-top:5px">12:00 PM<br>to<br>3:00 PM</p>
			<?php
				$request = "SELECT * FROM sunday WHERE id=" . $_SESSION['idn'];
				$result = mysqli_query($connection, $request);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				if ($row['shift0']) {
					$employee = $row['user0'];
					echo "Taken by <strong>$employee</strong>";
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
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
				}
				else
					echo "<i>Unclaimed</i>";
			?>
		</td>
	</tr>
		</table>
	</div>
</div>

</body>
</html>