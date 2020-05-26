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
<?php foreach ($Tests as $TestName => $NoMarks): ?>
<?php printf("<p><a href='test.php?Test=%s&NoMarks=%s' class='btn btn-primary'>Start %s</a></p>", $TestName, $NoMarks, $TestName); ?>
<?php endforeach; ?>
<p><a href="welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
</body>
</html>
