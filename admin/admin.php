<?php
/**
 * Created by PhpStorm.
 * User: sjm
 * Date: 15/06/2018
 * Time: 11:58
 */
//include ('functions.php');
include('adminFunctions.php');
if(!isAdmin()){
    header('location:../login.php');
} /*else{

}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin page</title>
    <link rel="stylesheet" href="../../bootstrap/3.3.7/dist/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .border-bottom{ text-align: center; }
        .wrapper{ padding: 20px; }
    </style>
</head>
<body>
<div class="border-bottom">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to the Admin page.</h1>
    <!--<p>Your UserID is <?php /*echo htmlspecialchars($_SESSION['users_id']); */?></p>-->
</div>
<?php echo display_error(); ?>
<div class="wrapper">
<?php
    if(isset($_GET['viewTests'])){
        viewTests();
        require 'viewTests.php';
    } elseif (isset($_GET['editTest'])){
        require 'editTest.php';
    } elseif (isset($_GET['viewQues'])){
        viewQues();
        require 'viewQues.php';
    } elseif (isset($_GET['editQues'])){
        editQues();
        require 'editQues.php';
    } elseif (isset($_GET['viewStudents'])){
        viewStudents();
        require 'viewStudents.php';
    } elseif (isset($_GET['viewGroups'])){
        viewGroups();
        require 'viewGroups.php';
    } elseif (isset($_GET['editGroup'])){
        require 'editGroup.php';
    } elseif (isset($_GET['viewStudentGroups'])){
        viewStudentGroups();
        require 'viewStudentGroups.php';
    } elseif (isset($_GET['testAssign'])){
        testAssign();
        require 'testAssign.php';
    } elseif (isset($_GET['selectTest'])){
        selectTest();
        require 'selectTest.php';
    }
?>

<div class="wrapper">
<p><a href="admin.php?viewTests=1" class="btn btn-link" name="viewTests_btn">Manage Tests and Questions</a></p>
<p><a href="admin.php?viewGroups=1" class="btn btn-link" name="viewGroups_btn">View / edit groups</a></p>
<p><a href="admin.php?viewStudents=1" class="btn btn-link" name="viewStudents_btn">View / edit students</a></p>
<!--<p><a href="admin.php?viewAssign=1" class="btn btn-link" name="viewAssign_btn">View / edit assigned Tests</a></p>-->
<!--<p><a href="admin.php?markTests=1" class="btn btn-link" name="viewAssign_btn">View submitted Tests</a></p>-->
<p><a href="../welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
</div>
</body>
</html>
