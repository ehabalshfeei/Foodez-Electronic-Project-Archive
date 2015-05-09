<?php
	/* Written by:  Kanav Tahilramani and Omar Warraky
 	* Debugged by: Kanav Tahilramani and Omar Warraky
 	* Tested by:   Kanav Tahilramani and Omar Warraky
 	*/
	// takes the persisting ID session variable and increments it to move forward a week
	session_start();
	$session = $_SESSION['idn'];
	$session++;
	$_SESSION['idn'] = $session;
	$_SESSION['sched'] = $_POST['sess'];
	$_SESSION['schedDB'] = $_POST['sessDB'];
	header('schedule.php');
?>