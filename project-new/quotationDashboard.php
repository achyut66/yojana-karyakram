<?php require_once("includes/initialize.php"); ?>

<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
?>
<?php $mode= getUserMode();?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title><?=$plan_selected->program_name?> ::<?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">कोटेसन् मार्फत | <a href="yojanasanchalandash.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न : <?=convertedcit($plan_selected->id)?></h1>
                      <?php if(isset($_GET['msg'])):?>
                      <h1 style="color:red;" class="myHeading1"><?php echo $_GET['msg'];?></h1>
                       <?php endif;?>
                      <?php if($mode=="user"||$mode=="administrator"||$mode=="subadmin"||$mode="superadmin"):?>
                      <a href="quotation_lagat_dashboard.php" target="_blank"><div class="userprofile">
                            <h3>योजनाको कुल लागत अनुमान / फोटो हाल्नुहोस </h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
<!--                        <a href="plan_form1_1.php"><div class="userprofile">
                        	<h3>उपभोक्ता समिति विवरण  </h3>
                            <div class="dashimg">
                            	<img src="images/user-profile.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div></a> user profile ends 
                      -->
<!--                        <div class="userprofile">
                        <a href="plan_form1_2.php"><h3>अनुगमन समिति विवरण</h3>
                            <div class="dashimg">
                            	<img src="images/office-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a> user profile ends -->
                        
                        <a href="quotation_more_details.php" target="_blank"><div class="userprofile">
                        	<h3>योजना सम्बन्धी अन्य विवरण</h3>
                            <div class="dashimg">
                            	<img src="images/report-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->

                          <a href="quotation_kabol_form.php" target="_blank"><div class="userprofile">
                        	<h3>योजना कबोल फारम</h3>
                            <div class="dashimg">
                            	<img src="images/report-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->

                         <?php endif; if($mode=="user"||$mode=="administrator"||$mode="superadmin"):?>
                        <a href="quotation_letters_select.php" target="_blank"><div class="userprofile">
                        	<h3>पत्रहरु</h3>
                            <div class="dashimg">
                            	<img src="images/patra-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <?php endif;?>
                         <?php if($mode=="administrator"||$mode="superadmin"):?>
                        <a href="amanat_bhuktani_dashboard.php" target="_blank"><div class="userprofile">
                        	<h3>भुक्तानी </h3>
                            <div class="dashimg">
                            	<img src="images/report-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                      <?php endif;?>
                       
                    </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
