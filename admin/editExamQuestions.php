<?php
//unset($_POST);
include ('adminFunctions.php');
//include ('ExamEditing.php');
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
    <title>Editing Question</title>
    <link rel="stylesheet" href="../../bootstrap/3.3.7/dist/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ padding: 20px; }
    </style>
</head>
<body onload="setInterval(function(){$.post('/../refresh_session.php');},600000);">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="../ckeditor5-build-classic/ckeditor.js"></script>
<div class="wrapper">
    <?php
    include ('ExamEditing.php');
    //echo "<p>From the top: </p><br>";
    //print_r($QuestParts);
    //printf("POST data: ".var_export( $_POST, true));
    ?>
    <?php //if(!empty($QuestionType)): ?>
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
                            <label for="editor<?php echo $val['QuestID']; ?>">Edit question:</label>
                            <textarea class="editor<?php echo $val['QuestID']; ?> form-control" name="EQedit[<?php echo $val['QuestID']; ?>]" rows="3">
                                <?php echo $val['Question']; ?>
                            </textarea>
                            <label for="editor<?php echo $val['QuestID']; ?>">Edit markscheme:</label>
                            <textarea class="editor<?php echo $val['QuestID']; ?> form-control" name="EQanswer[<?php echo $val['QuestID']; ?>]" rows="3">
                                <?php echo $val['CorrectAns']; ?>
                            </textarea>
                            <label for="Mark<?php echo $val['QuestID']; ?>">Mark available:</label>
                            <input type="number" name="EQMark[<?php echo $val['QuestID']; ?>]" id="Mark<?php echo $val['QuestID']; ?>" value="<?php echo $val['Marks']; ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p><?php if ($_GET['NoMarks']==0){ if($val['Marks']>1){printf("(%s marks)", $val['Marks']);}else{printf("(%s mark)", $val['Marks']);} }?></p>
                    </div>
                <script src="../ckeditor5-build-classic/ckfinder/ckfinder.js"></script>
                    <script>
                        var allEditors = document.querySelectorAll('.editor<?php echo $val["QuestID"]; ?>');
                        for (var i = 0; i < allEditors.length; ++i){
                            ClassicEditor
                                .create( allEditors[i],{
                                    toolbar: {
                                        items: [
                                            'heading',
                                            '|',
                                            'bold',
                                            'italic',
                                            'link',
                                            'bulletedList',
                                            'numberedList',
                                            '|',
                                            'indent',
                                            'outdent',
                                            '|',
                                            'imageUpload',
                                            'blockQuote',
                                            'insertTable',
                                            'mediaEmbed',
                                            'undo',
                                            'redo',
                                            'ckfinder'
                                        ]
                                    },
                                    image: {
                                        toolbar: [
                                            'imageStyle:full',
                                            'imageStyle:side',
                                            '|',
                                            'imageTextAlternative'
                                        ]
                                    },
                                    table: {
                                        contentToolbar: [
                                            'tableColumn',
                                            'tableRow',
                                            'mergeTableCells'
                                        ]
                                    }
                                } )
                                .then( editor => {
                                    console.log( editor );
                                } )
                                .catch( error => {
                                    console.error( error );
                                } );
                        }
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
            <input type="submit" class="btn btn-primary" name="editEQ_btn" value="Edit Question">
            <!--<input type="submit" class="btn btn-primary" name="previous_btn" value="Previous Question">-->
        </div>
    </form>
</div>
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
