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
    GLOBAL $action, $lastInsertID, $newAuthorID, $controller;

    //Get author names for existing author selection
    $authors = selectData('author', array(
        'select' => ' authorID, firstName, lastName',
        'order_by' => 'lastName, firstName'
        )
    );

    //Process the form to add new author information to My Books
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ( (!empty($_POST['authorSelect'])) && ($_POST['authorSelect'] == 'newAuthor')  ) {

            //Map sanitised form inputs to variables
            $firstName = !empty($_POST['firstName']) ? sanitiseUserInput($_POST['firstName']) : null;
            $lastName = !empty($_POST['lastName']) ? sanitiseUserInput($_POST['lastName']) : null;
            $nationality = !empty($_POST['nationality']) ? sanitiseUserInput($_POST['nationality']) : null;
            $birthYear = !empty($_POST['birthYear']) ? sanitiseUserInput($_POST['birthYear']) : null;
            $deathYear = !empty($_POST['deathYear']) ? sanitiseUserInput($_POST['deathYear']) : null;

            try {
                $authorData = array(
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'nationality' => $nationality,
                    'birthYear' => $birthYear,
                    'deathYear' => $deathYear
                );
                insertData('author', $authorData);
            } catch (PDOexception $e) {
                echo "Error:".$e -> getMessage();
                die();
            }

            //Set newly created author ID for use in next insert
            $newAuthorID = $lastInsertID;
        } else {
            $authorOption = isset($_POST['authorOption']) ? $_POST['authorOption'] : false;
            $newAuthorID = $authorOption;
        }


        //Map sanitised form inputs to variables
        $bookTitle = !empty($_POST['bookTitle']) ? sanitiseUserInput($_POST['bookTitle']) : null;
        $originalTitle = !empty($_POST['originalTitle']) ? sanitiseUserInput($_POST['originalTitle']) : null;
        $yearofPublication = !empty($_POST['yearofPublication']) ? sanitiseUserInput($_POST['yearofPublication']) : null;
        $genre = !empty($_POST['genre']) ? sanitiseUserInput($_POST['genre']) : null;
        $millionsSold = !empty($_POST['millionsSold']) ? sanitiseUserInput($_POST['millionsSold']) : null;
        $languageWritten = !empty($_POST['languageWritten']) ? sanitiseUserInput($_POST['languageWritten']) : null;

        try {
            $bookData = array(
                'bookTitle' => $bookTitle,
                'originalTitle' => $originalTitle,
                'yearofPublication' => $yearofPublication,
                'genre' => $genre,
                'millionsSold' => $millionsSold,
                'languageWritten' => $languageWritten,
                'authorID' => $newAuthorID
            );
            insertData('book', $bookData);
        } catch (PDOexception $e) {
            echo "Error:".$e -> getMessage();
            die();
        }

        //Set newly created book ID for use in next insert
        $newBookID = $lastInsertID;

        //Map sanitised form inputs to variables
        $plot = !empty($_POST['plot']) ? sanitiseUserInput($_POST['plot']) : null;
        $plotSource = !empty($_POST['plotSource']) ? sanitiseUserInput($_POST['plotSource']) : null;

        try {
            $plotData = array(
                'plot' => $plot,
                'plotSource' => $plotSource,
                'bookID' => $newBookID
            );
            insertData('bookplot', $plotData);
        } catch (PDOexception $e) {
            echo "Error:".$e -> getMessage();
            die();
        }

        //Map sanitised form inputs to variables
        $rankingScore = !empty($_POST['rankingScore']) ? sanitiseUserInput($_POST['rankingScore']) : null;

        try {
            $rankData = array(
                'rankingScore' => $rankingScore,
                'bookID' => $newBookID
            );
            insertData('bookranking', $rankData);
        } catch (PDOexception $e) {
            echo "Error:".$e -> getMessage();
            die();
        }

        try {
            $modifyData = array(
                'adminID' => $_SESSION['userID'],
                'bookID' => $newBookID
            );
            insertData('bookmodify', $modifyData);
        } catch (PDOexception $e) {
            echo "Error:".$e -> getMessage();
            die();
        }
    }

    $pageTitle = "Add Book | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/bookform.php');
    require_once('view/pages/footer.php');
}

function editBook() {
    GLOBAL $action, $controller;

    //Get Book ID from the query string
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
        'select' => ' plot, plotSource',
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

    $pageTitle = "Edit Book | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/bookform.php');
    require_once('view/pages/footer.php');
}

function viewBook() {
    GLOBAL $action, $controller;

    //Get Book ID from the query string
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
    GLOBAL $action, $controller;

    $books = selectData('book', array('order_by'=> 'bookID'));
    $authors = selectData('author', array('select'=> ' authorID, firstName, lastName'));

    $pageTitle = "Top Selling Books | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/displaybooks.php');
    require_once('view/pages/footer.php');
}
 ?>
