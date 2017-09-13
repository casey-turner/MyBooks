<?php

// Array of available views
$availableActions = array('login', 'register', 'logout');

// Get action name from query string and set to variable
if ( isset($_GET['action']) ) {
    if ( in_array($_GET['action'], $availableActions) ){
        $action = $_GET['action'];
    } else {
        $action = 'login';
    }
} else {
    $action = 'login';
}

//Define the php file and page title depending on the action
switch($action) {
    case "login":
        login();
        break;
    case "register":
        register();
        break;
    case "logout":
        logout();
        break;
    default:
        login();
        break;
}

function login() {
    GLOBAL $action, $controller;

    //Process the form to login
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['userName']) && isset($_POST['password'])) {
            // Do authentication checks
            if ( db_authenticate(sanitiseUserInput( $_POST['userName']), sanitiseUserInput($_POST['password'])) ) {
                $_SESSION['userstate'] = 'admin';
                $_SESSION['userName'] = sanitiseUserInput( $_POST['userName']);

                //Setting session variables based on user data
                $userdata = selectData('users', array(
                    'where'=> array('userName' => $_SESSION['userName'] ),
                    'return type' => 'single'
                    )
                );

                $_SESSION['userID'] = $userdata['adminID'];
                $_SESSION['firstName'] = $userdata['firstName'];
                header("location: ?controller=books&action=displaybooks");

            } else {
                $errorMsg = 'Login failed. Try again';
            }
        }
    }

    // Do authentication Checks
    /*if ($state == 'loginprocessing') {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            if ( db_authenticate(sanitiseUserInput( $_POST['username']), sanitiseUserInput($_POST['password'])) ) {
                $_SESSION['userstate'] = 'admin';
                header("location: ?controller=books&action=displaybooks");
            } else {
                $errorMsg = 'Login failed. Try again';
            }
        }
    }*/
    //Set page title
    $pageTitle = "Login | My Books";
    //Compile login page
    require_once('view/pages/head.php');
    require_once('view/pages/admin_login.php');
    require_once('view/pages/footer.php');
}

function register() {
    GLOBAL $action, $controller;

    //Process the form to register
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Map sanitised form inputs to variables
        $firstName = !empty($_POST['firstName']) ? sanitiseUserInput($_POST['firstName']) : null;
        $lastName = !empty($_POST['lastName']) ? sanitiseUserInput($_POST['lastName']) : null;
        $userName = !empty($_POST['userName']) ? sanitiseUserInput($_POST['userName']) : null;
        $email = !empty($_POST['email']) ? sanitiseUserInput($_POST['email']) : null;
        $password = !empty($_POST['password']) ? password_hash(sanitiseUserInput($_POST['password']), PASSWORD_DEFAULT) : null;

        //Check if username exists in the db
        $userNameCheck = selectData('users', array(
            'where'=> array('userName' => $userName ),
            'return type' => 'count'
            )
        );

        if ($userNameCheck == 0) {
            try {
                $registrationData = array(
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'userName' => $userName,
                    'email' => $email,
                    'password' => $password
                );
                //Call insert function
                insertData('users', $registrationData);

                //Set Session variables for login
                $_SESSION['userstate'] = 'admin';
                $_SESSION['userName'] = $userName;
                $_SESSION['userID'] = $lastInsertID;
                $_SESSION['firstName'] = $firstName;

                header("location: ?controller=books&action=displaybooks");

                //Set session variable
                $_SESSION['notification'] = 'Hi '.$firstName.', welcome to My Books.';
                exit;
            } catch (PDOexception $e) {
                echo "Error:".$e -> getMessage();
                die();
            }
        } else {
            $_SESSION['error'] = $userName.' is already registered, please select a different username.';
        }
    }

    //Set page title
    $pageTitle = "register | My Books";

    //Compile page elements
    require_once('view/pages/head.php');
    require_once('view/pages/register.php');
    require_once('view/pages/footer.php');
}

function logout() {
    GLOBAL $action, $controller;
    //Kill sessions
    session_unset();
    session_destroy();
    //Return user to the login page
    header("location: ?controller=users&action=login");
    exit;
}

?>
