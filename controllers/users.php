<?php
// Validate page control $_GET parameter
if (isset($_GET['state'])) {
    $state = $_GET['state'];
} else {
    $state = 'null';
}

// Do authentication Checks
if ($state == 'loginprocessing') {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        if ( db_authenticate(sanitiseUserInput( $_POST['username']), sanitiseUserInput($_POST['password'])) ) {
            $_SESSION['userstate'] = 'admin';
            header("location: ?controller=books&action=displaybooks");
        } else {
            $errorMsg = 'Login failed. Try again';
        }
    }
}
password = password_hash($password2, password_default);
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
    GLOBAL $action;
    $pageTitle = "Login | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/admin_login.php');
    require_once('view/pages/footer.php');
}

function register() {
    GLOBAL $action;
    $pageTitle = "register | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/register.php');
    require_once('view/pages/footer.php');
}

function logout() {
    GLOBAL $action;
    session_unset();
    session_destroy();
    $pageTitle = "Login | My Books";
    require_once('view/pages/head.php');
    require_once('view/pages/admin_login.php');
    require_once('view/pages/footer.php');
}

?>
