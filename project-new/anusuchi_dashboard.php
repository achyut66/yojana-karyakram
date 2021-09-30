<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php include("menuincludes/header.php"); ?>
<title>रिपोर्ट हेर्नुहोस :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent OurContentFull ">
             <h2 class="dashboard">खर्च प्रतिबेदनहरु हेर्नुहोस | <a href="report_dashboard.php" class="btn">पछि जानुहोस </a></h2>
            
				
                <div class="myMessage"><?php echo $message;?></div>
                
                <div class="dashboardcontent">
               		
<!--                        <a href="anusuchi_1.php">
                        <div class="userprofile">
                        	<h3>खर्च प्रतिबेदन सारांस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a> user profile ends -->
                        <a href="anusuchi_2.php">
                        <div class="userprofile">
                        	<h3>खर्च प्रतिबेदन बिस्तृत </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="sarans_expenditure_report.php">
                        <div class="userprofile">
                        	<h3>बिषयगत क्षेत्र / बजेट उपशीर्षक अनुसार खर्च विवरण </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="anudan_expenditure_report.php">
                        <div class="userprofile">
                        	<h3>अनुदान अनुसार खर्च विवरण </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="expenditure_type_wise_report.php">
                        <div class="userprofile">
                        	<h3>खर्च किसिम अनुसार रिपोर्ट हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="chaumasik_report.php">
                        <div class="userprofile">
                            <h3>चौमासिक खर्च रिपोर्ट हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
              </div>
              
                    
                  
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>