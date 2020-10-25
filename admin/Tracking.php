<?php
include ('../config.php');
global $link, $link2, $adminlink, $NextQuest, $QuestNo;

if ($keyStage3 == 1){
    $qryTrack = "SELECT Topic, Level, Descriptor FROM KS3Descriptors";
    $qryTrack2 = "SELECT * FROM KS3Tracking WHERE userID='".$userID."'";
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
} elseif ($keyStage4 == 1){
    $qryTrack = "SELECT Topic, Descriptor FROM KS4Descriptors";
    $qryTrack2 = "SELECT * FROM KS4Tracking WHERE userID='".$userID."'";
    if ($stmt = mysqli_prepare($link2,$qryTrack)){
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$Topic, $Descriptor);
        while (mysqli_stmt_fetch($stmt)){
            $KS4Track['Topic'][] = $Topic;
            $KS4Track['Descriptor'][] = $Descriptor;
        }
        mysqli_stmt_close($stmt);
    }
} elseif ($keyStage4_2020 == 1){
    $qryTrack = "SELECT Topic, Category, Descriptor FROM KS4_2020Descriptors";
    $qryTrack2 = "SELECT * FROM KS4_2020Tracking WHERE userID='".$userID."'";
    if ($stmt = mysqli_prepare($link2,$qryTrack)){
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$Topic, $Category, $Descriptor);
        while (mysqli_stmt_fetch($stmt)){
            $KS4_2020Track['Topic'][] = $Topic;
            $KS4_2020Track['Category'][] = $Category;
            $KS4_2020Track['Descriptor'][] = $Descriptor;
        }
        mysqli_stmt_close($stmt);
    }
}elseif ($keyStage5 == 1){
    $qryTrack = "SELECT Topic, Descriptor FROM KS5Descriptors";
    $qryTrack2 = "SELECT * FROM KS5Tracking WHERE userID='".$userID."'";
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
}

if ($result = mysqli_query($adminlink,$qryTrack2)){
    $studentData = mysqli_fetch_array($result, MYSQLI_NUM);
    if (count($studentData) == 0){
        if ($keyStage3 == 1){
            $insUser = "INSERT INTO KS3Tracking (userID) VALUES (".$userID.")";
        } elseif ($keyStage4 == 1){
            $insUser = "INSERT INTO KS4Tracking (userID) VALUES (".$userID.")";
        } elseif ($keyStage4_2020 == 1){
            $insUser = "INSERT INTO KS4_2020Tracking (userID) VALUES (".$userID.")";
        } elseif ($keyStage5 == 1){
            $insUser = "INSERT INTO KS5Tracking (userID) VALUES (".$userID.")";
        }

        if ($addUserTracking = mysqli_query($link,$insUser)){
            echo '<script>console.log("New student inserted into tracker");</script>';
        } else {
            die('SQL Error inserting Tracking data line 740: ' . mysqli_error($link));
        }
        mysqli_close($link);

    }

} else {
    echo'<h3>Error in Tracking.php line 37</h3>';
    die('SQL Error inserting Tracking data line 69: ' . mysqli_error($adminlink));
}

