<?php

require_once('Sesh.php');
class Responses extends Sesh
{
    // database connection and table name
    private $conn;

    // object properties
    public $QuestNo, $TestName, $QuestID;
    public $users_id;
    public $QuestPart, $QuestSubPart, $Question, $Marks, $QuestionType, $CorrectAns;
    public $Ans1, $Ans2, $Ans3, $Ans4;
    public $StudentsResponse, $feedback, $MarkAwarded;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        //select required data
        $query = "SELECT
                    tQ.QuestID, tQ.QuestPart, tQ.QuestSubPart, tQ.Question, tQ.Marks, tQ.QuestionType,
                    tQ.Ans1, tQ.Ans2, tQ.Ans3, tQ.Ans4,
                    tQ.CorrectAns, tSR.StudentsResponse, tSR.feedback, tSR.MarkAwarded
                FROM
                    tblStudentResponses tSR
                        JOIN tblQuestions tQ on tSR.ResponseQuestID = tQ.QuestID
                        WHERE tQ.QuestNo=:QuestNo AND tQ.TestName=:TestName AND tSR.users_id=:users_id";

        $stmt = $this->conn->prepare( $query );

        //posted values

        //bind the values
        $stmt->bindParam(':QuestNo', $this->QuestNo);
        $stmt->bindParam(':TestName', $this->TestName);
        $stmt->bindParam(':users_id', $this->users_id);

        $stmt->execute();

        return $stmt;
    }

    function quesResponse($EQresponse){
        // Update table with student responses, need to make sure record already exists or will fail
        $sql = "UPDATE tblStudentResponses SET StudentsResponse=:StudentsResponse, AnsweredAt=:timestamp 
                WHERE ResponseQuestID=:QuestID AND users_id=:users_id";
        $stmt = $this->conn->prepare($sql);
        $counter = 0;
        $userID = $_SESSION['users_id'];

        foreach ($EQresponse as $y => $value) {
            // posted values
            $this->StudentsResponse=$value;
            $this->QuestID=$y;
            $this->users_id=$userID;

            // to get time-stamp for 'created' field
            $timestamp = date('Y-m-d H:i:s');

            // bind values
            $stmt->bindParam(":StudentsResponse", $this->StudentsResponse);
            $stmt->bindParam(":timestamp", $timestamp);
            $stmt->bindParam(":QuestID", $this->QuestID);
            $stmt->bindParam(":users_id", $this->users_id);

            if($stmt->execute()){
                $counter = $counter + 1;
            }else {
                return false;
            }

        }
        if($counter > 0){
            //print_r("Responses: ",$EQresponse);
            return true;
        } else{
            echo "Something went wrong line 78 Responses. Please try again later.";
        }
    }

}
?>