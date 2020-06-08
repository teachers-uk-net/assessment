<?php
session_start();

if (isset($_SESSION['username'])) { //if you have more session-vars that are needed for login, also check if they are set and refresh them as well
    $_SESSION['username'] = $_SESSION['username'];
    $_SESSION['users_id'] = $_SESSION['users_id'];
    $_SESSION['user_type'] = $_SESSION['user_type'];
}
if (isset($_SESSION['TestName'])){
    $_SESSION['TestName'] = $_SESSION['TestName'];
    $_SESSION['NoMarks'] = $_SESSION['NoMarks'];
}
?>