echo'<div id="trackingLink">';
echo'    <a class="btn btn-link" onclick="showTracking()">Show / hide tracking</a>';
echo'</div>';
echo'<div id="tracking" class="col-sm-4" style="display: none">';
if ($keyStage3 == 1):
    $TheUrswickBasicsFlag = true;
    $ComputationalThinkingFlag = true;
    $MicrobitFlag = true;
    $DatabasesFlag = true;
    $DataAndTheCPUFlag = true;
    $IntroducingPythonFlag = true;
    $InformationTechFlag = true;
    $ProjectFlag = true;
    if (count($studentData) == 0){
        echo '<h2>Please go back and select the student again, there was no existing tracking data, a new record has been generated</h2>';
    }
    for ($i = 0;$i < count($studentData);$i++){
        if ($KS3Track['Topic'][$i] == "Intro" && $TheUrswickBasicsFlag){
            echo'<button type="button" class="collapsible TrackingBtn">The Urswick Basics</button>';
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
            echo'<button type="button" class="collapsible TrackingBtn">Microbit</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $MicrobitFlag = false;
        } elseif ($KS3Track['Topic'][$i] == "Databases" && $DatabasesFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Databases</button>';
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
        echo'                    <td align="center"><div class="form-check">';
        $t = $i + 1;
        if ($studentData[$i+1] == 0){
            echo '<input type="hidden" name="tracking[KS3_'.$t.']" value=0>';
            echo '<input class="form-check-input position-static" type="checkbox" name="tracking[KS3_'.$t.']" value=1 id="tracking[KS3_'.$t.']">';
        }
        else{
            echo '<input type="hidden" name="tracking[KS3_'.$t.']" value=0>';
            echo '<input class="form-check-input position-static" type="checkbox" name="tracking[KS3_'.$t.']" value=1 id="tracking[KS3_'.$t.']" checked="checked">';
        }
        //printf("%s",$studentData[$i+1]);
        echo'                    </div></td>';
        echo'                </tr>';
    }
    echo'            </table>';
    echo'        </div>';
elseif ($keyStage4 == 1):
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
    if (count($studentData) == 0){
        echo '<h2>Please go back and select the student again, there was no existing tracking data, a new record has been generated</h2>';
    }
    for ($i = 0;$i < count($studentData)-1;$i++){
        if ($KS4Track['Topic'][$i] == "Algorithms" && $AlgorithmsFlag){
            echo'<button type="button" class="collapsible TrackingBtn">Algorithms</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $AlgorithmsFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Programming Techniques" && $ProgrammingTechniquesFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Programming Techniques</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $ProgrammingTechniquesFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Producing Robust Programs" && $ProducingRobustProgramsFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Producing Robust Programs</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $ProducingRobustProgramsFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Computational Logic" && $ComputationalLogicFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Computational Logic</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $ComputationalLogicFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Translators and Facilities of Languages" && $TranslatorsLanguagesFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Translators and Facilities of Languages</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $TranslatorsLanguagesFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Data Representation" && $DataRepresentationFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Data Representation</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $DataRepresentationFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Systems Architecture" && $SystemsArchitectureFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Systems Architecture</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $SystemsArchitectureFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Memory" && $MemoryFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Memory</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $MemoryFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Storage" && $StorageFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Storage</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $StorageFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Wired and Wireless Networks" && $NetworksFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Wired and Wireless Networks</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $NetworksFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Network Topologies, Protocols and Layers" && $NetworkTPLFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Network Topologies, Protocols and Layers</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $NetworkTPLFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "System Security" && $SystemSecurityFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">System Security</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $SystemSecurityFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "System Software" && $SystemSoftwareFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">System Software</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $SystemSoftwareFlag = false;
        } elseif ($KS4Track['Topic'][$i] == "Ethical, legal, cultural and environmental concerns" && $EthLegCultEnvFlag){
            echo'            </table>';
            echo'        </div>';
            echo'<button type="button" class="collapsible TrackingBtn">Ethical, legal, cultural and environmental concerns</button>';
            echo'        <div class="contentLower panel panel-default">';
            echo'            <table class="table">';
            $EthLegCultEnvFlag = false;
        }
        echo'                <tr>';
        echo'                    <td>';
        printf("%s",$KS4Track['Descriptor'][$i]);
        echo'                    </td>';
        echo'                    <td>';
        $t = $i + 1;
        if ($studentData[$i+1] == 0){
            echo'<select id="tracking[KS4_'.$t.']" name="tracking[KS4_'.$t.']">
                <option value="0" selected>R</option>
                <option value="1">A</option>
                <option value="2">G</option>
              </select>';
        } elseif ($studentData[$i+1] == 1){
            echo'<select id="tracking[KS4_'.$t.']" name="tracking[KS4_'.$t.']">
                <option value="0">R</option>
                <option value="1" selected>A</option>
                <option value="2">G</option>
              </select>';
        } else {
            echo'<select id="tracking[KS4_'.$t.']" name="tracking[KS4_'.$t.']">
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
elseif ($keyStage4_2020 == 1):
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
        if (count($studentData) == 0){
            echo '<h2>Please go back and select the student again, there was no existing tracking data, a new record has been generated</h2>';
        }
        for ($i = 0;$i < count($studentData);$i++){
            if ($KS4_2020Track['Topic'][$i] == "Systems Architecture" && $SystemsArchitecture){
                echo'<button type="button" class="collapsible TrackingBtn">Systems Architecture</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $SystemsArchitecture = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Memory and storage" && $Memory){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Memory and Storage</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $Memory = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Computer networks, connections and protocols" && $Networks){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Computer networks, connections and protocols</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $Networks = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Network security" && $NetworkSecurity){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Network security</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $NetworkSecurity = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Systems software" && $SystemsSoftware){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Systems software</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $SystemsSoftware = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Ethical, legal, cultural and environmental impacts of digital technology" && $EthicalLegal){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Ethical, legal, cultural and environmental impacts of digital technology</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $EthicalLegal = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Algorithms" && $Algorithms){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Algorithms</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $Algorithms = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Programming fundamentals" && $ProgrammingFundamentals){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Programming fundamentals</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $ProgrammingFundamentals = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Producing robust programs" && $RobustPrograms){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Producing robust programs</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $RobustPrograms = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Boolean logic" && $Boolean){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Boolean logic</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $Boolean = false;
            } elseif ($KS4_2020Track['Topic'][$i] == "Programming languages and Integrated Development Environments" && $IDEs){
                echo'            </table>';
                echo'        </div>';
                echo'<button type="button" class="collapsible TrackingBtn">Programming languages and Integrated Development Environments</button>';
                echo'        <div class="contentLower panel panel-default">';
                echo'            <table class="table">';
                $IDEs = false;
            }
            echo'                <tr>';
            echo'                    <td>';
            printf("%s",$KS4_2020Track['Category'][$i]);
            echo'                    </td>';
            echo'                    <td>';
            printf("%s",$KS4_2020Track['Descriptor'][$i]);
            echo'                    </td>';
            echo'                    <td align="center"><div class="form-check">';
            $t = $i + 1;
            if ($studentData[$i+1] == 0){
                echo '<input type="hidden" name="tracking[KS4_2020_'.$t.']" value=0>';
                echo '<input class="form-check-input position-static" type="checkbox" name="tracking[KS4_2020_'.$t.']" value=1 id="tracking[KS4_2020_'.$t.']">';
            }
            else{
                echo '<input type="hidden" name="tracking[KS4_2020_'.$t.']" value=0>';
                echo '<input class="form-check-input position-static" type="checkbox" name="tracking[KS4_2020_'.$t.']" value=1 id="tracking[KS4_2020_'.$t.']" checked="checked">';
            }
            //printf("%s",$studentData[$i+1]);
            echo'                    </div></td>';
            echo'                </tr>';
        }
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
    if (count($studentData) == 0){
        echo '<h2>Please go back and select the student again, there was no existing tracking data, a new record has been generated</h2>';
    }
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
