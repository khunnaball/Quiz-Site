<?php

require_once "config.php";

    try{
        $url = $_SERVER['REQUEST_URI'];
        $quiz_id = substr($url, strrpos($url, '=') + 1);

        $sql = "SELECT questions.question_id, questions.question, questions.option_1, questions.option_2, questions.option_3, questions.answer, quizes.quiz_name 
        FROM questions 
        LEFT JOIN quizes ON questions.quiz_id = quizes.quiz_id 
        WHERE questions.quiz_id = ?";
        
        $statement = $db->prepare($sql);

        $statement->execute([$quiz_id]);

        $questions = $statement->fetchAll();

        $quizName = $questions[0]['quiz_name'];

    }catch(PDOException $e){
        $error = $e->getMessage();
        error_log( preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $sql));
    }

if(isset($_POST['saveData'])) {

    try{

        $title = $_POST['param']["title"];
        $username = $_POST['param']["username"];

        $sql = "INSERT INTO quizes (quiz_name, user_created)
                VALUES (?, ?)";

        $statement=$db->prepare($sql);

        if($statement->execute([$title, $username]) == true){
            try{
                
                $quiz_id = $db->lastInsertId();
                $myData = $_POST['myData'];

                foreach($myData as $row){
                    $question = $option_a = $option_b = $option_c = $answer = '';
                    $username = $_POST['param']["username"];
                    foreach($row as $key => $rowValue){
                        
                        switch($key){
                            case "question":
                                $question = $rowValue;
                                break;
                            case "option_a":
                                $option_a = $rowValue;
                                break;
                            case "option_b":
                                $option_b = $rowValue;
                                break;
                            case "option_c":
                                $option_c = $rowValue;
                                break;
                            case "answer":
                                $answer = $rowValue;
                                break;
                        }
                    }
                    $data = "INSERT INTO questions (quiz_id, user_created, question, option_1, option_2, option_3, answer) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";

                    $stmt=$db->prepare($data);

                    $stmt->execute([$quiz_id, $username, $question, $option_a, $option_b, $option_c, $answer]);
                }
                
                if($stmt != ''){
                    $result = array("status" => "1");
                    echo json_encode($result);
                }else{
                    echo "Something went wrong. Please try again later.";
                }
                
            }catch(PDOException $e){
                $error = $e->getMessage();
                error_log( preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $data));
            }
        }

    }catch(PDOException $e){
        $error = $e->getMessage();
        error_log( preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $sql));
    }
}

if(isset($_POST['deleteQuestion'])) {

    try{

        $question_id = $_POST['question_id'];

        $sql = "DELETE FROM questions WHERE question_id = ?";

        $statement = $db->prepare($sql);

        $statement->execute([$question_id]);

    } catch(PDOException $e) {
        $error = $e->getMessage();
        error_log(preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $sql));
    }

}

if(isset($_POST['updateQuestion'])){
    try{

        $question_id = $_POST['question_id'];
        $question = $_POST['updateData'][0]['question'];
        $option_1 = $_POST['updateData'][0]['option_1'];
        $option_2 = $_POST['updateData'][0]['option_2'];
        $option_3 = $_POST['updateData'][0]['option_3'];
        $answer = $_POST['updateData'][0]['answer'];

        $sql = "UPDATE questions
                SET question = ?, option_1 = ?, option_2 = ?, option_3 = ?, answer= ?
                WHERE question_id = ?";

        $statement = $db->prepare($sql);

        $statement->execute([$question, $option_1, $option_2, $option_3, $answer, $question_id]);
       
    }catch(PDOException $e){
        $error = $e->getMessage();
        error_log( preg_replace('/\s+/', " ", $e->getMessage()) .' /// '. preg_replace('/\s+/', " ", $data));
    }
}


?>  