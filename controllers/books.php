<?php

// Array of available actions
$availableActions = array('addbook', 'viewbook', 'editbook', 'displaybooks', 'deletebook');

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
    case "deletebook":
        deletebook();
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

    //Process the form to add new author, book, plot and ranking information to My Books
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Checking if new or existing author
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

                //Call insert data function
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
            //Call insert data function
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
            //Call insert data function
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
            //Call insert data function
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
            //Call insert data function
            insertData('bookmodify', $modifyData);
        } catch (PDOexception $e) {
            echo "Error:".$e -> getMessage();
            die();
        }
        //Set sesssion variable
        $_SESSION['notification'] = '"'.$bookTitle.'" has been successfully added to the database.';
        header("location: ?controller=books&action=displaybooks");
        exit;
    }
    //Set page title
    $pageTitle = "Add Book | My Books";
    //Compile add books page
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
    //Get existing data from book and author table
    $book = selectData('book', array(
        'left join' => array('table2' => 'author', 'column' => 'authorID'),
        'where'=> array('bookID' => $bookID ),
        'return type' => 'single'
        )
    );
    //Get existing data from bookplot table
    $bookplot = selectData('bookplot', array(
        'where' => array('bookID' => $bookID),
        'return type' => 'single'
        )
    );
    //Get existing data from ranking table
    $ranking = selectData('bookranking',  array(
        'where' => array('bookID' => $bookID),
        'return type' => 'single'
        )
    );

    //Process the form to update author, book, plot & ranking information in My Books
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
            $updateWhere = array(
                'authorID' => $book['authorID']
            );
            //Call update function
            updateData('author', $authorData, $updateWhere);

        } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
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
            );
            $updateWhere = array(
                'bookID' => $book['bookID']
            );
            //Call update function
            updateData('book', $bookData, $updateWhere);

        } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
        }

        //Map sanitised form inputs to variables
        $plot = !empty($_POST['plot']) ? sanitiseUserInput($_POST['plot']) : null;
        $plotSource = !empty($_POST['plotSource']) ? sanitiseUserInput($_POST['plotSource']) : null;

        try {
            $plotData = array(
                'plot' => $plot,
                'plotSource' => $plotSource
            );
            $updateWhere = array(
                'bookPlotID' => $bookplot['bookPlotID']
            );
            //Call update function
            updateData('bookplot', $plotData, $updateWhere);

        } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
        }

        //Map sanitised form inputs to variables
        $rankingScore = !empty($_POST['rankingScore']) ? sanitiseUserInput($_POST['rankingScore']) : null;

        try {
            $rankData = array(
                'rankingScore' => $rankingScore,
            );
            $updateWhere = array(
                'rankingID' => $ranking['rankingID']
            );
            //Call update function
            updateData('bookranking', $rankData, $updateWhere);

        } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
        }

        try {
            $modifyData = array(
                'adminID' => $_SESSION['userID'],
                'bookID' => $book['bookID']
            );
            //Call insert data function
            insertData('bookmodify', $modifyData);
        } catch (PDOexception $e) {
            echo "Error:".$e -> getMessage();
            die();
        }

        //Set session notification variable
        $_SESSION['notification'] = 'Changes to "'.$bookTitle.'" have been saved.';
        header("location: ?controller=books&action=displaybooks");
        exit;

    }
    //Set page title
    $pageTitle = "Edit Book | My Books";
    //Compile page
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
    //Select data from book and author table, based on current book id
    $book = selectData('book', array(
        'left join' => array('table2' => 'author', 'column' => 'authorID'),
        'where'=> array('bookID' => $bookID ),
        'return type' => 'single'
        )
    );

    //Select data from book plot table, based on current book id
    $plot = selectData('bookplot', array(
        'select' => ' plot',
        'where' => array('bookID' => $bookID),
        'return type' => 'single'
        )
    );

    //Select data from ranking table, based on current book id
    $ranking = selectData('bookranking',  array(
        'select' => ' rankingScore',
        'where' => array('bookID' => $bookID),
        'return type' => 'single'
        )
    );
    //Set book cover image
    if ($book['imageURL'] != '') {
        $image = $book['imageURL'];
    } else {
        $image = 'http://localhost/mybooks/view/images/default.png';
    }
    //Set page title
    $pageTitle = "View Book | My Books";
    //Compile view book page
    require_once('view/pages/head.php');
    require_once('view/pages/viewbook.php');
    require_once('view/pages/footer.php');
}

function displaybooks() {
    GLOBAL $action, $controller;

    //Select data from book table
    $books = selectData('book', array('order_by'=> 'bookID'));
    //Select data from author table
    $authors = selectData('author', array('select'=> ' authorID, firstName, lastName'));
    //Set page title
    $pageTitle = "Top Selling Books | My Books";
    //Compile display books page
    require_once('view/pages/head.php');
    require_once('view/pages/displaybooks.php');
    require_once('view/pages/footer.php');
}

function deletebook() {
    GLOBAL $action, $controller;

    //Get Book ID from the query string
    if ( !empty($_GET['bookid']) ) {
        $bookID = sanitiseUserInput($_GET['bookid']);
    } else {
        header('HTTP/1.1 404 Not Found');
        exit;
    }

    //Select data from book and author table
    $book = selectData('book', array(
        'left join' => array('table2' => 'author', 'column' => 'authorID'),
        'where'=> array('bookID' => $bookID ),
        'return type' => 'single'
        )
    );
    //Set table & condition variable
    $table = 'book';
    $condition = array('bookID' => $bookID);

    try {
        //Call delete function
        deleteData( $table, $condition);
    } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
    }
    //Set new table variable
    $table = 'bookplot';

    try {
        //Call delete function
        deleteData( $table, $condition);
    } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
    }
    //Set new table variable
    $table = 'bookranking';

    try {
        //Call delete function
        deleteData( $table, $condition);
    } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
    }
    //Set new table variable
    $table = 'bookmodify';

    try {
        //Call delete function
        deleteData( $table, $condition);
    } catch (PDOexception $e) {
        echo "Error:".$e -> getMessage();
        die();
    }
    //Set session notification variable
    $_SESSION['notification'] = '"'.$book['bookTitle'].'" has been successfully deleted from the database.';
    header("location: ?controller=books&action=displaybooks");
    exit;
}
 ?>
