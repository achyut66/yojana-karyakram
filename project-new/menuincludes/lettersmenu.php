<?php
$mode= getUserMode();
?>
<div class="mainmenu">            
                    <h2>मुख्य मेनु </h2>
                    <div class="navigation">
                        <ul class="nav navbar-nav">
                             <?php if($mode=="administrator"||$mode=="user"||$mode=="superadmin"):?>
                            <li><a href="upabhoktasamitidashboard.php">मूल पृष्ठ</a></li>
                            
                            <li><a href="print_bank_report08.php">संझौताको टिप्पणी</a></li>
                            <li><a href="print_bank_report02.php">संझौता पत्र</a></li>
                            <li><a href="print_bank_report_05.php">संझौता कार्यदेश</a></li>
                            <?php endif;
                            if($mode=="administrator"||$mode=="superadmin"):
                            ?>
                            <li><a href="print_bank_report03.php">पेश्की संझौताको टिप्पणी</a></li>
                            <li><a href="print_bank_report_04.php">पेश्की संझौताको कार्यदेश</a></li>
                            <?php
                            endif;
                            if($mode=="user"||$mode=="administrator"||$mode=="superadmin"):
                            ?>
                            <li><a href="print_bank_report01.php">बैंक खाता संचालनको पत्र</a></li>
                            <?php endif;
                           if($mode=="administrator"||$mode=="superadmin"):?>
                            <li><a href="print_bank_report07.php">म्यादको थपको टिप्पणी</a></li>
                            <li><a href="print_bank_report06.php">म्यादको थपको पत्र</a></li>
                            <li><a href="#">मुल्यांकनको आधारमा भुक्तानीको टिप्पणी</a></li>
                            <li><a href="#">अन्तिम भुक्तानीको टिप्पणी</a></li>
                            <li><a href="print_bank_report_14.php">उपभोक्ता समिति मार्फत पेश्कीको टिप्पणी</a></li>
                            <?php endif;?>
                        </ul>
                    </div>            
                </div><!-- main menu ends -->