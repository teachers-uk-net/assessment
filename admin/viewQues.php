<?php
if(!isAdmin()){
    header('location:../login.php');
}
?>
<h3>Current questions for test: <?php echo $_GET['viewQues']; ?></h3>
<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th scope="col">Quest No.</th>
        <th scope="col">Question</th>
        <th scope="col">Ans1</th>
        <th scope="col">Ans2</th>
        <th scope="col">Ans3</th>
        <th scope="col">Ans4</th>
        <th scope="col">CorrectAns</th>
        <th scope="col">Marks</th>
        <th scope="col">QuestionType</th>
        <th scope="col">Editable</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($Questions = mysqli_fetch_array($qryQues)){
        echo '<tr>';
        echo '<td>'.$Questions[1].'</td>';
        echo '<td>'.$Questions[2].'</td>';
        echo '<td>'.$Questions[3].'</td>';
        echo '<td>'.$Questions[4].'</td>';
        echo '<td>'.$Questions[5].'</td>';
        echo '<td>'.$Questions[6].'</td>';
        echo '<td>'.$Questions[7].'</td>';
        echo '<td>'.$Questions[8].'</td>';
        echo '<td>'.$Questions[9].'</td>';
        //Possible future functionality; if you are smart enough to be looking at the
        //source code and try to run these functions do not be surprised if stuff breaks
        //or you turn purple with green spots; it is better to manage tests using separate
        //csv files
        if($Questions[9]=='text'){
            echo '<td><a href="admin.php?editQues='.$Questions[0].'">Edit</a></td>';
        }
        else{
            echo '<td>N/A</td>';
        }
        /*echo '<td><a href="admin.php?editQues='.$Questions[0].'">Edit Question</a></td>';
        echo '<td><a href="admin.php?delQues='.$Questions[0].'">Delete Question</a></td>';*/
        echo '</tr>';
    }?>
    </tbody>
</table>
<p>Looking for a way to edit questions? It is better to manage your tests/questions in separate csv files</p>
<p>Delete the test and re-upload it</p>
