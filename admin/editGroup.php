<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<h3>Edit group:<?php echo $_GET['editGroup']; ?></h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-2">
            <input type="text" name="GroupID" placeholder="Group Name" class="form-control" value="<?php echo $GroupID; ?>">
        </div>
        <div class="form-group col-md-5">
            <input type="text" name="GroupDesc" placeholder="Description" class="form-control" value="<?php echo $GroupDesc; ?>">
        </div>
        <input type="hidden" name="editGroup" value="<?php echo $_GET['editGroup']; ?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="editGroup_btn" value="Submit">
        <input type="reset" class="btn btn-default" value="Reset">
    </div>
</form>
