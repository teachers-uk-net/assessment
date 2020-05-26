<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<!--testAssign will have the TestName as a value-->
<h3>Assign groups to Test: <?php echo $_GET['testAssign']; ?></h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="TestName" value="<?php echo $_GET['testAssign']; ?>">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th scope="col">Group</th>
            <th scope="col">Assigned</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($assignTest = mysqli_fetch_array($qryTestAssign)){
            echo '<tr>';
            echo '<td>'.$assignTest[0].'</td>';
            if (is_null($assignTest[1]) || $assignTest[2]==0){
                echo '<td align="center"><div class="form-check">';
                echo '<input type="hidden" name="assignedTest['.$assignTest[0].']" value=0>';
                echo '<input class="form-check-input position-static" type="checkbox" name="assignedTest['.$assignTest[0].']" value=1 id="assignedTest">';
                echo '</div></td>';
            }
            else{
                echo '<td align="center"><div class="form-check">';
                echo '<input type="hidden" name="assignedTest['.$assignTest[0].']" value=0>';
                echo '<input class="form-check-input position-static" type="checkbox" name="assignedTest['.$assignTest[0].']" value=1 id="assignedTest" checked="checked">';
                echo '</div></td>';
            }
            echo '</tr>';
        }?>
        </tbody>
    </table>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="assignTest_btn" value="Submit">
        <input type="reset" class="btn btn-default" value="Reset">
    </div>
</form>