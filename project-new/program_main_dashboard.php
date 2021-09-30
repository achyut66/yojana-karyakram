<?php require_once("includes/initialize.php");
?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	//$program_selected = Programdetails::find_by_id($_GET['id']);
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
                    <h2 class="dashboard">कार्यक्रम संचालन प्रकृया | <a href="yojanasanchalandash.php">Dashboard</a></h2>
                    <div class="dashboardcontent">
                        
                    	 <div class="userprofile">
                        	<h3><a href="program_dashboard.php">कार्यक्रम मार्फत</a></h3>
                            <div class="dashimg">
                            	<a href="program_dashboard.php"><img src="images/report-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div>
                          <div class="userprofile">
                        	<h3><a href="#">संघ संस्था मार्फत</a></h3>
                            <div class="dashimg">
                            	<a href="#"><img src="images/office-icon.png" alt="Billing Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        
                        
                        <div class="userprofile">
                        	<h3><a href="#">अमानत / कोटेसन / बोलपत्र  </a></h3>
                            <div class="dashimg">
                            	<a href="#"><img src="images/report-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        <!-- user profile ends -->
                        
                        
                       
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>