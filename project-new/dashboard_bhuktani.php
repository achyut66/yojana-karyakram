<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
        //get_access_form($_SESSION['set_plan_id']);
?>
<?php $mode= getUserMode();?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
             <h2 class="dashboard">उपभोक्ता समिति मार्फत | <a href="letters_select.php" class="btn">पछि जानुहोस</a> </h2>
            
            <div class="OurContentFull">
				<h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <h2>पत्रहरु छान्नुहोस् </h2>
                <?php if($mode=="administrator"||$mode=="user"||$mode=="superadmin"):?>
                <div class="userprofiletable">
               		
                        <?php endif;?>
                         <?php if($mode=="administrator"||$mode=="user"||$mode=="superadmin"):?>
                        
                        
                         <a href="print_bank_report_14.php"><div class="userprofile">
                        	<h3>सम्झौताको सिफारिस </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report_13.php"><div class="userprofile">
                        	<h3> मुल्यांकनको आधारमा  भुक्तानीको सिफारिस </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report_12.php"><div class="userprofile">
                        	<h3>अन्तिम भुक्तानीको सिफारिस </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        
                         
                        <?php endif;?>
                        
                        
              </div>
              
                    
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>