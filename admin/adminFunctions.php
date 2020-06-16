<?php
/**
 * Created by PhpStorm.
 * User: sjm
 * Date: 17/06/2018
 * Time: 11:43
 */
include('../functions.php');

// call the viewTest() function if viewTest_btn is clicked
/*if (isset($_POST['viewTests_btn'])) {
    viewTests();
}*/

function viewTests(){
    global $adminlink, $query;
    $TestNames = array();
    $sql = "SELECT TestName, Description, DoNotShowMarks, KS3, KS4, KS5
            FROM tblTests";

    $query = mysqli_query($adminlink, $sql);

    if (!$query) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }

}

// call the addTest() function if addTest_btn is clicked
if (isset($_POST['addTest_btn'])) {
    addTest();
}

//
function addTest(){
    global $link, $TestName, $Description, $errors, $DoNotShowMarks;

    // Validate username
    if(empty(trim($_POST["TestName"]))){
        array_push($errors, "Please enter a TestName.");
    } else{
        // Prepare a select statement
        $sql = "SELECT TestName FROM tblTests WHERE TestName = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_TestName);

            // Set parameters
            $param_TestName = trim($_POST["TestName"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    array_push($errors, "This TestName is already used.");
                } else{
                    $TestName = trim($_POST["TestName"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

        // Check input errors before inserting in database
    if(count($errors) == 0){

        // Prepare an insert statement
        $sql = "INSERT INTO tblTests (TestName, Description, DoNotShowMarks, KS3, KS4, KS5) VALUES (?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_TestName, $param_Description, $param_DoNotShowMarks, $param_KS3, $param_KS4, $param_KS5);

            // Set parameters
            $param_TestName = $TestName;
            $param_Description = trim($_POST['Description']);
            if (isset($_POST['DoNotShowMarks'])){
                $param_DoNotShowMarks = 1;
            } else{
                $param_DoNotShowMarks = 0;
            }
            if (isset($_POST['KS3'])){
                $param_KS3 = 1;
            } else{
                $param_KS3 = 0;
            }
            if (isset($_POST['KS4'])){
                $param_KS4 = 1;
            } else{
                $param_KS4 = 0;
            }
            if (isset($_POST['KS5'])){
                $param_KS5 = 1;
            } else{
                $param_KS5 = 0;
            }

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to page
                header("location: admin.php?viewTests=1");
            } else{
                echo "Something went wrong line 95 adminfunctions. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

if(isset($_GET['delTest'])){
    deleteTest();
}

function deleteTest(){
    global $adminlink;
    $sql = "DELETE FROM tblTests WHERE TestName='".$_GET['delTest']."'";

    $delQry = mysqli_query($adminlink, $sql);

    if (!$delQry) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }else{
        header("location: admin.php?viewTests=1");
    }
}

if(isset($_POST['editTest_btn'])){
    editTest();
}

function editTest()
{
    global $link, $TestName, $Description, $errors;

    // Validate username
    if(empty(trim($_POST["TestName"]))){
        array_push($errors, "Please enter a TestName.");
    } elseif(trim($_POST['TestName'])!=$_POST['editTest']){
        // Prepare a select statement
        $sql = "SELECT TestName FROM tblTests WHERE TestName = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_TestName);

            // Set parameters
            $param_TestName = trim($_POST["TestName"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // store result
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    array_push($errors, "This TestName is already used.");
                } else{
                    $TestName = trim($_POST["TestName"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Check input errors before inserting in database
    if(count($errors) == 0){

        // Prepare an insert statement
        $sql = "UPDATE tblTests SET TestName=?, Description=?, DoNotShowMarks=? WHERE TestName=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssis", $param_TestName, $param_Description, $param_DoNotShowMarks, $param_editTest);

            // Set parameters
            $param_TestName = trim($_POST['TestName']);
            $param_Description = trim($_POST['Description']);
            $param_editTest = $_POST['editTest'];
            if (isset($_POST['DoNotShowMarks'])){
                $param_DoNotShowMarks = 1;
            } else{
                $param_DoNotShowMarks = 0;
            }

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to page
                header("location: admin.php?viewTests=1");
            } else{
                echo "Something went wrong line 190 adminfunctions. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

if (isset($_POST['viewQues_btn'])) {
    viewQues();
}
//
function viewQues(){
    global $adminlink, $qryQues;
    $TestNames = array();
    $sql = "SELECT tQ.QuestID, tQ.QuestNo, tQ.Question, tQ.Ans1, tQ.Ans2, tQ.Ans3, tQ.Ans4, tQ.CorrectAns, tQ.Marks, tQT.Description
            FROM tblQuestions tQ
            JOIN tblQuestionTypes tQT on tQ.QuestionType = tQT.QuestionType
            WHERE tQ.TestName='".$_GET['viewQues']."' ORDER BY tQ.QuestNo";

    $qryQues = mysqli_query($adminlink, $sql);

    if (!$qryQues) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }

}

function editQues(){
    //
    global $link, $GroupID, $Description, $errors;

    if(empty(trim($_POST["GroupID"]))){
        array_push($errors, "Please enter a Group Name.");
    } else{
        // Prepare a select statement
        $sql = "SELECT GroupID FROM tblGroups WHERE GroupID = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_GroupID);

            // Set parameters
            $param_GroupID = trim($_POST["GroupID"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    array_push($errors, "This Group Name is already used.");
                } else{
                    $GroupID = trim($_POST["GroupID"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Check input errors before inserting in database
    if(count($errors) == 0){

        // Prepare an insert statement
        $sql = "UPDATE tblQuestions SET Question=?, CorrectAns=?, Marks=? WHERE QuestID=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssis", $param_Question, $param_CorrectAns, $param_Marks, $param_quesID);

            // Set parameters
            $param_Question = $_POST['Question'];
            $param_CorrectAns = $_POST['CorrectAns'];
            $param_Marks = $_POST['Marks'];
            $param_quesID = $_GET['editQues'];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to page
                header("location: admin.php?viewGroups=1");
            } else{
                echo "Something went wrong line 279 adminfunctions. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}

//function addQues(){
//
//}

function viewGroups(){
    global $adminlink, $qryGroups;
    $TestNames = array();
    $sql = "SELECT GroupID, GroupDesc
            FROM tblGroups";

    $qryGroups = mysqli_query($adminlink, $sql);

    if (!$qryGroups) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }

}

if (isset($_POST['addGroup_btn'])) {
    addGroup();
}

function addGroup(){
    global $link, $GroupID, $Description, $errors;

    // Validate username
    if(empty(trim($_POST["GroupID"]))){
        array_push($errors, "Please enter a Group Name.");
    } else{
        // Prepare a select statement
        $sql = "SELECT GroupID FROM tblGroups WHERE GroupID = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_GroupID);

            // Set parameters
            $param_GroupID = trim($_POST["GroupID"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    array_push($errors, "This Group Name is already used.");
                } else{
                    $GroupID = trim($_POST["GroupID"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Check input errors before inserting in database
    if(count($errors) == 0){

        // Prepare an insert statement
        $sql = "INSERT INTO tblGroups (GroupID, GroupDesc) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_GroupID, $param_GroupDesc);

            // Set parameters
            $param_GroupID = $GroupID;
            $param_GroupDesc = trim($_POST['GroupDesc']);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to page
                header("location: admin.php?viewGroups=1");
            } else{
                echo "Something went wrong line 367 adminfunctions. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

if(isset($_GET['delGroup'])){
    deleteGroup();
}

function deleteGroup(){
    global $adminlink;
    $sql = "DELETE FROM tblGroups WHERE GroupID='".$_GET['delGroup']."'";

    $delQry = mysqli_query($adminlink, $sql);

    if (!$delQry) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }else{
        header("location: admin.php?viewGroups=1");
    }
}

if(isset($_POST['editGroup_btn'])){
    editGroup();
}

function editGroup(){
    global $link, $GroupID, $Description, $errors;

    // Validate username
    if(empty(trim($_POST["GroupID"]))){
        array_push($errors, "Please enter a Group Name.");
    } else{
        // Prepare a select statement
        $sql = "SELECT GroupID FROM tblGroups WHERE GroupID = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_GroupID);

            // Set parameters
            $param_GroupID = trim($_POST["GroupID"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    array_push($errors, "This Group Name is already used.");
                } else{
                    $GroupID = trim($_POST["GroupID"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Check input errors before inserting in database
    if(count($errors) == 0){

        // Prepare an insert statement
        $sql = "UPDATE tblGroups SET GroupID=?, GroupDesc=? WHERE GroupID=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_GroupID, $param_GroupDesc, $param_editGroup);

            // Set parameters
            $param_GroupID = $GroupID;
            $param_GroupDesc = trim($_POST['GroupDesc']);
            $param_editGroup = $_POST['editGroup'];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to page
                header("location: admin.php?viewGroups=1");
            } else{
                echo "Something went wrong line 456 adminfunctions. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}



//Other management functions yet to be written
//addQues() needs to go in around line 212 and in to admin.php
//Need to assign groups to test

//Need to view students from groups
function viewStudents(){
    global $adminlink, $qryStudents;
    $TestNames = array();
    $sql = "SELECT UsersID, username, user_type
            FROM tblUsers";

    $qryStudents = mysqli_query($adminlink, $sql);

    if (!$qryStudents) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }
}

function viewStudentsForGroups(){
    global $adminlink, $qryStudentsForGroups;
    $TestNames = array();
    $sql2 = "SELECT UsersID, username
            FROM tblUsers";

    $qryStudentsForGroups = mysqli_query($adminlink, $sql2);

    if (!$qryStudentsForGroups) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }
}

function viewStudentGroups(){
    global $adminlink, $qryStudentGroup;
    $TestNames = array();
    $sql = "SELECT tU.UsersID, tU.username, tU.user_type
            FROM tblUsers tU
            JOIN tblUserGroups tUG on tU.UsersID = tUG.UsersID
            WHERE tUG.GroupID='".$_GET['viewStudentGroups']."'";

    $qryStudentGroup = mysqli_query($adminlink, $sql);

    if (!$qryStudentGroup) {
        die ('SQL Error: ' . mysqli_error($adminlink));
    }
}

//Need to be able to add students
function addStudents(){

}


//Need to be able to add students to groups
function addGroupStudents(){

}

//Probably also need to edit and delete students

//choose Test to view
function selectTest(){
    global $adminlink, $qrySelectTests;
    $sql = "SELECT tGT.TestName, tG.GroupID
            FROM tblGroupTests tGT
            JOIN tblGroups tG on tGT.GroupID = tG.GroupID
            WHERE tGT.TestName='".$_GET['selectTest']."' AND tGT.Available=1";

    $qrySelectTests = mysqli_query($adminlink, $sql);

    if(!$qrySelectTests){
        die('SQL Error: '.mysqli_error($adminlink));
    }
}

//Need to view and mark submissions
function markTests(){
    global $adminlink, $qryMarkTests;
    $sql = "SELECT DISTINCT tU.username, tG.GroupID, tU.UsersID, tT.KS3, tT.KS4, tT.KS5
            FROM tblStudentResponses tSR
            JOIN tblQuestions tQ on tSR.ResponseQuestID = tQ.QuestID
            JOIN tblUsers tU on tSR.users_id = tU.UsersID
            JOIN tblUserGroups tUG on tU.UsersID = tUG.UsersID
            JOIN tblGroups tG on tUG.GroupID = tG.GroupID
            JOIN tblTests tT on tQ.TestName = tT.TestName
            WHERE tG.GroupID='".$_GET['group']."' AND tQ.TestName='".$_GET['selectTest']."'";

    $qryMarkTests = mysqli_query($adminlink, $sql);

    if(!$qryMarkTests){
        die('SQL Error: '.mysqli_error($adminlink));
    }
}

//line 332 testAssign in admin.php
function testAssign(){
    global $link, $qryTestAssign;
    $sql = "SELECT tG.GroupID, tGT.TestName, tGT.Available, tGT.marked
            FROM tblGroups tG
            LEFT JOIN tblGroupTests tGT ON tG.GroupID = tGT.GroupID
            AND tGT.TestName='".$_GET['testAssign']."'";

    $qryTestAssign = mysqli_query($link, $sql);

    if (!$qryTestAssign){
        die('SQL Error: '.mysqli_error($link));
    }
}

if(isset($_POST['assignTest_btn'])){
    assignTest();
}

function assignTest(){
    global $link2, $link, $NextQuest, $TestName;

    $assignTest = $_POST['assignedTest'];
    //$subcheck = (isset($_POST['subcheck'])) ? 1 : 0;
    $TestName = $_POST['TestName'];
    //$MarkAvailable = $_POST['EQMark'];
    $marked = $_POST['marked'];
    $counter = 0;


    foreach ($assignTest as $y => $value){
        //$sql = "UPDATE tblGroupTests SET Available=? WHERE GroupID=? AND TestName=?";

        //$sql = "REPLACE INTO tblGroupTests (GroupID, TestName, Available)
        //        VALUES (?,?,?)";

        $sql = "INSERT INTO tblGroupTests (GroupID, TestName, Available, marked)
                VALUES (?,?,?,?)
                ON DUPLICATE KEY UPDATE Available=?";



        if ($stmt = mysqli_prepare($link2, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssii", $param_Group, $param_Test, $param_available, $param_available, $param_marked);
            $param_available = $value;
            $param_Group = $y;
            $param_Test = $TestName;
            $param_marked = $marked[$y];

            if (mysqli_stmt_execute($stmt)) {
                $counter = $counter + 1;
            } else {
                echo "<br>Something went wrong line 596 adminfunctions. Please try again later. Counter is: " . $counter."<br>";
                echo mysqli_error($link2)."<br>";
                print_r("Available: ".$value);
                print_r(" Group: ".$assignTest[$y]);
                print_r(" Test: ".$TestName);
                print_r(" y: ".$y);
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link2);

    if($counter > 0){
        $sql2 = "INSERT INTO tblStudentResponses
                    (ResponseQuestID, users_id)
                SELECT tQ.QuestID, tU.UsersID FROM tblGroupTests tGT
                JOIN tblGroups tG on tGT.GroupID = tG.GroupID
                JOIN tblUserGroups tUG on tG.GroupID = tUG.GroupID
                RIGHT JOIN tblUsers tU on tUG.UsersID = tU.UsersID
                JOIN tblTests tT on tGT.TestName = tT.TestName
                RIGHT JOIN tblQuestions tQ on tT.TestName = tQ.TestName
                WHERE tGT.TestName = '".$TestName."' AND
                NOT EXISTS
                    (SELECT 1 FROM tblStudentResponses tSR
                    WHERE tQ.QuestID = tSR.ResponseQuestID
                    AND tU.UsersID = tSR.users_id)";

        $qryAssignTest = mysqli_query($link, $sql2);

        if (!$qryAssignTest){
            die('SQL Error adminFunctions.php line 623: '.mysqli_error($link));
        }

    }
    mysqli_close($link);
}



if (isset($_POST['marking_btn']) && isset($_POST['EQfeedback'])){
    EQmarking();
}

function EQmarking()
{
    global $adminlink, $link2, $NextQuest, $TestName;

    $EQfeedback = $_POST['EQfeedback'];
    $userID = $_POST['users_id'];
    $MarkAwarded = $_POST['MarkAwarded'];
    $trackingSubmitted = $_POST['tracking'];
    $Keystage3 = $_POST['KS3'];
    $Keystage4 = $_POST['KS4'];
    $Keystage5 = $_POST['KS5'];
    //print_r($EQfeedback);
    //printf("userID: ".$userID."<br>");
    //print_r($MarkAwarded);

    $counter = 0;
    foreach ($EQfeedback as $y => $value) {
        $sql = "UPDATE tblStudentResponses SET feedback=?, MarkAwarded=?, MarkedOn=NOW() WHERE ResponseQuestID=? AND users_id=?";
        //printf("val of feedback: ".$value."");
        //printf("val of MarkAwarded[y]: ".$MarkAwarded[$y]."<br>");
        //printf("value of questID: ".$y."<br>");
        //printf("value of userID: ".$userID."<br>");
        if ($stmt = mysqli_prepare($link2, $sql)) {
            mysqli_stmt_bind_param($stmt, "siii", $param_feedback, $param_MarkAwarded, $param_questID, $param_usersID);
            $param_feedback = $value;
            $param_MarkAwarded = $MarkAwarded[$y];
            $param_questID = $y;
            $param_usersID = $userID;

            if (mysqli_stmt_execute($stmt)) {
                $counter = $counter + 1;
            } else {
                echo "Something went wrong line 686 adminfunctions. Please try again later. Counter is: ".$counter;
            }
        }
        mysqli_stmt_close($stmt);
    }

    if($counter > 0){
        //return to welcome page for next question in this format
        //header('location: welcome.php');
        // Next question!
        $NextQuest = intval($_POST['QuestNo']) + 1;
        $TestName = $_POST['TestName'];
        //printf("NextQuest: ".$NextQuest."<br>TestName: ".$TestName);
        //printf("SESSION TestName: ".$_SESSION['TestName']);
    } else{
        echo "Something went wrong line 701 adminfunctions. Please try again later.";
    }
    mysqli_close($link2);

    //Code to update tracking tables goes here
    //print_r($trackingSubmitted);
    $trackingSets = array();
    foreach ($trackingSubmitted as $key => $val){
        $trackingSets[] = $key . "=" .$val;
    }
    if ($Keystage3 == 1){
        $updTracking = "UPDATE KS3Tracking SET ".join(",",$trackingSets)." WHERE userID=".$userID;
    } elseif ($Keystage4 == 1){
        $updTracking = "UPDATE KS4Tracking SET ".join(",",$trackingSets)." WHERE userID=".$userID;
    } elseif ($Keystage5 == 1){
        $updTracking = "UPDATE KS5Tracking SET ".join(",",$trackingSets)." WHERE userID=".$userID;
    }
    if ($insResult = mysqli_query($adminlink,$updTracking)){
        echo '<script>console.log("Tracking data updated");</script>';
    } else {
        die('SQL Error inserting Tracking data line 740: ' . mysqli_error($adminlink));
    }
    //print_r($trackingSets);


}

if (isset($_POST['editEQ_btn'])){
    EQedit();
}

function EQedit()
{
    global $link2, $NextQuest, $TestName;

    $EQedit = $_POST['EQedit'];
    $CorrectAns = $_POST['EQanswer'];
    $MarkAvailable = $_POST['EQMark'];
    //print_r($EQfeedback);
    //printf("userID: ".$userID."<br>");
    //print_r($MarkAwarded);

    $counter = 0;
    foreach ($EQedit as $y => $value) {
        $sql = "UPDATE tblQuestions SET Question=?, CorrectAns=?, Marks=? WHERE QuestID=?";
        //printf("val of feedback: ".$value."");
        //printf("val of MarkAwarded[y]: ".$MarkAwarded[$y]."<br>");
        //printf("value of questID: ".$y."<br>");
        //printf("value of userID: ".$userID."<br>");
        if ($stmt = mysqli_prepare($link2, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssii", $param_edit, $param_CorrectAns, $param_MarkAvailable, $param_questID);
            $param_edit = $value;
            $param_CorrectAns = $CorrectAns[$y];
            $param_MarkAvailable = $MarkAvailable[$y];
            $param_questID = $y;
            //$param_usersID = $userID;

            if (mysqli_stmt_execute($stmt)) {
                $counter = $counter + 1;
            } else {
                echo "Something went wrong line 686 adminfunctions. Please try again later. Counter is: ".$counter;
            }
        }
        mysqli_stmt_close($stmt);
    }

    if($counter > 0){
        //return to welcome page for next question in this format
        //header('location: welcome.php');
        // Next question!
        $NextQuest = intval($_POST['QuestNo']) + 1;
        $TestName = $_POST['TestName'];
        //printf("NextQuest: ".$NextQuest."<br>TestName: ".$TestName);
        //printf("SESSION TestName: ".$_SESSION['TestName']);
    } else{
        echo "Something went wrong line 701 adminfunctions. Please try again later.";
    }
    mysqli_close($link2);
}

//Not used
function marking(){
    global $link, $link2, $adminlink, $NextQuest, $QuestID, $Question, $Ans1, $Ans2, $Ans3, $Ans4, $Marks, $QuestionType, $QuestNo
           , $QuestNoPart, $QuestSubPart, $QuestParts, $Questions, $QuestParts2;
//
    if (isset($_GET['Test'])){
        $TestName = $_GET['Test'];
        //$_SESSION['NoMarks'] = $_GET['NoMarks'];
    }
//if $NextQuest is not set then QuestID=1 else QuestID=$NextQuest
    if($NextQuest > 1){
        $QuestNo = $NextQuest;
    } else{
        $QuestNo = 1;
    }
    $sql = "SELECT QuestID, QuestPart, QuestSubPart, Question, Ans1, Ans2, Ans3, Ans4, Marks, QuestionType 
            FROM tblQuestions WHERE QuestNo=? AND TestName=? ORDER BY QuestPart,QuestSubPart";
    if($stmt = mysqli_prepare($link, $sql)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_QuestNo,$param_TestName);
        // Set parameters
        $param_QuestNo = $QuestNo;
        $param_TestName = $TestName;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){
                // Bind result variables
                mysqli_stmt_bind_result($stmt,$QuestID, $QuestNoPart, $QuestSubPart, $Question, $Ans1, $Ans2, $Ans3, $Ans4, $Marks, $QuestionType);

                if(mysqli_stmt_fetch($stmt)){
                    if($QuestionType == 1){
                        /* Radio button style question*/
                        //   echo "Question Type is 1: radio buttons";
                    } elseif($QuestionType==2){
                        //Single text box question
                        //    echo "Question Type is 2: single text box";
                    } elseif($QuestionType==3){
                        //Multi text box question
                        //    echo "Question Type is 3: multiple text answers";
                    } elseif($QuestionType==4){
                        //Checkboxes question
                        //    echo "Question Type is 4: checkbox";
                    } elseif($QuestionType==5){
                        //Checkboxes question
                        //    echo "Question Type is 5: examQuestion";
                    } else{
                        //Catch an error unknown questiontype
                        echo "Unknown question type";
                    }
                } else{
                    // Display an error message if questID doesn't exist
                    echo "Question does not exist";
                }
            } else{
                //echo "That is the end of the test, thank you.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
// Close connection
    mysqli_close($link);
}

?>