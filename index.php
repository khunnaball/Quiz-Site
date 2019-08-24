<?php

include_once 'navbar.php';
include 'php/home.php';

//init session
session_start();
 
//check if user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebbiSkools Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/home.css">

    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-12">
                <h3>All Quizzes<h3>
            </div>
            <?php if($_SESSION['role'] == "Edit"){ ?>
                <div class="col-md-2 col-sm-12">
                    <a href="edit.php" type="button"class="btn btn-success">Create Quiz</a>
                </div>
            <?php } ?>
        </div>
        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="50%">
            <thead>
                <tr>
                    <th>Quiz ID</th>
                    <th>Quiz Name</th>
                    <th>User Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($quizzes as $row) { ?>
                <tr>
                    <td><a href="edit.php?id=<?php echo $row['quiz_id'] ?>"><?php echo $row['quiz_id'] ?></a></td>
                    <td><?php echo $row['quiz_name'] ?></td>
                    <td><?php echo $row['user_created'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>