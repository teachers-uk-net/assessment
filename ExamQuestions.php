<?php

session_start();

include ('config.php');

$sql2_6 = "SELECT DISTINCT tQ.QuestID, tQ.QuestPart, tQ.QuestSubPart, tQ.Question, tQ.Marks, tQ.QuestionType, tSR.StudentsResponse
        FROM tblStudentResponses tSR
        INNER JOIN
            (SELECT ResponseQuestID, MAX(AnsweredAt) AS MaxAnsweredAt
                FROM tblStudentResponses
                GROUP BY ResponseQuestID) groupedresponses
        ON tSR.ResponseQuestID = groupedresponses.ResponseQuestID
        AND tSR.AnsweredAt = groupedresponses.MaxAnsweredAt
        JOIN tblQuestions tQ on tSR.ResponseQuestID = tQ.QuestID
        WHERE tQ.QuestNo=? AND tQ.TestName=? AND tSR.users_id=?";

$sql2 = "SELECT tQ.QuestID, tQ.QuestPart, tQ.QuestSubPart, tQ.Question, tQ.Marks, tQ.QuestionType, tSR.StudentsResponse
        FROM tblStudentResponses tSR
        JOIN tblQuestions tQ on tSR.ResponseQuestID = tQ.QuestID
        WHERE tQ.QuestNo=? AND tQ.TestName=? AND tSR.users_id=?";

if($stmt2 = mysqli_prepare($adminlink, $sql2)) {

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt2, "ssi", $param_QuestNo, $param_TestName, $param_users_id);
    // Set parameters
    $param_QuestNo = $QuestNo;
    $param_TestName = $_SESSION['TestName'];
    $param_users_id = $_SESSION['users_id'];

    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $QuestID, $QuestNoPart, $QuestSubPart, $Question, $Marks, $QuestionType, $SResponse);
    while (mysqli_stmt_fetch($stmt2)) {
        $QuestParts[$QuestNoPart][$QuestSubPart]['QuestID'] = $QuestID;
        $QuestParts[$QuestNoPart][$QuestSubPart]['Question'] = $Question;
        $QuestParts[$QuestNoPart][$QuestSubPart]['Marks'] = $Marks;
        $QuestParts[$QuestNoPart][$QuestSubPart]['SResponse'] = $SResponse;
        //print_r($QuestParts);
    }
    mysqli_stmt_close($stmt2);
}
mysqli_close($adminlink);