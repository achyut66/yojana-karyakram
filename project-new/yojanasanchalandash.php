<?php require_once("includes/initialize.php"); ?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$mode=getUserMode();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संचालन प्रकृया :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">योजना संचालन प्रकृया | <a href="index.php" class="btn">पछि जानुहोस</a></h2>
                    <?php if(isset($_GET['msg'])):?>
                    <h2 class="dashboard" style="color:red;"><?php echo $_GET['msg'];?></a></h2>
                    <?php endif;?>
                    <div class="dashboardcontent">
                    	<a href="setid.php">
                        <div class="userprofile">
                        	<h3>उपभोक्ता समिति मार्फत</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        <a href="samiti_setid.php">
                        <div class="userprofile">
                        	<h3>संस्था / समिति मार्फत</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                       
                        <a href="contract_set_id.php">
                        <div class=" userprofile">
                            <h3>ठेक्का मार्फत</h3>
                            <div class="dashimg">
                            	<img src="images/user-profile.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                       <a href="amanat_setid.php">
                        <div class="userprofile">
                        	<h3>अमानत मार्फत</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        <a href="quotation_setid.php">
                            <div class="userprofile">
                                <h3>कोटेसन् मार्फत</h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div>
                        </a>
                        <!-- user profile ends -->
                    </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
