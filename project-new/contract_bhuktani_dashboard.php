<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् </title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
             <h2 class="dashboard">उपभोक्ता समिति मार्फत | <a href="yojanasanchalandash.php">योजना संचालन प्रकृया</a> | <a href="contract_dashboard.php" class="btn">पछी जानुहोस </a></h2>
          	
                
            <div class="OurContentFull">
				<h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <h2>भुक्तानी छान्नुहोस् </h2>
                <div class="userprofiletable">
<!--               		<div class="userprofile3">
                            <h4><a href="contingency_expenditure.php">कन्टेन्जेन्सी खर्च</a></h4>
                            <div class="dashimg">
                                <a href="contingency_expenditure.php"><img src="images/pen-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div> user profile ends -->
                        <div class="userprofile3">
                        	<h4><a href="contract_advance.php"> पेश्की भुक्तानी </a></h4>
                            <div class="dashimg">
                                <a href="contract_advance.php"><img src="images/pen-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        
                        <div class="userprofile3">
                            <h4><a href="contract_form3.php"> मुल्यांकनको आधारमा भुक्तानी</a></h4>
                            <div class="dashimg">
                                <a href="contract_form3.php"><img src="images/pen-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                          <div class="userprofile3">
                        	<h4><a href="contract_final.php">अन्तिम भुक्तानी</a></h4>
                            <div class="dashimg">
                                <a href="contract_final.php"><img src="images/pen-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                      <div class="userprofile3">
                          <h4><a href="contract_additionaldate.php"> म्याद थप</a></h4>
                            <div class="dashimg">
                                <a href="contract_additionaldate.php"><img src="images/pen-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                          <div class="userprofile3">
                        	<h4><a href="contractdharauti_dashboard.php"> धरौटी फिर्ता </a></h4>
                            <div class="dashimg">
                                <a href="contractdharauti_dashboard.php"><img src="images/pen-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        
                        
                        
              </div>
              
                    
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>