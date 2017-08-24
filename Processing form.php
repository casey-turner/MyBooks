<?php
require_once("../model/db.php");
require_once ("../model/dbFunctions.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Input sanitation via the test_user_input function
    $username = !empty($_POST['username'])? test_user_input(($_POST['username'])): null;
    $password2 = !empty($_POST['password'])? test_user_input(($_POST['password'])): null;
    $name = !empty($_POST['name'])? test_user_input(($_POST['name'])): null;
    $surname = !empty($_POST['surname'])? test_user_input(($_POST['surname'])): null;
    $email = !empty($_POST['email'])? test_user_input(($_POST['email'])): null;
    $password = password_hash($password2, PASSWORD_DEFAULT);
    try {
        if ($_REQUEST['action_type'] == 'add') {
            $data = array (
                'username' => $username,
                'password' => $password,
                'name' => $name,
                'surname' => $surname,
                'email' => $email
            );
            $table = "admin";
            insertData($table, $data);
            header('location:../index.php');
        }
    } catch(PDOException $e) {
        echo "Error: ".$e -> getMessage();
        die();
    }

}
?>
