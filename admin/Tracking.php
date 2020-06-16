<?php
include ('../config.php');
global $link, $link2, $adminlink, $NextQuest, $QuestNo;

if ($keyStage3 == 1){
    $qryTrack = "SELECT Topic, Level, Descriptor FROM KS3Descriptors";
    $qryTrack2 = "SELECT * FROM KS3Tracking WHERE userID='".$userID."'";
} elseif ($keyStage4 == 1){
    $qryTrack = "SELECT Topic, Descriptor FROM KS4Descriptors";
    $qryTrack2 = "SELECT * FROM KS4Tracking WHERE userID='".$userID."'";
} elseif ($keyStage5 == 1){
    $qryTrack = "SELECT Topic, Descriptor FROM KS5Descriptors";
    $qryTrack2 = "SELECT * FROM KS5Tracking WHERE userID='".$userID."'";
}

if ($result = mysqli_query($adminlink,$qryTrack2)){
    $studentData = mysqli_fetch_array($result, MYSQLI_NUM);
} else {
    echo'<h3>Error in Tracking.php line 37</h3>';
}

if ($stmt = mysqli_prepare($link2,$qryTrack)){
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$Topic, $Descriptor);
    while (mysqli_stmt_fetch($stmt)){
        $KS5Track['Topic'][] = $Topic;
        $KS5Track['Descriptor'][] = $Descriptor;
        //print_r($KS5Track);
        //printf("\nTopic is: %s\n", $Topic);
        //printf("\nDescriptor is: %s\n", $Descriptor);
    }
    mysqli_stmt_close($stmt);
}

echo'<div id="trackingLink">';
echo'    <a class="btn btn-link" onclick="showTracking()">Show / hide tracking</a>';
echo'</div>';
echo'<div id="tracking" class="col-sm-4" style="display: none">';
if ($keyStage3 == 1):
    echo'<button type="button" class="collapsible TrackingBtn">The Urswick Basics</button>';
    echo'        <div class="contentLower panel panel-default">';
    echo'            <table class="table">';
    echo'                <tr>';
    echo'                    <td>Uses software under the control of the teacher to create, store and edit digital content using appropriate file and folder names.</td>';
    echo'                    <td><input type="checkbox"></td>';
    echo'                </tr>';
    echo'                <tr>';
    echo'                    <td>Understands that people interact with computers.</td>';
    echo'                    <td><input type="checkbox"></td>';
    echo'                </tr>';
    echo'                <tr>';
    echo'                    <td>Shares their use of technology in school.</td>';
    echo'                    <td><input type="checkbox"></td>';
    echo'                </tr>';
    echo'            </table>';
    echo'        </div>';
elseif ($keyStage4 == 1):
    echo'<button type="button" class="collapsible TrackingBtn">Algorithms</button>';
    echo'        <div class="contentLower panel panel-default">';
    echo'            <table class="table">';
    echo'                <tr>';
    echo'                    <td>KS4 Tracking details</td>';
    echo'                    <td><input type="checkbox"></td>';
    echo'                </tr>';
    echo'                <tr>';
    echo'                    <td>Understands that people interact with computers.</td>';
    echo'                    <td><input type="checkbox"></td>';
    echo'                </tr>';
    echo'                <tr>';
    echo'                    <td>Shares their use of technology in school.</td>';
    echo'                    <td><input type="checkbox"></td>';
    echo'                </tr>';
    echo'            </table>';
    echo'        </div>';
elseif ($keyStage5 == 1):
    $CompComponentsFlag = true;
    $SoftwareFlag = true;
    $ExchangingDataFlag = true;
    $RepresentingDataFlag = true;
    $MoralSocEthCultAndLegislFlag = true;
    $CompThinkingFlag = true;
    $SolvingProblemsFlag = true;
    $AlgorithmsFlag = true;
    $A2ContentFlag = true;
    //print_r($KS5Track);
    //print_r($studentData);
    for ($i = 0;$i < count($studentData)-1;$i++){
    if ($KS5Track['Topic'][$i] == "CompComponents" && $CompComponentsFlag){
        echo'<button type="button" class="collapsible TrackingBtn">Computer Components</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $CompComponentsFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "Software" && $SoftwareFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Software</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SoftwareFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "ExchangingData" && $ExchangingDataFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Exchanging Data</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ExchangingDataFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "RepresentingData" && $RepresentingDataFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Representing Data</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $RepresentingDataFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "MoralSocEthCultAndLegisl" && $MoralSocEthCultAndLegislFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Moral, Social, Ethical, etc.</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $MoralSocEthCultAndLegislFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "CompThinking" && $CompThinkingFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Computational Thinking</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $CompThinkingFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "SolvingProblems" && $SolvingProblemsFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Problem Solving</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SolvingProblemsFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "Algorithms" && $AlgorithmsFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Algorithms</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $AlgorithmsFlag = false;
    } elseif ($KS5Track['Topic'][$i] == "A2Content" && $A2ContentFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">A2 Content</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $A2ContentFlag = false;
    }
        echo'                <tr>';
        echo'                    <td>';
        printf("%s",$KS5Track['Descriptor'][$i]);
        echo'                    </td>';
        echo'                    <td>';
        $t = $i + 1;
        if ($studentData[$i+1] == 0){
            echo'<select id="tracking[KS5_'.$t.']" name="tracking[KS5_'.$t.']">
                <option value="0" selected>R</option>
                <option value="1">A</option>
                <option value="2">G</option>
              </select>';
        } elseif ($studentData[$i+1] == 1){
            echo'<select id="tracking[KS5_'.$t.']" name="tracking[KS5_'.$t.']">
                <option value="0">R</option>
                <option value="1" selected>A</option>
                <option value="2">G</option>
              </select>';
        } else {
            echo'<select id="tracking[KS5_'.$t.']" name="tracking[KS5_'.$t.']">
                <option value="0">R</option>
                <option value="1">A</option>
                <option value="2" selected>G</option>
              </select>';
        }

        //printf("%s",$studentData[$i+1]);
        echo'                    </td>';
        echo'                </tr>';
    }

    echo'            </table>';
    echo'        </div>';
endif;
echo'</div>';
mysqli_free_result($result);
mysqli_close($adminlink);
//mysqli_free_result($result2);
mysqli_close($link2);
echo'<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight){
                content.style.maxHeight = null;
            } else {
                //content.style.maxHeight = content.scrollHeight + "px";
                content.style.maxHeight = 60 + "vh";
            }
        });
    }
</script>';
