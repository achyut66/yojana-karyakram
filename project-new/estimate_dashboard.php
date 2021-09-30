<?php require_once("includes/initialize.php"); ?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$mode=getUserMode();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण | <a href="index.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="dashboardcontent">
                    	<a href="setestimate.php"><div class="userprofile">
                            <h3>प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण भर्नुहोस् </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <!-- <a href="estimate_setting.php"><div class="userprofile">
                        	<h3>कामको विवरण सेटिंग</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a> -->
                        <!-- user profile ends -->
                       
                      
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>