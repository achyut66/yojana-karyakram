<?php require_once("includes/initialize.php"); ?>
<?php
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संचालन प्रकृया :: <?php echo SITE_SUBHEADING;?></title>
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">मुख्य रिपोर्ट हेर्नुहोस | <a href="index.php">Dashboard</a></h2>
                    <div class="dashboardcontent">
                    	
                        <div class="userprofile">
                        	<h3><a href="mainreport1.php">योजनाको  बिस्तृत रिपोर्ट हेर्नुहोस </amainreport></h3>
                            <div class="dashimg">
                            	<a href="mainreport1.php"><img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                         <div class="userprofile">
                        	<h3><a href="mainreport2.php">कार्यक्रमको  बिस्तृत रिपोर्ट हेर्नुहोस </amainreport></h3>
                            <div class="dashimg">
                            	<a href="mainreport2.php"><img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        <!-- user profile ends -->
                       
                      
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>