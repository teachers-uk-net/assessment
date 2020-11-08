<?php
require_once 'config/Database.php';
require_once 'objects/Users.php';

$database = new Database();
$db = $database->getConnection();

$user = new Users($db);

if($user->is_loggedin()!="")
{
    $user->redirect('welcome.php');
}

if(isset($_POST['btn-login']))
{
    $uname = $_POST['txt_uname_email'];
    //$umail = $_POST['txt_uname_email'];
    $upass = $_POST['txt_password'];

    //if($user->login($uname,$umail,$upass))
    if($user->login($uname, $upass))
    {
        $user->redirect('welcome.php');
    }
    else
    {
        $error = "Incorrect Details";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/3.3.7/dist/css/bootstrap.min.css" type="text/css"  />
    <link rel="stylesheet" href="libs/css/style.css" type="text/css"  />
</head>
<body>
<div class="container">
    <div class="form-container">
        <form method="post">
            <h2>Sign in.</h2><hr />
            <?php
            if(isset($error))
            {
                ?>
                <div class="alert alert-danger">
                    <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                </div>
                <?php
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_uname_email" placeholder="Username" required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="txt_password" placeholder="Password" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
                <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                    <i class="glyphicon glyphicon-log-in"></i>&nbsp;SIGN IN
                </button>
            </div>
            <!--<br />
            <label>Don't have account yet ! <a href="sign-up.php">Sign Up</a></label>-->
        </form>
    </div>
</div>

</body>
</html>