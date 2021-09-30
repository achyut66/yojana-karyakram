<?php require_once("includes/initialize.php"); ?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$mode=getUserMode();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना / कार्यक्रम  विवरण : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">योजना / कार्यक्रम  विवरण | <a href="index.php" class="btn">पछि जानुहोस</a></h2>
                    <?php if(isset($_GET['msg'])):?>
                    <h2 class="dashboard" style="color:red;"><?php echo $_GET['msg'];?></a></h2>
                    <?php endif;?>
                    <div class="dashboardcontent">
                    	<a href="view_all_plans.php">
                        <div class="userprofile">
                            <h3>योजना / कार्यक्रम  विवरण हेर्नुहोस </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        <?php if($mode=="administrator"||$mode=="superadmin"):?>
                        <a href="view_budgetwise_plan.php">
                        <div class="userprofile">
                        	<h3>बजेट शिर्षक अनुसार योजना/कार्यक्रम हेर्नुहोस</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div>
                        </a>
                         <a href="view_topic_wise_report.php">
                        <div class="userprofile">
                        	<h3>बिषयगत क्षेत्रको किसिम अनुसार योजना/कार्यक्रम हेर्नुहोस</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <?php endif;?>
                       
                      
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
 
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>