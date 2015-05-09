<?php
	/* Written by:  Kanav Tahilramani and Omar Warraky
 	* Debugged by: Kanav Tahilramani and Omar Warraky
 	* Tested by:   Kanav Tahilramani and Omar Warraky
 	*/
	// used for the manager panel. sets the current schedule the manager is viewing to busboy.
	session_start();
	$_SESSION['sched'] = "Busboy";
	$_SESSION['schedDB'] = "foodezwo_shifts_busboy";
	header('control.php');
?>