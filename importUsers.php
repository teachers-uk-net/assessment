<?php
/**
 * Created by PhpStorm.
 * User: sjm
 * Date: 18/06/2018
 * Time: 22:00
 */
include('config.php');
if(isset($_POST["Import"])){

    $filename=$_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
            $sql = "INSERT INTO tblUsers (username,password) 
                   values ('".$getData[0]."','".password_hash($getData[1],PASSWORD_DEFAULT)."')";
            $result = mysqli_query($adminlink, $sql);

            $sql2 = "CREATE TEMPORARY TABLE newUsers (username VarChar(50), password VarChar(255), GroupID VarChar(32))";
            $result2 =mysqli_query($adminlink, $sql2);

            $sql3 = "INSERT INTO newUsers (username,password,GroupID) 
                   values ('".$getData[0]."','".password_hash($getData[1],PASSWORD_DEFAULT)."','".$getData[2]."')";
            $result3 =mysqli_query($adminlink, $sql3);

            $sql4 = "INSERT INTO tblUserGroups (UsersID, GroupID) SELECT tU.UsersID, nU.GroupID
                    FROM tblUsers tU INNER JOIN newUsers nU ON tU.username = nU.username";
            $result4 =mysqli_query($adminlink, $sql4);

            $sql5 = "DROP TEMPORARY TABLE newUsers";
            $result5 = mysqli_query($adminlink, $sql5);
            if(!isset($result))
            {
                echo "<script type=\"text/javascript\">
							alert(\"Invalid File: Please Upload CSV File.\");
							window.location = \"./admin/admin.php?viewStudents=1\"
						  </script>";
            }
            else {
                echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"./admin/admin.php?viewStudents=1\"
					</script>";
            }
        }

        fclose($file);
    }
}
?>