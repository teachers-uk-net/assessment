<?php
session_start();

include ('config.php');
function getStudentResponses($RQID){
    global $link;

    $users_id = $_SESSION['users_id'];
    $sql = "SELECT tSR.StudentsResponse
                                    FROM urswick.tblStudentResponses tSR
                                    WHERE tSR.users_id=? AND tSR.ResponseQuestID=? AND tSR.StudentsResponse <> ''
                                    ORDER BY tSR.AnsweredAt DESC
                                    LIMIT 1";
    if ($stmtR = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "iis", $param_users_id, $param_RQID);
        $param_users_id = $users_id;
        $param_RQID = $RQID;

        if (mysqli_stmt_execute($stmtR)) {
            mysqli_stmt_store_result($stmtR);
            mysqli_stmt_bind_result($stmtR, $studentsResponse);
            echo $studentsResponse;
        } else {
            echo "Enter your answer...".$RQID;
        }
    }
    mysqli_stmt_close($stmtR);

    mysqli_close($link);
}