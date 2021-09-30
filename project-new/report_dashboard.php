<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	
?>
<?php include("menuincludes/header.php"); ?>
<title>रिपोर्ट हेर्नुहोस :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent">
             <h2 class="dashboard">रिपोर्ट हेर्नुहोस | <a href="index.php" class="btn">पछि जानुहोस </a></h2>
             <div class="OurContentFull">
				
                <div class="myMessage"><?php echo $message;?></div>
                <div class="userprofiletable">
               		
                        <a href="report.php">
                        	<div class="userprofile">
                        	<h3>आन्तरिक रिपोर्ट हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="anusuchi_dashboard.php">
                        	<div class="userprofile">
                        	<h3>खर्च प्रतिवेदन</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="mainreport.php"><div class="userprofile">
                        	<h3>आंसिक मुख्य रिपोर्ट हेर्नुहोस </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                          <a href="mainreport1.php"><div class="userprofile">
                        	<h3>योजनाको बिस्तृत मुख्य रिपोर्ट हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="mainreport2.php">
                        <div class="userprofile">
                        	<h3> कार्यक्रमको बिस्तृत मुख्य रिपोर्ट हेर्नुहोस </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>  
                        </div></a><!-- user profile ends -->
                        <!--<a href="anusuchi_dashboard.php">-->
                        <!--<div class="userprofile">-->
                        <!--	<h3>खर्च प्रतिबेदन</h>-->
                        <!--    <div class="dashimg">-->
                        <!--        <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />-->
                        <!--    </div>-->
                        <!--</div></a><!-- user profile ends -->
                        <a href="sarans_report.php"><div class="userprofile">
                        	<h3>बिनियोजन सारांस हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="upabhokta_details_report.php"><div class="userprofile">
                        	<h3>उपभोक्ता समिति  विवरण हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                         <a href="detail_final_report.php"><div class="userprofile">
                        	<h3>बिस्तृत रिपोर्ट हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="sanchalan_prakriya_report.php"><div class="userprofile">
                                 <h3>संचालन प्रक्रिया अनुसार रिपोर्ट </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="bhautik_pragati_report.php"><div class="userprofile">
                                 <h3>भौतिक प्रगति विवरण </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="kar_katti_report.php"><div class="userprofile">
                                 <h3>कर कट्टी विवरण </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="anusuchi_2.php"><div class="userprofile">
                                 <h3>अनुसूची-१ रिपोर्ट </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="anusuchi_1.php"><div class="userprofile">
                                 <h3>अनुसूची-२ रिपोर्ट </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="added_plan_report.php"><div class="userprofile">
                                 <h3>जोडिएको योजनाको रिपोर्ट</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="separated_plan_report.php"><div class="userprofile">
                                 <h3>टुक्रिएको योजनाको रिपोर्ट</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
              </div>
                  </div>
                </div><!-- main menu ends -->
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>