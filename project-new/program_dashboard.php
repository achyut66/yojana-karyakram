<?php require_once("includes/initialize.php"); ?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	
	if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
	{
            redirectUrl();
	}
        if(!isset($_GET['id']))
        {
            redirect_to("setprogramid.php");
        }
        if($_GET['id']!=$_SESSION['set_plan_id']):
          die('Invalid Format');
       endif;
       
$program_selected = Plandetails1::find_by_id($_GET['id']);
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संचालन प्रकृया </title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">कार्यक्रम संचालन प्रकृया | <a href="setprogramid.php" class="btn">पछाडी जानुहोस</a></h2>
                    <h2 class="dashboard"><?=$program_selected->program_name?> | दर्ता न :<?=convertedcit($program_selected->id)?></h2>
                    <div class="dashboardcontent">
                        <a href="program_more_details.php">
                    	<div class="userprofile">
                            <h3>कार्यक्रम संचालन विवरण</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a>
                        <!-- user profile ends -->
                        <a href="training_expense.php">
                        <div class="userprofile">
                            <h3>कार्यक्रमको कुल लागत अनुमान</h3>
                            <div class="dashimg">
                            	<img src="images/office-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                          <!-- user profile ends -->
                        <a href="program_payment.php">
                        <div class="userprofile">
                             <h3>पेश्की भुक्तानी</h3>
                            <div class="dashimg">
                                <img src="images/report-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="program_additional_date.php">
                        <div class="userprofile">
                             <h3>कार्यक्रम म्याद थप</h3>
                            <div class="dashimg">
                                <img src="images/report-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="letters_select_programs.php">
                        <div class=" userprofile">
                            <h3>पत्रहरु</h3>
                            <div class="dashimg">
                            	<img src="images/patra-icon.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="program_payment_final.php">
                        <div class="userprofile">
                            <h3>अन्तिम भुक्तानी</h3>
                            <div class="dashimg">
                            	<img src="images/office-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="program_payment_deposit_return.php">
                        <div class="userprofile">
                            <h3>धरौटी फिर्ता </h3>
                            <div class="dashimg">
                            	<img src="images/office-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        
                       
                        
                       
                    </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>