<?php
require_once('model/db.php');
require_once('model/dbFunctions.php');

$db = db_object();



// Array of available controllers

if (isset($_SESSION['userstate']) && ($_SESSION['userstate'] == 'admin')) {
    $availableControllers = array('books', 'users');
} else {
    $availableControllers = array('users');
}

// Get controller name from query string and set to variable
if ( isset($_GET['controller']) ) {
    if ( in_array($_GET['controller'], $availableControllers) ){
        $controller = $_GET['controller'];
    } else {
        $controller = 'users';
    }
} else {
    $controller = 'users';
}


require_once('controllers/'.$controller.'.php');


?>
