<?php
    /* Written by:  Kanav Tahilramani and Omar Warraky
    * Debugged by: Kanav Tahilramani and Omar Warraky
    * Tested by:   Kanav Tahilramani and Omar Warraky
    */
// if action is set, it means we POSTED successfully from the AJAX bit in schedule.php
// we use a switch case, determine which shift button was clicked, and accordingly record or drop the shift
// depending on the name attribute of the button
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'shiftone':
            record($_POST['employee'], "sunday", "user0", "shift0", $_POST['id']);
            break;
        case 'shifttwo':
            record($_POST['employee'], "monday", "user0", "shift0", $_POST['id']);
            break;
        case 'shiftthree':
            record($_POST['employee'], "tuesday", "user0", "shift0", $_POST['id']);
            break;
        case 'shiftfour':
            record($_POST['employee'], "wednesday", "user0", "shift0", $_POST['id']);
            break;
        case 'shiftfive':
            record($_POST['employee'], "thursday", "user0", "shift0", $_POST['id']);
            break;
        case 'shiftsix':
            record($_POST['employee'], "friday", "user0", "shift0", $_POST['id']);
            break;
        case 'shiftseven':
            record($_POST['employee'], "saturday", "user0", "shift0", $_POST['id']);
            break;
        case 'shifteight':
            record($_POST['employee'], "sunday", "user1", "shift1", $_POST['id']);
            break;
        case 'shiftnine':
            record($_POST['employee'], "monday", "user1", "shift1", $_POST['id']);
            break;
        case 'shiftten':
            record($_POST['employee'], "tuesday", "user1", "shift1", $_POST['id']);
            break;
        case 'shifteleven':
            record($_POST['employee'], "wednesday", "user1", "shift1", $_POST['id']);
            break;
        case 'shifttwelve':
            record($_POST['employee'], "thursday", "user1", "shift1", $_POST['id']);
            break;
        case 'shiftthirteen':
            record($_POST['employee'], "friday", "user1", "shift1", $_POST['id']);
            break;
        case 'shiftfourteen':
            record($_POST['employee'], "saturday", "user1", "shift1", $_POST['id']);
            break;
        case 'shiftfifteen':
            record($_POST['employee'], "sunday", "user2", "shift2", $_POST['id']);
            break;
        case 'shiftsixteen':
            record($_POST['employee'], "monday", "user2", "shift2", $_POST['id']);
            break;
        case 'shiftseventeen':
            record($_POST['employee'], "tuesday", "user2", "shift2", $_POST['id']);
            break;
        case 'shifteighteen':
            record($_POST['employee'], "wednesday", "user2", "shift2", $_POST['id']);
            break;
        case 'shiftnineteen':
            record($_POST['employee'], "thursday", "user2", "shift2", $_POST['id']);
            break;
        case 'shifttwenty':
            record($_POST['employee'], "friday", "user2", "shift2", $_POST['id']);
            break;
        case 'shifttwentyone':
            record($_POST['employee'], "saturday", "user2", "shift2", $_POST['id']);
            break;
        case 'shifttwentytwo':
            record($_POST['employee'], "sunday", "user3", "shift3", $_POST['id']);
            break;
        case 'shifttwentythree':
            record($_POST['employee'], "monday", "user3", "shift3", $_POST['id']);
            break;
        case 'shifttwentyfour':
            record($_POST['employee'], "tuesday", "user3", "shift3", $_POST['id']);
            break;
        case 'shifttwentyfive':
            record($_POST['employee'], "wednesday", "user3", "shift3", $_POST['id']);
            break;
        case 'shifttwentysix':
            record($_POST['employee'], "thursday", "user3", "shift3", $_POST['id']);
            break;
        case 'shifttwentyseven':
            record($_POST['employee'], "friday", "user3", "shift3", $_POST['id']);
            break;
        case 'shifttwentyeight':
            record($_POST['employee'], "saturday", "user3", "shift3", $_POST['id']);
            break;
        case 'dropshiftone':
            drop($_POST['employee'], "sunday", "user0", "shift0", $_POST['id']);
            break;
        case 'dropshifttwo':
            drop($_POST['employee'], "monday", "user0", "shift0", $_POST['id']);
            break;
        case 'dropshiftthree':
            drop($_POST['employee'], "tuesday", "user0", "shift0", $_POST['id']);
            break;
        case 'dropshiftfour':
            drop($_POST['employee'], "wednesday", "user0", "shift0", $_POST['id']);
            break;
        case 'dropshiftfive':
            drop($_POST['employee'], "thursday", "user0", "shift0", $_POST['id']);
            break;
        case 'dropshiftsix':
            drop($_POST['employee'], "friday", "user0", "shift0", $_POST['id']);
            break;
        case 'dropshiftseven':
            drop($_POST['employee'], "saturday", "user0", "shift0", $_POST['id']);
            break;
        case 'dropshifteight':
            drop($_POST['employee'], "sunday", "user1", "shift1", $_POST['id']);
            break;
        case 'dropshiftnine':
            drop($_POST['employee'], "monday", "user1", "shift1", $_POST['id']);
            break;
        case 'dropshiftten':
            drop($_POST['employee'], "tuesday", "user1", "shift1", $_POST['id']);
            break;
        case 'dropshifteleven':
            drop($_POST['employee'], "wednesday", "user1", "shift1", $_POST['id']);
            break;
        case 'dropshifttwelve':
            drop($_POST['employee'], "thursday", "user1", "shift1", $_POST['id']);
            break;
        case 'dropshiftthirteen':
            drop($_POST['employee'], "friday", "user1", "shift1", $_POST['id']);
            break;
        case 'dropshiftfourteen':
            drop($_POST['employee'], "saturday", "user1", "shift1", $_POST['id']);
            break;
        case 'dropshiftfifteen':
            drop($_POST['employee'], "sunday", "user2", "shift2", $_POST['id']);
            break;
        case 'dropshiftsixteen':
            drop($_POST['employee'], "monday", "user2", "shift2", $_POST['id']);
            break;
        case 'dropshiftseventeen':
            drop($_POST['employee'], "tuesday", "user2", "shift2", $_POST['id']);
            break;
        case 'dropshifteighteen':
            drop($_POST['employee'], "wednesday", "user2", "shift2", $_POST['id']);
            break;
        case 'dropshiftnineteen':
            drop($_POST['employee'], "thursday", "user2", "shift2", $_POST['id']);
            break;
        case 'dropshifttwenty':
            drop($_POST['employee'], "friday", "user2", "shift2", $_POST['id']);
            break;
        case 'dropshifttwentyone':
            drop($_POST['employee'], "saturday", "user2", "shift2", $_POST['id']);
            break;
        case 'dropshifttwentytwo':
            drop($_POST['employee'], "sunday", "user3", "shift3", $_POST['id']);
            break;
        case 'dropshifttwentythree':
            drop($_POST['employee'], "monday", "user3", "shift3", $_POST['id']);
            break;
        case 'dropshifttwentyfour':
            drop($_POST['employee'], "tuesday", "user3", "shift3", $_POST['id']);
            break;
        case 'dropshifttwentyfive':
            drop($_POST['employee'], "wednesday", "user3", "shift3", $_POST['id']);
            break;
        case 'dropshifttwentysix':
            drop($_POST['employee'], "thursday", "user3", "shift3", $_POST['id']);
            break;
        case 'dropshifttwentyseven':
            drop($_POST['employee'], "friday", "user3", "shift3", $_POST['id']);
            break;
        case 'dropshifttwentyeight':
            drop($_POST['employee'], "saturday", "user3", "shift3", $_POST['id']);
            break;
    }
}

function record($employee, $table, $user, $shift, $idn) {
    // records the shift as taken by the current user logged in
    $server="localhost"; // Server
    $sqluser="root";
    $sqlpw="";

    switch ($employee) {
            case 'waiter1':
                $sqldb="foodezwo_shifts";
                break;
            case 'waiter2':
                $sqldb="foodezwo_shifts";
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

    $connection = mysqli_connect($server, $sqluser, $sqlpw, $sqldb);
    
    $request = "UPDATE $table SET $shift=1, $user='$employee' WHERE id=$idn";
    $connection->query($request);
}

function drop($employee, $table, $user, $shift, $idn) {
    // drops the shift by setting the corresponding row and shift's username to NULL and 0
    $server="localhost"; // Server
    $sqluser="root";
    $sqlpw="";

    switch ($employee) {
            case 'waiter1':
                $sqldb="foodezwo_shifts";
                break;
            case 'waiter2':
                $sqldb="foodezwo_shifts";
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

    $connection = mysqli_connect($server, $sqluser, $sqlpw, $sqldb);

    $request = "UPDATE $table SET $shift=0, $user=NULL WHERE id=$idn";
    $connection->query($request);
}
?>