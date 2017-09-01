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

    // Do authentication checks
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['userName']) && isset($_POST['password'])) {
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

    $pageTitle = "Login | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/admin_login.php');
    require_once('view/pages/footer.php');
}

function register() {
    GLOBAL $action, $controller;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $firstName = !empty($_POST['firstName']) ? sanitiseUserInput($_POST['firstName']) : null;
        $lastName = !empty($_POST['lastName']) ? sanitiseUserInput($_POST['lastName']) : null;
        $userName = !empty($_POST['userName']) ? sanitiseUserInput($_POST['userName']) : null;
        $email = !empty($_POST['email']) ? sanitiseUserInput($_POST['email']) : null;
        $password = !empty($_POST['password']) ? password_hash(sanitiseUserInput($_POST['password']), PASSWORD_DEFAULT) : null;

        try {
            $registrationData = array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'userName' => $userName,
                'email' => $email,
                'password' => $password
            );
            insertData('users', $registrationData);
            header("location: ?controller=users&action=login");
        } catch (PDOexception $e) {
            echo "Error:".$e -> getMessage();
            die();
        }
    }

    $pageTitle = "register | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/register.php');
    require_once('view/pages/footer.php');
}

function logout() {
    GLOBAL $action, $controller;
    session_unset();
    session_destroy();
    $pageTitle = "Login | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/admin_login.php');
    require_once('view/pages/footer.php');
}

?>
