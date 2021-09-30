<?php require_once("includes/initialize.php"); ?>
<?php	if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>

<?php include("menuincludes/header.php"); ?>
<?php

$mode= getUserMode();
?>
<!-- js ends -->
<title><?php echo SITE_SUBHEADING; ?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); 
   ?>
    <div id="body_wrap_inner"> 
    	        <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">ड्यासबोर्डमा यहाँहरुलाई स्वागत छ |</h2>
                      
                    <div class="dashboardcontent">
                        <?php if($mode=="superadmin"):?>
                    	<a href="plan_form.php">
                             <div class="userprofile">
                        	<h3>नया योजना / कार्यक्रम दर्ता</h3>
                            <div class="dashimg">
                            	<img src="images/new_plan_icon.png" alt="New Plan  Icons" class="dashimg" />
                            </div>
                        
                             <?php 
                             endif;
                             if($mode=="administrator"||$mode=="superadmin"|| $mode=="user" || $mode=="section"): ?>
                             </div>
                        </a>
                        <!-- user profile ends -->
                        <a href="view_plan_dashboard.php">
                        <div class="userprofile">
                        	<h3>योजना / कार्यक्रम हेर्नुहोस</h3>
                            <div class="dashimg">
                            	<img src="images/billing-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
			<?php endif;
						if($mode=="superadmin"):?>
                       
                        <a href="settings.php">
                        <div class=" userprofile">
                        	<h3>सेटिंग</h3>
                            <div class="dashimg">
                            	<img src="images/setting-icon.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        <?php endif;?>
                        <?php if($mode=="user"||$mode=="administrator"||$mode=="superadmin" || $mode=="section"):
                            echo $message;?>
                        <a href="yojanasanchalandash.php">
                        <div class="userprofile">
                        	<h3>योजना संचालन प्रकृया</h3>
                            <div class="dashimg">
                            	<img src="images/plan-icon.png" alt="User Profile" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        
                        <a href="setprogramid.php">
                        <div class="userprofile">
                            <h3>कार्यक्रम संचालन प्रकृया</h3>
                            <div class="dashimg">
                            	<img src="images/plan-icon.png" alt="User Profile" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        <?php endif;?>
                        <?php if($mode=="superadmin"||$mode=="subadmin"):?>
                        <a href="estimate_dashboard.php">
                        <div class="userprofile">
                             <h3>प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण भर्नुहोस्</h3>
                            <div class="dashimg">
                                <img src="images/plan-icon.png" alt="User Profile" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                         <?php endif;?>
                        <?php if($mode=="administrator"||$mode=="superadmin"||$mode=="subadmin"):?>
                         <a href="estimate_yojana_list.php">
                        <div class=" userprofile">
                        	<h3>इष्टिमेट भएको योजना </h3>
                            <div class="dashimg">
                            	<img src="images/setting-icon.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                         <?php endif;?>
                         <?php if($mode=="administrator"||$mode=="superadmin"||$mode=="user"):?>
                        <a href="report_dashboard.php">
                        <div class="userprofile">
                        	<h3>रिपोर्ट हेर्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/report-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                      
                        <?php endif;
                        if($mode=="superadmin"):?>
			<a href="user_details.php">
                        <div class="userprofile">
                        	<h3>प्रयोगकर्ता थप्नुहोस </h3>
                            <div class="dashimg">
                            	<img src="images/user-profile.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        	<a href="plan_form_test.php">
                        <div class="userprofile">
                        	<h3>Excel Upload</h3>
                            <div class="dashimg">
                            	<img src="images/user-profile.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        <?php endif;?>
                      <?php   if($mode=="user" || $mode=="section"):?>
                         <a href="settings_rules.php">
                                	<div class="userprofile">
                        		<h4>सर्तहरु थप्नुहोस</h4>
                        		<div class="dashimg">
                                      <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                                </div>
                        	</div>
                        </a>
                        <a href="program_settings.php">
                        	<div class="userprofile">
                        		<h4>सूची दर्ता</h4>
                        		<div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        	</div>
                        </a>
                        <?php endif; ?>
                    </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>