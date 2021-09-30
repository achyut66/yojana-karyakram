<?php require_once("includes/initialize.php"); 
$mode=  getUserMode();
?> 
<div class="mainmenu">            
                    <h2>मुख्य मेनु </h2>
                    <div class="navigation">
                        <ul class="nav navbar-nav">
                            <?php if($mode=="administrator"||$mode=="user"||$mode="superadmin"):?>
                            <li><a href="index.php">गृहपृष्ठ</a></li>
                            <li><a href="report.php">आन्तरिक रिपोर्ट हेर्नुहोस </a></li>
                            <li><a href="mainreport.php"> आंसिक मुख्य रिपोर्ट हेर्नुहोस </a></li>
                            <li><a href="mainreport1.php">योजनाको बिस्तृत मुख्य रिपोर्ट हेर्नुहोस </a></li>
                            <li><a href="mainreport2.php">कार्यक्रमको बिस्तृत मुख्य रिपोर्ट हेर्नुहोस </a></li>
                            <li><a href="anusuchi_1.php">आनुसुची १</a></li>
                            <li><a href="anusuchi_2.php">आनुसुची २ </a></li>
                            <?php endif;?>
                        </ul>
                    </div>            
                </div><!-- main menu ends -->