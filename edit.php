<?php
    require 'php/edit.php';
    include_once 'navbar.php';

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
    <title>WebbiSchools Quiz</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/edit.css">
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/edit.js"></script>
</head>
<body>
    <input id="username" value="<?php echo htmlspecialchars($_SESSION["username"]); ?>" type="hidden">

    <?php if($_SESSION['role'] == "Edit"){ ?>

    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Create/Edit Quiz</h2></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i>Add Question</button>
                    </div>
                </div>
            </div>
            <div class="row quiz_name">
                <div class="col-sm-8"><label>Quiz Title</label></div>
                <div class="col-sm-4">
                <?php if(is_numeric($quiz_id)){ ?>
                <input type="text" name="quiz_title" id="quiz_title" class="form-control" value="<?php echo $quizName ?>">
                <?php }else{ ?>
                    <input type="text" name="quiz_title" id="quiz_title" class="form-control" value="">
                <?php } ?>
            </div>
        </div>
            <table id="table_id" class="table table-bordered" cellspacing="0">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Option A</th>
                        <th>Option B</th>
                        <th>Option C</th>
                        <th>Correct Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(is_numeric($quiz_id)){
                        foreach($questions as $row) { 
                                ?>
                            <tr id="<?php echo $row['question_id'] ?>">
                                <td><?php echo $row['question'] ?></td>
                                <td><?php echo $row['option_1'] ?></td>
                                <td><?php echo $row['option_2'] ?></td>
                                <td><?php echo $row['option_3'] ?></td>
                                <td><?php echo $row['answer'] ?></td>
                                <td>
                                    <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                    <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                    <?php } }else{?>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                    <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-4">
                            <button type="button" class="btn btn-info" id="saveQuiz"><i class="fa fa-plus"></i>Save Quiz</button>
                </div>
            </div>
        </div>
    </div>

    <?php  }else{ ?>
        <div class="container">
            <form>
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?php echo $quizName ?>">
            </div>
            </div>
            <?php foreach($questions as $row) { ?>
                                <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Question</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?php echo $row['question'] ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">Option A</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?php echo $row['option_1'] ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">Option B</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?php echo $row['option_2'] ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">Option C</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?php echo $row['option_3'] ?>">
                                </div>
                                <?php if($_SESSION['role'] == "View" || $_SESSION['role'] == "Edit"){ ?>
                                <label class="col-sm-2 col-form-label">Answer</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?php echo $row['answer'] ?>">
                                </div>
                                <?php } ?>

                                </div>
                    <?php } ?>
        </form>
        </div>
   <?php } ?>
</body>
</html>