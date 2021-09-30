<?php require_once("includes/initialize.php"); 
$mode=  getUserMode();
?> 
<div class="mainmenu">            
                    <h2>मुख्य मेनु </h2>
                    <div class="navigation">
                        <ul class="nav navbar-nav">
                            <?php if($mode=="administrator"||$mode=="user"):?>
                            <li><a href="index.php">गृहपृष्ठ</a></li>
                            
                            <li><a href="#">कार्यदेशको टिप्पणी</a></li>
                            <li><a href="print_karyadesh_report_02.php">कार्यदेश पत्र</a></li>
                            <li><a href="#">पेश्की कार्यदेशको टिप्पणी</a></li>
                            <li><a href="print_karyadesh_report_04.php">पेश्की कार्यदेश पत्र</a></li>
                            <?php endif;?>
                              <?php if($mode=="administrator"):?>
                            <li><a href="#">म्यादको थपको टिप्पणी</a></li>
                            <?php endif;?>
                            <?php if($mode=="administrator"||$mode=="user"):?>
                            <li><a href="#">म्यादको थपको पत्र</a></li>
                            <?php endif;?>
                            <?php if($mode=="administrator"):?>
                            <li><a href="#">अन्तिम भुक्तानीको टिप्पणी </a></li>
                            <li><a href="#">फोटो हाल्नुहोस्</a></li>
                            <?php endif;?>
                        </ul>
                    </div>            
                </div><!-- main menu ends -->