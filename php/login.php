<?php

require_once "config.php";

//initialize session
    session_start();

//check if user is logged in, if yes then redirect to home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

//define vars and init with empty values
$username = $password = "";
$username_err = $password_err = "";

//processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    }else{
        $username = trim($_POST["username"]);
    }

    //check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    }else{
        $password = trim($_POST["password"]);
    }

    //validate
    if(empty($username_err) && empty($password_err)){

        try{
            $sql = "SELECT user_id, username, password, role FROM users WHERE username = ?";
            
            //prepare prepared statement
            $statement = $db->prepare($sql);

            //execute prepared statement
            $statement->execute([$username]);
            
            //fetch data
            $loginData = $statement->fetch();

            error_log(print_r($loginData, true));

            if(count($loginData) > 0){
                if($row = $loginData){
                    $id = $row["user_id"];
                    $username = $row["username"];
                    $hashed_password = $row["password"];
                    $role = $row['role'];
                    if(password_verify($password, $hashed_password)){
                        //password is correct, start a new session
                        session_start();
                        
                        //store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $id;
                        $_SESSION["username"] = $username;    
                        $_SESSION["role"] = $role;
                        
                        //redirect user to index page
                        header("location: index.php");
                    } else{
                        //display error message if password is not valid
                        $password_err = "The password you entered was not valid.";
                    }
                }
                }else{
                    //display error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
        }catch(PDOException $e){
            $error = $e->getMessage();
            error_log( preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $sql));
            
        }
    }
}