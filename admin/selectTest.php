<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<h3>Select Group to mark <?php echo $_GET['selectTest']; ?> for:</h3>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <!--0tSR.StudentsResponse, 1tSR.AnsweredAt, 2tQ.Question, 3tQ.CorrectAns, 4tQ.Marks, 5tU.username, 6tG.GroupName-->
        <th scope="col">Select Group</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($groupTest = mysqli_fetch_array($qrySelectTests)){
        echo '<tr>';
        echo '<td><a href="admin.php?selectTest='.$_GET['selectTest'].'&amp;group='.$groupTest[1].'">'.$groupTest[1].'</a></td>';
        echo '</tr>';
    }?>
    </tbody>
</table>


<?php if (isset($_GET['group'])): markTests(); ?>
    <h3>Mark Test: <?php echo $_GET['selectTest']; ?></h3>
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th scope="col">Group</th>
            <th scope="col">username</th>
            <!--<th scope="col">Answered At</th>
            <th scope="col">Question</th>
            <th scope="col">Marks</th>
            <th scope="col">CorrectAns</th>
            <th scope="col">Students Response</th>-->
        </tr>
        </thead>
        <tbody>
        <?php while ($markTest = mysqli_fetch_array($qryMarkTests)){
            echo '<tr>';
            echo '<td>'.$markTest[1].'</td>';
            echo '<td><a href="viewExamQuestions.php?Test='.$_GET['selectTest'].'&amp;NoMarks=0&amp;users_id='.$markTest[2].'&amp;KS3='.$markTest[3].'&amp;KS4='.$markTest[4].'&amp;KS4_2020='.$markTest[5].'&amp;KS5='.$markTest[6].'">'.$markTest[0].'</a></td>';
/*            echo '<td>'.$markTest[1].'</td>';
            echo '<td>'.$markTest[2].'</td>';
            echo '<td>'.$markTest[4].'</td>';
            echo '<td>'.$markTest[3].'</td>';
            echo '<td>'.$markTest[0].'</td>';*/
            echo '</tr>';
        }?>
        </tbody>
    </table>
<?php endif; ?>
