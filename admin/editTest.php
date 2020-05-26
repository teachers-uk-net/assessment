<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<h3>Edit test:<?php echo $_GET['editTest']; ?></h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-4">
            <input type="text" name="TestName" class="form-control" value="<?php echo $_GET['editTest']; ?>">
        </div>
        <div class="form-group col-md-5">
            <input type="text" name="Description" placeholder="Description" class="form-control" value="<?php echo $_GET['Description']; ?>">
        </div>
        <?php if ($_GET['NoMarks']=='1'){
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" name="DoNotShowMarks" id="NoMarks" checked="1">';
            echo '</div></td>';
        }
        else{
            echo '<td align="center"><div class="form-check">';
            echo '<input class="form-check-input position-static" type="checkbox" name="DoNotShowMarks" id="NoMarks">';
            echo '</div></td>';
        } ?>
        <input type="hidden" name="editTest" value="<?php echo $_GET['editTest']; ?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="editTest_btn" value="Submit">
        <input type="reset" class="btn btn-default" value="Reset">
    </div>
</form>
