<?php
/**
 * Created by PhpStorm.
 * User: sjm
 * Date: 18/06/2018
 * Time: 22:49
 */
include('config.php');
if(isset($_POST["ImportQuestions"])){

    $filename=$_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        {

            $sql = "INSERT INTO tblQuestions (TestName, QuestNo, QuestPart, QuestSubPart, Question, Ans1, Ans2, Ans3, Ans4, CorrectAns, Marks, QuestionType) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."')";
            $result = mysqli_query($adminlink, $sql);
            $gotData = $getData[0];
            if(!isset($result))
            {
                echo "<script type=\"text/javascript\">
							alert(\"Invalid File: ".$gotData." Please Upload CSV File.\");
							window.location = \"./admin/admin.php?viewTests=1\"
						  </script>";
            }
            else {
                echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"./admin/admin.php?viewQues=".$getData[0]."\"
					</script>";
            }
        }

        fclose($file);
    }
}
?>