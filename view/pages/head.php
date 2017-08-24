<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $pageTitle; ?></title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <link href="view/css/styles.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
<?php

if (!($action == "register" || $action == 'login' || $action == 'logout')) { ?>
    <header class="primary-header">
        <div class="container">
            <a href="#"><img src="view/images/logo.png" alt="My Books"></a>
            <img class="mobileMenu" src="view/images/mobile-menu.png" alt="mobile menu" />
            <nav class="primary-nav">
                <ul>
                    <li><a <?php if ($action == "displaybooks") { echo 'class="current"';} ?> href="?controller=books&action=displaybooks">Display Books</a></li>
                    <li><a <?php if ($action == "addbook") { echo 'class="current"';} ?>href="?controller=books&action=addbook">Add Book</a></li>
                    <li><a href="?controller=users&action=logout">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <?php

}


?>
