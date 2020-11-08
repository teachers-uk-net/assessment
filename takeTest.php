<?php

// include database and object files
include_once 'config/Database.php';
include_once 'objects/Responses.php';

if (!isset($_SESSION['users_id'])){
    header('location: index.php');
}

// assign variables to be used in responses
$QuestNo = isset($_GET['QuestNo']) ? $_GET['QuestNo'] : die('ERROR: missing QuestNo.');
$users_id = isset($_SESSION['users_id']) ? $_SESSION['users_id'] : die($_SESSION['users_id'].' <-ERROR: missing users_id, not logged in');
$TestName = isset($_GET['TestName']) ? $_GET['TestName'] : die('ERROR: missing TestName');

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

// instantiate responses
$response = new Responses($db);

// set variables for created object
$response->QuestNo = $QuestNo;
$response->TestName = $TestName;
$response->users_id = $users_id;

// query responses
$stmt = $response->read();
$num = $stmt->rowCount();

if(isset($_POST['response_submit_btn']))
{
    // To handle multi text box or checkbox answers the arrResponse is split and glued back in a suitable format
    if(isset($_POST['arrResponse'])){
        $name = $_POST['arrResponse'];
        print_r($name);
        print_r(array_keys($name));
        foreach ($name as $ansResp){
            $eqresponse[] = implode(", ", $ansResp);
            $EQresponse = array_combine(array_keys($name),$eqresponse);
            //print_r($EQresponse);
        }

    } else{
        $EQresponse = $_POST['EQresponse'];
        //print_r($EQresponse);
    }

    $url = "location: takeTest.php?TestName=".$TestName."&QuestNo=".($QuestNo + 1)."&ansResponse=".$ansResponse[0];
    //printf($url);

    if($response->quesResponse($EQresponse))
    {
        header($url);
    }
    else
    {
        $error = "Something went wrong!";
    }
}

