<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
             <h2 class="dashboard">ठेक्का मार्फत | <a href="contract_bhuktani_dashboard.php" class="btn"> पछि जानुहोस  </a></h2>
          
            <div class="OurContentFull">
				<h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <h2>धरौटी छान्नुहोस् </h2>
                  <a href="contractdharauti.php">
                  	<div class="userprofile">
                        	<h3>थप धरौटी जम्मा </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                          <a href="contract_dharauti_firta.php"><div class="userprofile">
                        	<h3>धरौटी फिर्ता</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                          <a href="contract_print_karyadesh_report_10.php"><div class="userprofile">
                        	<h3>धरौटी फिर्ता पत्र</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->                        
                        
              			</div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>