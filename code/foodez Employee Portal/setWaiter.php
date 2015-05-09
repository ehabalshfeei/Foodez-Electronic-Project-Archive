<?php
	/* Written by:  Kanav Tahilramani and Omar Warraky
 	* Debugged by: Kanav Tahilramani and Omar Warraky
 	* Tested by:   Kanav Tahilramani and Omar Warraky
 	*/
	// used for the manager panel. sets the current schedule the manager is viewing to waiter.
	session_start();
	$_SESSION['sched'] = "Waiter";
	$_SESSION['schedDB'] = "foodezwo_shifts";
	header('control.php');
?>