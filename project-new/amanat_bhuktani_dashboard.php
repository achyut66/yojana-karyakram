<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
//        get_access_form($_SESSION['set_plan_id']);
?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
             <h2 class="dashboard">अमानत मार्फत | <a href="amanatdashboard.php" class="btn">पछि जानुहोस</a></h2>
           
                
            <div class="OurContentFull">
				<h1 class="myHeading1"><?=$plan_selected->program_name?> | दर्ता न :<?=convertedcit($plan_selected->id)?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <h2>भुक्तानी छान्नुहोस् </h2>
                <div class="userprofiletable">
               		<a href="plan_form2.php"> 
                        <div class="userprofile">
                        	<h3>पेश्की भुक्तानी 
                            </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div>
                    </a><!-- user profile ends -->
                    <a href="plan_form4.php">
                     	<div class="userprofile">
                        	<h3> मुल्यांकनको आधारमा भुक्तानी</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                         <a href="plan_form5.php">
                         <div class="userprofile">
                        	<h3>अन्तिम भुक्तानी</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="additionaldate.php">
                        <div class="userprofile">
                        	<h3> म्याद थप</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div>
                        </a><!-- user profile ends -->
                       
                        
              </div>
              
                    
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>