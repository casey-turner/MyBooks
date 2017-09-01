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

    $authors = selectData('author', array(
        'select' => ' authorID, firstName, lastName',
        'order_by' => 'lastName, firstName'
        )
    );

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

    if ( !empty($_GET['bookid']) ) {
        $bookID = sanitiseUserInput($_GET['bookid']);
    } else {
        header('HTTP/1.1 404 Not Found');
        exit;
    }

    $book = selectData('book', array(
        'left join' => array('table2' => 'author', 'column' => 'authorID'),
        'where'=> array('bookID' => $bookID ),
        'return type' => 'single'
        )
    );

    $plot = selectData('bookplot', array(
        'select' => ' plot',
        'where' => array('bookID' => $bookID),
        'return type' => 'single'
        )
    );

    $ranking = selectData('bookranking',  array(
        'select' => ' rankingScore',
        'where' => array('bookID' => $bookID),
        'return type' => 'single'
        )
    );

    if ($book['imageURL'] != '') {
        $image = $book['imageURL'];
    } else {
        $image = 'http://localhost/mybooks/view/images/default.png';
    }

    $pageTitle = "View Book | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/viewbook.php');
    require_once('view/pages/footer.php');
}

function displaybooks() {
    GLOBAL $action;

    $books = selectData('book', array('order_by'=> 'bookID'));
    $authors = selectData('author', array('select'=> ' authorID, firstName, lastName'));

    $pageTitle = "Top Selling Books | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/displaybooks.php');
    require_once('view/pages/footer.php');
}
 ?>
