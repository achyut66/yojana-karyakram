<?php require_once("includes/initialize.php"); ?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$mode=getUserMode();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>प्राबिधिक इष्टिमेट :: <?php echo SITE_SUBHEADING;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण | <a href="index.php">ड्यासबोर्डमा जानुहोस</a></h2>
                    
                    <div class="dashboardcontent">
                    	<a href="estimatedashboard.php?type=1"><div class="userprofile">
                            <h3>उपभोक्ता मार्फत </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="estimatedashboard.php?type=2"><div class="userprofile">
                        	<h3>ठेक्का मार्फत</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                       
                      
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>