// set page header
$page_title = $TestName;
include_once "layout_header.php";
// display the current question or offer a return to the welcome page
?>
<div class="wrapper">
<?php if ($num > 0):?>
        <form method='post' action='<?php echo htmlspecialchars($_SESSION['PHP_SELF']) ?>'>
        <fieldset class='form-group'>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        extract($row);
        echo        "<input type='hidden' name='QuestionType' value='{$QuestionType}'>";
    ?>
        <?php if($QuestionType==1): ?>
            <legend class="col-form-legend col-sm-8"><?php echo "Question "."{$QuestNo}".") "."{$QuestPart}"."{$QuestSubPart}"; ?></legend>
            <input type="hidden" name="QuestID[<?php echo "{$QuestID}"; ?>]" value="<?php echo "{$QuestID}"; ?>">
            <div class="col-sm-8">
                <div class="form-group">
                    <div class="card">
                        <div class="card-body"> <?php echo "$Question"." "; ?><?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("({$Marks} marks)");}else{printf("({$Marks} mark)");} }?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="EQresponse[<?php echo "{$QuestID}"; ?>]" id="<?php echo "{$Ans1}"; ?>" value="Ans1">
                    <label class="form-check-label" for="<?php echo "{$Ans1}"; ?>">
                        <?php echo "{$Ans1}"; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="EQresponse[<?php echo "{$QuestID}"; ?>]" id="<?php echo "{$Ans2}"; ?>" value="Ans2">
                    <label class="form-check-label" for="<?php echo "{$Ans2}"; ?>">
                        <?php echo "{$Ans2}"; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="EQresponse[<?php echo "{$QuestID}"; ?>]" id="<?php echo "{$Ans3}"; ?>" value="Ans3">
                    <label class="form-check-label" for="<?php echo "{$Ans3}"; ?>">
                        <?php echo "{$Ans3}"; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="EQresponse[<?php echo "{$QuestID}"; ?>]" id="<?php echo "{$Ans4}"; ?>" value="Ans4">
                    <label class="form-check-label" for="<?php echo "{$Ans4}"; ?>">
                        <?php echo "{$Ans4}"; ?>
                    </label>
                </div>
            </div>
        <?php elseif($QuestionType==2): //text ?>
            <legend class="col-form-legend col-sm-8"><?php echo "Question "."{$QuestNo}".") "."{$QuestPart}"."{$QuestSubPart}"; ?></legend>
            <input type="hidden" name="QuestID[<?php echo "{$QuestID}"; ?>]" value="<?php echo "{$QuestID}"; ?>">
            <div class="col-sm-8">
            <div class="form-group">
            <div class="card">
                <div class="card-body"> <?php echo "$Question"." "; ?><?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("({$Marks} marks)");}else{printf("({$Marks} mark)");} }?></div>
            </div>
                    <label for="textResponse">
                        Enter your answer in the box provided
                    </label>
                    <textarea class="form-control" name="EQresponse[<?php echo "{$QuestID}"; ?>]" rows="3"><?php echo "{$StudentsResponse}"; ?></textarea>
                </div>
            </div>
        <?php elseif($QuestionType==3): //multi_text ?>
        <legend class="col-form-legend col-sm-8"><?php echo "Question "."{$QuestNo}".") "."{$QuestPart}"."{$QuestSubPart}"; ?></legend>
        <input type="hidden" name="QuestID[<?php echo "{$QuestID}"; ?>]" value="<?php echo "{$QuestID}"; ?>">
        <div class="col-sm-8">
            <div class="form-group">
                <div class="card">
                    <div class="card-body"> <?php echo "$Question"." "; ?><?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("({$Marks} marks)");}else{printf("({$Marks} mark)");} }?></div>
                </div>
            </div>
        </div>
            <?php for ($a = 0; $a < $Marks; $a++): ?>
            <div class="col-sm-10">
                <div class="form-group">
                    <label for="textResponse<?php echo $a; ?>">
                        Answer <?php echo $a + 1; ?>
                    </label>
                    <textarea class="form-control" name="arrResponse[<?php echo "{$QuestID}"; ?>][<?php echo "{$a}" ?>]" id="textResponse<?php echo $a; ?>" rows="1"></textarea>
                </div>
            </div>
            <?php endfor ?>
        <?php elseif($QuestionType==4): //checkbox ?>
        <legend class="col-form-legend col-sm-8"><?php echo "Question "."{$QuestNo}".") "."{$QuestPart}"."{$QuestSubPart}"; ?></legend>
        <input type="hidden" name="QuestID[<?php echo "{$QuestID}"; ?>]" value="<?php echo "{$QuestID}"; ?>">
        <div class="col-sm-8">
            <div class="form-group">
                <div class="card">
                    <div class="card-body"> <?php echo "$Question"." "; ?><?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("({$Marks} marks)");}else{printf("({$Marks} mark)");} }?></div>
                </div>
            </div>
        </div>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="arrResponse[<?php echo "{$QuestID}"; ?>][0]" id="<?php echo "{$QuestID}"; ?>" value="Ans1">
                    <label class="form-check-label" for="<?php echo "{$Ans1}"; ?>">
                        <?php echo "{$Ans1}"; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="arrResponse[<?php echo "{$QuestID}"; ?>][1]" id="<?php echo "{$QuestID}"; ?>" value="Ans2">
                    <label class="form-check-label" for="<?php echo "{$Ans2}"; ?>">
                        <?php echo "{$Ans2}"; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="arrResponse[<?php echo "{$QuestID}"; ?>][2]" id="<?php echo "{$QuestID}"; ?>" value="Ans3">
                    <label class="form-check-label" for="<?php echo "{$Ans3}"; ?>">
                        <?php echo "{$Ans3}"; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="arrResponse[<?php echo "{$QuestID}"; ?>][3]" id="<?php echo "{$QuestID}"; ?>" value="Ans4">
                    <label class="form-check-label" for="<?php echo "{$Ans4}"; ?>">
                        <?php echo "{$Ans4}"; ?>
                    </label>
                </div>
            </div>
        <?php elseif($QuestionType==5): ?>
            <legend class="col-form-legend col-sm-8"><?php echo "{$QuestNo}"." "."{$QuestPart}"."{$QuestSubPart}"; ?></legend>
            <input type="hidden" name="QuestID[<?php echo "{$QuestID}"; ?>]" value="<?php echo "{$QuestID}"; ?>">
            <div class="col-sm-8">
                <div class="form-group">
                    <div class="card">
                        <div class="card-body"> <?php echo "$Question"; ?></div>
                    </div>
                    <textarea class="editor form-control" name="EQresponse[<?php echo "{$QuestID}"; ?>]" rows="3">
                            <?php
                            echo "{$StudentsResponse}";
                            ?>
                        </textarea>
                </div>
            </div>
            <div class="col-sm-4">
                <p><?php if ($_SESSION['NoMarks']==0){ if($Marks>1){printf("({$Marks} marks)");}else{printf("({$Marks} mark)");} }//if ($_SESSION['NoMarks']==0){ if($val['Marks']>1){printf("(%s marks)", $val['Marks']);}else{printf("(%s mark)", $val['Marks']);} }?></p>
            </div>
        <?php else: ?>
            <!--<p>Something has gone wrong, please try again later.</p>
            <p><a href="welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>-->
        <?php endif; ?>
<?php endwhile; ?>
            <script src="libs/js/ckeditor.js"></script>
    </fieldset>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="response_submit_btn" value="Submit Answer">
    </div>
    </form>
<?php elseif ($num==0): ?>
    <h3>Test complete, well done!</h3>
    <p><a href="welcome.php" class="btn btn-primary">Return to the welcome page</a></p>
    <p><a href="welcome.php?logout='1'" class="btn btn-danger">Sign Out</a></p>
<?php endif; ?>
</div>

<?php
// set page footer
include_once "layout_footer.php";
?>