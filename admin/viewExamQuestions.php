<?php
//unset($_POST);
//include ('ExamMarking.php');
include ('adminFunctions.php');
if(!isAdmin()){
    header('location:../login.php');
}else{
    question();
}
//marking();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marking Question</title>
    <link rel="stylesheet" href="../../bootstrap/3.3.7/dist/css/bootstrap.css">
    <link rel="stylesheet" href="tracking.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ padding: 20px; }
        blockquote{background-color: lightblue; }
    </style>
</head>
<body onload="setInterval(function(){$.post('/../refresh_session.php');},600000);">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="../ckeditor5-build-classic/ckeditor.js"></script>
<div class="wrapper">
    <?php
    include ('ExamMarking.php');
    //echo "<p>From the top: </p><br>";
    //print_r($QuestParts);
    ?>
    <?php //if(!empty($QuestionType)): ?>
    <div id="trackingLink">
        <a class="btn btn-link" onclick="showTracking()">Show / hide tracking</a>
    </div>
    <div id="tracking">
        <div class="panel panel-default">
            <table class="table">
                <tr>
                    <td>Uses software under the control of the teacher to create, store and edit digital content using appropriate file and folder names.</td>
                    <td><input type="checkbox"></td>
                </tr>
                <tr>
                    <td>Understands that people interact with computers.</td>
                    <td><input type="checkbox"></td>
                </tr>
                <tr>
                    <td>Shares their use of technology in school.</td>
                    <td><input type="checkbox"></td>
                </tr>
            </table>
        </div>
        Tracking details here
    </div>
    <?php if(!empty($QuestNo)): ?>
<!--    <h2>Question --><?php //echo $QuestNo; ?><!--</h2>-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php echo display_error(); ?>
        <?php
        if(!isset($_GET['users_id'])){
            $userID = $_POST['users_id'];
        } else{
            $userID = $_GET['users_id'];
        }
        if(!isset($_GET['Test'])){
            $TestName = $_POST['TestName'];
        } else {
            $TestName = $_GET['Test'];
        }
        ?>
        <input type="hidden" name="QuestNo" value="<?php echo $QuestNo; ?>">
        <input type="hidden" name="QuestionType" value="<?php echo $QuestionType; ?>">
        <input type="hidden" name="users_id" value="<?php echo $userID; ?>">
        <input type="hidden" name="TestName" value="<?php echo $TestName; ?>">
        <fieldset class="form-group">
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
                            <label for="textResponse">
                                <?php echo $val['Question']; ?>
                            </label>
                            <hr>
                            <div>
                                <h2>Mark scheme:</h2>
                                <?php echo $val['CorrectAns']; ?>
                            </div>
                            <hr>
                            <blockquote>
                                <h2>Students response:</h2>
                                <?php
                                echo $val['SResponse'];
                                ?>
                            </blockquote>
                            <label for="editor<?php echo $val['QuestID']; ?>">Enter feedback:</label>
                            <textarea class="form-control" name="EQfeedback[<?php echo $val['QuestID']; ?>]" id="editor<?php echo $val['QuestID']; ?>" rows="3">
                            <?php echo $val['feedback']; ?>
                        </textarea>
                            <label for="Mark<?php echo $val['QuestID']; ?>">Enter mark:</label>
                            <input type="number" name="MarkAwarded[<?php echo $val['QuestID']; ?>]" id="Mark<?php echo $val['QuestID']; ?>" value="<?php echo $val['Marks']; ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p><?php if ($_GET['NoMarks']==0){ if($val['Marks']>1){printf("(%s marks)", $val['Marks']);}else{printf("(%s mark)", $val['Marks']);} }?></p>
                    </div>
                    <script>
                        ClassicEditor
                            .create( document.querySelector( '#editor<?php echo $val["QuestID"]; ?>' ),{
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
                    </script>
                <?php
                endforeach;
            endforeach; ?>
                <?php else: ?>
                <p>Something has gone wrong, line 105 viewExamQuestions, please try again later.</p>
                <p><a href="../welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
                <?php

                    ?>
            <?php endif; ?>
        </fieldset>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="marking_btn" value="Submit Marks">
            <!--<input type="submit" class="btn btn-primary" name="previous_btn" value="Previous Question">-->
        </div>
    </form>
</div>
<div class="wrapper">
    <p><a href="admin.php?selectTest=<?php echo $TestName; ?>" class="btn btn-link">Mark other <?php echo $TestName; ?> tests</a></p>
    <p><a href="admin.php?viewTests=1" class="btn btn-link" name="viewTests_btn">Manage Tests and Questions</a></p>
    <p><a href="admin.php?viewGroups=1" class="btn btn-link" name="viewGroups_btn">View / edit groups</a></p>
    <p><a href="admin.php?viewStudents=1" class="btn btn-link" name="viewStudents_btn">View / edit students</a></p>
    <!--<p><a href="admin.php?markTests=1" class="btn btn-link" name="viewAssign_btn">View submitted Tests</a></p>-->
    <p><a href="../welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
</div>
<script>
    function showTracking() {
        var x = document.getElementById("tracking");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

</body>
</html>
