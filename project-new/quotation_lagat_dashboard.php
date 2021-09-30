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
    	
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">योजनाको कुल लागत अनुमान / फोटो हाल्नुहोस | <a href="quotationDashboard.php" class="btn"> पछि जानुहोस </a></h2>
                    <div class="dashboardcontent">
                    	<a href="quotation_lagat.php"><div class="userprofile">
                            <h3>योजनाको कुल लागत अनुमान</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="photos_upload.php"><div class="userprofile">
                            <h3>फोटो हाल्नुहोस </h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        
                       
                      
                    </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
