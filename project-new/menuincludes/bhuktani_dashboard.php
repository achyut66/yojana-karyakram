<?php require_once("includes/initialize.php"); 
$mode=  getUserMode();
?> 
<div class="mainmenu">            
                    <h2>मुख्य मेनु </h2>
                    <div class="navigation">
                        <ul class="nav navbar-nav">
                            <?php if($mode=="administrator"||$mode=="user"||$mode="superadmin"):?>
                            <li><a href="index.php">गृहपृष्ठ</a></li>
                             <li><a href="plan_form2.php">पेश्की भुक्तानी </a></li>
                              <li><a href="plan_form4.php">मुल्यांकनको आधारमा भुक्तानी</a></li>
                              <li><a href="plan_form5.php">अन्तिम भुक्तानी</a></li>
                              <li><a href="additionaldate.php">म्याद थप</a></li> 
                               <li><a href="yojanadharauti.php">धरौटी फिर्ता </a></li>    
                            <?php endif;?>
                        </ul>
                    </div>            
                </div><!-- main menu ends -->