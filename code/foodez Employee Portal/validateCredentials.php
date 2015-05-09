<?php
/* Written by:  Kanav Tahilramani and Omar Warraky
 * Debugged by: Kanav Tahilramani and Omar Warraky
 * Tested by:   Kanav Tahilramani and Omar Warraky
 */
session_start();
$server="localhost";
$user="root"; // SQL User
$password=""; // SQL PW
$database="foodezwo_employees"; // Database
$table_one="members"; // Table

$db = mysqli_connect($server, $user, $password, $database);

if ($db->connect_errno > 0) {
	die('Unable to connect to the database [' . $db->connect_error . ']');
}

// Respectively initiate server and database connection.
//db->select_db("$database")

// Get user input from form
$username=$_POST['username'];
$password=MD5($_POST['password']);

// MySQL Injection Prevention
$username = stripslashes($username);
$password = stripslashes($password);
$username = $db->real_escape_string($username);
$password = $db->real_escape_string($password);
$sql="SELECT * FROM $table_one WHERE username='$username' and password='$password'";
$result=mysqli_query($db, $sql);

// Counts table row, should be 1 in the case of a match
$count=mysqli_num_rows($result);

// If input matches intended info in DB
if($count==1){
// Opens schedule.php after recording user/pw
	$_SESSION['username'] = $db->real_escape_string($username);
	$_SESSION['password'] = $db->real_escape_string($password);
	$_SESSION['table'] = $table_one;
	if ($_SESSION['username'] == "manager")
		header("location:control.php");
	else
		header("location:schedule.php");
}
else {
	echo "Username and/or password is incorrect.";
}
?>