<?php

// Array of available actions
$availableActions = array('addbook', 'viewbook', 'editbook', 'displaybooks');

// Get action name from query string and set to variable
if ( isset($_GET['action']) ) {
    if ( in_array($_GET['action'], $availableActions) ){
        $action = $_GET['action'];
    } else {
        $action = 'displaybooks';
    }
} else {
    $action = 'displaybooks';
}

//Define the php file and page title depending on the action
switch($action) {
    case "addbook":
        addBook();
        break;
    case "editbook":
        editBook();
        break;
    case "viewbook":
        viewBook();
        break;
    case "displaybooks":
        displayBooks();
        break;
    default:
        displayBooks();
        break;
}

function addBook() {
    GLOBAL $action;
    $pageTitle = "Add Book | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/bookform.php');
    require_once('view/pages/footer.php');
}

function editBook() {
    GLOBAL $action;
    $pageTitle = "Edit Book | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/bookform.php');
    require_once('view/pages/footer.php');
}

function viewBook() {
    GLOBAL $action;
    $pageTitle = "View Book | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/viewbook.php');
    require_once('view/pages/footer.php');
}

function displaybooks() {
    GLOBAL $action;
    $pageTitle = "Top Selling Books | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/displaybooks.php');
    require_once('view/pages/footer.php');
}
 ?>
