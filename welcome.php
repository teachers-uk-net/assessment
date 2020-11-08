<?php

/**
 * Created by PhpStorm.
 * User: sjm
 * Date: 31/05/2018
 * Time: 21:54
 */
// If session variable is not set it will redirect to login page
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
} else{
    welcome();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="../bootstrap/3.3.7/dist/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div class="page-header">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>.</h1>
    <!--<p>Your UserID is <?php /*echo htmlspecialchars($_SESSION['users_id']); */?></p>-->
</div>
<?php if ($_SESSION['user_type']==1): ?>
    <p><a href="admin/admin.php" class="btn btn-primary">Admin page</a></p>
<?php endif; ?>
<?php foreach ($Tests as $TestName => $vals): ?>
<?php

    if($vals['marked'] == 1){
        //printf("<p><a href='viewMarks.php?Test=%s&NoMarks=%s&users_id=%s&KS3=%s&KS4=%s&KS4_2020=%s&KS5=%s&QuestNo=1' class='btn btn-info'>View marks for %s</a></p>", $TestName, $vals['NoMarks'], $_SESSION['users_id'], $vals['KS3'], $vals['KS4'], $vals['KS4_2020'], $vals['KS5'], $TestName);
        printf("<p><a href='viewFeedback.php?TestName=%s&QuestNo=1' class='btn btn-info'>View feedback for %s</a></p>", $TestName, $TestName);

        //print_r("This has been marked");
    } else {
        printf("<p><a href='takeTest.php?TestName=%s&QuestNo=1&NoMarks=%s' class='btn btn-primary'>Start %s</a></p>", $TestName, $vals['NoMarks'], $TestName);
    }
?>
<?php endforeach; ?>
<p><a href="welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
</body>
</html>
