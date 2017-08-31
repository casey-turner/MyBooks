
        <?php
        if (!($action == "register" || $action == 'login' || $action == 'logout')) { ?>
            <footer> © 2017 MyBooks.com.au. All Rights Reserved.</footer>
            <?php
        }
             ?>
        <script src="view/js/main.js"></script>
    </body>
</html>
<?php
//Echoing session variable for debugging purposes
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
 ?>
