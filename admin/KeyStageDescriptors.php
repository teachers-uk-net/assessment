<?php
include ('../config.php');
global $link2, $link, $adminlink, $link2020;

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Success Criteria / Descriptors for CS</title>
    <link rel="stylesheet" href="../../bootstrap/3.3.7/dist/css/bootstrap.css">
    <link rel="stylesheet" href="tracking2.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ padding: 20px; }
        blockquote{background-color: lightblue; }
    </style>
</head>
<body onload="setInterval(function(){$.post(\'/../refresh_session.php\');},600000);">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<div class="wrapper">
<a class="btn btn-link" href="#BTECTracking">View BTEC and GCE A Level Assessment Criteria</a>
<div class="row">';

$keyStage3 = 1;
$keyStage4 = 1;
$keyStage4_2020 = 1;
$keyStage5 = 1;



    $qryTrack = "SELECT Topic, Level, Descriptor FROM KS3Descriptors";
    if ($stmt = mysqli_prepare($link2,$qryTrack)){
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$Topic, $Level, $Descriptor);
        while (mysqli_stmt_fetch($stmt)){
            $KS3Track['Topic'][] = $Topic;
            $KS3Track['Level'][] = $Level;
            $KS3Track['Descriptor'][] = $Descriptor;
        }
        mysqli_stmt_close($stmt);
    }

    $qryTrack2 = "SELECT Topic, Descriptor FROM KS4Descriptors";
    if ($stmt2 = mysqli_prepare($link,$qryTrack2)){
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_bind_result($stmt2,$Topic, $Descriptor);
        while (mysqli_stmt_fetch($stmt2)){
            $KS4Track['Topic'][] = $Topic;
            $KS4Track['Descriptor'][] = $Descriptor;
        }
        mysqli_stmt_close($stmt2);
    }

    $qryTrack2020 = "SELECT Topic, Category, Descriptor FROM KS4_2020Descriptors";
    if ($stmt2020 = mysqli_prepare($link2020,$qryTrack2020)){
        mysqli_stmt_execute($stmt2020);
        mysqli_stmt_bind_result($stmt2020,$Topic, $Category, $Descriptor);
        while (mysqli_stmt_fetch($stmt2020)){
            $KS4_2020Track['Topic'][] = $Topic;
            $KS4_2020Track['Category'][] = $Category;
            $KS4_2020Track['Descriptor'][] = $Descriptor;
            //print_r($KS4_2020Track);
            //printf("\nTopic is: %s\n", $Topic);
            //printf("\nCategory is: %s\n", $Category);
            //printf("\nDescriptor is: %s\n", $Descriptor);
        }
        mysqli_stmt_close($stmt2020);
    }

    $qryTrack3 = "SELECT Topic, Descriptor FROM KS5Descriptors";
    if ($stmt3 = mysqli_prepare($adminlink,$qryTrack3)){
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_bind_result($stmt3,$Topic, $Descriptor);
        while (mysqli_stmt_fetch($stmt3)){
            $KS5Track['Topic'][] = $Topic;
            $KS5Track['Descriptor'][] = $Descriptor;
            //print_r($KS5Track);
            //printf("\nTopic is: %s\n", $Topic);
            //printf("\nDescriptor is: %s\n", $Descriptor);
        }
        mysqli_stmt_close($stmt3);
    }

//print_r($KS4Track);
echo'<div class="KS4tracking" class="col-sm-4">
    <h3 style="text-align: center">KS3 Success Criteria by teaching topic</h3>';

