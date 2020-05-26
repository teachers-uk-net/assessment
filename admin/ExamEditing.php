<?php

session_start();

include ('../config.php');
global $link, $link2, $adminlink, $NextQuest, $QuestNo;

if(!isset($_GET['Test'])){
    $TestName = $_POST['TestName'];
} else {
    $TestName = $_GET['Test'];
}

$sql2 = "SELECT DISTINCT tQ.QuestID, tQ.QuestPart, tQ.QuestSubPart, tQ.Question, tQ.Marks, tQ.QuestionType, tQ.CorrectAns
        FROM tblQuestions tQ
        WHERE tQ.QuestNo=? AND tQ.TestName=?";
if($stmt2 = mysqli_prepare($adminlink, $sql2)) {

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt2, "ss", $param_QuestNo, $param_TestName);
    // Set parameters
    $param_QuestNo = $QuestNo;
    $param_TestName = $TestName;
    //$param_TestName = $_SESSION['TestName'];
    //$param_users_id = $userID;
    //$param_users_id = $_GET['users_id'];

    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $QuestID, $QuestNoPart, $QuestSubPart, $Question, $Marks, $QuestionType, $CorrectAns);
    while (mysqli_stmt_fetch($stmt2)) {
        $QuestParts[$QuestNoPart][$QuestSubPart]['QuestID'] = $QuestID;
        $QuestParts[$QuestNoPart][$QuestSubPart]['Question'] = $Question;
        $QuestParts[$QuestNoPart][$QuestSubPart]['Marks'] = $Marks;
        $QuestParts[$QuestNoPart][$QuestSubPart]['CorrectAns'] = $CorrectAns;
        //print_r($QuestParts);
    }
    mysqli_stmt_close($stmt2);
}
mysqli_close($adminlink);

