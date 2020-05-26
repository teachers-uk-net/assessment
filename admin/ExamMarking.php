<?php

session_start();

include ('../config.php');
global $link, $link2, $adminlink, $NextQuest, $QuestNo;

if(!isset($_GET['users_id'])){
    $userID = $_POST['users_id'];
} else{
    $userID = $_GET['users_id'];
}
if(!isset($_GET['Test'])){
    $TestName = $_POST['TestName'];
} else {
    $TestName = $_GET['Test'];
}

$sql2_7a = "SELECT DISTINCT tQ.QuestID, tQ.QuestPart, tQ.QuestSubPart, tQ.Question, tQ.Marks, tQ.QuestionType, tQ.CorrectAns, tSR.StudentsResponse, tSR.feedback, tSR.MarkAwarded
        FROM tblStudentResponses tSR
        INNER JOIN
            (SELECT ResponseQuestID, MAX(AnsweredAt) AS MaxAnsweredAt
                FROM tblStudentResponses
                GROUP BY ResponseQuestID) groupedresponses
        ON tSR.ResponseQuestID = groupedresponses.ResponseQuestID
        AND tSR.AnsweredAt = groupedresponses.MaxAnsweredAt
        JOIN tblQuestions tQ on tSR.ResponseQuestID = tQ.QuestID
        WHERE tQ.QuestNo=? AND tQ.TestName=? AND tSR.users_id=?";

$sql2 = "SELECT tQ.QuestID, tQ.QuestPart, tQ.QuestSubPart, tQ.Question, tQ.Marks, tQ.QuestionType, tQ.CorrectAns, tSR.StudentsResponse, tSR.feedback, tSR.MarkAwarded
        FROM tblStudentResponses tSR
        JOIN tblQuestions tQ on tSR.ResponseQuestID = tQ.QuestID
        WHERE tQ.QuestNo=? AND tQ.TestName=? AND tSR.users_id=?";

if($stmt2 = mysqli_prepare($adminlink, $sql2)) {

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt2, "isi", $param_QuestNo, $param_TestName, $param_users_id);
    // Set parameters
    $param_QuestNo = $QuestNo;
    $param_TestName = $TestName;
    //$param_TestName = $_SESSION['TestName'];
    $param_users_id = $userID;
    //$param_users_id = $_GET['users_id'];

    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $QuestID, $QuestNoPart, $QuestSubPart, $Question, $Marks, $QuestionType, $CorrectAns, $SResponse, $feedback, $MarkAwarded);
    while (mysqli_stmt_fetch($stmt2)) {
        $QuestParts[$QuestNoPart][$QuestSubPart]['QuestID'] = $QuestID;
        $QuestParts[$QuestNoPart][$QuestSubPart]['Question'] = $Question;
        $QuestParts[$QuestNoPart][$QuestSubPart]['Marks'] = $Marks;
        $QuestParts[$QuestNoPart][$QuestSubPart]['CorrectAns'] = $CorrectAns;
        $QuestParts[$QuestNoPart][$QuestSubPart]['SResponse'] = $SResponse;
        $QuestParts[$QuestNoPart][$QuestSubPart]['feedback'] = $feedback;
        $QuestParts[$QuestNoPart][$QuestSubPart]['MarkAwarded'] = $MarkAwarded;
        //print_r($QuestParts);
    }
    mysqli_stmt_close($stmt2);
}
mysqli_close($adminlink);