$TheUrswickBasicsFlag = true;
$ComputationalThinkingFlag = true;
$MicrobitFlag = true;
$DatabasesFlag = true;
$DataAndTheCPUFlag = true;
$IntroducingPythonFlag = true;
$InformationTechFlag = true;
$ProjectFlag = true;
for ($i = 0;$i < count($KS3Track['Topic']);$i++){
    if ($KS3Track['Topic'][$i] == "Intro" && $TheUrswickBasicsFlag){
        echo'<button type="button" class="collapsible TrackingBtn">The Urswick Basics for IT and CS</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $TheUrswickBasicsFlag = false;
    } elseif ($KS3Track['Topic'][$i] == "Computational Thinking" && $ComputationalThinkingFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Computational Thinking</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ComputationalThinkingFlag = false;
    } elseif ($KS3Track['Topic'][$i] == "Microbit" && $MicrobitFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Microbit (Year 7)</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $MicrobitFlag = false;
    } elseif ($KS3Track['Topic'][$i] == "Databases" && $DatabasesFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Databases (Year 8)</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $DatabasesFlag = false;
    } elseif ($KS3Track['Topic'][$i] == "DataAndTheCPU" && $DataAndTheCPUFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Data And The CPU</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $DataAndTheCPUFlag = false;
    } elseif ($KS3Track['Topic'][$i] == "IntroducingPython" && $IntroducingPythonFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Introducing Python</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $IntroducingPythonFlag = false;
    } elseif ($KS3Track['Topic'][$i] == "InformationTechnology" && $InformationTechFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Information Technology</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $InformationTechFlag = false;
    } elseif ($KS3Track['Topic'][$i] == "Project" && $ProjectFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Project</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ProjectFlag = false;
    }
    echo'                <tr>';
    echo'                    <td>';
    printf("%s",$KS3Track['Level'][$i]);
    echo'                    </td>';
    echo'                    <td>';
    printf("%s",$KS3Track['Descriptor'][$i]);
    echo'                    </td>';
    echo'                </tr>';
}
echo'            </table>';
echo'        </div>';
echo'</div>';

echo'<div class="KS4tracking" class="col-sm-4">
    <h3 style="text-align: center">GCSE Computer Science 2020</h3>';
$SystemsArchitecture = true;
$Memory = true;
$Networks = true;
$NetworkSecurity = true;
$SystemsSoftware = true;
$EthicalLegal = true;
$Algorithms = true;
$ProgrammingFundamentals = true;
$RobustPrograms = true;
$Boolean = true;
$IDEs = true;
for ($k = 0;$k < count($KS4_2020Track['Topic'])-1;$k++){
    if ($KS4_2020Track['Topic'][$k] == "Systems Architecture" && $SystemsArchitecture){
        echo'<button type="button" class="collapsible TrackingBtn">Systems Architecture</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SystemsArchitecture = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Memory and storage" && $Memory){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Memory and Storage</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $Memory = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Computer networks, connections and protocols" && $Networks){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Computer networks, connections and protocols</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $Networks = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Network security" && $NetworkSecurity){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Network security</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $NetworkSecurity = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Systems software" && $SystemsSoftware){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Systems software</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SystemsSoftware = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Ethical, legal, cultural and environmental impacts of digital technology" && $EthicalLegal){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Ethical, legal, cultural and environmental impacts of digital technology</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $EthicalLegal = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Algorithms" && $Algorithms){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Algorithms</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $Algorithms = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Programming fundamentals" && $ProgrammingFundamentals){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Programming fundamentals</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ProgrammingFundamentals = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Producing robust programs" && $RobustPrograms){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Producing robust programs</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $RobustPrograms = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Boolean logic" && $Boolean){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Boolean logic</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $Boolean = false;
    } elseif ($KS4_2020Track['Topic'][$k] == "Programming languages and Integrated Development Environments" && $IDEs){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Programming languages and Integrated Development Environments</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $IDEs = false;
    }
    echo'                <tr>';
    echo'                    <td>';
    printf("%s",$KS4_2020Track['Category'][$k]);
    echo'                    </td>';
    echo'                    <td>';
    printf("%s",$KS4_2020Track['Descriptor'][$k]);
    echo'                    </td>';
    echo'                </tr>';
}
echo'            </table>';
echo'        </div>';
echo'</div>';
echo'<div class="KS4tracking" class="col-sm-4">
    <h3 style="text-align: center">GCSE Computer Science Success Criteria</h3>';
