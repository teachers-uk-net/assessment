<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<h3>Existing Students in Group: <?php echo $_GET['viewStudentGroups']; ?></h3>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th scope="col">UsersID</th>
        <th scope="col">username</th>
        <th scope="col">user_type</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($StudentGroup = mysqli_fetch_array($qryStudentGroup)){
        echo '<tr>';
        echo '<td>'.$StudentGroup[0].'</td>';
        echo '<td>'.$StudentGroup[1].'</td>';
        echo '<td>'.$StudentGroup[2].'</td>';
        echo '<td><a href="admin.php?editStudent='.$StudentGroup[0].'">Edit Student Details</a></td>';
        echo '<td><a href="admin.php?delStudent='.$StudentGroup[0].'">Delete Student</a></td>';
        echo '</tr>';
    }?>
    </tbody>
</table>
