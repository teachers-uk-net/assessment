<?php
/**
 * Created by PhpStorm.
 * User: sjm
 * Date: 10/06/2018
 * Time: 21:10
 */
session_start();
// connect to database
include('config.php');


// variable declaration
$username = $password = $confirm_password = "";
$errors   = array();

// escape string
function e($val){
    global $link;
    return mysqli_real_escape_string($link, trim($val));
}

//Display errors
function display_error() {
    global $errors;

    if (count($errors) > 0){
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
        echo '</div>';
    }
}

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

// REGISTER USER
function register(){
    // call these variables with the global keyword to make them available in function
    global $link, $username, $password, $confirm_password, $errors;

    // Validate username
    if(empty(trim($_POST["username"]))){
        array_push($errors, "Please enter a username.");
    } else{
        // Prepare a select statement
        $sql = "SELECT UsersID FROM tblUsers WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);


            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    array_push($errors, "This username is already taken.");
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong line 72 functions. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty(trim($_POST['password']))){
        array_push($errors, "Please enter a password.");
    } elseif(strlen(trim($_POST['password'])) < 6){
        array_push($errors,"Password must have atleast 6 characters.");
    } else{
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        array_push($errors,"Please confirm password.");
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            array_push($errors,"Password did not match.");
        }
    }

    // Check input errors before inserting in database
    if(count($errors) == 0){

        // Prepare an insert statement
        $sql = "INSERT INTO tblUsers (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong line 118 functions. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

// return user array from their id
function getUserById($id){
    global $link;
    $query = "SELECT * FROM tblUsers WHERE UsersID=" . $id;
    $result = mysqli_query($link, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
    login();
}

// LOGIN USER
function login(){
    global $link, $username, $errors;

    // grap form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        array_push($errors, "Please enter username.");
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT UsersID, username, password, user_type FROM tblUsers WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt,$UsersID, $username, $hashed_password, $user_type);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['users_id'] = $UsersID;
                            $_SESSION['user_type'] = $user_type;
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

//Return True if user is logged in correctly
function isLoggedIn()
{
    if (isset($_SESSION['users_id'])) {
        return true;
    }else{
        return false;
    }
}

//Return True if user is an admin
function isAdmin()
{
    if (isset($_SESSION['users_id']) && $_SESSION['user_type'] == 1 ) {
        return true;
    }else{
        return false;
    }
}

//Function for welcome page to select testnames based on usersID
function welcome(){
    global $link, $Tests;
    $Tests = array();
    $sql = "SELECT tGT.TestName AS TestName, tT.DoNotShowMarks AS NoMarks
            FROM tblUsers tU
            JOIN tblUserGroups tUG on tU.UsersID = tUG.UsersID
            JOIN tblGroups tG on tUG.GroupID = tG.GroupID
            JOIN tblGroupTests tGT on tG.GroupID = tGT.GroupID
            JOIN tblTests tT on tGT.TestName = tT.TestName
            WHERE tU.UsersID=? AND tGT.Available=1";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s",$param_UsersID);
        $param_UsersID = $_SESSION['users_id'];
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_bind_result($stmt,$TestName, $NoMarks);
            while (mysqli_stmt_fetch($stmt)){
                //array_push($Tests, $TestName);
                $Tests[$TestName] = $NoMarks;
            }

        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

//Function to select the correct question from table and associated answers (if applicable), marks and type
//QuestionType is passed to the page to generate views depending on the type of question
function question(){
    global $link, $adminlink, $NextQuest, $QuestID, $Question, $Ans1, $Ans2, $Ans3, $Ans4, $Marks, $QuestionType, $QuestNo
           , $QuestNoPart, $QuestSubPart, $QuestParts, $Questions, $QuestParts2, $TestName;
    //
    if (isset($_GET['Test'])){
        $_SESSION['TestName'] = $_GET['Test'];
        $_SESSION['NoMarks'] = $_GET['NoMarks'];
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
        mysqli_stmt_bind_param($stmt, "is", $param_QuestNo,$param_TestName);
        // Set parameters
        $param_QuestNo = $QuestNo;
        $param_TestName = $_SESSION['TestName'];

        //printf("ParamQuestNo: ".$param_QuestNo."<br>ParamTestName: ".$param_TestName);

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

if (isset($_POST['response_btn']) && isset($_POST['EQresponse'])){
    EQresponse();
} elseif (isset($_POST['response_btn']) && isset($_POST['arrResponse']) or isset($_POST['response'])){
    response();
}

function EQresponse()
{
    global $link2, $NextQuest;

    $EQresponse = $_POST['EQresponse'];
    $userID = $_SESSION['users_id'];

    $counter = 0;
    foreach ($EQresponse as $y => $value) {
        $sql = "UPDATE tblStudentResponses SET StudentsResponse=? WHERE ResponseQuestID=? AND users_id=?";

        //printf("Value is: ".$value);
        //printf('y is: '.$y);
        //printf("UserID is: ".$userID);

        if ($stmt = mysqli_prepare($link2, $sql)) {
            mysqli_stmt_bind_param($stmt, "sii", $param_response, $param_questID, $param_usersID);
            $param_response = $value;
            $param_questID = $y;
            $param_usersID = $userID;

            if (mysqli_stmt_execute($stmt)) {
                $counter = $counter + 1;
            } else {
                echo "Something went wrong line 364 functions. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }

    if($counter > 0){
        //return to welcome page for next question in this format
        //header('location: welcome.php');
        // Next question!
        $NextQuest = intval($_POST['QuestNo']) + 1;
    } else{
        echo "Something went wrong line 378 functions. Please try again later.";
    }
    mysqli_close($link2);
}


//Submit responses to question database and update the Question Number to be passed back to question function
function response(){
    global $errors, $NextQuest, $link2, $LastAnswers ;

    $LastAnswers = "Wrong Place!";

    if (isset($_POST['arrResponse'])){
        $response = implode(", ", $_POST['arrResponse']);
    } else{
        $response = $_POST['response'];
    }

    if(empty(trim($response)) && $_SESSION['NoMarks']==0){
        array_push($errors,"Please enter an answer!");
        $NextQuest = intval($_POST['QuestNo']);
    } else{
        $sql = "INSERT INTO tblStudentResponses (ResponseQuestID, users_id, StudentsResponse) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link2,$sql)){
            mysqli_stmt_bind_param($stmt,"iis",$param_questID,$param_usersID, $param_response);
            $param_questID = $_POST['QuestID'];
            $param_usersID = $_SESSION['users_id'];
            $param_response = $response;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Next question!
                $NextQuest = intval($_POST['QuestNo']) + 1;
            } else{
                echo "Something went wrong line 413 functions. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link2);
}

// log user out if logout button clicked
if (isset($_GET['logout']) || isset($_POST['logout_btn'])) {
    logout();
}


function logout(){
// Unset all of the session variables
    $_SESSION = array();
// Destroy the session.
    session_destroy();
// Redirect to login page
    header("location: login.php");
}

