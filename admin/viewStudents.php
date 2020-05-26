<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<div class="container">
    <div class="row">

        <form class="form-horizontal" action="../importUsers.php" method="post" name="upload_excel" enctype="multipart/form-data">
            <fieldset>

                <!-- Form Name -->
                <legend>Bulk upload students</legend>
                <p>CSV file just needs three columns; username, password and group with no headers (the group must already exist in groups)</p>

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
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</div>
<div class="container">
    <div class="row">
        <h3>Existing Students:</h3>
        <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th scope="col">UsersID</th>
                <th scope="col">username</th>
                <th scope="col">user_type</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($StudentNames = mysqli_fetch_array($qryStudents)){
                echo '<tr>';
                echo '<td>'.$StudentNames[0].'</td>';
                echo '<td>'.$StudentNames[1].'</td>';
                echo '<td>'.$StudentNames[2].'</td>';
                echo '<td><a href="admin.php?editStudent='.$StudentNames[0].'">Edit Student Details</a></td>';
                echo '<td><a href="admin.php?delStudent='.$StudentNames[0].'">Delete Student</a></td>';
                echo '</tr>';
            }?>
            </tbody>
        </table>

    </div>
</div>

