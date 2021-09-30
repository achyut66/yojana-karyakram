<?php require_once("includes/initialize.php"); 
$mode=  getUserMode();
?> 
<div class="mainmenu">            
                    <h2>मुख्य मेनु </h2>
                    <div class="navigation">
                        <ul class="nav navbar-nav">
                            <?php if($mode=="administrator"||$mode=="user"||$mode="superadmin"):?>
                            <li><a href="index.php">गृहपृष्ठ</a></li>
                            <?php endif;?>
                        </ul>
                    </div>            
                </div><!-- main menu ends -->