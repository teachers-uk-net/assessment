<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<div class="container">
    <div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h3>Add a test:</h3>
            <div class="row">
                <div class="form-group col-md-5">
                    <input type="text" name="TestName" placeholder="Test Name" class="form-control" value="<?php echo $TestName; ?>">
                </div>
                <div class="form-group col-md-5">
                    <input type="text" name="Description" placeholder="Description" class="form-control" value="<?php echo $Description; ?>">
                </div>
            </div>
            <div class="row">
                <div class="form-check form-check-inline col-md-5">
                    <input class="form-check-input position-static" type="checkbox" id="KS3" name="KS3">
                    <label class="form-check-label" for="KS3">KS3 Assessment &nbsp;</label>
                    <input class="form-check-input position-static" type="checkbox" id="KS4" name="KS4">
                    <label class="form-check-label" for="KS4">KS4 Assessment &nbsp;</label>
                    <input class="form-check-input position-static" type="checkbox" id="KS5" name="KS5">
                    <label class="form-check-label" for="KS5">KS5 Assessment &nbsp;</label>
                </div>
                <div class="form-check form-check-inline col-md-3">
                    <input class="form-check-input position-static" type="checkbox" id="DoNotShowMarks" name="DoNotShowMarks">
                    <label class="form-check-label" for="DoNotShowMarks">Check box to not show marks on Test</label>
                </div>
                <div class="form-group form-inline">
                    <input type="submit" class="btn btn-primary" name="addTest_btn" value="Submit">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container">
    <div class="row">

        <form class="form-horizontal" action="../importQuestions.php" method="post" name="upload_excel" enctype="multipart/form-data">
            <fieldset>

                <!-- Form Name -->
                <legend>Upload questions</legend>
                <p>CSV file needs 12 columns:</p>
                <ul>
                    <li>Name of the test (exactly as it appears below) in the first column (on every row)</li>
                    <li>Question Numbers are required and must be unique and sequential (although do not have to be in order in the csv file)</li>
                    <ul>
                        <li>
                            The beta allows for non-unique question numbers although they need part and sub-part as
                            described below, also can only be for type of text (2).
                        </li>
                    </ul>
                    <li>Question part (i.e. a, b or c) - leave empty if not needed</li>
                    <li>Question sub-part (i.e. i, ii or iii...) - leave empty if not needed</li>
                    <li>Question is required</li>
                    <li>There must be columns for Ans1, Ans2, Ans3, Ans4 and CorrectAns (although these are not required and can be left blank)</li>
                    <li>Marks are required although there is an option not to display them</li>
                    <li>Question Type is required (numeric value)</li>
                    <li>Question Types are currently:</li>
                    <ol>
                        <li>radio</li>
                        <li>text</li>
                        <li>multi-text (number of marks awarded will define the number of single line text boxes displayed</li>
                        <li>checkbox</li>
                    </ol>
                    <li>There should be no header row in the csv file</li>
                    <li>Escape apostrophes with two backslashes ' becomes \\'</li>
                </ul>
                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="filebutton">Select File</label>
                    <div class="col-md-4">
                        <input type="file" name="file" id="filebutton" class="form-control-file">
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-5 control-label" for="singlebutton">Import data</label>
                    <div class="col-md-5">
                        <button type="submit" id="submit" name="ImportQuestions" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</div>
<h3>Existing tests:</h3>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th scope="col">Test Name</th>
        <th scope="col">Description</th>
        <th scope="col">Do Not Show Marks</th>
        <th scope="col">KS3</th>
        <th scope="col">KS4</th>
        <th scope="col">KS5</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($TestNames = mysqli_fetch_array($query)){
        echo '<tr>';
        echo '<td>'.$TestNames[0].'</td>';
        echo '<td>'.$TestNames[1].'</td>';
        if ($TestNames[2]=='1'){
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" checked="1" disabled>';
            echo '</div></td>';
        }
        else{
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" disabled>';
            echo '</div></td>';
        }
        if ($TestNames[3]=='1'){
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" checked="1" disabled>';
            echo '</div></td>';
        }
        else{
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" disabled>';
            echo '</div></td>';
        }
        if ($TestNames[4]=='1'){
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" checked="1" disabled>';
            echo '</div></td>';
        }
        else{
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" disabled>';
            echo '</div></td>';
        }
        if ($TestNames[5]=='1'){
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" checked="1" disabled>';
            echo '</div></td>';
        }
        else{
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" value="'.$TestNames[2].'" id="'.$TestNames[2].'" disabled>';
            echo '</div></td>';
        }
        echo '<td><a href="admin.php?editTest='.$TestNames[0].'&NoMarks='.$TestNames[2].'&Description='.$TestNames[1].'">Edit Test details</a></td>';
        echo '<td><a href="editExamQuestions.php?Test='.$TestNames[0].'&NoMarks='.$TestNames[2].'">Edit/Add Questions</a></td>';
        echo '<td><a href="admin.php?testAssign='.$TestNames[0].'">Assign Test to groups</a>';
        echo '<td><a href="admin.php?selectTest='.$TestNames[0].'">Mark Test</a></td>';
        echo '<td><a href="admin.php?delTest='.$TestNames[0].'">Delete Test</a></td>';
        echo '</tr>';
    }?>
    </tbody>
</table>
</div>