<?php require_once("includes/initialize.php"); 
$mode=  getUserMode();
?> 
<div class="mainmenu">            
                    <h2>मुख्य मेनु </h2>
                    <div class="navigation">
                        <ul class="nav navbar-nav">
                            <?php if($mode=="administrator"||$mode=="user"||$mode="superadmin"):?>
                            <li><a href="index.php">गृहपृष्ठ</a></li>
                            
                            <li><a href="samiti_plan_form1.php">योजनाको कुल लागत अनुमान</a></li>
                            <li><a href="samiti_plan_form1_1.php">समिति विवरण </a></li>
                            <li><a href="samiti_plan_form1_2.php">अनुगमन समिति विवरण</a></li>
                            <li><a href="samiti_plan_form1_3.php">योजना सम्बन्धी अन्य विवरण</a></li>
                            <?php endif;?>
                              <?php if($mode=="administrator"||$mode="superadmin"):?>
                            <li><a href="view_all_plans.php">पुरा विवरण हेर्नुहोस </a></li>
                            <?php endif;?>
                            <?php if($mode=="administrator"||$mode=="user"||$mode="superadmin"):?>
                            <li><a href="samiti_letters_select.php">पत्रहरु</a></li>
                            <?php endif;?>
                            <?php if($mode=="administrator"||$mode="superadmin"):?>
                            <li><a href="samiti_bhuktani_select.php">भुक्तानी</a></li>
                            <li><a href="#">फोटो हालनुहोस</a></li>
                            <?php endif;?>
                        </ul>
                    </div>            
                </div><!-- main menu ends -->