$AlgorithmsFlag = true;
$ProgrammingTechniquesFlag = true;
$ProducingRobustProgramsFlag = true;
$ComputationalLogicFlag = true;
$TranslatorsLanguagesFlag = true;
$DataRepresentationFlag = true;
$SystemsArchitectureFlag = true;
$MemoryFlag = true;
$StorageFlag = true;
$NetworksFlag = true;
$NetworkTPLFlag = true;
$SystemSecurityFlag = true;
$SystemSoftwareFlag = true;
$EthLegCultEnvFlag = true;
for ($j = 0;$j < count($KS4Track['Topic'])-1;$j++){
    if ($KS4Track['Topic'][$j] == "Algorithms" && $AlgorithmsFlag){
        echo'<button type="button" class="collapsible TrackingBtn">Algorithms</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $AlgorithmsFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Programming Techniques" && $ProgrammingTechniquesFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Programming Techniques</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ProgrammingTechniquesFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Producing Robust Programs" && $ProducingRobustProgramsFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Producing Robust Programs</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ProducingRobustProgramsFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Computational Logic" && $ComputationalLogicFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Computational Logic</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ComputationalLogicFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Translators and Facilities of Languages" && $TranslatorsLanguagesFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Translators and Facilities of Languages</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $TranslatorsLanguagesFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Data Representation" && $DataRepresentationFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Data Representation</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $DataRepresentationFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Systems Architecture" && $SystemsArchitectureFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Systems Architecture</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SystemsArchitectureFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Memory" && $MemoryFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Memory</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $MemoryFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Storage" && $StorageFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Storage</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $StorageFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Wired and Wireless Networks" && $NetworksFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Wired and Wireless Networks</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $NetworksFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Network Topologies, Protocols and Layers" && $NetworkTPLFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Network Topologies, Protocols and Layers</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $NetworkTPLFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "System Security" && $SystemSecurityFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">System Security</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SystemSecurityFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "System Software" && $SystemSoftwareFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">System Software</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SystemSoftwareFlag = false;
    } elseif ($KS4Track['Topic'][$j] == "Ethical, legal, cultural and environmental concerns" && $EthLegCultEnvFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Ethical, legal, cultural and environmental concerns</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $EthLegCultEnvFlag = false;
    }
    echo'                <tr>';
    echo'                    <td>';
    printf("%s",$KS4Track['Descriptor'][$j]);
    echo'                    </td>';
    echo'                </tr>';
}
echo'            </table>';
echo'        </div>';
echo'</div>';
echo'<div class="KS4tracking" class="col-sm-4">
    <h3 style="text-align: center">GCE Computer Science Success Criteria</h3>';
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
for ($s = 0;$s < count($KS5Track['Topic'])-1;$s++){
    if ($KS5Track['Topic'][$s] == "CompComponents" && $CompComponentsFlag){
        echo'<button type="button" class="collapsible TrackingBtn">Computer Components</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $CompComponentsFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "Software" && $SoftwareFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Software</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SoftwareFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "ExchangingData" && $ExchangingDataFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Exchanging Data</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $ExchangingDataFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "RepresentingData" && $RepresentingDataFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Representing Data</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $RepresentingDataFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "MoralSocEthCultAndLegisl" && $MoralSocEthCultAndLegislFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Moral, Social, Ethical, etc.</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $MoralSocEthCultAndLegislFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "CompThinking" && $CompThinkingFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Computational Thinking</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $CompThinkingFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "SolvingProblems" && $SolvingProblemsFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Problem Solving</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $SolvingProblemsFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "Algorithms" && $AlgorithmsFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">Algorithms</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $AlgorithmsFlag = false;
    } elseif ($KS5Track['Topic'][$s] == "A2Content" && $A2ContentFlag){
        echo'            </table>';
        echo'        </div>';
        echo'<button type="button" class="collapsible TrackingBtn">A2 Content</button>';
        echo'        <div class="contentLower panel panel-default">';
        echo'            <table class="table">';
        $A2ContentFlag = false;
    }
    echo'                <tr>';
    echo'                    <td>';
    printf("%s",$KS5Track['Descriptor'][$s]);
    echo'                    </td>';
    echo'                </tr>';
}
echo'            </table>';
echo'        </div>';
echo'</div>';
mysqli_close($link2);
mysqli_close($link);
mysqli_close($adminlink);
mysqli_close($link2020);
include ('CreativeMediaCriteria.php');
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
</script>
</div>
</div>
</body>
</html>';
