<?php

// include database and object files
include_once 'config/Database.php';
include_once 'objects/Responses.php';

// assign variables to be used in responses
$QuestNo = isset($_GET['QuestNo']) ? $_GET['QuestNo'] : die('ERROR: missing QuestNo.');
$users_id = isset($_SESSION['users_id']) ? $_SESSION['users_id'] : die($_SESSION['users_id'].' <-ERROR: missing users_id, not logged in');
$TestName = isset($_GET['TestName']) ? $_GET['TestName'] : die('ERROR: missing TestName');

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

// instantiate responses
$response = new Responses($db);

// set variables for created object
$response->QuestNo = $QuestNo;
$response->TestName = $TestName;
$response->users_id = $users_id;

// query responses
$stmt = $response->read();
$num = $stmt->rowCount();

// set page header
$page_title = $TestName;
include_once "layout_header.php";

// display the current question or offer a return to the welcome page
if($num>0){

    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>QuestNo</th>";
    echo "<th>Question</th>";
    echo "<th>StudentsResponse</th>";
    echo "<th>Feedback</th>";
    echo "<th>Mark/Possible</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        echo "<tr>";
        echo "<td>{$QuestNo}{$QuestPart}{$QuestSubPart}</td>";
        echo "<td>{$Question}</td>";
        echo "<td>{$StudentsResponse}</td>";
        echo "<td>{$feedback}</td>";
        echo "<td>{$MarkAwarded}/{$Marks}</td>";

        echo "</tr>";

    }

    echo "</table>";

    // paging buttons will be here
    printf("<p><a href='viewFeedback.php?TestName=%s&QuestNo=%s' class='btn btn-info'>Next question</a></p>", $TestName, $QuestNo + 1);
    printf("<p><a href='viewFeedback.php?TestName=%s&QuestNo=%s' class='btn btn-info'>Previous question</a></p>", $TestName, $QuestNo - 1);
}

// tell the user there is nothing found
else{
    echo "<div class='alert alert-info'>Nothing found.</div>";
    // button to return to welcome page will be here
}

// set page footer
include_once "layout_footer.php";
?>
