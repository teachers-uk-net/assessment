<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $page_title; ?></title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/3.3.7/dist/css/bootstrap.css" />

    <!-- our custom CSS -->
    <link rel="stylesheet" href="libs/css/custom.css" />
    <link rel="stylesheet" href="libs/css/userPref.css" />

</head>
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="ckeditor5-build-classic/ckeditor.js"></script>
<!-- container -->
<div class="container">

    <?php
    // show page header
    echo "<div class='page-header'>
                <h1>{$page_title}</h1>
            </div>";
    ?>
