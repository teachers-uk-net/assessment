<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<h3>Add a group:</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-2">
            <input type="text" name="GroupID" placeholder="Group Name" class="form-control" value="<?php echo $GroupID; ?>">
        </div>
        <div class="form-group col-md-5">
            <input type="text" name="GroupDesc" placeholder="Description" class="form-control" value="<?php echo $GroupDesc; ?>">
        </div>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="addGroup_btn" value="Submit">
        <input type="reset" class="btn btn-default" value="Reset">
    </div>
</form>
<h3>Existing groups:</h3>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th scope="col">Group Name</th>
        <th scope="col">Description</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($GroupNames = mysqli_fetch_array($qryGroups)){
        echo '<tr>';
        echo '<td>'.$GroupNames[0].'</td>';
        echo '<td>'.$GroupNames[1].'</td>';
        echo '<td><a href="admin.php?editGroup='.$GroupNames[0].'">Edit Name / Description</a></td>';
        echo '<td><a href="admin.php?viewStudentGroups='.$GroupNames[0].'">Edit/Add Students</a></td>';
        echo '<td><a href="admin.php?delGroup='.$GroupNames[0].'">Delete Group</a></td>';
        echo '</tr>';
    }?>
    </tbody>
</table>
