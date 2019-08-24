<?php

require_once "config.php";

$sql ="SELECT * FROM quizes";

$statement = $db->prepare($sql);

$statement->execute();

$quizzes = $statement->fetchAll();

?>