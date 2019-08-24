<?php

require_once "config.php";

//define variables and set with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

//process form data when it is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    //validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else {
        try {
            $param_username = trim($_POST["username"]);

            $sql = "SELECT user_id FROM users WHERE username = ?";

            $statement = $db->prepare($sql);

            $statement->execute([$param_username]);

            $checkUsername = $statement->fetch();

            if(!empty($checkUsername)) {
                $username_err = "This username is already taken.";
            } else {
                $username = trim($_POST["username"]);
            }
        } catch(PDOException $e) {
            $error = $e->getMessage();
            error_log(preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $sql));
        }
    }

    //validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters";
    } else {
        $password = trim($_POST["password"]);
    }

    //validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $password_confirm_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords did not match.";
        }
    }

    //check input errors before passsing to db
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        try{
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

            $statement=$db->prepare($sql);

            $statement->execute([$username, $hashed_password]);

            $addUser = $statement->fetch();

            if(count($addUser) > 0){
                header("location: login.php");
            }else{
                echo "Something went wrong. Please try again later.";
            }
        }catch(PDOException $e){
            $error = $e->getMessage();
            error_log( preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $sql));
        }
    }
}
?>