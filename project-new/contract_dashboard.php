<?php require_once("includes/initialize.php"); ?>

<?php	

	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_sn($_SESSION['sn']);
     //echo Contractamountwithdrawdetails::get_payement_till_now($_SESSION['set_plan_id']);exit;
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
                    <h2 class="dashboard">ठेक्का मार्फत  | <a href="yojanasanchalandash.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <?php if($mode=="user"||$mode=="administrator"||$mode=="superadmin" || $mode=="section"):?>
                       <a href="view_contract_info.php"><div class="userprofile25">
                       <h3>ठेक्का सूचना दर्ता </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                       </div></a><!-- user profile ends -->
                        <a href="view_contract_invitation_for_bid.php"><div class="userprofile25">
                       <h3>ठेक्का बोलपत्र बिक्रि किताब </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                       </div></a><!-- user profile ends -->
                       <a href="view_contract_invitation_entry.php"><div class="userprofile25">
                       <h3>ठेक्का बोलपत्र दर्ता किताब</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                       </div></a><!-- user profile ends -->
                       <a href="view_contract_bid_final.php"><div class="userprofile25">
                       <h3>ठेक्का खोलिएको फारम </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                       </div></a><!-- user profile ends -->
                       <a href="view_contract_entry_final.php"><div class="userprofile25">
                            <h3>ठेक्का कबोल फारम </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                       <a href="contract_invitation_bid_form_view.php"><div class="userprofile25">
                            <h3>ठेक्का बोलिने फारम </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                    	<a href="contract_form1.php"><div class="userprofile25">
                            <h3>ठेक्काको कुल लागत अनुमान</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="contract_form2.php"><div class=" userprofile25">
                        	<h3>ठेक्का संचालन विवरण</h3>
                            <div class="dashimg">
                            	<img src="images/user-profile.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                       
                        <a href="contract_letter_dashboard.php"><div class="userprofile25">
                            <h3>पत्रहरु </h3>
                            <div class="dashimg">
                            	<img src="images/patra-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <?php endif;?>
                         <?php if($mode=="administrator"||$mode=="superadmin"):?>
                        <a href="contract_bhuktani_dashboard.php"><div class="userprofile25">
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