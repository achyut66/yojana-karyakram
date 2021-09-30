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
    	<div class="">
            <div class="">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">योजना संचालन प्रकृया | <a href="index.php">Dashboard</a></h2>
                    <?php if(isset($_GET['msg'])):?>
                    <h2 class="dashboard" style="color:red;"><?php echo $_GET['msg'];?></a></h2>
                    <?php endif;?>
                    <div class="dashboardcontent">
                    	<div class="userprofile">
                        	<h3><a href="estimate_setid.php">उपभोक्ता समिति मार्फत</a></h3>
                            <div class="dashimg">
                            	<a href="estimate_setid.php"><img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        <div class="userprofile">
                        	<h3><a href="estimate_samiti_setid.php">संस्था / समिति मार्फत</a></h3>
                            <div class="dashimg">
                            	<a href="estimate_samiti_setid.php"><img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        <?php if($mode=="administrator"||$mode="superadmin"):?>
                        <div class=" userprofile">
                            <h3><a href="estimate_contract_set_id.php">ठेक्का मार्फत</a></h3>
                            <div class="dashimg">
                            	<a href="estimate_contract_set_id.php"><img src="images/user-profile.png" alt="Settings Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                       <?php endif;?>
                      
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>