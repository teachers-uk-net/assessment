<?php
/**
 * Created by PhpStorm.
 * User: sjm
 * Date: 08/06/2018
 * Time: 09:57
 */
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
} else{
    question();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/3.3.7/dist/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ padding: 20px; }
        .card-body table th {
            border-collapse: collapse;
            padding: .4em;
            min-height: 3.5em;
        }
        table, td {
            border: 1px solid dimgrey;
            min-width: 4em;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="userPref.css">
</head>
<body onload="setInterval(function(){$.post('refresh_session.php');},600000);">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="ckeditor5-build-classic/ckeditor.js"></script>
<script>
     //refreshes the session every 10 minutes
</script>
<div class="wrapper">
    <?php
    include ('ExamQuestions.php');
        //echo "<p>From the top: </p><br>";
        //print_r($QuestParts);
        //printf("POST data: ".var_export( $_POST, true));
        //printf("<br>GET data: ".var_export( $_GET, true));
        //printf("<br>SESSION data: ".var_export( $_SESSION, true));
    ?>
    <?php if(!empty($QuestionType)): ?>
    <h2>Question <?php echo $QuestNo; ?></h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php echo display_error(); ?>
        <input type="hidden" name="QuestNo" value="<?php echo $QuestNo; ?>">
        <input type="hidden" name="QuestionType" value="<?php echo $QuestionType; ?>">
        <fieldset class="form-group">
            <?php if($QuestionType==5):?>
            <?php

            ?>
                <?php
                    foreach ($QuestParts as $x => $vals):
                        foreach($vals as $key => $val):
                            if(!empty($key)){
                                $subPart = $key.") ";
                            } else {
                                $subPart = "";
                            }
                            if(!empty($x)){
                                $Part = $x.") ";
                            } else {
                                $Part = "";
                            }
                    ?>
                <legend class="col-form-legend col-sm-8"><?php echo $QuestNo.' '.$Part.$subPart; ?></legend>
                <input type="hidden" name="QuestID[<?php echo $val['QuestID']; ?>]" value="<?php echo $val['QuestID']; ?>">
                <div class="col-sm-8">
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body"> <?php echo $val['Question']; ?></div>
                        </div>
                        <!--<label for="textResponse">

                        </label>-->
                        <textarea class="editor form-control" name="EQresponse[<?php echo $val['QuestID']; ?>]" rows="3">
                            <?php
                                echo $val['SResponse'];
                            ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-4">
                    <p><?php if ($_SESSION['NoMarks']==0){ if($val['Marks']>1){printf("(%s marks)", $val['Marks']);}else{printf("(%s mark)", $val['Marks']);} }?></p>
                </div>

                    <?php
                        endforeach;
                endforeach; ?>
                <script>
                    var allEditors = document.querySelectorAll('.editor');
                    for (var i = 0; i < allEditors.length; ++i){
                    ClassicEditor
                        .create(allEditors[i],{
                            toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList' ],
                            heading: {
                                options: [
                                    {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                                    {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                                    {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'}
                                ]
                            }
                        } )
                        .catch( error => {
                            console.error( error );
                        } );
                    }
                </script>
            <?php elseif($QuestionType==1): ?>
                <legend class="col-form-legend col-sm-10"><?php echo $Question; ?> <?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("(%s marks)", $Marks);}else{printf("(%s mark)", $Marks);} }?></legend>
                <input type="hidden" name="QuestID" value="<?php echo $QuestID; ?>">
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="response" id="<?php echo $Ans1; ?>" value="Ans1">
                        <label class="form-check-label" for="<?php echo $Ans1; ?>">
                            <?php echo $Ans1; ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="response" id="<?php echo $Ans2; ?>" value="Ans2">
                        <label class="form-check-label" for="<?php echo $Ans2; ?>">
                            <?php echo $Ans2; ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="response" id="<?php echo $Ans3; ?>" value="Ans3">
                        <label class="form-check-label" for="<?php echo $Ans3; ?>">
                            <?php echo $Ans3; ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="response" id="<?php echo $Ans4; ?>" value="Ans4">
                        <label class="form-check-label" for="<?php echo $Ans4; ?>">
                            <?php echo $Ans4; ?>
                        </label>
                    </div>
                </div>
            <?php elseif($QuestionType==2): //text ?>
                <legend class="col-form-legend col-sm-10"><?php echo $Question; ?> <?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("(%s marks)", $Marks);}else{printf("(%s mark)", $Marks);} }?></legend>
                <input type="hidden" name="QuestID" value="<?php echo $QuestID; ?>">
                <div class="col-sm-10">
                    <div class="form-group">
                        <label for="textResponse">
                            Enter your answer in the box provided
                        </label>
                        <textarea class="form-control" name="response" id="textResponse" rows="3"></textarea>
                    </div>
                </div>
            <?php elseif($QuestionType==3): //multi_text ?>
                <legend class="col-form-legend col-sm-10"><?php echo $Question; ?> <?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("(%s marks)", $Marks);}else{printf("(%s mark)", $Marks);} }?></legend>
                <input type="hidden" name="QuestID" value="<?php echo $QuestID; ?>">
            <?php for ($a = 1; $a <= $Marks; $a++): ?>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label for="textResponse<?php echo $a; ?>">
                            Answer <?php echo $a; ?>
                        </label>
                        <textarea class="form-control" name="arrResponse[]" id="textResponse<?php echo $a; ?>" rows="1"></textarea>
                    </div>
                </div>
            <?php endfor ?>
            <?php elseif($QuestionType==4): //checkbox ?>
                <legend class="col-form-legend col-sm-10"><?php echo $Question; ?> <?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("(%s marks)", $Marks);}else{printf("(%s mark)", $Marks);} }?></legend>
                <input type="hidden" name="QuestID" value="<?php echo $QuestID; ?>">
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="arrResponse[]" id="<?php echo $Ans1; ?>" value="Ans1">
                        <label class="form-check-label" for="<?php echo $Ans1; ?>">
                            <?php echo $Ans1; ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="arrResponse[]" id="<?php echo $Ans2; ?>" value="Ans2">
                        <label class="form-check-label" for="<?php echo $Ans2; ?>">
                            <?php echo $Ans2; ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="arrResponse[]" id="<?php echo $Ans3; ?>" value="Ans3">
                        <label class="form-check-label" for="<?php echo $Ans3; ?>">
                            <?php echo $Ans3; ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="arrResponse[]" id="<?php echo $Ans4; ?>" value="Ans4">
                        <label class="form-check-label" for="<?php echo $Ans4; ?>">
                            <?php echo $Ans4; ?>
                        </label>
                    </div>
                </div>
            <?php else: ?>
                <p>Something has gone wrong, please try again later.</p>
                <p><a href="welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
            <?php endif; ?>
        </fieldset>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="response_btn" value="Submit Answer">
        </div>
    </form>
    <?php else: ?>
        <h3>Test complete, well done!</h3>

        <p><a href="welcome.php" class="btn btn-primary">Return to the welcome page</a></p>
        <p><a href="welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
    <?php endif; ?>
</div>

<div id="bgBtnLinks">
    <button class="colorButtons btn-sm btn-link" onclick="changeBGColor('Cornsilk')">Cornsilk</button>
    <button class="colorButtons btn-sm btn-link" onclick="changeBGColor('White')">White</button>
    <button class="colorButtons btn-sm btn-link" onclick="changeBGColor('PowderBlue')">PowderBlue</button>
</div>


<script>
    function changeBGColor(colorName){
        document.body.style.background = colorName;
    }
</script>

</body>

</html>